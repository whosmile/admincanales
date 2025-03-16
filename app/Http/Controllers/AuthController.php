<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WebTransactionalLog;
use App\Models\BitacoraAdministrativa;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function register()
    {
        if (!Auth::check() || Auth::user()->role->nombre !== 'Administrador') {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        
        // Ya no necesitamos verificar Auth::check() aquí porque el middleware 'auth' y 'role' lo manejan
        return view('auth.register')->with([
            'fromDashboard' => true
        ]);
    }

    public function registrar(Request $request)
    {
        // Limpiar el número de teléfono de cualquier formato
        $telefono = preg_replace('/[^0-9]/', '', $request->telefono);
        
        // Construir la cédula completa
        $numero_cedula = preg_replace('/\D/', '', $request->numero_cedula);
        $cedula = $request->nacionalidad . '-' . $numero_cedula;
        
        // Obtener el ID del rol de Usuario
        $userRoleId = DB::table('roles')->where('nombre', 'Usuario')->value('id');
        
        if (!$userRoleId) {
            Log::error('No se encontró el rol de Usuario en la base de datos');
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error en el registro. Por favor, contacte al administrador.']);
        }
        
        $request->merge([
            'telefono' => $telefono,
            'cedula' => $cedula
        ]);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'nacionalidad' => ['required', 'in:V,E'],
            'numero_cedula' => [
                'required',
                'numeric',
                'digits_between:5,8'
            ],
            'cedula' => [
                'required',
                'string',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[VE]-\d{5,8}$/', $value)) {
                        $fail('El formato de la cédula es inválido.');
                    }
                }
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'telefono' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $cleanNumber = preg_replace('/[^0-9]/', '', $value);
                    if (strlen($cleanNumber) !== 11) {
                        $fail('El número de teléfono debe tener 11 dígitos incluyendo el prefijo.');
                        return;
                    }
                    $prefix = substr($cleanNumber, 0, 4);
                    $validPrefixes = ['0412', '0416', '0426', '0414', '0424'];
                    if (!in_array($prefix, $validPrefixes)) {
                        $fail('El prefijo del número debe ser uno de los siguientes: 0412, 0416, 0426, 0414, 0424');
                        return;
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'apellido' => $request->apellido,
                'cedula' => strtoupper($request->cedula),
                'email' => $request->email,
                'username' => $request->username,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
                'role_id' => $userRoleId, // Asignar el rol de Usuario
                'activo' => true,
            ]);

            // Registrar en el log la creación del usuario
            Log::info('Usuario registrado exitosamente', [
                'user_id' => $user->id,
                'username' => $user->username,
                'role_id' => $userRoleId
            ]);

            return redirect()->route('login')
                ->with('success', 'Registro exitoso. Por favor, inicie sesión.');

        } catch (\Exception $e) {
            Log::error('Error al registrar usuario', [
                'error' => $e->getMessage(),
                'data' => $request->except('password')
            ]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error en el registro. Por favor, intente nuevamente.']);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Registrar el inicio de sesión exitoso en ambas bitácoras
            $user = Auth::user();
            $logData = [
                'user_id' => $user->id,
                'usuario' => $user->name . ' ' . $user->apellido,
                'accion' => 'inicio_sesion',
                'modulo' => 'Autenticación',
                'detalles' => 'El usuario ha iniciado sesión en el sistema',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ];

            WebTransactionalLog::create($logData);
            BitacoraAdministrativa::create($logData);

            return redirect()->intended('dashboard');
        }

        // Registrar el intento fallido de inicio de sesión
        $user = User::where('username', $request->username)->first();
        $logData = [
            'user_id' => $user ? $user->id : null,
            'usuario' => $user ? ($user->name . ' ' . $user->apellido) : $request->username,
            'accion' => 'intento_fallido_login',
            'modulo' => 'Autenticación',
            'detalles' => 'Intento fallido de inicio de sesión',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        WebTransactionalLog::create($logData);
        BitacoraAdministrativa::create($logData);

        return back()->withErrors([
            'username' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // Registrar el cierre de sesión en ambas bitácoras antes de cerrar la sesión
        $user = Auth::user();
        
        if ($user) {
            $logData = [
                'user_id' => $user->id,
                'usuario' => $user->name . ' ' . $user->apellido,
                'accion' => 'cierre_sesion',
                'modulo' => 'Autenticación',
                'detalles' => 'El usuario ha cerrado sesión en el sistema',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ];

            WebTransactionalLog::create($logData);
            BitacoraAdministrativa::create($logData);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->activo) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'username' => 'Tu cuenta está desactivada. Por favor, contacta al administrador.',
            ]);
        }

        switch ($user->role->nombre) {
            case 'operador':
                return view('modules.dashboard.home_operador');
            case 'master':
                return view('modules.dashboard.home_master');
            case 'master_unico':
                return view('modules.dashboard.home_master_unico');
            default:
                return view('modules.dashboard.index');
        }
    }
}

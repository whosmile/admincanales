<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use App\Models\Bitacora;
use App\Models\Modulo;
use App\Models\GrupoParametro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParametrosController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user with role
        $user = Auth::user()->load('role');

        // Get search query
        $search = $request->get('search');

        // Base query for parameters
        $query = Parametro::with('grupo')
            ->select(
                'id',
                'codigo',
                'valor',
                'descripcion',
                'grupo_id',
                'created_at',
                'updated_at'
            );

        // Apply search filter if search query exists
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('grupo', function($subQuery) use ($search) {
                      $subQuery->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Get filtered parameters
        $parametros = $query->get();

        return view('modules.dashboard.parametros', compact('user', 'parametros', 'search'));
    }

    public function create()
    {
        // Prevent Operador from accessing create page
        $user = User::with('role')
            ->where('id', Auth::id())
            ->first();
        
        if ($user && $user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para crear parámetros.');
        }

        $grupos = GrupoParametro::all();
        return view('modules.dashboard.parametros.create', compact('grupos'));
    }

    public function store(Request $request)
    {
        // Prevent Operador from storing parameters
        $user = User::with('role')
            ->where('id', Auth::id())
            ->first();
        
        if ($user && $user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para crear parámetros.');
        }

        $request->validate([
            'codigo' => [
                'required',
                'string',
                'unique:parametros',
                'regex:/^[a-z]+(\\.[a-z]+)*$/'
            ],
            'descripcion' => 'required|string|max:255',
            'valor' => 'required|string|max:255',
            'grupo_id' => 'required|exists:grupos_parametros,id'
        ], [
            'codigo.regex' => 'El código solo puede contener letras minúsculas y puntos como separadores (ejemplo: sistema.config.timeout).',
            'codigo.unique' => 'Este código ya está en uso.',
            'grupo_id.required' => 'Debe seleccionar un grupo de parámetros.',
            'grupo_id.exists' => 'El grupo seleccionado no es válido.'
        ]);

        $parametro = Parametro::create($request->only(['codigo', 'descripcion', 'valor', 'grupo_id']));

        // Registrar creación en bitácora
        $user = Auth::user();
        $modulo = Modulo::firstOrCreate(
            ['codigo' => 'PARAMETROS'],
            [
                'nombre' => 'Parámetros',
                'descripcion' => 'Módulo de gestión de parámetros del sistema',
                'activo' => true
            ]
        );

        Bitacora::create([
            'user_id' => $user->id,
            'usuario' => $user->name . ' ' . $user->apellido,
            'accion' => 'creación',
            'modulo_id' => $modulo->id,
            'detalles' => "Creación de nuevo parámetro:\nCódigo: {$parametro->codigo}\nDescripción: {$parametro->descripcion}\nValor: {$parametro->valor}\nGrupo: {$parametro->grupo->nombre}"
        ]);

        return redirect()->route('parametros.index')->with('success', 'Parámetro creado exitosamente');
    }

    public function edit($id)
    {
        // Prevent Operador from accessing edit page
        $user = User::with('role')
            ->where('id', Auth::id())
            ->first();
        
        if ($user && $user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para editar parámetros.');
        }

        $parametro = Parametro::find($id);
        return view('modules.dashboard.parametros.edit', compact('parametro'));
    }

    public function update(Request $request, $id)
    {
        // Prevent Operador from accessing update method
        $user = User::with('role')
            ->where('id', Auth::id())
            ->first();
        
        if ($user && $user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para editar parámetros.');
        }

        $request->validate([
            'codigo' => [
                'required',
                'string',
                'regex:/^[a-z]+(\\.[a-z]+)*$/',
                Rule::unique('parametros')->ignore($id)
            ],
            'descripcion' => 'required|string|max:255',
            'valor' => 'required|string|max:255'
        ], [
            'codigo.regex' => 'El código solo puede contener letras minúsculas y puntos como separadores (ejemplo: sistema.config.timeout).',
            'codigo.unique' => 'Este código ya está en uso.'
        ]);

        $oldData = Parametro::find($id)->toArray();
        Parametro::find($id)->update($request->only(['codigo', 'descripcion', 'valor']));

        // Registrar actualización en bitácora
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'actualización',
            'modulo' => 'parámetros',
            'descripcion' => "Actualización del parámetro: " . Parametro::find($id)->codigo,
            'detalles' => "Datos anteriores:\nCódigo: {$oldData['codigo']}\nDescripción: {$oldData['descripcion']}\nValor: {$oldData['valor']}\n\n" .
                         "Datos nuevos:\nCódigo: " . Parametro::find($id)->codigo . "\nDescripción: " . Parametro::find($id)->descripcion . "\nValor: " . Parametro::find($id)->valor
        ]);

        return redirect()->route('parametros.index')->with('success', 'Parámetro actualizado exitosamente');
    }
}

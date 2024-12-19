<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PerfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rol = DB::table('roles')->find($user->role_id);
        
        // Asignar el nombre del rol al usuario
        $user->role = $rol->nombre;
        
        return view('modules.perfil.index', [
            'user' => $user,
            'rol' => $rol
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = User::find(Auth::id());

            $request->validate([
                'telefono' => ['nullable', 'string', 'max:20'],
                'avatar' => ['nullable', 'image', 'max:2048'], // máximo 2MB
                'current_password' => ['nullable', 'required_with:new_password'],
                'new_password' => ['nullable', 'min:8', 'confirmed'],
            ]);

            $changes = [];
            
            // Actualizar teléfono
            if ($user->telefono !== $request->telefono) {
                $user->telefono = $request->telefono;
                $changes[] = 'teléfono';
            }

            // Manejar la subida de avatar si se proporciona uno nuevo
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                // Eliminar avatar anterior si existe
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Crear directorio si no existe
                $avatarPath = 'avatars/' . $user->id;
                Storage::disk('public')->makeDirectory($avatarPath);

                // Generar nombre único para el archivo
                $filename = time() . '_' . $user->id . '.' . $request->file('avatar')->getClientOriginalExtension();
                
                // Guardar la imagen
                $path = $request->file('avatar')->storeAs($avatarPath, $filename, 'public');
                
                if (!$path || !Storage::disk('public')->exists($avatarPath . '/' . $filename)) {
                    throw new \Exception('No se pudo guardar la imagen correctamente');
                }
                
                // Guardar la ruta relativa en la base de datos
                $user->avatar = $avatarPath . '/' . $filename;
                $changes[] = 'foto de perfil';
            }

            // Actualizar contraseña si se proporciona
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    throw new \Exception('La contraseña actual no es correcta.');
                }
                $user->password = Hash::make($request->new_password);
                $changes[] = 'contraseña';
            }

            $user->save();

            // Construir mensaje de éxito
            $message = count($changes) > 0 
                ? 'Se ha actualizado correctamente: ' . implode(', ', $changes)
                : 'No se realizaron cambios';

            $response = [
                'success' => true,
                'message' => $message
            ];

            // Agregar URL del avatar si se actualizó
            if (in_array('foto de perfil', $changes)) {
                $response['avatar_url'] = asset('storage/' . $user->avatar);
            }

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            return back()->with('success', $response['message']);

        } catch (\Exception $e) {
            Log::error('Error en actualización de perfil', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function deleteAvatar()
    {
        $user = User::find(Auth::id());

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Foto de perfil eliminada exitosamente.');
    }
}

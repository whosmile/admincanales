<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class PerfilController extends Controller
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

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
        $user = User::find(Auth::id());

        $request->validate([
            'telefono' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:2048'], // máximo 2MB
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        // Actualizar teléfono
        $user->telefono = $request->telefono;

        // Manejar la subida de avatar si se proporciona uno nuevo
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Procesar y guardar la imagen
            $image = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $image->getClientOriginalExtension();
            
            // Crear directorio si no existe
            $avatarPath = 'avatars/' . $user->id;
            if (!Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->makeDirectory($avatarPath);
            }
            
            // Redimensionar y optimizar la imagen
            $img = $this->manager->read($image->getRealPath());
            $img = $img->cover(300, 300);
            
            // Guardar imagen optimizada
            $savePath = storage_path('app/public/' . $avatarPath . '/' . $filename);
            file_put_contents($savePath, $img->encode(new JpegEncoder(80)));
            
            $user->avatar = $avatarPath . '/' . $filename;
        }

        // Actualizar contraseña si se proporciona
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado exitosamente.');
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

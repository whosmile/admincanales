<?php

namespace App\Http\Controllers;

use App\Models\PermisoVuelto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermisoVueltoController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los datos del cliente de la sesión
        $cliente = [
            'nombre' => $request->session()->get('cliente_nombre'),
            'login' => $request->session()->get('cliente_login'),
            'telefono' => $request->session()->get('cliente_telefono')
        ];

        // Obtener el usuario consultado
        $cedula = $request->session()->get('cliente_login');
        $user = User::where('cedula', $cedula)->first();

        // Obtener los permisos si existe el usuario
        $permisos = null;
        if ($user) {
            $permisos = PermisoVuelto::where('user_id', $user->id)->first();
        }

        return view('modules.permiso-vuelto.index', compact('cliente', 'permisos'));
    }

    public function actualizarPermisos(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string',
            'permiso_p2p' => 'required|boolean',
            'permiso_homebanking' => 'required|boolean'
        ]);

        // Buscar el usuario por cédula
        $user = User::where('cedula', $request->cedula)->firstOrFail();

        // Actualizar o crear los permisos
        $permisos = PermisoVuelto::updateOrCreate(
            ['user_id' => $user->id],
            [
                'permiso_p2p' => $request->permiso_p2p,
                'permiso_homebanking' => $request->permiso_homebanking,
                'modificado_por' => Auth::user()->name
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Permisos actualizados correctamente',
            'data' => $permisos
        ]);
    }
}

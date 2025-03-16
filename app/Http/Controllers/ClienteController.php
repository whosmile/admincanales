<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\UserLimit;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    public function search(Request $request, $cedula)
    {
        try {
            $cliente = Cliente::with('limits')
                            ->where('cedula', $cedula)
                            ->firstOrFail();

            // Si no existen límites, crear con valores por defecto
            if (!$cliente->limits) {
                $cliente->limits = UserLimit::create([
                    'cedula' => $cedula,
                    'limite_delsur' => 0,
                    'limite_otros' => 50000.00
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'cedula' => $cliente->cedula,
                    'nombre' => $cliente->nombre,
                    'email' => $cliente->email,
                    'telefono' => $cliente->telefono,
                    'status' => $cliente->status,
                    'ultimo_login' => $cliente->ultimo_login,
                    'role' => $cliente->role,
                    'limits' => [
                        'limite_delsur' => number_format($cliente->limits->limite_delsur, 2, ',', '.'),
                        'limite_otros' => number_format($cliente->limits->limite_otros, 2, ',', '.')
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda de cliente', [
                'cedula' => $cedula,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado'
            ], 404);
        }
    }

    public function updateLimite(Request $request, $cedula, $tipo)
    {
        try {
            // Validar que el tipo sea correcto
            if (!in_array($tipo, ['delsur', 'otros'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de límite inválido'
                ], 400);
            }

            // Validar el límite
            $request->validate([
                'limite' => 'required|numeric|min:0'
            ]);

            // Buscar el cliente primero
            $cliente = User::where('cedula', $cedula)->first();
            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cliente no encontrado'
                ], 404);
            }

            Log::info('Actualizando límite', [
                'cedula' => $cedula,
                'tipo' => $tipo,
                'valor' => $request->limite
            ]);

            // Obtener o crear límites para el usuario
            $userLimit = UserLimit::updateOrCreate(
                ['cedula' => $cedula],
                [
                    $tipo === 'delsur' ? 'limite_delsur' : 'limite_otros' => $request->limite
                ]
            );

            // Asegurarse de que el modelo se ha actualizado
            $userLimit->refresh();

            // Obtener el valor del campo actualizado
            $campoActualizado = $tipo === 'delsur' ? 'limite_delsur' : 'limite_otros';
            $valorActualizado = $userLimit->$campoActualizado;

            Log::info('Límite actualizado', [
                'cedula' => $cedula,
                'tipo' => $tipo,
                'valor_anterior' => $request->limite,
                'valor_nuevo' => $valorActualizado
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Límite actualizado correctamente',
                'data' => [
                    'limite_delsur' => $tipo === 'delsur' ? number_format($valorActualizado, 2, ',', '.') : null,
                    'limite_otros' => $tipo === 'otros' ? number_format($valorActualizado, 2, ',', '.') : null
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al actualizar límite', [
                'cedula' => $cedula,
                'tipo' => $tipo,
                'errores' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'El límite debe ser un número válido mayor o igual a cero'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar límite', [
                'cedula' => $cedula,
                'tipo' => $tipo,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el límite: ' . $e->getMessage()
            ], 500);
        }
    }
}

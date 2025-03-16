<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bitacora;
use App\Models\BitacoraAdministrativa;
use App\Models\Modulo;
use App\Models\EstadoTransaccion;
use App\Models\Transaccion;
use App\Models\TipoTransaccion;
use Carbon\Carbon;

class ConsultasController extends Controller
{
    public function clientes(Request $request)
    {
        // Obtener los datos del cliente de la sesión si existen
        $clienteData = null;
        if ($request->session()->has('cliente_nombre')) {
            $clienteData = [
                'nombre' => $request->session()->get('cliente_nombre'),
                'cedula' => $request->session()->get('cliente_login'),
                'telefono' => $request->session()->get('cliente_telefono'),
                'email' => $request->session()->get('cliente_email'),
                'status' => $request->session()->get('cliente_status'),
                'ultimo_login' => $request->session()->get('cliente_ultimo_login'),
                'role' => $request->session()->get('cliente_role')
            ];
        }

        return view('modules.consultas.clientes', compact('clienteData'));
    }

    public function buscarCliente(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'tipo_cedula' => 'required|in:V,E',
            'cedula' => 'required|string|max:10'
        ]);

        $nacionalidad = strtoupper($request->tipo_cedula);
        $numero = $request->cedula;
        
        Log::info('Búsqueda de cliente iniciada', [
            'nacionalidad' => $nacionalidad,
            'numero' => $numero,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        try {
            // Limpiar el número de cédula (solo permitir dígitos)
            $numeroLimpio = preg_replace('/[^0-9]/', '', $numero);
            
            // Formatear la cédula como se guarda en la base de datos (V-12345678)
            $cedulaFormateada = $nacionalidad . '-' . $numeroLimpio;
            
            Log::info('Cédula formateada', [
                'cedula_formateada' => $cedulaFormateada
            ]);

            // Buscar el cliente
            $cliente = User::where('cedula', $cedulaFormateada)
                ->with(['role' => function($query) {
                    $query->select('id', 'nombre');
                }])
                ->select('id', 'cedula', 'name', 'apellido', 'email', 'telefono', 'status', 'ultimo_login', 'role_id')
                ->first();

            $user = Auth::user();
            
            // Obtener el módulo CLIENTES
            $modulo = Modulo::where('codigo', 'CLIENTES')->first();
            if (!$modulo) {
                Log::error('Módulo CLIENTES no encontrado');
                
                // Intentar crear el módulo si no existe
                try {
                    $modulo = Modulo::create([
                        'codigo' => 'CLIENTES',
                        'nombre' => 'Gestión de Clientes',
                        'descripcion' => 'Módulo para la gestión y consulta de clientes del sistema',
                        'activo' => true
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error al crear el módulo CLIENTES: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Error en la configuración del sistema. Por favor, contacte al administrador.'
                    ], 500);
                }
            }
            
            $logData = [
                'user_id' => $user->id,
                'usuario' => $user->name . ' ' . $user->apellido,
                'accion' => 'Búsqueda de cliente',
                'modulo_id' => $modulo->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ];

            if (!$cliente) {
                Log::info('Cliente no encontrado', [
                    'cedula_buscada' => $cedulaFormateada
                ]);

                // Registrar búsqueda sin éxito
                $logData['detalles'] = "Cliente no encontrado con cédula: {$cedulaFormateada}";
                $logData['datos_nuevos'] = json_encode([
                    'cedula' => $cedulaFormateada,
                    'encontrado' => false
                ]);
                Bitacora::create($logData);

                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ningún cliente con la cédula especificada'
                ]);
            }

            Log::info('Cliente encontrado', [
                'cedula' => $cliente->cedula,
                'nombre' => $cliente->name . ' ' . $cliente->apellido
            ]);
            
            // Registrar búsqueda exitosa
            $logData['detalles'] = "Búsqueda exitosa de cliente con cédula: {$cedulaFormateada}";
            $logData['datos_nuevos'] = json_encode([
                'cedula' => $cedulaFormateada,
                'encontrado' => true,
                'cliente_id' => $cliente->id
            ]);
            Bitacora::create($logData);

            // Guardar datos del cliente en la sesión
            $request->session()->put([
                'cliente_nombre' => $cliente->name . ' ' . $cliente->apellido,
                'cliente_login' => $cliente->cedula,
                'cliente_telefono' => $cliente->telefono,
                'cliente_email' => $cliente->email,
                'cliente_status' => $cliente->status,
                'cliente_ultimo_login' => $cliente->ultimo_login,
                'cliente_role' => $cliente->role ? [
                    'nombre' => $cliente->role->nombre
                ] : null
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'nombre' => $cliente->name . ' ' . $cliente->apellido,
                    'cedula' => $cliente->cedula,
                    'email' => $cliente->email,
                    'telefono' => $cliente->telefono,
                    'ultimo_login' => $cliente->ultimo_login,
                    'status' => $cliente->status,
                    'role' => $cliente->role ? [
                        'nombre' => $cliente->role->nombre
                    ] : null
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error en búsqueda de cliente', [
                'error' => $e->getMessage(),
                'nacionalidad' => $nacionalidad,
                'numero' => $numero,
                'trace' => $e->getTraceAsString()
            ]);

            // Registrar el error en la bitácora
            $user = Auth::user();
            
            // Obtener el módulo CLIENTES para el registro de error
            $modulo = Modulo::where('codigo', 'CLIENTES')->first();
            if (!$modulo) {
                Log::error('Módulo CLIENTES no encontrado');
                return response()->json([
                    'success' => false,
                    'message' => 'Error en la configuración del sistema. Por favor, contacte al administrador.'
                ], 500);
            }
            
            Bitacora::create([
                'user_id' => $user->id,
                'usuario' => $user->name . ' ' . $user->apellido,
                'accion' => 'Error en búsqueda',
                'modulo_id' => $modulo->id,
                'detalles' => "Error al buscar cliente con cédula: {$nacionalidad}-{$numero}",
                'datos_nuevos' => json_encode([
                    'error' => $e->getMessage(),
                    'nacionalidad' => $nacionalidad,
                    'numero' => $numero
                ]),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al buscar el cliente. Por favor, intente nuevamente.'
            ], 500);
        }
    }

    public function bitacora(Request $request)
    {
        // Obtener los valores de los filtros
        $desde = $request->input('desde', Carbon::now()->subDays(7)->format('Y-m-d'));
        $hasta = $request->input('hasta', Carbon::now()->format('Y-m-d'));
        $usuario = $request->input('usuario', '');

        // Consultar ambas bitácoras y unir los resultados
        $bitacoraRegular = Bitacora::with(['user', 'modulo'])
            ->when($desde, function($query) use ($desde) {
                return $query->whereDate('created_at', '>=', $desde);
            })
            ->when($hasta, function($query) use ($hasta) {
                return $query->whereDate('created_at', '<=', $hasta);
            })
            ->when($usuario, function($query) use ($usuario) {
                return $query->where('usuario', 'LIKE', '%' . $usuario . '%');
            })
            ->select('created_at', 'usuario', 'accion', 'detalles');

        $bitacoraAdmin = BitacoraAdministrativa::when($desde, function($query) use ($desde) {
                return $query->whereDate('created_at', '>=', $desde);
            })
            ->when($hasta, function($query) use ($hasta) {
                return $query->whereDate('created_at', '<=', $hasta);
            })
            ->when($usuario, function($query) use ($usuario) {
                return $query->where('usuario', 'LIKE', '%' . $usuario . '%');
            })
            ->select('created_at', 'usuario', 'accion', 'detalles');

        // Unir las consultas y ordenar por fecha
        $bitacora = $bitacoraRegular->union($bitacoraAdmin)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('modules.consultas.bitacora', compact('bitacora', 'desde', 'hasta', 'usuario'));
    }

    private function registrarEnBitacora($modulo_id, $accion, $detalles = null, $datos_nuevos = null)
    {
        $user = Auth::user();
        
        Bitacora::create([
            'user_id' => $user->id,
            'modulo_id' => $modulo_id,
            'accion' => $accion,
            'detalles' => $detalles,
            'datos_nuevos' => $datos_nuevos,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public function logTransaccional(Request $request)
    {
        try {
            // Obtener los parámetros de búsqueda
            $desde = $request->get('desde', Carbon::now()->subDays(7)->format('Y-m-d'));
            $hasta = $request->get('hasta', Carbon::now()->format('Y-m-d'));
            $cedula = $request->get('cedula');
            $transaccion = $request->get('transaccion');
            $origen = $request->get('origen');
            $destino = $request->get('destino');
            $ref = $request->get('ref');

            // Verificar si se están aplicando filtros manualmente (no por defecto)
            $filtrosAplicados = $request->hasAny(['desde', 'hasta', 'cedula', 'transaccion', 'origen', 'destino', 'ref']);

            // Construir la consulta base
            $query = Transaccion::query()
                ->with(['user', 'tipoTransaccion'])
                ->when($desde, function ($q) use ($desde) {
                    return $q->whereDate('fecha_hora', '>=', $desde);
                })
                ->when($hasta, function ($q) use ($hasta) {
                    return $q->whereDate('fecha_hora', '<=', $hasta);
                })
                ->when($cedula, function ($q) use ($cedula) {
                    // Limpiar el número de cédula (solo permitir dígitos y guiones)
                    $cedula = preg_replace('/[^0-9V-]/', '', strtoupper($cedula));
                    return $q->where('cedula', 'like', '%' . $cedula . '%');
                })
                ->when($transaccion, function ($q) use ($transaccion) {
                    return $q->whereHas('tipoTransaccion', function($subq) use ($transaccion) {
                        $subq->where('nombre', $transaccion);
                    });
                })
                ->when($origen, function ($q) use ($origen) {
                    return $q->where('origen', 'like', '%' . $origen . '%');
                })
                ->when($destino, function ($q) use ($destino) {
                    return $q->where('destino', 'like', '%' . $destino . '%');
                })
                ->when($ref, function ($q) use ($ref) {
                    // Limpiar la referencia (solo permitir alfanuméricos y guiones)
                    $ref = preg_replace('/[^A-Z0-9-]/', '', strtoupper($ref));
                    return $q->where('ref', 'like', '%' . $ref . '%');
                })
                ->orderBy('fecha_hora', 'desc');

            // Obtener las transacciones paginadas
            $transacciones = $query->paginate(10);

            // Obtener los tipos de transacción únicos
            $tipos_transaccion = TipoTransaccion::orderBy('nombre')->pluck('nombre');

            // Registrar en bitácora solo si hay filtros aplicados manualmente
            if ($filtrosAplicados) {
                $user = Auth::user();
                $modulo = Modulo::firstOrCreate(
                    ['codigo' => 'LOG-TRANSACCIONAL'],
                    [
                        'nombre' => 'Log Transaccional',
                        'descripcion' => 'Módulo de registro y consulta de transacciones del sistema',
                        'activo' => true
                    ]
                );

                $detalles = "Consulta de Log Transaccional\n";
                $filtros = [];

                if ($request->has('desde')) $filtros[] = "Desde: {$desde}";
                if ($request->has('hasta')) $filtros[] = "Hasta: {$hasta}";
                if ($cedula) $filtros[] = "Cédula: {$cedula}";
                if ($transaccion) $filtros[] = "Tipo Transacción: {$transaccion}";
                if ($origen) $filtros[] = "Origen: {$origen}";
                if ($destino) $filtros[] = "Destino: {$destino}";
                if ($ref) $filtros[] = "Referencia: {$ref}";

                $detalles .= "Filtros aplicados:\n" . implode("\n", $filtros);

                Bitacora::create([
                    'user_id' => $user->id,
                    'usuario' => $user->name . ' ' . $user->apellido,
                    'accion' => 'Consulta de Log Transaccional',
                    'modulo_id' => $modulo->id,
                    'detalles' => $detalles,
                    'datos_nuevos' => json_encode([
                        'filtros' => $filtros,
                        'resultados' => $transacciones->total()
                    ]),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]);
            }

            return view('modules.consultas.log-transaccional', compact(
                'transacciones',
                'tipos_transaccion',
                'desde',
                'hasta',
                'cedula',
                'transaccion',
                'origen',
                'destino',
                'ref'
            ));

        } catch (\Exception $e) {
            Log::error('Error en log transaccional: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Registrar el error en la bitácora
            try {
                $user = Auth::user();
                $modulo = Modulo::where('codigo', 'LOG-TRANSACCIONAL')->first();
                
                if ($modulo) {
                    Bitacora::create([
                        'user_id' => $user->id,
                        'usuario' => $user->name . ' ' . $user->apellido,
                        'accion' => 'Error en Log Transaccional',
                        'modulo_id' => $modulo->id,
                        'detalles' => 'Error al consultar el log transaccional: ' . $e->getMessage(),
                        'datos_nuevos' => json_encode([
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]),
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]);
                }
            } catch (\Exception $logError) {
                Log::error('Error al registrar en bitácora: ' . $logError->getMessage());
            }
            
            return back()->with('error', 'Error al cargar el log transaccional. Por favor, intente nuevamente.');
        }
    }
}

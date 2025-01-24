<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ServiciosController extends Controller
{
    public function index(Request $request)
    {
        // Get the authenticated user with role
        $user = Auth::user()->load('role');

        // Get search query
        $search = $request->get('search');

        // Base query for services
        $query = DB::table('servicios')
            ->join('tipos_servicios', 'servicios.tipo_servicio_id', '=', 'tipos_servicios.id')
            ->leftJoin('limites_servicios', 'servicios.id', '=', 'limites_servicios.servicio_id')
            ->leftJoin('configuraciones_servicios', 'servicios.id', '=', 'configuraciones_servicios.servicio_id')
            ->select(
                'servicios.id',
                'servicios.nombre',
                'tipos_servicios.codigo as tipo_servicio',
                'servicios.activo as estatus',
                'limites_servicios.limite_minimo',
                'limites_servicios.limite_maximo',
                'configuraciones_servicios.maxima_afiliacion'
            );

        // Apply search filter if search query exists
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('servicios.nombre', 'like', "%{$search}%")
                  ->orWhere('tipos_servicios.codigo', 'like', "%{$search}%");
            });
        }

        // Get filtered services
        $servicios = $query->get();

        return view('modules.dashboard.servicios', compact('user', 'servicios', 'search'));
    }

    public function create()
    {
        // Prevent Operador from accessing create page
        $user = Auth::user()->load('role');
        
        if ($user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para crear servicios.');
        }

        return view('modules.servicios.create');
    }

    public function store(Request $request)
    {
        // Prevent Operador from storing services
        $user = Auth::user()->load('role');
        
        if ($user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para crear servicios.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_servicio' => 'required|string|max:50',
            'estatus' => 'required|boolean',
            'limite_minimo' => 'required|numeric|min:0',
            'limite_maximo' => 'required|numeric|gt:limite_minimo',
            'maxima_afiliacion' => 'required|integer|min:1',
            'multiplo' => 'required|numeric|min:0.01'
        ]);

        DB::table('servicios')->insert([
            'nombre' => $request->nombre,
            'tipo_servicio' => $request->tipo_servicio,
            'estatus' => $request->estatus,
            'limite_minimo' => $request->limite_minimo,
            'limite_maximo' => $request->limite_maximo,
            'maxima_afiliacion' => $request->maxima_afiliacion,
            'multiplo' => $request->multiplo,
            'fecha_creacion' => now()
        ]);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio creado exitosamente');
    }

    public function edit($id)
    {
        // Prevent Operador from accessing edit page
        $user = Auth::user()->load('role');
        
        if ($user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para editar servicios.');
        }

        $servicio = DB::table('servicios')
            ->join('tipos_servicios', 'servicios.tipo_servicio_id', '=', 'tipos_servicios.id')
            ->leftJoin('limites_servicios', 'servicios.id', '=', 'limites_servicios.servicio_id')
            ->leftJoin('configuraciones_servicios', 'servicios.id', '=', 'configuraciones_servicios.servicio_id')
            ->where('servicios.id', $id)
            ->select(
                'servicios.id',
                'servicios.nombre',
                'tipos_servicios.codigo as tipo_servicio',
                'servicios.activo as estatus',
                'limites_servicios.limite_minimo',
                'limites_servicios.limite_maximo',
                'configuraciones_servicios.maxima_afiliacion'
            )
            ->first();

        if (!$servicio) {
            return redirect()->route('servicios.index')
                ->with('error', 'Servicio no encontrado');
        }

        return view('modules.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        // Prevent Operador from accessing update method
        $user = Auth::user()->load('role');
        
        if ($user->role && $user->role->nombre === 'Operador') {
            abort(403, 'No tienes permiso para editar servicios.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_servicio' => 'required|string|max:50',
            'estatus' => 'required|boolean',
            'limite_minimo' => 'required|numeric|min:0',
            'limite_maximo' => 'required|numeric|gt:limite_minimo',
            'maxima_afiliacion' => 'required|integer|min:1'
        ]);

        try {
            // Get the tipo_servicio_id from tipos_servicios table
            $tipo_servicio_id = DB::table('tipos_servicios')
                ->where('codigo', $request->tipo_servicio)
                ->value('id');

            if (!$tipo_servicio_id) {
                return redirect()->back()
                    ->with('error', 'Tipo de servicio no válido')
                    ->withInput();
            }

            // Debugging: Log all input data
            \Log::info('Service Update Input', [
                'service_id' => $id,
                'nombre' => $request->nombre,
                'tipo_servicio_id' => $tipo_servicio_id,
                'estatus' => $request->estatus,
                'limite_minimo' => $request->limite_minimo,
                'limite_maximo' => $request->limite_maximo,
                'maxima_afiliacion' => $request->maxima_afiliacion
            ]);

            // Get current service data for comparison
            $currentService = DB::table('servicios')->where('id', $id)->first();
            
            // Debugging: Log current service state
            \Log::info('Current Service State', [
                'service_id' => $id,
                'current_activo' => $currentService->activo,
                'new_activo' => $request->estatus
            ]);

            $updateResult = DB::table('servicios')
                ->where('id', $id)
                ->update([
                    'nombre' => $request->nombre,
                    'tipo_servicio_id' => $tipo_servicio_id,
                    'activo' => $request->estatus
                ]);

            // Debugging: Log update result
            \Log::info('Service Update Result', [
                'service_id' => $id,
                'update_result' => $updateResult,
                'affected_rows' => $updateResult
            ]);

            // Update or insert into limites_servicios
            DB::table('limites_servicios')
                ->updateOrInsert(
                    ['servicio_id' => $id],
                    [
                        'limite_minimo' => $request->limite_minimo,
                        'limite_maximo' => $request->limite_maximo,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

            // Update or insert into configuraciones_servicios
            DB::table('configuraciones_servicios')
                ->updateOrInsert(
                    ['servicio_id' => $id],
                    [
                        'maxima_afiliacion' => $request->maxima_afiliacion,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

            return redirect()->route('servicios.index')
                ->with('success', '¡El servicio ha sido actualizado exitosamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el servicio: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function data(Request $request)
    {
        $query = DB::table('servicios');

        if ($request->filled('tipo_servicio')) {
            $query->where('tipo_servicio', $request->tipo_servicio);
        }

        $servicios = $query->get();

        return response()->json(['data' => $servicios]);
    }

    public function destroy($id)
    {
        DB::table('servicios')->where('id', $id)->delete();
        return response()->json(['message' => 'Servicio eliminado exitosamente']);
    }

    public function setTipo(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|string'
            ]);

            session(['tipo_servicio' => $request->tipo]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al establecer el tipo de servicio: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getData(Request $request)
    {
        try {
            $tipo = $request->query('tipo');
            if (!$tipo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de servicio no especificado'
                ], 400);
            }

            $servicios = DB::table('servicios')
                ->join('tipos_servicios', 'servicios.tipo_servicio_id', '=', 'tipos_servicios.id')
                ->leftJoin('limites_servicios', 'servicios.id', '=', 'limites_servicios.servicio_id')
                ->leftJoin('configuraciones_servicios', 'servicios.id', '=', 'configuraciones_servicios.servicio_id')
                ->where('tipos_servicios.codigo', $tipo)
                ->select(
                    'servicios.id',
                    'servicios.nombre',
                    'tipos_servicios.codigo as tipo',
                    DB::raw('CASE WHEN servicios.activo = 1 THEN "Activo" ELSE "Inactivo" END as estatus'),
                    'servicios.activo as activo_raw',
                    'limites_servicios.limite_minimo',
                    'limites_servicios.limite_maximo',
                    'configuraciones_servicios.maxima_afiliacion'
                )
                ->get();

            // Additional logging for debugging
            \Log::info('Services Data Fetch', [
                'tipo' => $tipo,
                'total_services' => $servicios->count(),
                'services_details' => $servicios->map(function($service) {
                    return [
                        'id' => $service->id,
                        'nombre' => $service->nombre,
                        'estatus' => $service->estatus,
                        'activo_raw' => $service->activo_raw
                    ];
                })->toArray()
            ]);

            return response()->json([
                'success' => true,
                'data' => $servicios
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los servicios: ' . $e->getMessage()
            ], 500);
        }
    }
}

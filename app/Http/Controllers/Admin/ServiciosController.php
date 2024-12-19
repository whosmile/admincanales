<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    public function index()
    {
        return view('modules.dashboard.servicios');
    }

    public function create()
    {
        return view('modules.servicios.create');
    }

    public function store(Request $request)
    {
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
        $servicio = DB::table('servicios')
            ->join('tipos_servicios', 'servicios.tipo_servicio_id', '=', 'tipos_servicios.id')
            ->where('servicios.id', $id)
            ->select(
                'servicios.id',
                'servicios.nombre',
                'tipos_servicios.codigo as tipo_servicio',
                'servicios.activo as estatus',
                'servicios.limite_minimo',
                'servicios.limite_maximo',
                'servicios.maxima_afiliacion'
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

            DB::table('servicios')
                ->where('id', $id)
                ->update([
                    'nombre' => $request->nombre,
                    'tipo_servicio_id' => $tipo_servicio_id,
                    'activo' => $request->estatus,
                    'limite_minimo' => $request->limite_minimo,
                    'limite_maximo' => $request->limite_maximo,
                    'maxima_afiliacion' => $request->maxima_afiliacion
                ]);

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
                ->where('tipos_servicios.codigo', $tipo)
                ->select(
                    'servicios.id',
                    'servicios.nombre',
                    'tipos_servicios.codigo as tipo',
                    DB::raw('IF(servicios.activo = 1, "Activo", "Inactivo") as estatus'),
                    'servicios.limite_minimo',
                    'servicios.limite_maximo',
                    'servicios.maxima_afiliacion'
                )
                ->get();

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

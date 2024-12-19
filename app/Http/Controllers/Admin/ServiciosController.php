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
            'NOMBRE' => $request->nombre,
            'TIPO_SERVICIO' => $request->tipo_servicio,
            'ESTATUS' => $request->estatus,
            'LIMITE_MINIMO' => $request->limite_minimo,
            'LIMITE_MAXIMO' => $request->limite_maximo,
            'MAXIMA_AFILIACION' => $request->maxima_afiliacion,
            'MULTIPLO' => $request->multiplo,
            'FECHA_CREACION' => now()
        ]);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio creado exitosamente');
    }

    public function edit($id)
    {
        $servicio = DB::table('servicios')
            ->where('ID_SERVICIO', $id)
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
            'maxima_afiliacion' => 'required|integer|min:1',
            'multiplo' => 'required|numeric|min:0.01'
        ]);

        DB::table('servicios')
            ->where('ID_SERVICIO', $id)
            ->update([
                'NOMBRE' => $request->nombre,
                'TIPO_SERVICIO' => $request->tipo_servicio,
                'ESTATUS' => $request->estatus,
                'LIMITE_MINIMO' => $request->limite_minimo,
                'LIMITE_MAXIMO' => $request->limite_maximo,
                'MAXIMA_AFILIACION' => $request->maxima_afiliacion,
                'MULTIPLO' => $request->multiplo,
                'FECHA_MODIFICACION' => now()
            ]);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado exitosamente');
    }

    public function data(Request $request)
    {
        $query = DB::table('servicios');

        if ($request->filled('tipo_servicio')) {
            $query->where('TIPO_SERVICIO', $request->tipo_servicio);
        }

        $servicios = $query->get();

        return response()->json(['data' => $servicios]);
    }

    public function destroy($id)
    {
        DB::table('servicios')->where('ID_SERVICIO', $id)->delete();
        return response()->json(['message' => 'Servicio eliminado exitosamente']);
    }
}

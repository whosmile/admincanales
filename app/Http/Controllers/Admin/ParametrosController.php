<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use App\Models\Bitacora;
use App\Models\Modulo;
use App\Models\GrupoParametro;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParametrosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $parametros = Parametro::when($search, function ($query) use ($search) {
            return $query->where('codigo', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%");
        })->get();

        if ($search) {
            // Registrar búsqueda en bitácora
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
                'accion' => 'búsqueda',
                'modulo_id' => $modulo->id,
                'detalles' => "Término de búsqueda: {$search}\nResultados encontrados: {$parametros->count()}"
            ]);
        }

        return view('modules.dashboard.parametros', compact('parametros', 'search'));
    }

    public function create()
    {
        $grupos = GrupoParametro::all();
        return view('modules.dashboard.parametros.create', compact('grupos'));
    }

    public function store(Request $request)
    {
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

    public function edit(Parametro $parametro)
    {
        return view('modules.dashboard.parametros.edit', compact('parametro'));
    }

    public function update(Request $request, Parametro $parametro)
    {
        $request->validate([
            'codigo' => [
                'required',
                'string',
                'regex:/^[a-z]+(\\.[a-z]+)*$/',
                Rule::unique('parametros')->ignore($parametro->id)
            ],
            'descripcion' => 'required|string|max:255',
            'valor' => 'required|string|max:255'
        ], [
            'codigo.regex' => 'El código solo puede contener letras minúsculas y puntos como separadores (ejemplo: sistema.config.timeout).',
            'codigo.unique' => 'Este código ya está en uso.'
        ]);

        $oldData = $parametro->toArray();
        $parametro->update($request->only(['codigo', 'descripcion', 'valor']));

        // Registrar actualización en bitácora
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => 'actualización',
            'modulo' => 'parámetros',
            'descripcion' => "Actualización del parámetro: {$parametro->codigo}",
            'detalles' => "Datos anteriores:\nCódigo: {$oldData['codigo']}\nDescripción: {$oldData['descripcion']}\nValor: {$oldData['valor']}\n\n" .
                         "Datos nuevos:\nCódigo: {$parametro->codigo}\nDescripción: {$parametro->descripcion}\nValor: {$parametro->valor}"
        ]);

        return redirect()->route('parametros.index')->with('success', 'Parámetro actualizado exitosamente');
    }
}

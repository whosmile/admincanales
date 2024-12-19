<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener usuarios activos
        $usuariosActivos = User::where('activo', true)->count();
        $totalUsuarios = User::count();
        
        // Obtener estadísticas de actividad por mes desde la bitácora
        $actividadMensual = Bitacora::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('count(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->map(function ($item) {
            $fecha = Carbon::create(date('Y'), $item->mes, 1);
            $item->mes = ucfirst($fecha->locale('es')->monthName);
            return $item;
        });

        // Obtener actividad detallada con módulos
        $actividadDetallada = Bitacora::join('modulos', 'bitacora.modulo_id', '=', 'modulos.id')
            ->select(
                DB::raw('MONTH(bitacora.created_at) as mes'),
                DB::raw('count(*) as total'),
                DB::raw("GROUP_CONCAT(DISTINCT modulos.nombre SEPARATOR ', ') as modulos")
            )
            ->whereYear('bitacora.created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                $fecha = Carbon::create(date('Y'), $item->mes, 1);
                $item->mes = ucfirst($fecha->locale('es')->monthName);
                return [
                    'mes' => $item->mes,
                    'total' => $item->total,
                    'modulos' => $item->modulos
                ];
            });

        // Obtener distribución de usuarios por rol
        $distribucionUsuarios = Role::withCount('users')
            ->get()
            ->map(function ($role) {
                return [
                    'rol' => $role->nombre,
                    'total' => $role->users_count
                ];
            });

        // Obtener actividad reciente
        $actividadReciente = DB::table('bitacora')
            ->join('users', 'bitacora.user_id', '=', 'users.id')
            ->join('modulos', 'bitacora.modulo_id', '=', 'modulos.id')
            ->select(
                'bitacora.accion',
                'modulos.nombre as modulo',
                'bitacora.detalles',
                'bitacora.created_at',
                'users.name',
                'users.apellido'
            )
            ->where('bitacora.user_id', auth()->id())  // Solo mostrar actividades del usuario actual
            ->orderBy('bitacora.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('modules.dashboard.index', compact(
            'usuariosActivos',
            'totalUsuarios',
            'actividadMensual',
            'actividadDetallada',
            'distribucionUsuarios',
            'actividadReciente'
        ));
    }

    public function getRecentActivity()
    {
        $actividadReciente = DB::table('bitacora')
            ->join('users', 'bitacora.user_id', '=', 'users.id')
            ->join('modulos', 'bitacora.modulo_id', '=', 'modulos.id')
            ->select(
                'bitacora.accion',
                'modulos.nombre as modulo',
                'bitacora.detalles',
                'bitacora.created_at',
                'users.name',
                'users.apellido'
            )
            ->where('bitacora.user_id', auth()->id())
            ->orderBy('bitacora.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $item->tiempo = Carbon::parse($item->created_at)->diffForHumans();
                return $item;
            });

        return response()->json($actividadReciente);
    }
}

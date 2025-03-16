<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebTransactionalLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WebTransactionalLogController extends Controller
{
    public function index(Request $request)
    {
        $query = WebTransactionalLog::query();

        // Filtro por fechas
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        // Filtro por usuario
        if ($request->filled('usuario')) {
            $query->where('usuario', 'LIKE', '%' . $request->usuario . '%');
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.web-transactional-log.index', compact('logs'));
    }

    public static function log($accion, $modulo, $detalles = null, $datos = [])
    {
        $user = Auth::user();
        
        WebTransactionalLog::create([
            'user_id' => $user->id,
            'usuario' => $user->name . ' ' . $user->apellido,
            'accion' => $accion,
            'modulo' => $modulo,
            'detalles' => $detalles,
            'datos_anteriores' => $datos['datos_anteriores'] ?? null,
            'datos_nuevos' => $datos['datos_nuevos'] ?? null,
            'parametros_busqueda' => $datos['parametros_busqueda'] ?? null,
            'total_resultados' => $datos['total_resultados'] ?? null,
            'criterio_busqueda' => $datos['criterio_busqueda'] ?? null,
            'filtros_aplicados' => $datos['filtros_aplicados'] ?? null,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}

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
        $query = WebTransactionalLog::with('user');

        // Filtro por fechas
        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        // Filtro por usuario
        if ($request->filled('usuario')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->usuario . '%');
            });
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.web-transactional-log.index', compact('logs'));
    }

    public static function log($action, $module, $description, $details = null)
    {
        WebTransactionalLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}

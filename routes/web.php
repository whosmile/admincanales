<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ConsultasController;
use App\Http\Controllers\Admin\ParametrosController;
use App\Http\Controllers\Admin\ServiciosController;
use App\Http\Controllers\User\PerfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Rutas de Autenticación
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'authenticate'])->name('authenticate');
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/recent-activity', [DashboardController::class, 'getRecentActivity'])->name('dashboard.recent-activity');
    
    // Registro de usuarios (solo admin)
    Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':Administrador'])->group(function () {
        Route::get('/dashboard/usuarios/register', [AuthController::class, 'register'])->name('register');
        Route::post('/dashboard/usuarios/register', [AuthController::class, 'registrar'])->name('register.submit');
    });
    
    // API para usuarios activos en tiempo real
    Route::get('/api/usuarios-activos', function () {
        return response()->json([
            'activos' => \App\Models\User::where('activo', true)->count()
        ]);
    });
    
    // Consultas
    Route::prefix('consultas')->group(function () {
        Route::get('/clientes', [ConsultasController::class, 'clientes'])->name('consultas.clientes');
        Route::post('/clientes/buscar', [ConsultasController::class, 'buscarCliente'])->name('consultas.buscarCliente');
        Route::get('/bitacora', [ConsultasController::class, 'bitacora'])->name('consultas.bitacora');
        Route::get('/log-transaccional', [ConsultasController::class, 'logTransaccional'])
            ->middleware(\App\Http\Middleware\EnsureLogTransaccionalIsConfigured::class)
            ->name('consultas.log-transaccional');
    });
    
    // Parámetros
    Route::prefix('parametros')->group(function () {
        Route::get('/', [ParametrosController::class, 'index'])->name('parametros.index');
        Route::get('/create', [ParametrosController::class, 'create'])->name('parametros.create');
        Route::post('/', [ParametrosController::class, 'store'])->name('parametros.store');
        Route::get('/{parametro}/edit', [ParametrosController::class, 'edit'])->name('parametros.edit');
        Route::put('/{parametro}', [ParametrosController::class, 'update'])->name('parametros.update');
    });
    
    // Servicios
    Route::prefix('servicios')->group(function () {
        Route::get('/', [ServiciosController::class, 'index'])->name('servicios.index');
        Route::post('/set-tipo', [ServiciosController::class, 'setTipo'])->name('servicios.setTipo');
        Route::get('/data', [ServiciosController::class, 'getData'])->name('servicios.getData');
        Route::get('/create', [ServiciosController::class, 'create'])->name('servicios.create');
        Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
        Route::get('/servicios/{id}/edit', [ServiciosController::class, 'edit'])->name('servicios.edit');
        Route::put('/servicios/{id}', [ServiciosController::class, 'update'])->name('servicios.update');
        Route::get('/servicios/empresas/{tipo}', [ServiciosController::class, 'getEmpresas'])->name('servicios.empresas');
        Route::delete('/servicios/{id}', [ServiciosController::class, 'destroy'])->name('servicios.destroy');
    });
    
    // Perfil
    Route::prefix('perfil')->group(function () {
        Route::get('/', [PerfilController::class, 'index'])->name('perfil.index');
        Route::put('/update', [PerfilController::class, 'update'])->name('perfil.update');
        Route::delete('/avatar', [PerfilController::class, 'deleteAvatar'])->name('perfil.delete-avatar');
    });
    
    // Cerrar Sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

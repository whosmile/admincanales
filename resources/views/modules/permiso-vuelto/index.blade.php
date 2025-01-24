@extends('layouts.dashboard')

@section('title', 'Permiso Vuelto al Instante')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header">
                <h1 class="consultas-title">Permiso Vuelto al Instante</h1>
            </div>

            <!-- Información del Cliente -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-group mb-3">
                                <label class="info-label">Nombre de Empresa</label>
                                <p class="mb-0" id="info-nombre">ARMANDO ALBERTO LOPEZ BAUDO</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group mb-3">
                                <label class="info-label">Login</label>
                                <p class="mb-0" id="info-login">V16460959</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group mb-3">
                                <label class="info-label">Teléfono</label>
                                <p class="mb-0" id="info-telefono">04242818497</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permisos del Cliente -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="permisos-list">
                        <div class="permiso-item mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Cliente se encuentra afiliado al servicio de Pago Móvil - P2P</span>
                            </div>
                        </div>
                        <div class="permiso-item mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Permisos Habilitados - Menú HomeBanking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Permiso Vuelto -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Configuración de Permiso Vuelto</h5>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('consultas.clientes') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                        <button type="button" class="btn btn-primary" id="quitarPermisos">
                            <i class="fas fa-ban me-1"></i>Quitar Permisos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/consultas.css') }}">
<style>
    .permiso-item {
        padding: 0.75rem;
        border-radius: 0.375rem;
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
    }
    .permiso-item span {
        color: var(--text-color);
    }
    .info-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        font-weight: 500;
    }
    .info-group p {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-color);
    }
    .card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
    }
    .card-body {
        color: var(--text-color);
    }
    .consultas-title {
        color: var(--text-color);
    }
    .card-title {
        color: var(--text-color);
    }
</style>
@endpush

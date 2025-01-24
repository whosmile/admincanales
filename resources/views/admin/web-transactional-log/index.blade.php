@extends('layouts.dashboard')

@section('title', 'Bitácora Web Transaccional')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header">
                <h1 class="consultas-title">Bitácora Web Transaccional</h1>
            </div>

            <!-- Filtros -->
            <div class="filtros-card">
                <div class="filtros-body">
                    <form id="searchForm" class="row g-3" method="GET" action="{{ route('admin.web-transactional-log.index') }}">
                        <!-- Fechas -->
                        <div class="col-md-3">
                            <label for="desde" class="form-label">Desde</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="desde" 
                                   name="desde" 
                                   value="{{ request('desde') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="hasta" class="form-label">Hasta</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="hasta" 
                                   name="hasta" 
                                   value="{{ request('hasta') }}">
                        </div>

                        <!-- Usuario -->
                        <div class="col-md-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0" 
                                       id="usuario" 
                                       name="usuario" 
                                       placeholder="Buscar por usuario..."
                                       value="{{ request('usuario') }}">
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="d-grid gap-2 w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resultados -->
            <div class="resultados-card mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Módulo</th>
                                        <th>Descripción</th>
                                        <th>IP</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $log->user ? $log->user->name : 'Sistema' }}</td>
                                            <td>{{ $log->action }}</td>
                                            <td>{{ $log->module }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->ip_address }}</td>
                                            <td>
                                                @if($log->details)
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $log->id }}">
                                                        Ver detalles
                                                    </button>
                                                    
                                                    <div class="modal fade" id="detailsModal{{ $log->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $log->id }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailsModalLabel{{ $log->id }}">Detalles de la Transacción</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <pre>{{ json_encode($log->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sin detalles</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No se encontraron registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-end mt-3">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
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
    .filtros-card {
        background: var(--bs-body-bg);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .form-text {
        color: var(--bs-secondary);
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background-color: var(--bs-body-bg);
    }
    
    .table th {
        background-color: var(--bs-gray-100);
        border-bottom-width: 1px;
    }
    
    .table td {
        vertical-align: middle;
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de fechas
    const desdeInput = document.getElementById('desde');
    const hastaInput = document.getElementById('hasta');
    
    function validarFechas() {
        const desde = new Date(desdeInput.value);
        const hasta = new Date(hastaInput.value);
        
        if (desde > hasta) {
            alert('La fecha "Desde" no puede ser mayor que la fecha "Hasta"');
            return false;
        }
        return true;
    }
    
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        if (!validarFechas()) {
            e.preventDefault();
        }
    });
});
</script>
@endpush

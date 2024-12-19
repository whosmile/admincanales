@extends('layouts.dashboard')

@section('title', 'Bitácora del Sistema')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header">
                <h1 class="consultas-title">Bitácora del Sistema</h1>
            </div>

            <!-- Filtros -->
            <div class="filtros-card">
                <div class="filtros-body">
                    <form id="searchForm" class="row g-3" method="GET" action="{{ route('consultas.bitacora') }}">
                        <!-- Fechas -->
                        <div class="col-md-3">
                            <label for="desde" class="form-label">Desde</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="desde" 
                                   name="desde" 
                                   value="{{ $desde }}">
                        </div>
                        <div class="col-md-3">
                            <label for="hasta" class="form-label">Hasta</label>
                            <input type="date" 
                                   class="form-control" 
                                   id="hasta" 
                                   name="hasta" 
                                   value="{{ $hasta }}">
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
                                       value="{{ $usuario }}">
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
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bitacora as $registro)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $registro->usuario }}</td>
                                            <td>{{ $registro->accion }}</td>
                                            <td>{{ $registro->detalles }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No se encontraron registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-end mt-3">
                            {{ $bitacora->appends(request()->query())->links() }}
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

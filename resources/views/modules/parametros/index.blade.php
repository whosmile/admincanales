@extends('layouts.dashboard')

@section('title', 'Parámetros Generales')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header">
                <h1 class="consultas-title">Parámetros Generales</h1>
            </div>

            <!-- Buscador -->
            <div class="filtros-card">
                <div class="filtros-body">
                    <form id="searchForm" class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-0" 
                                       id="search" 
                                       name="search" 
                                       placeholder="Buscar por nombre..."
                                       value="{{ $search }}">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Parámetros -->
            <div class="resultados-card">
                <div class="table-responsive">
                    <table class="table table-consultas">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th>Valor</th>
                                <th>Última Actualización</th>
                            </tr>
                        </thead>
                        <tbody id="parametersTable">
                            @foreach($parameters as $parameter)
                            <tr>
                                <td>{{ $parameter->codigo }}</td>
                                <td>{{ $parameter->descripcion }}</td>
                                <td>{{ $parameter->valor }}</td>
                                <td>{{ \Carbon\Carbon::parse($parameter->updated_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($parameters->hasPages())
                    <div class="pagination-container">
                        {{ $parameters->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const searchForm = document.getElementById('searchForm');
    let searchTimeout;

    // Función para realizar la búsqueda
    function performSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchValue = searchInput.value;
            window.location.href = `{{ route('parametros.index') }}?search=${encodeURIComponent(searchValue)}`;
        }, 500);
    }

    // Evento input para búsqueda en tiempo real
    searchInput.addEventListener('input', performSearch);

    // Prevenir envío del formulario
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        performSearch();
    });
});
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/consultas.css') }}">
@endpush

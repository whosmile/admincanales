@extends('layouts.dashboard')

@section('title', 'Log Transaccional')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header d-flex justify-content-between align-items-center">
                <h1 class="consultas-title h3">Log Transaccional</h1>
            </div>

            <!-- Filtros -->
            <div class="filtros-card">
                <div class="filtros-body">
                    <form id="searchForm" class="row g-3">
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

                        <!-- Cédula -->
                        <div class="col-md-2">
                            <label for="cedula" class="form-label">Documento</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="cedula" 
                                   name="cedula" 
                                   placeholder="V-12345678"
                                   value="{{ $cedula }}">
                        </div>

                        <!-- Tipo de Transacción -->
                        <div class="col-md-2">
                            <label for="transaccion" class="form-label">Tipo</label>
                            <select class="form-select" id="transaccion" name="transaccion">
                                <option value="">Todas</option>
                                @foreach($tipos_transaccion as $tipo)
                                    <option value="{{ $tipo }}" {{ $transaccion == $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Referencia -->
                        <div class="col-md-2">
                            <label for="ref" class="form-label">Referencia</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="ref" 
                                   name="ref" 
                                   placeholder="Ej: REF123"
                                   value="{{ $ref }}">
                        </div>

                        <!-- Botones -->
                        <div class="col-md-12 mt-4 text-end">
                            <button type="reset" class="btn btn-light">
                                <i class="fas fa-undo me-2"></i>Limpiar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Resultados -->
            <div class="resultados-card">
                <div class="table-responsive">
                    <table class="table table-consultas">
                        <thead>
                            <tr>
                                <th>Fecha y Hora</th>
                                <th>Cédula</th>
                                <th>Tipo</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Monto</th>
                                <th>Referencia</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transacciones as $transaccion)
                                <tr>
                                    <td>{{ $transaccion->fecha_hora->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $transaccion->cedula }}</td>
                                    <td>{{ $transaccion->tipoTransaccion->nombre }}</td>
                                    <td>{{ $transaccion->origen }}</td>
                                    <td>{{ $transaccion->destino }}</td>
                                    <td>{{ number_format($transaccion->monto, 2, ',', '.') }}</td>
                                    <td>{{ $transaccion->ref }}</td>
                                    <td>{{ $transaccion->ip }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="no-resultados">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <p class="mb-0">No se encontraron transacciones con los filtros seleccionados</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transacciones->isNotEmpty())
                    <div class="pagination-container">
                        {{ $transacciones->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/modules/consultas.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar el evento reset del formulario
        document.getElementById('searchForm').addEventListener('reset', function(e) {
            // Esperar al siguiente ciclo para que el formulario se limpie
            setTimeout(function() {
                document.getElementById('searchForm').submit();
            }, 0);
        });
    });
</script>
@endpush

@extends('layouts.dashboard')

@section('titulo_pagina')
    Editar Servicio
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Servicio</h1>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editarServicioForm" method="POST" action="{{ route('servicios.update', $servicio->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipo" value="{{ $tipo }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre del Servicio</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ $servicio->nombre }}" readonly disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estatus" class="form-label">Estatus</label>
                                <select class="form-select" id="estatus" name="estatus" required>
                                    <option value="Activo" {{ $servicio->estatus === 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ $servicio->estatus === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="limite_minimo" class="form-label">Límite Mínimo</label>
                                <input type="number" class="form-control" id="limite_minimo" name="limite_minimo" 
                                       value="{{ $servicio->limite_minimo }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="limite_maximo" class="form-label">Límite Máximo</label>
                                <input type="number" class="form-control" id="limite_maximo" name="limite_maximo" 
                                       value="{{ $servicio->limite_maximo }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="maxima_afiliacion" class="form-label">Máxima Afiliación</label>
                                <input type="number" class="form-control" id="maxima_afiliacion" name="maxima_afiliacion" 
                                       value="{{ $servicio->maxima_afiliacion }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('editarServicioForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validaciones básicas
    const limiteMinimo = parseFloat(document.getElementById('limite_minimo').value);
    const limiteMaximo = parseFloat(document.getElementById('limite_maximo').value);
    
    if (limiteMinimo >= limiteMaximo) {
        alert('El límite mínimo debe ser menor que el límite máximo');
        return;
    }
    
    // Si pasa las validaciones, enviar el formulario
    this.submit();
});
</script>
@endpush

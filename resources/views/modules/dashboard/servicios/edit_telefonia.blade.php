@extends('layouts.dashboard')

@section('titulo_pagina')
    Editar Servicio de Telefonía
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Servicio de Telefonía</h1>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editarServicioForm" method="POST" action="{{ route('servicios.update', $servicio->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipo" value="{{ $tipo }}">

                        <div class="row">
                            <!-- Nombre del Servicio (No editable) -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre del Servicio</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ $servicio->nombre }}" readonly disabled>
                            </div>

                            <!-- Estatus -->
                            <div class="col-md-6 mb-3">
                                <label for="estatus" class="form-label">Estatus</label>
                                <select class="form-select @error('estatus') is-invalid @enderror" id="estatus" name="estatus" required>
                                    <option value="Activo" {{ $servicio->estatus === 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ $servicio->estatus === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estatus')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                                @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo de Recarga -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo_recarga" class="form-label">Tipo de Recarga</label>
                                <select class="form-select @error('tipo_recarga') is-invalid @enderror" id="tipo_recarga" name="tipo_recarga" required>
                                    <option value="Escala" {{ old('tipo_recarga', $servicio->tipo_recarga) === 'Escala' ? 'selected' : '' }}>Escala</option>
                                    <option value="Libre" {{ old('tipo_recarga', $servicio->tipo_recarga) === 'Libre' ? 'selected' : '' }}>Libre</option>
                                </select>
                                @error('tipo_recarga')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Límite de Móviles -->
                            <div class="col-md-6 mb-3">
                                <label for="limite_moviles" class="form-label">Límite de Móviles Soportados</label>
                                <input type="number" class="form-control @error('limite_moviles') is-invalid @enderror" 
                                       id="limite_moviles" name="limite_moviles" 
                                       value="{{ old('limite_moviles', $servicio->limite_moviles) }}" required min="1">
                                @error('limite_moviles')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Escala de Montos -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Escala de Montos</label>
                                <div id="escala_montos_container" class="border rounded p-3">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <button type="button" class="btn btn-sm btn-success" onclick="agregarMonto()">
                                                <i class="fas fa-plus me-1"></i>Agregar Monto
                                            </button>
                                        </div>
                                    </div>
                                    <div id="montos_list">
                                        @php
                                            $montos = json_decode($servicio->escala_montos ?? '[]');
                                            $montos = is_array($montos) ? $montos : [];
                                        @endphp
                                        @foreach($montos as $monto)
                                        <div class="row mb-2 monto-item">
                                            <div class="col-md-10">
                                                <input type="number" class="form-control" name="escala_montos[]" 
                                                       value="{{ $monto }}" required min="0" step="0.01">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarMonto(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @error('escala_montos')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                @error('escala_montos.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Límites -->
                            <div class="col-md-4 mb-3">
                                <label for="limite_minimo" class="form-label">Límite Mínimo</label>
                                <input type="number" class="form-control @error('limite_minimo') is-invalid @enderror" 
                                       id="limite_minimo" name="limite_minimo" 
                                       value="{{ old('limite_minimo', $servicio->limite_minimo) }}" required min="0" step="0.01">
                                @error('limite_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="limite_maximo" class="form-label">Límite Máximo</label>
                                <input type="number" class="form-control @error('limite_maximo') is-invalid @enderror" 
                                       id="limite_maximo" name="limite_maximo" 
                                       value="{{ old('limite_maximo', $servicio->limite_maximo) }}" required min="0" step="0.01">
                                @error('limite_maximo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="maxima_afiliacion" class="form-label">Máxima Afiliación</label>
                                <input type="number" class="form-control @error('maxima_afiliacion') is-invalid @enderror" 
                                       id="maxima_afiliacion" name="maxima_afiliacion" 
                                       value="{{ old('maxima_afiliacion', $servicio->maxima_afiliacion) }}" required min="1">
                                @error('maxima_afiliacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
function agregarMonto() {
    const container = document.getElementById('montos_list');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 monto-item';
    newRow.innerHTML = `
        <div class="col-md-10">
            <input type="number" class="form-control" name="escala_montos[]" required min="0" step="0.01">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="eliminarMonto(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

function eliminarMonto(button) {
    button.closest('.monto-item').remove();
}

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

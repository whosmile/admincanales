@extends('layouts.dashboard')

@section('title', 'Crear Servicio')

@section('content')
<div class="consultas-container">
    <div class="card shadow-orange mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-orange">Crear Nuevo Servicio</h6>
        </div>
        <div class="card-body">
            <form id="serviceForm" action="{{ route('servicios.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_servicio" class="form-label">Tipo de Servicio</label>
                        <select class="form-select" id="tipo_servicio" name="tipo_servicio" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="TELEFONIA">Telefonía</option>
                            <option value="TELEVISION">Televisión</option>
                            <option value="AGUA">Agua</option>
                            <option value="GAS">Gas</option>
                            <option value="ELECTRICIDAD">Electricidad</option>
                            <option value="INTERNET">Internet</option>
                            <option value="TELEFONIA_MOVIL">Telefonía Móvil</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="limite_minimo" class="form-label">Límite Mínimo (VES)</label>
                        <input type="number" class="form-control" id="limite_minimo" name="limite_minimo" step="0.01" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="limite_maximo" class="form-label">Límite Máximo (VES)</label>
                        <input type="number" class="form-control" id="limite_maximo" name="limite_maximo" step="0.01" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="maxima_afiliacion" class="form-label">Máxima Afiliación</label>
                        <input type="number" class="form-control" id="maxima_afiliacion" name="maxima_afiliacion" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="multiplo" class="form-label">Múltiplo (VES)</label>
                        <input type="number" class="form-control" id="multiplo" name="multiplo" step="0.01" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="estatus" class="form-label">Estatus</label>
                        <select class="form-select" id="estatus" name="estatus" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-orange">
                        <i class="fas fa-save"></i> Guardar Servicio
                    </button>
                </div>
            </form>
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
    // Validación de límites
    const limiteMinimo = document.getElementById('limite_minimo');
    const limiteMaximo = document.getElementById('limite_maximo');
    const multiplo = document.getElementById('multiplo');
    const maxAfiliacion = document.getElementById('maxima_afiliacion');

    function validarLimites() {
        if (parseFloat(limiteMinimo.value) > parseFloat(limiteMaximo.value)) {
            limiteMaximo.setCustomValidity('El límite máximo debe ser mayor que el límite mínimo');
        } else {
            limiteMaximo.setCustomValidity('');
        }
    }

    limiteMinimo.addEventListener('change', validarLimites);
    limiteMaximo.addEventListener('change', validarLimites);

    // Validación de múltiplo
    multiplo.addEventListener('change', function() {
        if (parseFloat(this.value) <= 0) {
            this.setCustomValidity('El múltiplo debe ser mayor que cero');
        } else {
            this.setCustomValidity('');
        }
    });

    // Validación de máxima afiliación
    maxAfiliacion.addEventListener('change', function() {
        if (parseInt(this.value) <= 0) {
            this.setCustomValidity('La máxima afiliación debe ser mayor que cero');
        } else {
            this.setCustomValidity('');
        }
    });

    // Formateo de números en tiempo real
    const formatoMoneda = new Intl.NumberFormat('es-VE', {
        style: 'currency',
        currency: 'VES'
    });

    [limiteMinimo, limiteMaximo, multiplo].forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value) {
                const valor = parseFloat(this.value);
                this.value = valor.toFixed(2);
            }
        });
    });
});
</script>
@endpush

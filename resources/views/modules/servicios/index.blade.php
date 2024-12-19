@extends('layouts.dashboard')

@section('title', 'Servicios')

@section('content')
<div class="consultas-container">
    <div class="mb-4 card shadow-orange">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-orange">Servicios Disponibles</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <h5 class="alert-heading"><i class="fas fa-info-circle"></i> Bienvenido al Módulo de Servicios</h5>
                <p>Este módulo está diseñado para la gestión de servicios de pago disponibles en la plataforma.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scripts básicos para la página de servicios
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Módulo de servicios cargado');
    });
</script>
@endpush

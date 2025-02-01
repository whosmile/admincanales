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
                                <p class="mb-0" id="info-nombre">{{ $cliente['nombre'] ?? 'No disponible' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group mb-3">
                                <label class="info-label">Login</label>
                                <p class="mb-0" id="info-login">{{ $cliente['login'] ?? 'No disponible' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-group mb-3">
                                <label class="info-label">Teléfono</label>
                                <p class="mb-0" id="info-telefono">{{ $cliente['telefono'] ?? 'No disponible' }}</p>
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
                                <input type="radio" name="permiso_p2p" id="permiso_p2p" class="me-2" 
                                    {{ isset($permisos) && $permisos->permiso_p2p ? 'checked' : '' }}>
                                <label for="permiso_p2p">Cliente se encuentra afiliado al servicio de Pago Móvil - P2P</label>
                            </div>
                        </div>
                        <div class="permiso-item mb-2">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="permiso_homebanking" id="permiso_homebanking" class="me-2"
                                    {{ isset($permisos) && $permisos->permiso_homebanking ? 'checked' : '' }}>
                                <label for="permiso_homebanking">Permisos Habilitados - Menú HomeBanking</label>
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
    }
    /* Estilos para los radio inputs */
    .permiso-item input[type="radio"] {
        appearance: none;
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #ddd;
        border-radius: 50%;
        outline: none;
        position: relative;
    }
    .permiso-item input[type="radio"]:checked {
        border-color: #28a745;
        background-color: #28a745;
    }
    .permiso-item input[type="radio"]:checked::after {
        content: '';
        width: 8px;
        height: 8px;
        background-color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }
    .permiso-item label {
        color: var(--text-color);
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnQuitarPermisos = document.getElementById('quitarPermisos');
    const permisoP2P = document.getElementById('permiso_p2p');
    const permisoHomebanking = document.getElementById('permiso_homebanking');
    const clienteLogin = '{{ $cliente["login"] }}';

    // Función para actualizar permisos
    function actualizarPermisos() {
        fetch('{{ route("permiso-vuelto.actualizar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                cedula: clienteLogin,
                permiso_p2p: permisoP2P.checked,
                permiso_homebanking: permisoHomebanking.checked
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito
                alert('Permisos actualizados correctamente');
            } else {
                // Mostrar mensaje de error
                alert('Error al actualizar los permisos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar los permisos');
        });
    }

    // Evento para el botón de quitar permisos
    btnQuitarPermisos.addEventListener('click', function() {
        permisoP2P.checked = false;
        permisoHomebanking.checked = false;
        actualizarPermisos();
    });

    // Eventos para los radio buttons
    permisoP2P.addEventListener('change', actualizarPermisos);
    permisoHomebanking.addEventListener('change', actualizarPermisos);
});
</script>
@endpush

@extends('layouts.dashboard')

@section('title', 'Consulta de Clientes')

@section('content')
<div class="consultas-container">
    <div class="row">
        <div class="col-12">
            <div class="consultas-header">
                <h1 class="consultas-title">Consulta de Clientes</h1>
            </div>

            <!-- Formulario de búsqueda -->
            <div class="filtros-card">
                <div class="filtros-body">
                    <form id="searchForm" class="row g-3">
                        <div class="col-md-6 mx-auto">
                            <div class="input-group">
                                <!-- Selector de tipo de cédula -->
                                <select class="form-select flex-grow-0" style="width: auto;" name="tipo_cedula" id="tipo_cedula" required>
                                    <option value="V">V</option>
                                    <option value="E">E</option>
                                </select>

                                <!-- Campo de cédula -->
                                <input type="text" 
                                       class="form-control" 
                                       id="cedula" 
                                       name="cedula" 
                                       placeholder="Ingrese el número de cédula"
                                       pattern="[0-9]*"
                                       maxlength="8"
                                       required>

                                <!-- Botón de búsqueda -->
                                <button type="submit" class="btn btn-primary" id="buscarBtn">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </button>
                            </div>
                            <div class="form-text text-center mt-2">
                                Ingrese solo números, máximo 8 dígitos
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Spinner de carga -->
            <div class="text-center mt-4" id="loading" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Buscando...</span>
                </div>
                <p class="mt-2">Buscando cliente...</p>
            </div>

            <!-- Resultados -->
            <div class="resultados-card mt-4" id="resultados" style="display: {{ isset($clienteData) ? 'block' : 'none' }};">
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <button type="button" class="btn btn-primary" id="modificarLimites">
                        <i class="fas fa-edit me-1"></i>Modificar Límites
                    </button>
                    <button type="button" class="btn btn-primary" id="bloqueoPreventivo">
                        <i class="fas fa-lock me-1"></i>Bloqueo Preventivo
                    </button>
                    <a href="{{ route('permiso-vuelto.index') }}" class="btn btn-primary" id="permisoVuelto">
                        <i class="fas fa-cog me-1"></i>Permiso Vuelto
                    </a>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Información del Cliente</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="info-label">Nombre de Usuario</label>
                                    <p class="mb-0" id="info-nombre">{{ $clienteData['nombre'] ?? '' }}</p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Cédula</label>
                                    <p class="mb-0" id="info-cedula">{{ $clienteData['cedula'] ?? '' }}</p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Email</label>
                                    <p class="mb-0" id="info-email">{{ $clienteData['email'] ?? '' }}</p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Teléfono</label>
                                    <p class="mb-0" id="info-telefono">{{ $clienteData['telefono'] ?? '' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group mb-3">
                                    <label class="info-label">Última Interacción</label>
                                    <p class="mb-0" id="info-ultima-interaccion">
                                        @if(isset($clienteData['ultimo_login']))
                                            {{ \Carbon\Carbon::parse($clienteData['ultimo_login'])->format('d-m-Y H:i:s') }}
                                        @else
                                            Nunca
                                        @endif
                                    </p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Estado</label>
                                    <p class="mb-0">
                                        <span class="badge" id="info-estado">
                                            @if(isset($clienteData['status']))
                                                {{ $clienteData['status'] === 'active' ? 'Activo' : 'Inactivo' }}
                                            @else
                                                No definido
                                            @endif
                                        </span>
                                    </p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Tipo de Perfil</label>
                                    <p class="mb-0" id="info-tipo-perfil">
                                        @if(isset($clienteData['role']))
                                            {{ $clienteData['role']['nombre'] ?? 'No asignado' }}
                                        @else
                                            No asignado
                                        @endif
                                    </p>
                                </div>
                                <div class="info-group mb-3">
                                    <label class="info-label">Rol del Sistema</label>
                                    <p class="mb-0" id="info-role">
                                        @if(isset($clienteData['role']))
                                            {{ $clienteData['role']['nombre'] ?? 'No asignado' }}
                                        @else
                                            No asignado
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Límites de Transferencias y Pagos -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Límites Transferencias y Pagos</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 50%">Terceros en DELSUR:</th>
                                        <td id="info-limite-delsur">{{ $clienteData['limite_delsur'] ?? 'Sin Límites' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Otros Bancos:</th>
                                        <td id="info-limite-otros">{{ $clienteData['limite_otros'] ?? '50.000,00' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje de no resultados -->
            <div class="alert alert-info mt-4" id="no-resultados" style="display: none;">
                <i class="fas fa-info-circle me-2"></i>
                No se encontraron resultados para la cédula ingresada
            </div>

            <!-- Mensaje de error -->
            <div class="alert alert-danger mt-4" id="error-message" style="display: none;">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="error-text"></span>
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
    
    #cedula {
        text-align: center;
        font-size: 1.1rem;
        letter-spacing: 1px;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
    }
    
    .info-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        color: var(--bs-emphasis-color);
        font-weight: 500;
    }
    
    .info-group p {
        font-size: 1rem;
        font-weight: 500;
        color: var(--bs-body-color);
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        background-color: var(--bs-body-bg);
    }
    
    .card-title {
        color: var(--bs-primary);
        font-weight: 600;
    }

    .card-body {
        color: var(--bs-body-color);
    }

    .text-muted {
        color: var(--bs-secondary) !important;
    }

    .table th {
        background-color: var(--bs-gray-100);
        font-weight: 500;
        color: var(--bs-emphasis-color);
    }
    
    .table td {
        font-weight: 500;
        color: var(--bs-body-color);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('searchForm');
    const cedulaInput = document.getElementById('cedula');
    const loading = document.getElementById('loading');
    const resultados = document.getElementById('resultados');
    const noResultados = document.getElementById('no-resultados');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    const buscarBtn = document.getElementById('buscarBtn');
    
    // Solo permitir números en el campo de cédula
    cedulaInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }
    });
    
    // Prevenir pegar contenido no numérico
    cedulaInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.originalEvent || e).clipboardData.getData('text/plain');
        if (/^\d+$/.test(text)) {
            this.value = text.slice(0, 8);
        }
    });
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const tipoCedula = document.getElementById('tipo_cedula').value;
        let numeroCedula = cedulaInput.value;
        
        // Validaciones
        if (!numeroCedula) {
            errorMessage.style.display = 'block';
            errorText.textContent = 'Por favor, ingrese un número de cédula.';
            return;
        }

        // Limpiar el número de cédula de cualquier carácter no numérico
        numeroCedula = numeroCedula.replace(/[^0-9]/g, '');
        
        if (numeroCedula.length < 4) {
            errorMessage.style.display = 'block';
            errorText.textContent = 'El número de cédula debe tener al menos 4 dígitos.';
            return;
        }
        
        // Ocultar mensajes anteriores y mostrar loading
        resultados.style.display = 'none';
        noResultados.style.display = 'none';
        errorMessage.style.display = 'none';
        loading.style.display = 'block';
        buscarBtn.disabled = true;

        try {
            const response = await fetch('/consultas/clientes/buscar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    tipo_cedula: tipoCedula,
                    cedula: numeroCedula
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Error en el servidor');
            }

            loading.style.display = 'none';
            buscarBtn.disabled = false;

            if (data.success) {
                // Mostrar los datos del cliente
                resultados.style.display = 'block';
                noResultados.style.display = 'none';
                
                // Actualizar la información en la vista
                document.getElementById('info-cedula').textContent = data.data.cedula;
                document.getElementById('info-nombre').textContent = 
                    `${data.data.name} ${data.data.apellido}`.trim();
                document.getElementById('info-email').textContent = 
                    data.data.email || 'No disponible';
                document.getElementById('info-telefono').textContent = 
                    data.data.telefono || 'No disponible';
                
                const ultimaInteraccion = data.data.ultimo_login;
                document.getElementById('info-ultima-interaccion').textContent = 
                    ultimaInteraccion ? new Date(ultimaInteraccion).toLocaleString() : 'Nunca';
                
                const estadoBadge = document.getElementById('info-estado');
                estadoBadge.textContent = data.data.status === 'active' ? 'Activo' : 'Inactivo';
                estadoBadge.className = `badge ${data.data.status === 'active' ? 'bg-success' : 'bg-danger'}`;
                
                document.getElementById('info-tipo-perfil').textContent = 
                    data.data.role ? data.data.role.nombre : 'No asignado';
                document.getElementById('info-role').textContent = 
                    data.data.role ? data.data.role.nombre : 'No asignado';
                
                // Límites de transferencias y pagos
                document.getElementById('info-limite-delsur').textContent = data.data.limite_delsur;
                document.getElementById('info-limite-otros').textContent = data.data.limite_otros;
            } else {
                // Mostrar mensaje de no encontrado
                resultados.style.display = 'none';
                noResultados.style.display = 'block';
            }
        } catch (error) {
            console.error('Error:', error);
            loading.style.display = 'none';
            buscarBtn.disabled = false;
            errorMessage.style.display = 'block';
            errorText.textContent = error.message || 'Error al buscar el cliente. Por favor, intente nuevamente.';
        }
    });
    
    // Si hay datos del cliente, rellenar el formulario
    @if(isset($clienteData))
    document.getElementById('tipo_cedula').value = '{{ substr($clienteData["cedula"], 0, 1) }}';
    document.getElementById('cedula').value = '{{ substr($clienteData["cedula"], 2) }}';
    @endif
});
</script>
@endpush

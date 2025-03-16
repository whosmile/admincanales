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
                <div class="card" id="seccionLimites">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Límites Transferencias y Pagos</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width: 50%">Terceros en DELSUR:</th>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control text-end" 
                                                       id="limite_delsur" 
                                                       value="{{ $clienteData['limits']['limite_delsur'] ?? '0,00' }}"
                                                       style="max-width: 200px;"
                                                       readonly>
                                                <button class="btn btn-outline-primary" type="button" onclick="guardarLimite('delsur')" disabled>
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Otros Bancos:</th>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control text-end" 
                                                       id="limite_otros" 
                                                       value="{{ $clienteData['limits']['limite_otros'] ?? '50.000,00' }}"
                                                       style="max-width: 200px;"
                                                       readonly>
                                                <button class="btn btn-outline-primary" type="button" onclick="guardarLimite('otros')" disabled>
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-4 d-none" id="cancelarModificacion">
                            <button type="button" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-1"></i>Salir
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje de no resultados -->
            <div class="alert alert-info mt-4" id="no-resultados" style="display: none;">
                <i class="fas fa-info-circle me-2"></i>
                No se encontró ningún cliente con la cédula especificada
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
        color: var(--bs-gray-600);
        margin-bottom: 0.25rem;
    }

    /* Estilos para los campos de límites */
    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        text-align: right;
        font-size: 1rem;
        padding-right: 0.75rem;
    }

    .input-group .btn-outline-primary {
        border-left: none;
    }

    .input-group .btn-outline-primary:hover {
        background-color: var(--bs-primary);
        color: white;
    }

    .input-group .btn-outline-primary:focus {
        box-shadow: none;
    }

    .input-group .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: none;
    }

    .input-group .form-control:focus + .btn-outline-primary {
        border-color: var(--bs-primary);
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
    const btnModificarLimites = document.getElementById('modificarLimites');
    const btnCancelarContainer = document.getElementById('cancelarModificacion');
    const limiteInputs = document.querySelectorAll('input[id^="limite_"]');
    const btnGuardarLimites = document.querySelectorAll('button[onclick^="guardarLimite"]');
    const seccionLimites = document.getElementById('seccionLimites');
    
    // Estado de modificación de límites
    let modificandoLimites = false;
    
    // Función para habilitar/deshabilitar la edición de límites
    function toggleEdicionLimites(habilitar) {
        modificandoLimites = habilitar;
        
        // Mostrar/ocultar botones
        btnModificarLimites.style.display = habilitar ? 'none' : 'block';
        btnCancelarContainer.classList.toggle('d-none', !habilitar);
        
        // Habilitar/deshabilitar inputs y botones de guardar
        limiteInputs.forEach(input => {
            input.readOnly = !habilitar;
            if (!habilitar) {
                // Restaurar valores originales al cancelar
                const tipo = input.id.replace('limite_', '');
                input.value = input.getAttribute('data-original-value') || input.value;
            }
        });
        
        btnGuardarLimites.forEach(btn => {
            btn.disabled = !habilitar;
            btn.classList.toggle('btn-outline-primary', !habilitar);
            btn.classList.toggle('btn-primary', habilitar);
        });

        // Si estamos habilitando la edición, hacer scroll suave a la sección de límites
        if (habilitar && seccionLimites) {
            seccionLimites.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    // Event listener para el botón Modificar Límites
    btnModificarLimites.addEventListener('click', () => {
        toggleEdicionLimites(true);
        
        // Guardar valores originales
        limiteInputs.forEach(input => {
            input.setAttribute('data-original-value', input.value);
        });
    });
    
    // Event listener para el botón Salir
    btnCancelarContainer.querySelector('button').addEventListener('click', () => {
        toggleEdicionLimites(false);
    });
    
    // Formatear número con separadores de miles y decimales
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".").replace(/\.(?=[^.]*$)/, ",");
    }

    // Convertir formato español a número
    function parseSpanishNumber(str) {
        if (!str) return 0;
        return parseFloat(str.replace(/\./g, '').replace(',', '.'));
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const tipoCedula = document.getElementById('tipo_cedula').value;
        let numeroCedula = cedulaInput.value;
        
        // Validar que la cédula solo contenga números
        if (!/^\d+$/.test(numeroCedula)) {
            errorMessage.querySelector('#error-text').textContent = 'La cédula debe contener solo números';
            errorMessage.style.display = 'block';
            noResultados.style.display = 'none';
            resultados.style.display = 'none';
            return;
        }

        // Mostrar spinner de carga
        loading.style.display = 'block';
        errorMessage.style.display = 'none';
        noResultados.style.display = 'none';
        resultados.style.display = 'none';

        try {
            const response = await fetch('/consultas/clientes/buscar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    tipo_cedula: tipoCedula,
                    cedula: numeroCedula
                })
            });
            const data = await response.json();

            loading.style.display = 'none';

            if (data.success) {
                // Mostrar resultados
                resultados.style.display = 'block';
                
                // Actualizar información del cliente
                document.getElementById('info-nombre').textContent = data.data.nombre;
                document.getElementById('info-cedula').textContent = data.data.cedula;
                document.getElementById('info-email').textContent = data.data.email;
                document.getElementById('info-telefono').textContent = data.data.telefono;
                
                document.getElementById('info-ultima-interaccion').textContent = 
                    data.data.ultimo_login ? new Date(data.data.ultimo_login).toLocaleString() : 'Nunca';
                
                document.getElementById('info-estado').textContent = 
                    data.data.status === 'active' ? 'Activo' : 'Inactivo';
                document.getElementById('info-estado').className = 
                    `badge ${data.data.status === 'active' ? 'bg-success' : 'bg-danger'}`;
                
                document.getElementById('info-tipo-perfil').textContent = 
                    data.data.role ? data.data.role.nombre : 'No asignado';
                document.getElementById('info-role').textContent = 
                    data.data.role ? data.data.role.nombre : 'No asignado';
                
                // Actualizar límites
                if (data.data.limits) {
                    document.getElementById('limite_delsur').value = data.data.limits.limite_delsur;
                    document.getElementById('limite_otros').value = data.data.limits.limite_otros;
                } else {
                    document.getElementById('limite_delsur').value = '0,00';
                    document.getElementById('limite_otros').value = '50.000,00';
                }
                
                // Asegurarse de que los límites estén en modo lectura
                toggleEdicionLimites(false);
            } else {
                // Mostrar mensaje de no encontrado
                noResultados.style.display = 'block';
            }
        } catch (error) {
            loading.style.display = 'none';
            errorMessage.querySelector('#error-text').textContent = 'Error al buscar el cliente';
            errorMessage.style.display = 'block';
            console.error('Error:', error);
        }
    });

    // Función para guardar límites
    window.guardarLimite = async function(tipo) {
        if (!modificandoLimites) return;

        const cedula = document.getElementById('info-cedula').textContent;
        const limiteInput = document.getElementById(`limite_${tipo}`);
        const limiteValue = parseSpanishNumber(limiteInput.value);

        console.log('Guardando límite:', {
            tipo,
            cedula,
            valor: limiteValue
        });

        try {
            const response = await fetch(`/clientes/${cedula}/limites/${tipo}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    limite: limiteValue
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Respuesta del servidor:', data);

            if (data.success) {
                // Actualizar el valor formateado en el input
                if (data.data.limite_delsur) limiteInput.value = data.data.limite_delsur;
                if (data.data.limite_otros) limiteInput.value = data.data.limite_otros;
                
                // Actualizar el valor original
                limiteInput.setAttribute('data-original-value', limiteInput.value);
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Límite actualizado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Desactivar modo de edición después de guardar exitosamente
                toggleEdicionLimites(false);
            } else {
                throw new Error(data.message || 'Error al actualizar el límite');
            }
        } catch (error) {
            console.error('Error al guardar límite:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al actualizar el límite',
                confirmButtonText: 'Aceptar'
            });
        }
    };

    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

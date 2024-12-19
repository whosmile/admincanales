@extends('layouts.dashboard')

@section('titulo_pagina')
    Servicios
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Servicios Bancarios</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="servicioForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipoServicio" class="form-label">Tipo de Servicio</label>
                                    <select class="form-select" id="tipoServicio" name="tipoServicio">
                                        <option value="">Seleccione un servicio...</option>
                                        <option value="TELEFONIA">Telefonía</option>
                                        <option value="ELECTRICIDAD">Electricidad</option>
                                        <option value="AGUA">Agua</option>
                                        <option value="INTERNET">Internet</option>
                                        <option value="TELEVISION">Televisión por Cable</option>
                                        <option value="GAS">Gas Natural</option>
                                        <option value="SEGUROS">Seguros</option>
                                        <option value="IMPUESTOS">Impuestos</option>
                                        <option value="EDUCACION">Instituciones Educativas</option>
                                        <option value="TARJETAS">Tarjetas de Crédito</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary" id="btnBuscar">
                                    <i class="fas fa-search me-2"></i>Buscar
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de servicios -->
                    <div class="table-responsive mt-4" id="tablaServicios" style="display: none;">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Estatus</th>
                                    <th>Límite Mínimo</th>
                                    <th>Límite Máximo</th>
                                    <th>Máxima Afiliación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaServiciosBody">
                            </tbody>
                        </table>
                    </div>

                    <!-- Loading spinner -->
                    <div id="loadingSpinner" class="text-center mt-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando servicios...</p>
                    </div>

                    <!-- Mensaje de error -->
                    <div id="errorMessage" class="alert alert-danger mt-4" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('servicioForm');
    const tipoServicio = document.getElementById('tipoServicio');
    const tablaServicios = document.getElementById('tablaServicios');
    const tablaServiciosBody = document.getElementById('tablaServiciosBody');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const errorMessage = document.getElementById('errorMessage');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const servicioSeleccionado = tipoServicio.value;
        
        if (!servicioSeleccionado) {
            alert('Por favor seleccione un tipo de servicio');
            return;
        }

        // Store the selected type in session
        try {
            const response = await fetch('/servicios/set-tipo', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tipo: servicioSeleccionado })
            });

            if (!response.ok) {
                throw new Error('Error al establecer el tipo de servicio');
            }

            // Mostrar spinner y ocultar tabla y mensajes de error
            loadingSpinner.style.display = 'block';
            tablaServicios.style.display = 'none';
            errorMessage.style.display = 'none';
            
            try {
                const response = await fetch(`/servicios/data?tipo=${encodeURIComponent(servicioSeleccionado)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });
                
                const data = await response.json();
                console.log('Response data:', data);
                
                if (data.success) {
                    // Limpiar tabla
                    tablaServiciosBody.innerHTML = '';
                    
                    console.log('Number of services:', data.data.length);
                    
                    // Llenar tabla con datos
                    data.data.forEach(servicio => {
                        console.log('Processing service:', servicio);
                        console.log('Service type:', servicio.tipo_servicio, servicio.TIPO_SERVICIO, servicio.tipo);
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${servicio.nombre || 'N/A'}</td>
                            <td>${servicio.tipo || servicio.TIPO_SERVICIO || 'N/A'}</td>
                            <td>${servicio.estatus ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>'}</td>
                            <td>${servicio.limite_minimo || 'N/A'}</td>
                            <td>${servicio.limite_maximo || 'N/A'}</td>
                            <td>${servicio.maxima_afiliacion || 'N/A'}</td>
                            <td>
                                <a href="/servicios/${servicio.id}/edit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            </td>
                        `;
                        tablaServiciosBody.appendChild(row);
                    });
                    
                    // Mostrar tabla
                    tablaServicios.style.display = 'block';
                } else {
                    throw new Error(data.message || 'Error al obtener los datos');
                }
            } catch (error) {
                errorMessage.textContent = error.message;
                errorMessage.style.display = 'block';
            } finally {
                loadingSpinner.style.display = 'none';
            }
        } catch (error) {
            errorMessage.textContent = error.message;
            errorMessage.style.display = 'block';
        }
    });
});
</script>
@endpush

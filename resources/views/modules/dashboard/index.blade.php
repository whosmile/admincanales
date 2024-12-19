@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="mb-4 row">
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 card border-left-orange shadow-orange h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-orange text-uppercase">
                                Usuarios Activos</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold" id="usuariosActivos">{{ $usuariosActivos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-orange-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 card border-left-orange-dark shadow-orange h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs font-weight-bold text-orange-dark text-uppercase">
                                Total Usuarios</div>
                            <div class="mb-0 text-gray-800 h5 font-weight-bold">{{ $totalUsuarios }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-2x text-orange-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfica de Actividad Mensual -->
        <div class="col-xl-8 col-lg-7">
            <div class="mb-4 card shadow-orange">
                <div class="py-3 card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-orange">Actividad Mensual</h6>
                    <div class="dropdown">
                        <button class="btn btn-link text-orange dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('consultas.bitacora') }}">Ver Bitácora Completa</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="actividadMensual"></canvas>
                    </div>
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Detalles de Actividad</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Total Actividades</th>
                                        <th>Módulos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividadDetallada as $actividad)
                                    <tr>
                                        <td>{{ $actividad['mes'] }}</td>
                                        <td>{{ $actividad['total'] }}</td>
                                        <td>{{ $actividad['modulos'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfica de Tipos de Usuario -->
        @if(Auth::user()->hasRole('Administrador'))
        <div class="col-xl-4 col-lg-5">
            <div class="mb-4 card shadow-orange">
                <div class="py-3 card-header">
                    <h6 class="m-0 font-weight-bold text-orange">Distribución de Usuarios</h6>
                </div>
                <div class="card-body">
                    <div class="pt-4 chart-pie">
                        <canvas id="distribucionUsuarios"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Actividad Reciente -->
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 card-title">
                            <i class="fas fa-history"></i> Actividad Reciente
                        </h5>
                    </div>
                    <div class="p-0 card-body" style="height: 300px; overflow-y: auto;">
                        <div id="actividadReciente">
                            <!-- Las actividades se cargarán aquí dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.text-orange { color: #F29A2E !important; }
.text-orange-dark { color: #cc5500 !important; }
.text-orange-light { color: #ffa66b !important; }

.border-left-orange {
    border-left: 4px solid #F29A2E !important;
}

.border-left-orange-dark {
    border-left: 4px solid #cc5500 !important;
}

.shadow-orange {
    box-shadow: 0 .15rem 1.75rem 0 rgba(242, 154, 46, 0.15) !important;
}

.activity-feed .feed-item {
    position: relative;
    padding-left: 30px;
    border-left: 2px solid #F29A2E;
    margin-left: 15px;
}

.activity-feed .feed-item::before {
    content: '';
    position: absolute;
    left: -7px;
    top: 0;
    width: 12px;
    height: 12px;
    background: #F29A2E;
    border-radius: 50%;
}

.chart-area {
    position: relative;
    height: 300px;
    width: 100%;
}

.chart-pie {
    position: relative;
    height: 250px;
}

/* Estilos para el tema oscuro en la actividad reciente */
body.dark-mode .card .activity-content h6 {
    color: #ffffff !important;
}

body.dark-mode .card .activity-content p.text-muted,
body.dark-mode .card .activity-content small.text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

body.dark-mode .card .activity-item {
    color: #ffffff;
}

.dark-mode .activity-content h6,
.dark-mode .activity-content p,
.dark-mode .activity-content small {
    color: #ffffff !important;
}

.dark-mode .activity-content .text-muted {
    color: #d1d1d1 !important;
}

body.dark-mode .card-body .activity-item * {
    color: #ffffff !important;
}

body.dark-mode .card-body .activity-item .text-muted {
    color: rgba(255, 255, 255, 0.7) !important;
}

/* Estilos mejorados para la actividad reciente */
.activity-item {
    padding: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(33, 37, 41, 0.95);
    transition: background-color 0.3s ease;
}

.activity-item:hover {
    background-color: rgba(40, 44, 48, 0.95);
}

.activity-content {
    flex: 1;
}

.activity-content h6 {
    color: #F29A2E !important;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.activity-content p {
    color: rgba(255, 255, 255, 0.9) !important;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.activity-content small {
    color: rgba(255, 255, 255, 0.7) !important;
    font-size: 0.8rem;
    display: block;
}

.activity-icon {
    background-color: rgba(242, 154, 46, 0.2);
    width: 40px;
    height: 40px;
    min-width: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.activity-icon i {
    color: #F29A2E;
    font-size: 1.1rem;
}

#actividadReciente {
    max-height: 400px;
    overflow-y: auto;
}

#actividadReciente::-webkit-scrollbar {
    width: 8px;
}

#actividadReciente::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

#actividadReciente::-webkit-scrollbar-thumb {
    background-color: rgba(242, 154, 46, 0.5);
    border-radius: 4px;
}

#actividadReciente::-webkit-scrollbar-thumb:hover {
    background-color: rgba(242, 154, 46, 0.7);
}

/* Ajustes para modo oscuro */
.dark-mode .activity-item {
    background-color: rgba(33, 37, 41, 0.95);
}

.dark-mode .activity-content h6 {
    color: #F29A2E !important;
}

.dark-mode .activity-content p {
    color: rgba(255, 255, 255, 0.9) !important;
}

.dark-mode .activity-content small {
    color: rgba(255, 255, 255, 0.7) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orangePalette = {
        primary: '#F29A2E',
        secondary: '#F2AB27',
        light: '#ffa66b',
        lighter: '#ffc4a1'
    };

    // Gráfica de Actividad Mensual
    const ctxActividad = document.getElementById('actividadMensual');
    if (ctxActividad) {
        new Chart(ctxActividad, {
            type: 'line',
            data: {
                labels: @json($actividadMensual->pluck('mes')),
                datasets: [{
                    label: 'Actividades',
                    data: @json($actividadMensual->pluck('total')),
                    borderColor: orangePalette.primary,
                    backgroundColor: 'rgba(242, 154, 46, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(242, 154, 46, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Gráfica de Distribución de Usuarios (solo para administradores)
    @if(Auth::user()->hasRole('Administrador'))
    const ctxDistribucion = document.getElementById('distribucionUsuarios');
    if (ctxDistribucion) {
        new Chart(ctxDistribucion, {
            type: 'doughnut',
            data: {
                labels: @json($distribucionUsuarios->pluck('rol')),
                datasets: [{
                    data: @json($distribucionUsuarios->pluck('total')),
                    backgroundColor: [
                        orangePalette.primary,
                        orangePalette.secondary,
                        orangePalette.light,
                        orangePalette.lighter
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    @endif
});

function actualizarActividad() {
    fetch('{{ route('dashboard.recent-activity') }}')
        .then(response => response.json())
        .then(data => {
            const contenedor = document.getElementById('actividadReciente');
            contenedor.innerHTML = ''; // Limpiar el contenedor

            data.forEach(actividad => {
                // Determinar el icono basado en la acción
                let icono = 'fa-history';
                if (actividad.accion.toLowerCase().includes('búsqueda')) {
                    icono = 'fa-search';
                } else if (actividad.accion.toLowerCase().includes('creación')) {
                    icono = 'fa-plus';
                } else if (actividad.accion.toLowerCase().includes('actualización')) {
                    icono = 'fa-edit';
                } else if (actividad.accion.toLowerCase().includes('eliminación')) {
                    icono = 'fa-trash';
                }

                const html = `
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="activity-icon me-3">
                                <i class="fas ${icono}"></i>
                            </div>
                            <div class="activity-content">
                                <h6>${actividad.accion}</h6>
                                <p>${actividad.detalles}</p>
                                <small>${actividad.tiempo}</small>
                            </div>
                        </div>
                    </div>
                `;
                contenedor.innerHTML += html;
            });

            if (data.length === 0) {
                contenedor.innerHTML = `
                    <div class="activity-item">
                        <div class="d-flex align-items-center justify-content-center">
                            <p class="text-muted mb-0">No hay actividad reciente</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const contenedor = document.getElementById('actividadReciente');
            contenedor.innerHTML = `
                <div class="activity-item">
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="text-muted mb-0">Error al cargar la actividad reciente</p>
                    </div>
                </div>
            `;
        });
}

// Actualizar inmediatamente y luego cada 30 segundos
actualizarActividad();
setInterval(actualizarActividad, 30000);
</script>
@endpush

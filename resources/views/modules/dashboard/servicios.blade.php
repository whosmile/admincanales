@extends('layouts.dashboard')

@section('title', 'Servicios')

@section('content')
@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $user = User::with('role')
        ->where('id', Auth::id())
        ->first();
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Servicios</h3>
                    @if($user && $user->role)
                    <div class="card-tools d-flex align-items-center">
                        <form action="{{ route('servicios.index') }}" method="GET" class="d-flex me-2">
                            <input type="text" name="search" class="form-control form-control-sm me-2" 
                                   placeholder="Buscar servicio..." 
                                   value="{{ $search ?? '' }}">
                            <button type="submit" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(!empty($search))
                            <a href="{{ route('servicios.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </form>
                        @if($user->role->nombre !== 'Operador')
                        <a href="{{ route('servicios.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Añadir Servicio
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($servicios->isEmpty())
                        <div class="alert alert-info text-center">
                            @if(!empty($search))
                                No se encontraron servicios que coincidan con "{{ $search }}".
                            @else
                                No hay servicios registrados.
                            @endif
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo de Servicio</th>
                                    <th>Estatus</th>
                                    <th>Límite Mínimo</th>
                                    <th>Límite Máximo</th>
                                    <th>Máxima Afiliación</th>
                                    @if($user->role->nombre !== 'Operador')
                                    <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->id }}</td>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->tipo_servicio }}</td>
                                    <td>
                                        <span class="badge {{ $servicio->estatus ? 'bg-success' : 'bg-danger' }}">
                                            {{ $servicio->estatus ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($servicio->limite_minimo, 2) }}</td>
                                    <td>{{ number_format($servicio->limite_maximo, 2) }}</td>
                                    <td>{{ $servicio->maxima_afiliacion }}</td>
                                    @if($user->role->nombre !== 'Operador')
                                    <td>
                                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
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
                        console.log('Service Details:', {
                            id: servicio.id,
                            nombre: servicio.nombre,
                            tipo: servicio.tipo,
                            estatus: servicio.estatus,
                            activo_raw: servicio.activo_raw
                        });
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${servicio.nombre || 'N/A'}</td>
                            <td>${servicio.tipo || servicio.TIPO_SERVICIO || 'N/A'}</td>
                            <td>${servicio.estatus === 'Activo' ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>'}</td>
                            <td>${servicio.limite_minimo || 'N/A'}</td>
                            <td>${servicio.limite_maximo || 'N/A'}</td>
                            <td>${servicio.maxima_afiliacion || 'N/A'}</td>
                            <td>
                                @if($user && $user->role && $user->role->nombre !== 'Operador')
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                @endif
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

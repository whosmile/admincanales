@extends('layouts.dashboard')

@section('title', 'Bitácora Administrador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Bitácora Administrador</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Registro de Actividades Administrativas</h5>
                    <p class="card-text">Este módulo permite visualizar y dar seguimiento a todas las acciones realizadas por los administradores en el sistema.</p>
                    
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('admin.consultas.bitacora') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="desde" class="form-label">Desde</label>
                                <input type="date" class="form-control" id="desde" name="desde" value="{{ $desde }}">
                            </div>
                            <div class="col-md-3">
                                <label for="hasta" class="form-label">Hasta</label>
                                <input type="date" class="form-control" id="hasta" name="hasta" value="{{ $hasta }}">
                            </div>
                            <div class="col-md-4">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario }}" placeholder="Buscar por nombre de usuario">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-orange w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de Resultados -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Módulo</th>
                                    <th>Acción</th>
                                    <th>Detalles</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bitacora as $registro)
                                <tr>
                                    <td>{{ $registro->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $registro->user->name }} {{ $registro->user->apellido }}</td>
                                    <td>{{ $registro->modulo->nombre }}</td>
                                    <td>{{ $registro->accion }}</td>
                                    <td>{{ $registro->detalles }}</td>
                                    <td>{{ $registro->ip }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bitacora->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Gestión de Parámetros')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Parámetros del Sistema</h3>
                    <a href="{{ route('parametros.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Parámetro
                    </a>
                </div>
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <form action="{{ route('parametros.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por código o nombre..." value="{{ $search }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('parametros.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Limpiar
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de parámetros -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Valor</th>
                                    <th>Fecha Creación</th>
                                    <th>Fecha Actualización</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parametros as $parametro)
                                    <tr>
                                        <td>{{ $parametro->id }}</td>
                                        <td>{{ $parametro->codigo }}</td>
                                        <td>{{ $parametro->descripcion }}</td>
                                        <td>{{ $parametro->valor }}</td>
                                        <td>{{ $parametro->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $parametro->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('parametros.edit', $parametro->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Parámetros')

@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $user = User::with('role')
        ->where('id', Auth::id())
        ->first();
@endphp

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Parámetros</h3>
                    @if($user && $user->role)
                    <div class="card-tools d-flex align-items-center">
                        <form action="{{ route('parametros.index') }}" method="GET" class="d-flex me-2">
                            <input type="text" name="search" class="form-control form-control-sm me-2" 
                                   placeholder="Buscar parámetro..." 
                                   value="{{ $search ?? '' }}">
                            <button type="submit" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(!empty($search))
                            <a href="{{ route('parametros.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </form>
                        @if($user->role->nombre !== 'Operador')
                        <a href="{{ route('parametros.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Añadir Parámetro
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    @if($parametros->isEmpty())
                        <div class="alert alert-info text-center">
                            @if(!empty($search))
                                No se encontraron parámetros que coincidan con "{{ $search }}".
                            @else
                                No hay parámetros registrados.
                            @endif
                        </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Valor</th>
                                    <th>Descripción</th>
                                    <th>Grupo</th>
                                    <th>Fecha Creación</th>
                                    <th>Última Actualización</th>
                                    @if($user->role->nombre !== 'Operador')
                                    <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parametros as $parametro)
                                <tr>
                                    <td>{{ $parametro->id }}</td>
                                    <td>{{ $parametro->codigo }}</td>
                                    <td>{{ $parametro->valor }}</td>
                                    <td>{{ $parametro->descripcion }}</td>
                                    <td>{{ $parametro->grupo->nombre ?? 'Sin Grupo' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($parametro->created_at)->format('d/m/Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($parametro->updated_at)->format('d/m/Y H:i') }}</td>
                                    @if($user->role->nombre !== 'Operador')
                                    <td>
                                        <a href="{{ route('parametros.edit', $parametro->id) }}" class="btn btn-sm btn-primary">
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

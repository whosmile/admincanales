@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Panel de Control</h1>
            
            <div class="row">
                <!-- Tarjeta de Bienvenida -->
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">¡Bienvenido(a) {{ Auth::user()->name }}!</h5>
                            <p class="card-text">
                                Este es tu panel de control donde podrás gestionar todas las funcionalidades del sistema.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Accesos Rápidos -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-search"></i> Consultas
                            </h5>
                            <p class="card-text">Accede a las consultas de clientes y registros del sistema.</p>
                            <a href="{{ route('consultas.clientes') }}" class="btn btn-primary">Ir a Consultas</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-shield-alt"></i> Seguridad
                            </h5>
                            <p class="card-text">Gestiona los aspectos de seguridad y permisos del sistema.</p>
                            <a href="{{ route('seguridad.index') }}" class="btn btn-primary">Ir a Seguridad</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-cogs"></i> Parámetros
                            </h5>
                            <p class="card-text">Configura los parámetros generales del sistema.</p>
                            <a href="{{ route('parametros.index') }}" class="btn btn-primary">Ir a Parámetros</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

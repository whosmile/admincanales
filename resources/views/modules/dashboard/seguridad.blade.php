@extends('layouts.dashboard')

@section('titulo_pagina')
    Seguridad
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Gestión de Seguridad</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Descripción General</h5>
                    <p class="card-text">
                        El módulo de seguridad proporciona herramientas y configuraciones para garantizar la protección 
                        de las transacciones y datos de los usuarios. Aquí podrás gestionar:
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-lock me-2 text-primary"></i>
                            <strong>Control de Acceso:</strong> Gestión de permisos y roles de usuarios
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-shield-alt me-2 text-primary"></i>
                            <strong>Configuración de Seguridad:</strong> Políticas de contraseñas y autenticación
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-history me-2 text-primary"></i>
                            <strong>Registro de Actividades:</strong> Monitoreo de acciones y auditoría
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('titulo_pagina')
    Notificación de Viaje
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Notificación de Viaje</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Descripción General</h5>
                    <p class="card-text">
                        El módulo de Notificación de Viaje permite a los usuarios informar sobre sus 
                        viajes al extranjero para garantizar el uso seguro de sus tarjetas. Incluye:
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-plane me-2 text-primary"></i>
                            <strong>Registro de Viajes:</strong> Notificación de fechas y destinos
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-credit-card me-2 text-primary"></i>
                            <strong>Gestión de Tarjetas:</strong> Selección de tarjetas para uso en el extranjero
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-globe me-2 text-primary"></i>
                            <strong>Países de Destino:</strong> Registro de países a visitar
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

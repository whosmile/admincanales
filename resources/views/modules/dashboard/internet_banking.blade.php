@extends('layouts.dashboard')

@section('titulo_pagina')
    Internet Banking
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Internet Banking</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Descripción General</h5>
                    <p class="card-text">
                        El módulo de Internet Banking ofrece una plataforma completa para la gestión de 
                        servicios bancarios en línea. Aquí encontrarás:
                    </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-exchange-alt me-2 text-primary"></i>
                            <strong>Transferencias:</strong> Gestión de transferencias entre cuentas
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                            <strong>Pagos:</strong> Procesamiento de pagos y servicios
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            <strong>Estados de Cuenta:</strong> Consulta de movimientos y saldos
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')

@section('titulo_pagina')
    Editar Servicio de Agua
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Editar Servicio de Agua</h1>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editarServicioForm" method="POST" action="{{ route('servicios.update', $servicio->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipo" value="{{ $tipo }}">

                        <div class="row">
                            <!-- Nombre del Servicio (No editable) -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre del Servicio</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="{{ $servicio->nombre }}" readonly disabled>
                            </div>

                            <!-- Estatus -->
                            <div class="col-md-6 mb-3">
                                <label for="estatus" class="form-label">Estatus</label>
                                <select class="form-select @error('estatus') is-invalid @enderror" id="estatus" name="estatus" required>
                                    <option value="Activo" {{ $servicio->estatus === 'Activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="Inactivo" {{ $servicio->estatus === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estatus')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tipo de Servicio -->
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo de Servicio</label>
                                <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                    <option value="Residencial" {{ old('tipo', $servicio->tipo) == 'Residencial' ? 'selected' : '' }}>Residencial</option>
                                    <option value="Comercial" {{ old('tipo', $servicio->tipo) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    <option value="Industrial" {{ old('tipo', $servicio->tipo) == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                                </select>
                                @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Límite Mínimo -->
                            <div class="col-md-6 mb-3">
                                <label for="limite_minimo" class="form-label">Límite Mínimo</label>
                                <input type="number" step="0.01" class="form-control @error('limite_minimo') is-invalid @enderror"
                                       id="limite_minimo" name="limite_minimo"
                                       value="{{ old('limite_minimo', $servicio->limite_minimo) }}" required>
                                @error('limite_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Límite Máximo -->
                            <div class="col-md-6 mb-3">
                                <label for="limite_maximo" class="form-label">Límite Máximo</label>
                                <input type="number" step="0.01" class="form-control @error('limite_maximo') is-invalid @enderror"
                                       id="limite_maximo" name="limite_maximo"
                                       value="{{ old('limite_maximo', $servicio->limite_maximo) }}" required>
                                @error('limite_maximo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Máxima Afiliación -->
                            <div class="col-md-6 mb-3">
                                <label for="maxima_afiliacion" class="form-label">Máxima Afiliación</label>
                                <input type="number" class="form-control @error('maxima_afiliacion') is-invalid @enderror"
                                       id="maxima_afiliacion" name="maxima_afiliacion"
                                       value="{{ old('maxima_afiliacion', $servicio->maxima_afiliacion) }}" required>
                                @error('maxima_afiliacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

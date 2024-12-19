@extends('layouts/main')

@section('titulo_pagina', 'Iniciar Sesión')

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-7">
                <div class="auth-card">
                    <div class="mosaic-background"></div>
                    <div class="login-content">
                        <div class="auth-header">
                            <img src="{{ asset('assets/images/logo-delsur.jpg') }}" alt="Logo" class="auth-logo">
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger rounded-3 mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('authenticate') }}" method="POST" class="auth-form">
                            @csrf
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text"
                                           class="form-control @error('username') is-invalid @enderror"
                                           name="username"
                                           id="username"
                                           placeholder="Nombre de usuario"
                                           value="{{ old('username') }}"
                                           required>
                                    <label for="username">Nombre de Usuario</label>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           id="password"
                                           placeholder="Contraseña"
                                           required>
                                    <label for="password">Contraseña</label>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="loginButton">
                                    <span class="button-content">
                                        Iniciar Sesión
                                    </span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.auth-form');
    const loginButton = document.getElementById('loginButton');
    const spinner = loginButton.querySelector('.spinner-border');
    const buttonContent = loginButton.querySelector('.button-content');

    loginForm.addEventListener('submit', function() {
        loginButton.disabled = true;
        spinner.classList.remove('d-none');
        buttonContent.classList.add('opacity-50');
    });

    document.body.classList.add('fade-in');
    setTimeout(() => {
        document.querySelector('.auth-card').classList.add('slide-in');
    }, 100);
});
</script>
@endpush

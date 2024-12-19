@extends(isset($fromDashboard) ? 'layouts/dashboard' : 'layouts/main')

@section('title', 'Registrar Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-orange text-white">
                        <h1 class="h4 mb-0">Registrar Nuevo Usuario</h1>
                    </div>

                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('register.submit') }}" method="POST" class="auth-form" id="registerForm">
                            @csrf
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control form-control-lg @error('name') is-invalid @enderror"
                                               name="name"
                                               id="name"
                                               placeholder=" "
                                               value="{{ old('name') }}"
                                               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                               title="Solo se permiten letras y espacios"
                                               oninput="this.value = this.value.replace(/[0-9]/g, '')"
                                               required>
                                        <label for="name"><i class="fas fa-user me-2"></i>Nombre</label>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                               class="form-control form-control-lg @error('apellido') is-invalid @enderror"
                                               name="apellido"
                                               id="apellido"
                                               placeholder=" "
                                               value="{{ old('apellido') }}"
                                               pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+"
                                               title="Solo se permiten letras y espacios"
                                               oninput="this.value = this.value.replace(/[0-9]/g, '')"
                                               required>
                                        <label for="apellido"><i class="fas fa-user me-2"></i>Apellido</label>
                                        @error('apellido')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mt-4">
                                <input type="email"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       name="email"
                                       id="email"
                                       placeholder=" "
                                       value="{{ old('email') }}"
                                       required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Correo Electrónico</label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-4">
                                <input type="text"
                                       class="form-control form-control-lg @error('username') is-invalid @enderror"
                                       name="username"
                                       id="username"
                                       placeholder=" "
                                       value="{{ old('username') }}"
                                       required>
                                <label for="username"><i class="fas fa-user me-2"></i>Nombre de Usuario</label>
                                @error('username')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mt-4">
                                <input type="tel"
                                       class="form-control form-control-lg @error('telefono') is-invalid @enderror"
                                       name="telefono"
                                       id="telefono"
                                       placeholder=" "
                                       value="{{ old('telefono') }}"
                                       maxlength="13"
                                       required>
                                <label for="telefono"><i class="fas fa-phone me-2"></i>Teléfono Móvil (0412-123-4567)</label>
                                @error('telefono')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <label class="cedula-group-label">Cédula de Identidad</label>
                                <div class="input-group">
                                    <select class="form-select flex-grow-0" 
                                            style="width: auto;" 
                                            name="nacionalidad" 
                                            id="nacionalidad" 
                                            required>
                                        <option value="V" {{ old('nacionalidad', 'V') == 'V' ? 'selected' : '' }}>V</option>
                                        <option value="E" {{ old('nacionalidad') == 'E' ? 'selected' : '' }}>E</option>
                                    </select>
                                    <input type="text"
                                           class="form-control form-control-lg @error('numero_cedula') is-invalid @enderror"
                                           name="numero_cedula"
                                           id="numero_cedula"
                                           placeholder="12345678"
                                           value="{{ old('numero_cedula') }}"
                                           maxlength="8"
                                           required>
                                    <input type="hidden" name="cedula" id="cedula_completa">
                                </div>
                                <div class="form-text cedula-help-text">
                                    Ingrese solo números (entre 5 y 8 dígitos)
                                </div>
                                @error('cedula')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row g-4 mt-4">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="password"
                                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                                               name="password"
                                               id="password"
                                               placeholder=" "
                                               required>
                                        <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="password"
                                               class="form-control form-control-lg"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               placeholder=" "
                                               required>
                                        <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirmar Contraseña</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-orange btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Registrar
                                </button>
                                @if(!isset($fromDashboard))
                                    <div class="text-center mt-3">
                                        <span class="text-muted">¿Ya tienes una cuenta?</span>
                                        <a href="{{ route('login') }}" class="text-orange text-decoration-none ms-2">Iniciar Sesión</a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($fromDashboard))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Desactivar la validación del formulario de registro para el botón de cerrar sesión
            const logoutForm = document.getElementById('logout-form');
            const logoutButton = document.querySelector('#logout-form button');
            
            if (logoutButton) {
                logoutButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    logoutForm.submit();
                });
            }

            // Formateo del teléfono
            const telefonoInput = document.getElementById('telefono');
            if (telefonoInput) {
                telefonoInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 4) {
                        value = value.slice(0,4) + '-' + value.slice(4);
                    }
                    if (value.length >= 8) {
                        value = value.slice(0,8) + '-' + value.slice(8);
                    }
                    e.target.value = value.slice(0,13);
                });
            }

            // Validación de cédula
            const numeroInput = document.getElementById('numero_cedula');
            const nacionalidadSelect = document.getElementById('nacionalidad');
            const cedulaCompleta = document.getElementById('cedula_completa');

            if (numeroInput && nacionalidadSelect && cedulaCompleta) {
                function actualizarCedulaCompleta() {
                    cedulaCompleta.value = nacionalidadSelect.value + numeroInput.value;
                }

                numeroInput.addEventListener('input', actualizarCedulaCompleta);
                nacionalidadSelect.addEventListener('change', actualizarCedulaCompleta);
            }
        });
    </script>
    @endpush
@endif
@endsection

@push('styles')
@if(!isset($fromDashboard))
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endif
@endpush

@push('scripts')
@if(!isset($fromDashboard))
<script src="{{ asset('js/register.js') }}"></script>
<script src="{{ asset('js/cedula.js') }}"></script>
@endif
<script src="{{ asset('assets/js/register-validation.js') }}"></script>
@endpush

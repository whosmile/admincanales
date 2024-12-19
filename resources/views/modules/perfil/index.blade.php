@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Mensajes de éxito o error -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-orange mb-4">
                <div class="card-body">
                    <div class="row">
                        <!-- Avatar y acciones rápidas -->
                        <div class="col-md-3 text-center mb-4">
                            <div class="avatar-container">
                                <div class="avatar-wrapper mb-3">
                                    <img src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) : asset('images/default-avatar.png') }}" 
                                         class="rounded-circle avatar-img" 
                                         alt="Avatar de {{ Auth::user()->name }}">
                                    <div class="avatar-overlay">
                                        <label for="avatar" class="avatar-edit-btn">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                    </div>
                                </div>
                                <p class="avatar-label">Avatar</p>
                                @if(Auth::user()->avatar)
                                    <form action="{{ route('perfil.delete-avatar') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Eliminar foto
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="user-info mt-3">
                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-0">
                                    <span class="badge bg-orange" style="background-color: var(--orange-primary); color: white; padding: 5px 10px; border-radius: 10px;">
                                        {{ Auth::user()->role }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Formulario de edición -->
                        <div class="col-md-9">
                            <form action="{{ route('perfil.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nombre Completo</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="{{ Auth::user()->name }}" readonly disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Nombre de Usuario</label>
                                        <input type="text" class="form-control" id="username" name="username" 
                                               value="{{ Auth::user()->username }}" readonly disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="{{ Auth::user()->email }}" readonly disabled>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" 
                                               value="{{ old('telefono', Auth::user()->telefono) }}">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Cambiar Contraseña</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="current_password" class="form-label">Contraseña Actual</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="current_password" 
                                                   name="current_password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_password" 
                                                   name="new_password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_password_confirmation" 
                                                   name="new_password_confirmation">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --orange-primary: #ff6b00;
        --orange-secondary: #ff8534;
        --orange-light: #ffa66b;
        --orange-dark: #cc5500;
    }

    .bg-orange {
        background-color: var(--orange-primary) !important;
        color: white;
    }

    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 0 20px rgba(255, 107, 0, 0.2);
        background-color: #f8f9fa;
    }

    .avatar-wrapper:hover {
        box-shadow: 0 0 25px rgba(255, 107, 0, 0.4);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 3px solid var(--orange-primary);
        transition: all 0.3s ease;
    }

    .avatar-container {
        max-width: 120px;
        margin: 0 auto 2rem;
    }

    .avatar-label {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .avatar-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        padding: 8px;
        opacity: 0;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-edit-btn {
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .avatar-edit-btn:hover {
        color: var(--orange-primary);
        transform: scale(1.1);
    }

    .preview-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1050;
    }

    .preview-content {
        max-width: 90%;
        max-height: 90%;
    }

    .preview-image {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }

    .form-control:focus {
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 0, 0.25);
    }

    .btn-primary {
        background-color: var(--orange-primary);
        border-color: var(--orange-primary);
    }

    .btn-primary:hover {
        background-color: var(--orange-dark);
        border-color: var(--orange-dark);
    }

    .toggle-password {
        border-color: #ced4da;
    }

    .toggle-password:hover {
        background-color: #f8f9fa;
    }

    .shadow-orange {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(255, 107, 0, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    const avatarImg = document.querySelector('.avatar-img');
    const previewContainer = document.createElement('div');
    previewContainer.className = 'preview-container';
    document.body.appendChild(previewContainer);

    // Manejar la subida de avatar
    avatarInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                avatarImg.src = e.target.result;
                
                // Mostrar preview
                previewContainer.innerHTML = `
                    <div class="preview-content">
                        <img src="${e.target.result}" class="preview-image">
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary me-2" onclick="document.querySelector('.preview-container').style.display='none'">
                                Aceptar
                            </button>
                            <button class="btn btn-secondary" onclick="resetAvatar()">
                                Cancelar
                            </button>
                        </div>
                    </div>
                `;
                previewContainer.style.display = 'flex';
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Función para resetear el avatar
    window.resetAvatar = function() {
        avatarInput.value = '';
        avatarImg.src = originalAvatarSrc;
        previewContainer.style.display = 'none';
    }

    // Guardar la URL original del avatar
    const originalAvatarSrc = avatarImg.src;

    // Cerrar preview al hacer clic fuera
    previewContainer.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });

    // Toggle de visibilidad de contraseña
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>
@endpush

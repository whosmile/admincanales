<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - AdminCanales</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Dashboard CSS -->
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">

    <!-- Yield para CSS adicional específico de cada vista -->
    @yield('styles')
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Overlay para móviles -->
        <div class="overlay"></div>

        <!-- Sidebar -->
        <nav id="sidebar">
            <!-- User Info -->
            <div class="user-info d-flex align-items-center">
                <img src="{{ asset('assets/images/default-icon.jpg') }}" alt="User Avatar">
                <div>
                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                    <small>{{ Auth::user()->email }}</small>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('consultas*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#consultasSubmenu" aria-expanded="{{ request()->is('consultas*') ? 'true' : 'false' }}">
                        <i class="fas fa-search"></i>
                        <span>Consultas</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->is('consultas*') ? 'show' : '' }}" id="consultasSubmenu">
                        <ul class="nav flex-column submenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('consultas.clientes') ? 'active' : '' }}" href="{{ route('consultas.clientes') }}">
                                    <i class="fas fa-users"></i>
                                    <span>Consultas Clientes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('consultas.bitacora') ? 'active' : '' }}" href="{{ route('consultas.bitacora') }}">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Bitácora Administrador</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('consultas.log-transaccional') ? 'active' : '' }}" href="{{ route('consultas.log-transaccional') }}">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span>Log Transaccional</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @if(Auth::user()->hasRole('Administrador'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard/usuarios*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#usuariosSubmenu" aria-expanded="{{ request()->is('dashboard/usuarios*') ? 'true' : 'false' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Gestión de Usuarios</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <div class="collapse {{ request()->is('dashboard/usuarios*') ? 'show' : '' }}" id="usuariosSubmenu">
                        <ul class="nav flex-column submenu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Registrar Usuario</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('parametros.*') ? 'active' : '' }}" href="{{ route('parametros.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Parámetros Generales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">
                        <i class="fas fa-concierge-bell"></i>
                        <span>Servicios</span>
                    </a>
                </li>
                <li class="nav-item theme-option">
                    <button type="button" class="nav-link" id="themeToggle">
                        <i class="fas fa-sun"></i>
                        <span>Cambiar Tema</span>
                    </button>
                </li>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Bar -->
            <div class="top-bar">
                <button type="button" id="sidebarCollapse" class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <img src="{{ asset('assets/images/logo-delsur.jpg') }}" alt="Company Logo" class="company-logo">

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn nav-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('perfil.index') }}">
                                <i class="fas fa-user-circle"></i> Mi Perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="p-4 container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="footer">
                &copy; Copyright 2024 Del Sur, Banco Universal. RIF: J-00079723-4. Todos los derechos reservados. La información mostrada en esta página, es de carácter confidencial.
            </footer>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dashboard JavaScript -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <!-- Scripts específicos de cada vista -->
    @stack('scripts')

    <!-- Yield para JavaScript adicional específico de cada vista -->
    @yield('scripts')
</body>
</html>

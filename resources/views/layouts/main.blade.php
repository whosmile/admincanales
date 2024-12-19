<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <title>@yield('titulo_pagina') - AdminCanales</title>

    <!-- Estilos adicionales -->
    @stack('styles')
</head>
<body>
    <div class="page-transition"></div>
    <div class="page-content">
        @yield('content')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in body
            document.body.classList.add('fade-in');

            // Slide in auth card
            const authCard = document.querySelector('.auth-card');
            if (authCard) {
                setTimeout(() => {
                    authCard.classList.add('slide-in');
                }, 100);
            }

            // Page transition for auth links
            document.querySelectorAll('a[href*="login"], a[href*="register"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const href = this.getAttribute('href');
                    const transition = document.querySelector('.page-transition');

                    // Slide in transition
                    transition.classList.add('active');

                    // Wait for transition and redirect
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500);
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>

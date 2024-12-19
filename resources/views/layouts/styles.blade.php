{{-- Estilos Globales --}}
<link href="{{ asset('assets/css/shared/main.css') }}" rel="stylesheet">

{{-- Estilos específicos por módulo --}}
@if(Request::is('login*'))
    <link href="{{ asset('assets/css/modules/auth/auth.css') }}" rel="stylesheet">
@endif

@if(Request::is('dashboard*'))
    <link href="{{ asset('assets/css/modules/dashboard/dashboard.css') }}" rel="stylesheet">
@endif

{{-- Estilos específicos de la vista --}}
@stack('styles')

{{-- Scripts Globales --}}
<script src="{{ asset('assets/js/shared/main.js') }}"></script>

{{-- Scripts específicos por módulo --}}
@if(Request::is('login*'))
    <script type="module" src="{{ asset('assets/js/modules/auth/auth.js') }}"></script>
@endif

@if(Request::is('dashboard*'))
    <script type="module" src="{{ asset('assets/js/modules/dashboard/dashboard.js') }}"></script>
@endif

{{-- Scripts específicos de la vista --}}
@stack('scripts')

@extends('layouts/main')

@section('titulo_pagina', 'Home Master Único')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mt-4">
                <div class="card-body">
                    <h2>Bienvenido Master Único</h2>
                    <p>Esta es la vista del master único</p>
                    
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

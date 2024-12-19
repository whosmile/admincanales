@extends('layouts.dashboard')

@section('title', 'Editar Parámetro')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Parámetro</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('parametros.update', $parametro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('codigo') is-invalid @enderror" 
                                   id="codigo" 
                                   name="codigo" 
                                   value="{{ old('codigo', $parametro->codigo) }}"
                                   placeholder="Ejemplo: sistema.config.timeout"
                                   required>
                            <small class="form-text text-muted">Solo se permiten letras y puntos como separadores. No se permiten números ni otros caracteres especiales.</small>
                            @error('codigo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del Parámetro</label>
                            <input type="text" 
                                   class="form-control @error('descripcion') is-invalid @enderror" 
                                   id="descripcion" 
                                   name="descripcion" 
                                   value="{{ old('descripcion', $parametro->descripcion) }}" 
                                   required>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" 
                                   class="form-control @error('valor') is-invalid @enderror" 
                                   id="valor" 
                                   name="valor" 
                                   value="{{ old('valor', $parametro->valor) }}"
                                   required>
                            @error('valor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codigoInput = document.getElementById('codigo');
    
    codigoInput.addEventListener('input', function(e) {
        // Reemplazar cualquier carácter que no sea letra o punto
        this.value = this.value.replace(/[^a-zA-Z.]/g, '');
        
        // Evitar puntos consecutivos
        this.value = this.value.replace(/\.{2,}/g, '.');
        
        // Evitar punto al inicio
        if (this.value.startsWith('.')) {
            this.value = this.value.substring(1);
        }
    });

    codigoInput.addEventListener('blur', function() {
        // Remover punto al final si existe
        if (this.value.endsWith('.')) {
            this.value = this.value.slice(0, -1);
        }
    });
});
</script>
@endpush

@endsection

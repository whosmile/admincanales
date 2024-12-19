document.addEventListener('DOMContentLoaded', function() {
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

    function actualizarCedulaCompleta() {
        if (numeroInput && nacionalidadSelect && cedulaCompleta) {
            cedulaCompleta.value = nacionalidadSelect.value + numeroInput.value;
        }
    }

    if (numeroInput) {
        numeroInput.addEventListener('input', function(e) {
            // Solo permitir números
            e.target.value = e.target.value.replace(/\D/g, '');
            actualizarCedulaCompleta();
        });
    }

    if (nacionalidadSelect) {
        nacionalidadSelect.addEventListener('change', actualizarCedulaCompleta);
    }

    // Validación del formulario
    const form = document.querySelector('form.auth-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessages = [];

            // Validación de cédula
            if (numeroInput) {
                const cedula = numeroInput.value;
                if (cedula.length < 5 || cedula.length > 8) {
                    isValid = false;
                    errorMessages.push('La cédula debe tener entre 5 y 8 dígitos');
                    numeroInput.classList.add('is-invalid');
                } else {
                    numeroInput.classList.remove('is-invalid');
                }
            }

            // Validación de teléfono
            if (telefonoInput) {
                const telefono = telefonoInput.value;
                if (!telefono.match(/^\d{4}-\d{3}-\d{4}$/)) {
                    isValid = false;
                    errorMessages.push('El formato del teléfono debe ser 0412-123-4567');
                    telefonoInput.classList.add('is-invalid');
                } else {
                    telefonoInput.classList.remove('is-invalid');
                }
            }

            if (!isValid) {
                e.preventDefault();
                // Mostrar errores en un alert más amigable
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger alert-dismissible fade show mt-3';
                errorDiv.innerHTML = `
                    <strong>Por favor, corrija los siguientes errores:</strong>
                    <ul class="mb-0 mt-2">
                        ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                form.insertBefore(errorDiv, form.firstChild);
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const nacionalidadSelect = document.getElementById('nacionalidad');
    const numeroCedulaInput = document.getElementById('numero_cedula');
    const cedulaCompletaInput = document.getElementById('cedula_completa');
    const form = document.querySelector('form');

    function actualizarCedulaCompleta() {
        const nacionalidad = nacionalidadSelect.value;
        const numero = numeroCedulaInput.value.replace(/\D/g, '');
        cedulaCompletaInput.value = `${nacionalidad}-${numero}`;
    }

    // Solo permitir números en el campo de cédula
    numeroCedulaInput.addEventListener('input', function(e) {
        // Remover cualquier caracter que no sea número
        let numero = e.target.value.replace(/\D/g, '');
        
        // Limitar a 8 dígitos
        numero = numero.substring(0, 8);
        
        // Actualizar el valor del input
        e.target.value = numero;
        
        actualizarCedulaCompleta();
    });

    nacionalidadSelect.addEventListener('change', actualizarCedulaCompleta);

    // Validar antes de enviar el formulario
    form.addEventListener('submit', function(e) {
        const numero = numeroCedulaInput.value;
        if (numero.length < 5) {
            e.preventDefault();
            alert('La cédula debe tener al menos 5 dígitos');
            numeroCedulaInput.focus();
        }
    });
});

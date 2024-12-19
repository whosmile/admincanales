document.addEventListener('DOMContentLoaded', function() {
    const telefonoInput = document.getElementById('telefono');
    
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            // Obtener solo los números del input
            let numero = e.target.value.replace(/\D/g, '');
            
            // Limitar a 11 dígitos
            numero = numero.substring(0, 11);
            
            // Formatear el número
            if (numero.length > 0) {
                if (numero.length <= 4) {
                    // Solo el prefijo
                    numero = numero;
                } else if (numero.length <= 7) {
                    // Prefijo y primeros dígitos
                    numero = numero.substring(0, 4) + '-' + numero.substring(4);
                } else {
                    // Número completo
                    numero = numero.substring(0, 4) + '-' + numero.substring(4, 7) + '-' + numero.substring(7);
                }
            }
            
            // Actualizar el valor del input
            e.target.value = numero;
        });

        // Agregar placeholder dinámico
        telefonoInput.placeholder = "0412-123-4567";
    }

    // Agregar ayuda visual para los prefijos válidos
    const helpText = document.createElement('small');
    helpText.className = 'form-text text-muted mt-1';
    helpText.innerHTML = 'Prefijos válidos: 0412, 0414, 0416, 0424, 0426';
    telefonoInput.parentNode.appendChild(helpText);
});

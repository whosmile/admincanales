let editModal = null;

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el modal
    const modalElement = document.getElementById('editarServicioModal');
    if (modalElement) {
        editModal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });

        // Evento cuando el modal se muestra
        modalElement.addEventListener('shown.bs.modal', function () {
            document.getElementById('editNombre').focus();
            habilitarCampos();
        });

        // Evento cuando el modal se oculta
        modalElement.addEventListener('hidden.bs.modal', function () {
            document.getElementById('editarServicioForm').reset();
        });
    }
});

function getTiposServicio(tipo) {
    switch(tipo.toLowerCase()) {
        case 'pagos':
            return ['Servicio Público', 'Telefonía', 'Internet', 'Cable TV', 'Otro'];
        case 'transferencias':
            return ['Interbancaria', 'Mismo Banco', 'Internacional'];
        default:
            return [];
    }
}

async function editarServicio(tipo, id) {
    try {
        const response = await fetch(`/servicios/edit/${tipo}/${id}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        const data = await response.json();

        if (data.success) {
            const servicio = data.data;
            
            // Llenar el formulario con los datos del servicio
            document.getElementById('editServicioId').value = servicio.id;
            document.getElementById('editServicioTipo').value = tipo;
            document.getElementById('editNombre').value = servicio.nombre || '';
            document.getElementById('editLimiteMinimo').value = servicio.limite_minimo || '';
            document.getElementById('editLimiteMaximo').value = servicio.limite_maximo || '';
            document.getElementById('editMaximaAfiliacion').value = servicio.maxima_afiliacion || '';

            // Cargar las opciones del tipo de servicio
            const select = document.getElementById('editTipoServicio');
            select.innerHTML = '';
            
            const tiposServicio = getTiposServicio(tipo);
            tiposServicio.forEach(tipoServicio => {
                const option = document.createElement('option');
                option.value = tipoServicio;
                option.textContent = tipoServicio;
                option.selected = tipoServicio === servicio.tipo_servicio;
                select.appendChild(option);
            });

            // Mostrar el modal
            editModal.show();
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error al editar servicio:', error);
        alert('Error al cargar el servicio: ' + error.message);
    }
}

async function guardarEdicion() {
    try {
        const form = document.getElementById('editarServicioForm');
        const formData = new FormData(form);
        const tipo = formData.get('tipo');
        const id = formData.get('id');

        const response = await fetch(`/servicios/update/${tipo}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            editModal.hide();
            // Recargar la tabla de servicios
            cargarServicios(tipo);
            alert('Servicio actualizado correctamente');
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error al guardar servicio:', error);
        alert('Error al guardar el servicio: ' + error.message);
    }
}

function habilitarCampos() {
    const inputs = document.getElementById('editarServicioModal').querySelectorAll('input, select');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.removeAttribute('disabled');
    });
}

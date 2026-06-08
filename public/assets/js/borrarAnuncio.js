let idAnuncioActual = null;
let accionActual = null;

document.addEventListener('DOMContentLoaded', () => {
    // Manejar botones de Eliminar
    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            idAnuncioActual = this.getAttribute('data-id');
            accionActual = 'eliminar';
            
            mostrarModal(
                '¿Eliminar anuncio?',
                '¿Estás seguro de que deseas eliminar este anuncio? Esta acción no se puede deshacer.'
            );
        });
    });

    // Manejar botones de Vendido
    const botonesVendido = document.querySelectorAll('.button-success');
    
    botonesVendido.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            idAnuncioActual = this.getAttribute('data-id');
            accionActual = 'vender';
            
            mostrarModal(
                '¿Marcar como vendido?',
                '¿Marcar este anuncio como vendido?'
            );
        });
    });
});

// Función para mostrar el modal
function mostrarModal(titulo, mensaje) {
    const modal = document.getElementById('confirmModal');
    document.getElementById('modalTitle').textContent = titulo;
    document.getElementById('modalMessage').textContent = mensaje;
    modal.style.display = 'flex';
}

// Función para cerrar el modal
function cerrarModal() {
    const modal = document.getElementById('confirmModal');
    modal.style.display = 'none';
    idAnuncioActual = null;
    accionActual = null;
}

// Función para confirmar la acción
function confirmarAccion() {
    if (accionActual === 'eliminar') {
        eliminarAnuncio(idAnuncioActual);
    } else if (accionActual === 'vender') {
        marcarVendido(idAnuncioActual);
    }
}

// Función para eliminar un anuncio
function eliminarAnuncio(idAnuncio) {
    const formData = new FormData();
    formData.append('formulario', 'eliminarAnuncio');
    formData.append('idAnuncio', idAnuncio);

    fetch('../../src/Controller/userPanelController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        cerrarModal();
        if (data.success) {
            mostrarMensaje('Éxito', 'Anuncio eliminado correctamente.', 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            mostrarMensaje('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        cerrarModal();
        mostrarMensaje('Error', 'Hubo un error al eliminar el anuncio.', 'error');
    });
}

// Función para marcar como vendido
function marcarVendido(idAnuncio) {
    // Si se pasó un elemento DOM (por onclick inline), extraer el data-id
    if (idAnuncio && typeof idAnuncio === 'object' && idAnuncio.getAttribute) {
        idAnuncio = idAnuncio.getAttribute('data-id');
    }
    const formData = new FormData();
    formData.append('formulario', 'marcarVendido');
    formData.append('idAnuncio', idAnuncio);

    fetch('../../src/Controller/userPanelController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        cerrarModal();
        if (data.success) {
            mostrarMensaje('Éxito', 'Anuncio marcado como vendido.', 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            mostrarMensaje('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        cerrarModal();
        mostrarMensaje('Error', 'Hubo un error al marcar el anuncio como vendido.', 'error');
    });
}

// Función para mostrar un mensaje temporal
function mostrarMensaje(titulo, mensaje, tipo) {
    const modal = document.getElementById('confirmModal');
    const modalContent = modal.querySelector('.modal-content');
    
    // Crear un mensaje temporal
    const mensajeDiv = document.createElement('div');
    mensajeDiv.className = `mensaje-temporal mensaje-${tipo}`;
    mensajeDiv.innerHTML = `
        <div class="mensaje-contenido">
            <h3>${titulo}</h3>
            <p>${mensaje}</p>
        </div>
    `;
    
    modal.style.display = 'flex';
    modalContent.style.display = 'none';
    modal.appendChild(mensajeDiv);
    
    setTimeout(() => {
        modal.style.display = 'none';
        modalContent.style.display = 'block';
        mensajeDiv.remove();
    }, 2000);
}

// Cerrar modal si se hace clic fuera de él
window.addEventListener('click', function(event) {
    const modal = document.getElementById('confirmModal');
    if (event.target == modal) {
        cerrarModal();
    }
});
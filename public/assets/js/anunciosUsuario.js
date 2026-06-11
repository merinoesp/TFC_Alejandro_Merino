document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('button[data-action="vendido"]').forEach((button) => {
        button.addEventListener('click', () => {
            if (typeof marcarVendido === 'function') {
                marcarVendido(button);
            }
        });
    });

    document.querySelectorAll('[data-action="cerrar-modal"]').forEach((element) => {
        element.addEventListener('click', () => {
            if (typeof cerrarModal === 'function') {
                cerrarModal();
            }
        });
    });

    const confirmButton = document.getElementById('modalConfirmBtn');
    if (confirmButton) {
        confirmButton.addEventListener('click', () => {
            if (typeof confirmarAccion === 'function') {
                confirmarAccion();
            }
        });
    }
});
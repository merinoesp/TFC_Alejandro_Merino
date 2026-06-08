// ── Dropdown toggle (click, no hover) ──────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-dropdown').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            const isOpen = menu.classList.contains('open');

            // Cerrar todos los demás
            document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));

            if (!isOpen) menu.classList.add('open');
        });
    });

    // Cerrar al pulsar fuera
    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
    });
});

// ── Acciones admin ──────────────────────────────────────────────────────────
function borrarCuenta(id_usuario) {
    if(confirm('¿Seguro que quieres borrar esta cuenta? Esta acción no se puede deshacer.')) {
        fetch(`/src/Controller/adminController.php?action=borrarCuenta&id=${id_usuario}`, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            if(data.success) location.reload();
            else alert('Error al borrar la cuenta');
        });
    }
}

function marcarLeido(id_reporte) {
    fetch(`/src/Controller/adminController.php?action=marcarLeido&id=${id_reporte}`, { method: 'POST' })
    .then(r => r.json())
    .then(data => {
        if(data.success) location.reload();
        else alert('Error al marcar como leído');
    });
}

function borrarAnuncioAdmin(id_anuncio) {
    if (!id_anuncio || id_anuncio <= 0) {
        alert('ID de anuncio no válido.');
        return;
    }
    if(confirm('¿Seguro que quieres eliminar este anuncio? Esta acción no se puede deshacer.')) {
        fetch(`/src/Controller/adminController.php?action=borrarAnuncio&id=${id_anuncio}`, { method: 'POST' })
        .then(r => {
            if (!r.ok) throw new Error('Error de red: ' + r.status);
            return r.json();
        })
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Error al eliminar el anuncio: ' + (data.error || 'Error desconocido'));
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error de conexión al intentar eliminar el anuncio. Inténtalo de nuevo.');
        });
    }
}

// Cerrar dropdown al pulsar fuera
window.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
});

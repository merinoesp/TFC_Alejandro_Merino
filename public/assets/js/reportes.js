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
    if(confirm('¿Seguro que quieres eliminar este anuncio?')) {
        fetch(`/src/Controller/adminController.php?action=borrarAnuncio&id=${id_anuncio}`, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            if(data.success) location.reload();
            else alert('Error al eliminar el anuncio');
        });
    }
}

// ── Modal Contactar ─────────────────────────────────────────────────────────
function contactar(email) {
    const modal = document.getElementById('modalContactar');
    document.getElementById('emailContactar').textContent = email;
    modal.style.display = 'flex';
}

function cerrarModalContactar() {
    document.getElementById('modalContactar').style.display = 'none';
}

function copiarEmail() {
    const email = document.getElementById('emailContactar').textContent;
    navigator.clipboard.writeText(email).then(() => {
        const btn = document.getElementById('btnCopiar');
        btn.textContent = '✅ Copiado';
        setTimeout(() => { btn.textContent = '📋 Copiar'; }, 2000);
    });
}

// Cerrar modal al pulsar fuera
window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalContactar');
    if (e.target === modal) cerrarModalContactar();
});

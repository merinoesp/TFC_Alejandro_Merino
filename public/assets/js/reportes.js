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

function contactar(email) {
    window.location.href = `mailto:${email}`;
}
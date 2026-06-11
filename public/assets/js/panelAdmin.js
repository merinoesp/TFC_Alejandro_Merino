document.addEventListener('DOMContentLoaded', () => {
    const repContainer = document.querySelector('.reps-container');
    if (!repContainer) return;

    repContainer.addEventListener('click', (event) => {
        const button = event.target.closest('button[data-action]');
        if (!button) return;

        const action = button.dataset.action;
        const id = parseInt(button.dataset.id, 10);
        const anuncioId = button.dataset.anuncioId ? parseInt(button.dataset.anuncioId, 10) : null;

        switch (action) {
            case 'borrar-cuenta':
                borrarCuenta(id);
                break;
            case 'borrar-anuncio':
                if (anuncioId) borrarAnuncioAdmin(anuncioId);
                break;
            case 'marcar-leido':
                marcarLeido(id);
                break;
            case 'contactar-admin':
                iniciarChatAdmin(id, anuncioId);
                break;
            default:
                break;
        }
    });

    async function iniciarChatAdmin(idUsuario, idAnuncio) {
        const fd = new FormData();
        fd.append('id_otro', idUsuario);
        if (idAnuncio) fd.append('id_anuncio', idAnuncio);
        try {
            const res = await fetch('/src/Controller/chatController.php?action=iniciar', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) {
                window.location.href = '/chats?id=' + data.id_chat;
            } else {
                alert('Error al abrir el chat: ' + (data.error || ''));
            }
        } catch (e) {
            alert('Error de conexión');
        }
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnContactar');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        btn.disabled = true;
        btn.textContent = 'Abriendo chat…';

        const fd = new FormData();
        fd.append('id_otro', btn.dataset.idOtro);
        fd.append('id_anuncio', btn.dataset.idAnuncio);

        try {
            const res = await fetch('/src/Controller/chatController.php?action=iniciar', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) {
                window.location.href = '/chats?id=' + data.id_chat;
            } else {
                alert('Error al abrir el chat: ' + (data.error || ''));
                btn.disabled = false;
                btn.textContent = '💬 Contactar al vendedor';
            }
        } catch (e) {
            alert('Error de conexión');
            btn.disabled = false;
            btn.textContent = '💬 Contactar al vendedor';
        }
    });
});
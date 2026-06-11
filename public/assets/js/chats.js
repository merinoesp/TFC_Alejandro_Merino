document.addEventListener('DOMContentLoaded', () => {
    const ME = parseInt(document.body.dataset.chatMe, 10) || 0;
    const ME_NOMBRE = document.body.dataset.chatMeNombre || '';
    let activeChatId = null;
    let pollTimer = null;

    function avatarSrc(ruta) {
        if (!ruta) return '/uploads/avatars/default.png';
        return '/' + ruta.replace(/^\.?\/?/, '');
    }

    function formatHora(ts) {
        if (!ts) return '';
        const d = new Date(ts.replace(' ', 'T'));
        const hoy = new Date();
        const mismoDia = d.toDateString() === hoy.toDateString();
        if (mismoDia) return d.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        return d.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit' });
    }

    function formatFechaCompleta(ts) {
        if (!ts) return '';
        return new Date(ts.replace(' ', 'T')).toLocaleDateString('es-ES', {
            weekday: 'long',
            day: 'numeric',
            month: 'long'
        });
    }

    async function cargarChats() {
        const res = await fetch('/src/Controller/chatController.php?action=listar');
        const data = await res.json();
        const list = document.getElementById('chatList');
        if (!data.success || !data.chats.length) {
            list.innerHTML = '<p class="chat-empty-sidebar">Aún no tienes conversaciones.<br>Contacta a un vendedor para empezar.</p>';
            return;
        }

        let totalUnread = 0;
        list.innerHTML = data.chats.map(c => {
            totalUnread += (c.no_leidos || 0);
            return `
            <div class="chat-item ${c.id_chat == activeChatId ? 'active' : ''}" data-id="${c.id_chat}">
                <img class="chat-avatar" src="${avatarSrc(c.avatar_otro)}" alt="${c.nombre_otro}">
                <div class="chat-item-info">
                    <div class="chat-item-name">${c.nombre_otro}</div>
                    ${c.titulo_anuncio ? `<div class="chat-item-anuncio">🚗 ${c.titulo_anuncio}</div>` : ''}
                    <div class="chat-item-preview">${c.ultimo_msg ? c.ultimo_msg.substring(0, 50) : 'Sin mensajes aún'}</div>
                </div>
                <div class="chat-item-meta">
                    <span class="chat-item-time">${formatHora(c.ultimo_ts)}</span>
                    ${c.no_leidos > 0 ? '<span class="chat-unread-dot"></span>' : ''}
                </div>
            </div>`;
        }).join('');

        document.querySelectorAll('.chat-item').forEach(el => {
            el.addEventListener('click', () => abrirChat(parseInt(el.dataset.id, 10)));
        });

        const badge = document.getElementById('totalUnread');
        if (totalUnread > 0) {
            badge.textContent = totalUnread;
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }

    async function abrirChat(idChat) {
        if (!idChat) return;
        activeChatId = idChat;
        document.getElementById('chatPlaceholder').style.display = 'none';
        const win = document.getElementById('chatWindow');
        win.style.display = 'flex';
        win.style.flexDirection = 'column';

        document.querySelectorAll('.chat-item').forEach(el => {
            el.classList.toggle('active', parseInt(el.dataset.id, 10) === idChat);
        });

        await cargarMensajes();
        clearInterval(pollTimer);
        pollTimer = setInterval(cargarMensajes, 3000);
        await cargarChats();
    }

    async function cargarMensajes() {
        if (!activeChatId) return;
        const res = await fetch(`/src/Controller/chatController.php?action=mensajes&id_chat=${activeChatId}`);
        const data = await res.json();
        if (!data.success) return;

        const info = data.info;
        document.getElementById('chatHeader').innerHTML = `
            <img src="${avatarSrc(info.avatar_otro)}" alt="${info.nombre_otro}">
            <div class="chat-main-header-info">
                <h3>${info.nombre_otro}</h3>
                ${info.titulo_anuncio ? `<span>🚗 ${info.titulo_anuncio}</span>` : ''}
            </div>`;

        const box = document.getElementById('chatMessages');
        const wasBottom = box.scrollHeight - box.scrollTop - box.clientHeight < 60;
        let lastDate = '';

        box.innerHTML = data.mensajes.map(m => {
            const mine = m.id_emisor == ME;
            const fecha = m.enviado_en ? new Date(m.enviado_en.replace(' ', 'T')).toDateString() : '';
            let sep = '';
            if (fecha !== lastDate) {
                sep = `<div class="msg-date-sep">${formatFechaCompleta(m.enviado_en)}</div>`;
                lastDate = fecha;
            }
            const hora = m.enviado_en ? new Date(m.enviado_en.replace(' ', 'T')).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }) : '';
            return `${sep}
            <div class="msg-row ${mine ? 'mine' : 'other'}">
                ${!mine ? `<img class="msg-avatar-small" src="${avatarSrc(m.avatar_ruta)}" alt="${m.nombre_emisor}">` : ''}
                <div>
                    <div class="msg-bubble">${escHtml(m.contenido)}</div>
                    <span class="msg-time">${hora}${mine && m.leido ? ' ✓✓' : ''}</span>
                </div>
            </div>`;
        }).join('');

        if (wasBottom || data.mensajes.length === 0) box.scrollTop = box.scrollHeight;
    }

    function escHtml(t) {
        return String(t)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\n/g, '<br>');
    }

    async function enviarMensaje() {
        const input = document.getElementById('msgInput');
        const texto = input.value.trim();
        if (!texto || !activeChatId) return;

        input.value = '';
        input.style.height = '';

        const fd = new FormData();
        fd.append('id_chat', activeChatId);
        fd.append('contenido', texto);

        const res = await fetch('/src/Controller/chatController.php?action=enviar', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) await cargarMensajes();
    }

    document.getElementById('btnSend').addEventListener('click', enviarMensaje);
    document.getElementById('msgInput').addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            enviarMensaje();
        }
    });
    document.getElementById('msgInput').addEventListener('input', function () {
        this.style.height = '';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    cargarChats().then(() => {
        const params = new URLSearchParams(location.search);
        const idFromUrl = params.get('id');
        if (idFromUrl) abrirChat(parseInt(idFromUrl, 10));
    });
});
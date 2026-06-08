<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id'])) { header('Location: /login'); exit(); }
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
$db  = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$uid = (int)$_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <title>Mensajes — Car2iu</title>
    <style>
        /* ── Layout ── */
        .chat-app {
            display: flex;
            height: calc(100vh - 64px);
            background: var(--bg-900, #0E1116);
            overflow: hidden;
        }

        /* ── Sidebar ── */
        .chat-sidebar {
            width: 340px;
            min-width: 260px;
            border-right: 1px solid var(--border-500, #2E364A);
            display: flex;
            flex-direction: column;
            background: var(--bg-850, #131722);
        }
        .chat-sidebar-header {
            padding: 1.2rem 1.4rem;
            border-bottom: 1px solid var(--border-500, #2E364A);
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .chat-sidebar-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-100, #fff);
            margin: 0;
        }
        .unread-badge {
            background: var(--primary-500, #5B6CFF);
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            border-radius: 999px;
            padding: 2px 7px;
        }
        .chat-list {
            overflow-y: auto;
            flex: 1;
        }
        .chat-item {
            display: flex;
            align-items: center;
            gap: .9rem;
            padding: .9rem 1.2rem;
            cursor: pointer;
            border-bottom: 1px solid var(--border-500, #2E364A);
            transition: background .15s;
        }
        .chat-item:hover, .chat-item.active {
            background: var(--surface-600, #232A3A);
        }
        .chat-item.active {
            border-left: 3px solid var(--primary-500, #5B6CFF);
        }
        .chat-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            background: var(--surface-550, #273046);
        }
        .chat-item-info { flex: 1; min-width: 0; }
        .chat-item-name {
            font-weight: 600;
            font-size: .92rem;
            color: var(--text-100, #fff);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chat-item-anuncio {
            font-size: .75rem;
            color: var(--primary-400, #7C88FF);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chat-item-preview {
            font-size: .78rem;
            color: var(--text-400, #8A94AD);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }
        .chat-item-meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }
        .chat-item-time {
            font-size: .7rem;
            color: var(--text-500, #5E6885);
        }
        .chat-unread-dot {
            width: 8px; height: 8px;
            background: var(--primary-500, #5B6CFF);
            border-radius: 50%;
        }
        .chat-empty-sidebar {
            padding: 2rem 1.4rem;
            color: var(--text-400, #8A94AD);
            font-size: .9rem;
            text-align: center;
        }

        /* ── Main chat area ── */
        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: var(--bg-900, #0E1116);
            min-width: 0;
        }
        .chat-main-header {
            padding: .9rem 1.4rem;
            border-bottom: 1px solid var(--border-500, #2E364A);
            display: flex;
            align-items: center;
            gap: .9rem;
            background: var(--bg-850, #131722);
        }
        .chat-main-header img {
            width: 40px; height: 40px;
            border-radius: 50%; object-fit: cover;
        }
        .chat-main-header-info h3 {
            font-size: 1rem; font-weight: 700;
            color: var(--text-100, #fff); margin: 0;
        }
        .chat-main-header-info span {
            font-size: .75rem;
            color: var(--primary-400, #7C88FF);
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1.2rem 1.4rem;
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }
        .msg-row {
            display: flex;
            align-items: flex-end;
            gap: .5rem;
        }
        .msg-row.mine { flex-direction: row-reverse; }
        .msg-avatar-small {
            width: 28px; height: 28px;
            border-radius: 50%; object-fit: cover;
            flex-shrink: 0;
        }
        .msg-bubble {
            max-width: 65%;
            padding: .55rem .9rem;
            border-radius: 16px;
            font-size: .88rem;
            line-height: 1.5;
            word-break: break-word;
        }
        .msg-row.mine .msg-bubble {
            background: var(--primary-600, #4756E6);
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .msg-row.other .msg-bubble {
            background: var(--surface-550, #273046);
            color: var(--text-200, #E6EAF2);
            border-bottom-left-radius: 4px;
        }
        .msg-time {
            font-size: .65rem;
            color: var(--text-500, #5E6885);
            margin-top: 2px;
            display: block;
        }
        .msg-row.mine .msg-time { text-align: right; }

        /* ── Input ── */
        .chat-input-area {
            padding: .9rem 1.2rem;
            border-top: 1px solid var(--border-500, #2E364A);
            display: flex;
            gap: .7rem;
            background: var(--bg-850, #131722);
        }
        .chat-input {
            flex: 1;
            background: var(--surface-600, #232A3A);
            border: 1px solid var(--border-400, #3A445C);
            border-radius: 24px;
            padding: .6rem 1.1rem;
            color: var(--text-100, #fff);
            font-size: .9rem;
            outline: none;
            resize: none;
            max-height: 120px;
            line-height: 1.5;
            transition: border-color .2s;
        }
        .chat-input:focus { border-color: var(--primary-500, #5B6CFF); }
        .chat-input::placeholder { color: var(--text-500, #5E6885); }
        .btn-send {
            background: var(--primary-500, #5B6CFF);
            border: none;
            border-radius: 50%;
            width: 42px; height: 42px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .2s, transform .1s;
            align-self: flex-end;
        }
        .btn-send:hover { background: var(--primary-400, #7C88FF); }
        .btn-send:active { transform: scale(.94); }
        .btn-send svg { fill: #fff; }

        /* ── Placeholder sin chat ── */
        .chat-placeholder {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-400, #8A94AD);
            gap: 1rem;
        }
        .chat-placeholder svg { opacity: .25; }
        .chat-placeholder p { font-size: .95rem; }

        /* ── Fecha separadora ── */
        .msg-date-sep {
            text-align: center;
            font-size: .72rem;
            color: var(--text-500, #5E6885);
            margin: .4rem 0;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {
            .chat-sidebar { width: 72px; min-width: 72px; }
            .chat-item-info, .chat-item-meta, .chat-item-anuncio,
            .chat-sidebar-header h2, .unread-badge { display: none; }
            .chat-item { justify-content: center; padding: .8rem .5rem; }
            .chat-avatar { width: 40px; height: 40px; }
        }
    </style>
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>

<div class="chat-app">

    <!-- SIDEBAR -->
    <aside class="chat-sidebar">
        <div class="chat-sidebar-header">
            <h2>Mensajes</h2>
            <span class="unread-badge" id="totalUnread" style="display:none">0</span>
        </div>
        <div class="chat-list" id="chatList">
            <p class="chat-empty-sidebar">Cargando conversaciones…</p>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="chat-main" id="chatMain">
        <div class="chat-placeholder" id="chatPlaceholder">
            <svg width="64" height="64" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
            </svg>
            <p>Selecciona una conversación para empezar a chatear</p>
        </div>

        <div id="chatWindow" style="display:none; flex:1; flex-direction:column; overflow:hidden; display:none">
            <div class="chat-main-header" id="chatHeader"></div>
            <div class="chat-messages" id="chatMessages"></div>
            <div class="chat-input-area">
                <textarea class="chat-input" id="msgInput" rows="1" placeholder="Escribe un mensaje…" maxlength="1000"></textarea>
                <button class="btn-send" id="btnSend" title="Enviar">
                    <svg width="20" height="20" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>

<script>
const ME = <?= $uid ?>;
const ME_NOMBRE = <?= json_encode(htmlspecialchars($_SESSION['usuario'])) ?>;
let activeChatId = null;
let pollTimer    = null;

// ── Utilidades ────────────────────────────────────────────
function avatarSrc(ruta) {
    if (!ruta) return '/uploads/avatars/default.png';
    return '/' + ruta.replace(/^\.?\/?/, '');
}
function formatHora(ts) {
    if (!ts) return '';
    const d = new Date(ts.replace(' ', 'T'));
    const hoy = new Date();
    const mismoDia = d.toDateString() === hoy.toDateString();
    if (mismoDia) return d.toLocaleTimeString('es-ES', {hour:'2-digit', minute:'2-digit'});
    return d.toLocaleDateString('es-ES', {day:'2-digit', month:'2-digit'});
}
function formatFechaCompleta(ts) {
    if (!ts) return '';
    return new Date(ts.replace(' ', 'T')).toLocaleDateString('es-ES', {weekday:'long', day:'numeric', month:'long'});
}

// ── Sidebar ───────────────────────────────────────────────
async function cargarChats() {
    const res  = await fetch('/src/Controller/chatController.php?action=listar');
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
        <div class="chat-item ${c.id_chat == activeChatId ? 'active' : ''}" onclick="abrirChat(${c.id_chat})" data-id="${c.id_chat}">
            <img class="chat-avatar" src="${avatarSrc(c.avatar_otro)}" alt="${c.nombre_otro}">
            <div class="chat-item-info">
                <div class="chat-item-name">${c.nombre_otro}</div>
                ${c.titulo_anuncio ? `<div class="chat-item-anuncio">🚗 ${c.titulo_anuncio}</div>` : ''}
                <div class="chat-item-preview">${c.ultimo_msg ? c.ultimo_msg.substring(0,50) : 'Sin mensajes aún'}</div>
            </div>
            <div class="chat-item-meta">
                <span class="chat-item-time">${formatHora(c.ultimo_ts)}</span>
                ${c.no_leidos > 0 ? '<span class="chat-unread-dot"></span>' : ''}
            </div>
        </div>`;
    }).join('');

    const badge = document.getElementById('totalUnread');
    if (totalUnread > 0) { badge.textContent = totalUnread; badge.style.display = 'inline'; }
    else badge.style.display = 'none';
}

// ── Abrir chat ────────────────────────────────────────────
async function abrirChat(idChat) {
    activeChatId = idChat;
    document.getElementById('chatPlaceholder').style.display = 'none';
    const win = document.getElementById('chatWindow');
    win.style.display = 'flex';
    win.style.flexDirection = 'column';

    // marcar activo en sidebar
    document.querySelectorAll('.chat-item').forEach(el => {
        el.classList.toggle('active', el.dataset.id == idChat);
    });

    await cargarMensajes();
    clearInterval(pollTimer);
    pollTimer = setInterval(cargarMensajes, 3000);
    await cargarChats(); // actualizar badges
}

async function cargarMensajes() {
    if (!activeChatId) return;
    const res  = await fetch(`/src/Controller/chatController.php?action=mensajes&id_chat=${activeChatId}`);
    const data = await res.json();
    if (!data.success) return;

    // Header
    const info = data.info;
    document.getElementById('chatHeader').innerHTML = `
        <img src="${avatarSrc(info.avatar_otro)}" alt="${info.nombre_otro}">
        <div class="chat-main-header-info">
            <h3>${info.nombre_otro}</h3>
            ${info.titulo_anuncio ? `<span>🚗 ${info.titulo_anuncio}</span>` : ''}
        </div>`;

    // Mensajes
    const box = document.getElementById('chatMessages');
    const wasBottom = box.scrollHeight - box.scrollTop - box.clientHeight < 60;

    let lastDate = '';
    box.innerHTML = data.mensajes.map(m => {
        const mine = m.id_emisor == ME;
        const fecha = m.enviado_en ? new Date(m.enviado_en.replace(' ','T')).toDateString() : '';
        let sep = '';
        if (fecha !== lastDate) {
            sep = `<div class="msg-date-sep">${formatFechaCompleta(m.enviado_en)}</div>`;
            lastDate = fecha;
        }
        const hora = m.enviado_en ? new Date(m.enviado_en.replace(' ','T')).toLocaleTimeString('es-ES',{hour:'2-digit',minute:'2-digit'}) : '';
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
    return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
}

// ── Enviar ────────────────────────────────────────────────
async function enviarMensaje() {
    const input = document.getElementById('msgInput');
    const texto = input.value.trim();
    if (!texto || !activeChatId) return;

    input.value = '';
    input.style.height = '';

    const fd = new FormData();
    fd.append('id_chat',   activeChatId);
    fd.append('contenido', texto);

    const res  = await fetch('/src/Controller/chatController.php?action=enviar', { method:'POST', body: fd });
    const data = await res.json();
    if (data.success) await cargarMensajes();
}

document.getElementById('btnSend').addEventListener('click', enviarMensaje);
document.getElementById('msgInput').addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); enviarMensaje(); }
});
// Auto-resize textarea
document.getElementById('msgInput').addEventListener('input', function() {
    this.style.height = '';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// ── Abrir chat desde URL: /chats?id=X ─────────────────────
(async () => {
    await cargarChats();
    const params = new URLSearchParams(location.search);
    const idFromUrl = params.get('id');
    if (idFromUrl) abrirChat(parseInt(idFromUrl));
})();
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio - <?php echo htmlspecialchars($anuncio['titulo'] ?? ''); ?></title>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

    $db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);

    $id = (int)($_GET['id'] ?? 0);

    if ($id === 0) {
        header('Location: /anuncios');
        exit();
    }

    $anuncio = $db->listarAnuncio($id);

    if (!$anuncio) {
        header('Location: /anuncios');
        exit();
    }

    $rutaImagen   = '/' . ltrim(ltrim($anuncio['ruta'], '.'), '/');
    $esPropietario = isset($_SESSION['id']) && (int)$_SESSION['id'] === (int)$anuncio['id_usuario'];
    $estaLogueado  = isset($_SESSION['id']);
    ?>

    <main class="anuncio-main">
        <section class="anuncio-content">
            <h2 class="subtitle"><?php echo htmlspecialchars($anuncio['titulo']); ?></h2>

            <div class="anuncio-img">
                <img src="<?php echo $rutaImagen; ?>" alt="Imagen de <?php echo htmlspecialchars($anuncio['titulo']); ?>">
            </div>

            <div class="specs-container">
                <div><strong>Marca:</strong> <?php echo htmlspecialchars($anuncio['marca']); ?></div>
                <div><strong>Año:</strong> <?php echo htmlspecialchars($anuncio['anio']); ?></div>
                <div><strong>KM:</strong> <?php echo number_format($anuncio['kilometraje'], 0, ',', '.'); ?> km</div>
                <div><strong>Ubicación:</strong> <?php echo htmlspecialchars($anuncio['ubicacion']); ?></div>
            </div>

            <p class="description"><?php echo nl2br(htmlspecialchars($anuncio['descripcion'])); ?></p>

            <div class="precio-container">
                <p class="precio"><span><?php echo number_format($anuncio['precio'], 2, ',', '.'); ?></span> €</p>
                <?php if ($anuncio['vendido'] == 1): ?>
                    <span class="vendido-badge">Vendido</span>
                <?php else: ?>
                    <?php if ($estaLogueado && !$esPropietario): ?>
                        <button class="button button-primary" id="btnContactar" onclick="iniciarChat()">
                            💬 Contactar al vendedor
                        </button>
                    <?php elseif (!$estaLogueado): ?>
                        <a href="/login"><button class="button button-primary">Inicia sesión para contactar</button></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="anuncio-vendedor">
                <p>Vendedor: <strong><?php echo htmlspecialchars($anuncio['nombre']); ?></strong></p>

                <?php if ($estaLogueado && !$esPropietario): ?>
                    <!-- Ver perfil del vendedor -->
                    <a href="/perfil?usuario=<?php echo $anuncio['id_usuario']; ?>">
                        <button class="button button-secondary">Ver Perfil</button>
                    </a>
                    <!-- Reportar: solo si NO eres el dueño -->
                    <?php if ($anuncio['vendido'] != 1): ?>
                    <a href="/nuevoReporte?id=<?php echo $anuncio['id_anuncio']; ?>&id_usuario=<?php echo $anuncio['id_usuario']; ?>&nombre=<?php echo urlencode($anuncio['nombre']); ?>&titulo=<?php echo urlencode($anuncio['titulo']); ?>">
                        <button class="button button-danger">Reportar anuncio</button>
                    </a>
                    <?php endif; ?>

                <?php elseif ($esPropietario): ?>
                    <!-- Es tu propio anuncio -->
                    <a href="/anunciosUsuario">
                        <button class="button button-secondary">Gestionar mis anuncios</button>
                    </a>

                <?php else: ?>
                    <!-- No logueado -->
                    <a href="/login"><button class="button button-secondary">Inicia sesión para ver el perfil</button></a>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] === 'autoreporte'): ?>
                    <p style="color:orange; margin-top:10px;">No puedes reportar tu propio anuncio.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
    <?php if ($estaLogueado && !$esPropietario): ?>
    <script>
    async function iniciarChat() {
        const btn = document.getElementById('btnContactar');
        btn.disabled = true;
        btn.textContent = 'Abriendo chat…';
        const fd = new FormData();
        fd.append('id_otro',    <?= (int)$anuncio['id_usuario'] ?>);
        fd.append('id_anuncio', <?= (int)$anuncio['id_anuncio'] ?>);
        try {
            const res  = await fetch('/src/Controller/chatController.php?action=iniciar', { method:'POST', body: fd });
            const data = await res.json();
            if (data.success) {
                window.location.href = '/chats?id=' + data.id_chat;
            } else {
                alert('Error al abrir el chat: ' + (data.error || ''));
                btn.disabled = false;
                btn.textContent = '💬 Contactar al vendedor';
            }
        } catch(e) {
            alert('Error de conexión');
            btn.disabled = false;
            btn.textContent = '💬 Contactar al vendedor';
        }
    }
    </script>
    <?php endif; ?>
</body>
</html>

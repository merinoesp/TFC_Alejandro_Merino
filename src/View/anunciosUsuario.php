<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Anuncios — Car2iu</title>
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['id'])) {
        header('Location: /login');
        exit();
    }
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
    ?>
    <main class="main-anuncios">
        <h1>Mis Anuncios</h1>
        <section class="mas-visitados">
            <div class="card-container">
                <?php
                $anunciosDb = $db->listarAnunciosUsuario();

                if ($anunciosDb === false || empty($anunciosDb)) {
                    echo '<div class="no-anuncios">
                        <p>¡Vaya! Parece que no tienes ningún anuncio en línea.</p>
                        <a href="crearAnuncio.php"><button class="button button-primary">Publica uno ya!</button></a>
                    </div>';
                } else {
                    foreach ($anunciosDb as $anuncio) {
                        $rutaLimpia = ltrim($anuncio['ruta'], './');
                        $rutaLimpia = ltrim($rutaLimpia, '/');
                        $srcImagen  = '/' . $rutaLimpia;

                        echo '<article class="anuncios-main">
                            <section class="anuncio-content">
                                <img src="' . htmlspecialchars($srcImagen) . '" alt="' . htmlspecialchars($anuncio['titulo'] ?? 'Anuncio') . '">
                                <h2 class="subtitle">' . htmlspecialchars($anuncio['titulo']) . '</h2>
                                <div class="precio-container">
                                    <p class="precio"><span>' . htmlspecialchars($anuncio['precio']) . '</span>&nbsp;€</p>
                                    <a href="/anuncio?id=' . (int)$anuncio['id_anuncio'] . '">
                                        <button class="button button-primary">Ver Detalle</button>
                                    </a>
                                </div>
                                <div class="anuncio-vendedor">
                                    ' . ($anuncio['vendido'] == 1 ? '<span class="vendido-badge">Ya vendido</span>' : '<button class="button button-success" data-id="' . (int)$anuncio['id_anuncio'] . '" onclick="marcarVendido(this)">Vendido</button>') . '
                                    <button class="button button-danger btn-eliminar" data-id="' . (int)$anuncio['id_anuncio'] . '">Eliminar</button>
                                </div>
                            </section>
                        </article>';
                    }
                }
                ?>
            </div>
        </section>
    </main>
    

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Confirmación</h2>
                <span class="modal-close" onclick="cerrarModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p id="modalMessage">¿Estás seguro?</p>
            </div>
            <div class="modal-footer">
                <button class="button button-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="button button-danger" id="modalConfirmBtn" onclick="confirmarAccion()">Confirmar</button>
            </div>
        </div>
    </div>
    
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
    <script src="/public/assets/js/borrarAnuncio.js"></script>
</body>
</html>

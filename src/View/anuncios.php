<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncios — Car2iu</title>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database('localhost', 'root', '', 'car2iu', 3306);
    ?>
    <main class="main-anuncios">
        <h1>Anuncios</h1>
        <section class="mas-visitados">
            <?php
            $anunciosDb = $db->listarAnuncios();

            if ($anunciosDb === false || empty($anunciosDb)) {
                echo '<div class="no-anuncios">
                    <p>¡Vaya! Parece que no hay anuncios. ¡Publica uno ya!</p>
                    <a href="crearAnuncio.php"><button class="button button-primary">Publica uno ya!</button></a>
                </div>';
            } else {
                echo '<div class="card-container">';
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
                                ' . ($anuncio['vendido'] == 1 ? '<span class="vendido-badge">Vendido</span>' : '') . '
                                <a href="/anuncio?id=' . (int)$anuncio['id_anuncio'] . '">
                                    <button class="button button-primary">Ver Detalle</button>
                                </a>
                            </div>
                            <div class="anuncio-vendedor">
                                <p>Vendedor: <strong>' . htmlspecialchars($anuncio['nombre']) . '</strong></p>
                                
                            </div>
                        </section>
                    </article>';
                }
                echo '</div>';
            }
            ?>
        </section>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
</body>
</html>

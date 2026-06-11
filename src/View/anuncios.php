<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);

$PER_PAGE = 9;
$total    = $db->contarAnuncios();
$anunciosDb = $db->listarAnunciosPaginados(0, $PER_PAGE);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncios — Car2iu</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>

    <main class="main-anuncios">
        <h1>Anuncios</h1>

        <section class="mas-visitados">
            <?php if (empty($anunciosDb)): ?>
                <div class="no-anuncios">
                    <p>¡Vaya! No hay anuncios. ¡Publica el primero!</p>
                    <?php if (isset($_SESSION['id']) && !$db->verificarAdmin($_SESSION['id'])): ?>
                        <a href="/crearAnuncio"><button class="button button-primary">Publica uno ya</button></a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="card-container" id="card-container">
                    <?php foreach ($anunciosDb as $a): ?>
                        <?php
                        $rutaLimpia = '/' . ltrim(ltrim($a['ruta'], './'), '/');
                        $precioFmt  = number_format((float)$a['precio'], 0, ',', '.');
                        $kmFmt      = number_format((int)$a['kilometraje'], 0, ',', '.');
                        ?>
                        <article class="wlp-card<?= $a['vendido'] ? ' wlp-card--vendido' : '' ?>">
                            <a href="/anuncio?id=<?= (int)$a['id_anuncio'] ?>" class="wlp-card__link" tabindex="-1" aria-hidden="true">
                                <div class="wlp-card__img-wrap">
                                    <img src="<?= htmlspecialchars($rutaLimpia) ?>"
                                         alt="<?= htmlspecialchars($a['titulo']) ?>"
                                         loading="lazy">
                                    <?php if ($a['vendido']): ?>
                                        <span class="wlp-card__badge wlp-card__badge--vendido">Vendido</span>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="wlp-card__body">
                                <p class="wlp-card__precio"><?= $precioFmt ?> €</p>
                                <h2 class="wlp-card__titulo">
                                    <a href="/anuncio?id=<?= (int)$a['id_anuncio'] ?>"><?= htmlspecialchars($a['titulo']) ?></a>
                                </h2>
                                <div class="wlp-card__meta">
                                    <span><?= htmlspecialchars($a['marca']) ?></span>
                                    <span><?= htmlspecialchars($a['anio']) ?></span>
                                    <span><?= $kmFmt ?> km</span>
                                </div>
                                <div class="wlp-card__footer">
                                    <span class="wlp-card__ubicacion">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <?= htmlspecialchars($a['ubicacion']) ?>
                                    </span>
                                    <span class="wlp-card__vendedor"><?= htmlspecialchars($a['nombre']) ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if ($total > $PER_PAGE): ?>
                <div class="paginacion-wrap" id="paginacion-wrap">
                    <button class="button button-outline" id="btn-cargar-mas"
                            data-offset="<?= $PER_PAGE ?>"
                            data-total="<?= $total ?>"
                            data-per="<?= $PER_PAGE ?>">
                        Cargar más <span id="pag-contador">(<?= min($PER_PAGE, $total) ?> de <?= $total ?>)</span>
                    </button>
                </div>
                <?php endif; ?>

            <?php endif; ?>
        </section>
    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
    <script defer src="/public/assets/js/anuncios.js"></script>
</body>
</html>

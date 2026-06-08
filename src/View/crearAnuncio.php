<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Security.php';

Security::setHeaders();

// Bloquear admins y no logueados
if (!isset($_SESSION['id'])) { header('Location: /login'); exit(); }
$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
if ($db->verificarAdmin($_SESSION['id'])) { header('Location: /'); exit(); }

$csrf = Security::generateCsrf();

$errores = [
    'datos'   => 'Faltan campos obligatorios o los valores no son válidos.',
    'upload'  => 'No se pudo subir la imagen. Asegúrate de adjuntar un archivo.',
    'formato' => 'Formato de imagen no permitido. Usa JPG, PNG o WebP.',
    'tamano'  => 'La imagen supera el tamaño máximo permitido (5 MB).',
];
$err = isset($_GET['err']) ? ($errores[$_GET['err']] ?? null) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Anuncio — Car2iu</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>
    <main class="n_main">
        <h1>Nuevo Anuncio</h1>
        <?php if ($err): ?>
            <p style="color:#e74c3c;background:#2c1010;border-radius:8px;padding:12px 16px;margin-bottom:16px;"><?= $err ?></p>
        <?php endif; ?>
        <section class="n_anuncio">
            <form action="/src/Controller/ProcesarAnuncio.php" method="POST" class="form-group" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="formulario" value="crear">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

                <label for="titulo">Título del anuncio:</label>
                <input type="text" id="titulo" name="titulo" maxlength="150" required>

                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" maxlength="80" required>

                <label for="anio">Año:</label>
                <input type="number" id="anio" name="anio" min="1900" max="2099" required>

                <label for="kilometraje">Kilometraje:</label>
                <input type="number" id="kilometraje" name="kilometraje" min="0" max="9999999" required>

                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" max="9999999" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="5" maxlength="2000" required></textarea>

                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion" maxlength="100" required>

                <label for="imagen">Foto del vehículo (JPG, PNG, WebP · máx 5 MB):</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp" required>

                <button type="submit" class="button button-primary">Publicar Anuncio</button>
            </form>
        </section>
    </main>
</body>
</html>

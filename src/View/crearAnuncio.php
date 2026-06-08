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
        <section class="n_anuncio">
            <form action="/src/Controller/ProcesarAnuncio.php" method="POST" class="form-group" enctype="multipart/form-data">
                <input type="hidden" name="formulario" value="crear">

                <label for="titulo">Título del anuncio:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>

                <label for="anio">Año:</label>
                <input type="number" id="anio" name="anio" min="1900" max="2099" required>

                <label for="kilometraje">Kilometraje:</label>
                <input type="number" id="kilometraje" name="kilometraje" min="0" required>

                <label for="precio">Precio (€):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="5" required></textarea>

                <label for="ubicacion">Ubicación:</label>
                <input type="text" id="ubicacion" name="ubicacion" required>

                <label for="imagen">Foto del vehículo:</label>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg,image/png,image/webp" required>

                <button type="submit" class="button button-primary">Publicar Anuncio</button>
            </form>
        </section>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Reporte</title>
</head>
<body>
  <?php 
  require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
  $id         = $_GET['id'] ?? null;
  $nombre     = $_GET['nombre'] ?? '';
  $titulo     = $_GET['titulo'] ?? '';
  $id_usuario = $_GET['id_usuario'] ?? null;
  ?>

  <main class="main-reportes">
    <section class="title">
        <h1>Nuevo Reporte</h1>
    </section>
    <section class="rep-section">
        <form action="/src/Controller/ControladorReporte.php" method="POST" class="form-group">

            <input type="hidden" name="id_anuncio"  value="<?php echo $id; ?>">
            <input type="hidden" name="id_usuario"  value="<?php echo $id_usuario; ?>">
            <input type="hidden" name="nombre"      value="<?php echo htmlspecialchars($nombre); ?>">
            <input type="hidden" name="titulo"      value="<?php echo htmlspecialchars($titulo); ?>">

            <h3>Reportar: <?php echo htmlspecialchars($nombre); ?></h3>
            <p>Anuncio: <?php echo htmlspecialchars($titulo); ?></p>
            <label for="rep">Motivo del reporte:</label>
            <textarea name="rep" id="rep"></textarea>
            <br>
            <button type="submit" class="button button-primary">Enviar Reporte</button>
        </form>
    </section>
  </main>
</body>
</html>
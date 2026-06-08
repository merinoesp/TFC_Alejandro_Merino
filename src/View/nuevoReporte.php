<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Reporte — Car2iu</title>
</head>
<body>
  <?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';

  // Debe estar logueado para reportar
  if (!isset($_SESSION['id'])) {
      header('Location: /login');
      exit();
  }

  $id         = (int)($_GET['id'] ?? 0);
  $id_usuario = (int)($_GET['id_usuario'] ?? 0);
  $nombre     = $_GET['nombre'] ?? '';
  $titulo     = $_GET['titulo'] ?? '';

  // No puedes reportar tu propio anuncio
  if ($id_usuario === (int)$_SESSION['id']) {
      header('Location: /anuncio?id=' . $id . '&error=autoreporte');
      exit();
  }

  if ($id === 0 || $id_usuario === 0) {
      header('Location: /anuncios');
      exit();
  }
  ?>

  <main class="main-reportes">
    <section class="title">
        <h1>Nuevo Reporte</h1>
    </section>
    <section class="rep-section">

        <?php if (isset($_GET['error']) && $_GET['error'] === 'vacio'): ?>
            <p style="color:red;">El motivo del reporte no puede estar vacío.</p>
        <?php endif; ?>

        <form action="/src/Controller/ControladorReporte.php" method="POST" class="form-group">

            <input type="hidden" name="id_anuncio"  value="<?php echo $id; ?>">
            <input type="hidden" name="id_usuario"  value="<?php echo $id_usuario; ?>">

            <h3>Reportar anuncio de: <?php echo htmlspecialchars($nombre); ?></h3>
            <p>Anuncio: <strong><?php echo htmlspecialchars($titulo); ?></strong></p>
            <label for="rep">Motivo del reporte:</label>
            <textarea name="rep" id="rep" placeholder="Describe el motivo del reporte..." required></textarea>
            <br>
            <button type="submit" class="button button-danger">Enviar Reporte</button>
            <a href="/anuncio?id=<?php echo $id; ?>"><button type="button" class="button button-secondary">Cancelar</button></a>
        </form>
    </section>
  </main>
  <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anuncio - <?php echo htmlspecialchars($anuncio['titulo']); ?></title>
</head>
<body>
    <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

    $db = new Database('localhost', 'root', '', 'car2iu', 3306); 

    $id = $_GET['id'] ?? null;

    if ($id === null) {
        die("Error: No se recibió ningún ID por la URL.");
    }

    $anuncio = $db->listarAnuncio($id);

    if (!$anuncio) {
        die("Error: Anuncio no encontrado o la consulta falló.");
    }

    $rutaImagen = "/" . ltrim(ltrim($anuncio['ruta'], '.'), '/');
    ?>

    <main class="anuncio-main">
        <section class="anuncio-content">
            <h2 class="subtitle"><?php echo htmlspecialchars($anuncio['titulo']); ?></h2>
            
            <div class="anuncio-img">
                <img src="<?php echo $rutaImagen; ?>" alt="Imagen de <?php echo htmlspecialchars($anuncio['titulo']); ?>">
            </div>

            <div class="specs-container" >
                <div><strong>Marca:</strong> <?php echo htmlspecialchars($anuncio['marca']); ?></div>
                <div><strong>Año:</strong> <?php echo htmlspecialchars($anuncio['anio']); ?></div>
                <div><strong>KM:</strong> <?php echo number_format($anuncio['kilometraje'], 0, ',', '.'); ?> km</div>
            </div>

            <p class="description"><?php echo nl2br(htmlspecialchars($anuncio['descripcion'])); ?></p>
            
            <div class="precio-container">
                <p class="precio"><span><?php echo number_format($anuncio['precio'], 2, ',', '.'); ?></span>€</p>
                <?php if ($anuncio['vendido'] == 1): ?>
                    <span class="vendido-badge">Vendido</span>
                <?php else: ?>
                    <br>
                    <button class="button button-primary contactar">Contactar</button>
                <?php endif; ?>
            </div>

            <div class="anuncio-vendedor">
                <p>Ubicación: <strong><?php echo htmlspecialchars($anuncio['ubicacion']); ?></strong></p>
                <p>Vendedor: <strong><?php echo htmlspecialchars($anuncio['nombre']); ?></strong></p>
                <a href="/nuevoReporte?id=<?php echo $anuncio['id_anuncio']; ?>&id_usuario=<?php echo $anuncio['id_usuario']; ?>&nombre=<?php echo urlencode($anuncio['nombre']); ?>&titulo=<?php echo urlencode($anuncio['titulo']); ?>">
    <button class="button button-danger">Reportar</button>
</a>
                <a href="perfil.php?id=<?php echo $anuncio['id_usuario']; ?>">
        
                   
              <?php
if (isset($_SESSION['usuario'])) {
   //<a href="/anuncio?id=' . (int)$anuncio['id_anuncio'] . '">
    echo '<a href="/perfil?usuario='.$anuncio['id_usuario'].'"><button class="button button-secondary">Ver Perfil</button></a>';
} else {
    
    echo '<a href="/login"><button class="button button-secondary">Iniciar Sesión</button></a>';
}
?>
                </a>
            </div>
        </section>
    </main>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/footer.php'; ?>
</body>
</html>
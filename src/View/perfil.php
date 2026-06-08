<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
</head>
<body>
    <?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    $db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
     //Cogemos el id por get para poder ver el perfil de el usuario
    $id = $_GET['usuario'];
    $datosUsuario = $db->datosUsuario($id);
    $anunciosDb = $db->listarAnunciosUsuario($id);
    ?>

    <main class="profile">
        <div class="user-info">
        <h1 class="title"><?php echo  $datosUsuario['nombre']; ?></h1>
        <div class="user-datos">
        <p>Anuncios Publicados: <span><?php echo count($anunciosDb); ?></span></p>
        <p>Reportes: <span>2</span></p>
        <p>Ventas: <span>5</span></p>
        <p>Miembro desde el <span><?php echo $datosUsuario['fecha_registro']; ?></span></p>
        </div>
        
        
    </div>
<br><br>

     <h1 class="title">Anuncios</h1>
        <br>
        <?php
            

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
        
            
       
       
   
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
</head>

<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php';
    $db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
    ?>

    <main class="main-user">
        <h1>Panel de Usuario</h1>
        <section class="section-user">
            <div class="userSection">
                <form action="/src/Controller/userPanelController.php" method="POST" class="form-group" enctype="multipart/form-data">
                    <input type="hidden" name="formulario" value="avatar">
                    <p>Cambio de Avatar</p>
                <?php if (isset($_GET['avatar'])): ?>
                    <?php if ($_GET['avatar'] === 'ok'): ?>
                        <p style="color:green;">&#10003; Avatar actualizado correctamente.</p>
                    <?php elseif ($_GET['avatar'] === 'tipo'): ?>
                        <p style="color:red;">&#10007; Formato no permitido. Usa JPG, PNG, WEBP o GIF.</p>
                    <?php elseif ($_GET['avatar'] === 'error'): ?>
                        <p style="color:red;">&#10007; No se pudo guardar el archivo. Inténtalo de nuevo.</p>
                    <?php endif; ?>
                <?php endif; ?>
                <img src="/<?php echo ltrim($_SESSION['avatar'], './'); ?>" alt="avatar" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp,image/gif">
                <button class="button button-secondary" name="enviar">Cambiar Avatar</button>
                  
            </form>
            </div>
            <div class="userSection">
                <p>Cambio de Contraseña</p>
                <form action="/src/Controller/userPanelController.php" class="form-group" method="POST">
                    <input type="hidden" name="formulario" value="password">
                    <label for="nueva">Contraseña Actual</label>
                    <input type="password" name="actual" id="current">
                    <label for="nueva">Nueva Contraseña</label>
                    <input type="password" name="nueva" id="new">
                    <button type="submit" class="button button-secondary">Cambiar Contraseña</button>
                    
                </form>
            </div>
            <div class="userSection">
                <p>Cambio de Email</p>
                <form action="/src/Controller/userPanelController.php" class="form-group" method="POST">
                    <input type="hidden" name="formulario" value="email">
                    <label for="text">Email Actual</label>
                    <input type="text" name="actual" id="current">
                    <label for="new">Email Nuevo</label>
                    <input type="text" name="nuevo" id="new">
                    <button type="submit" class="button button-secondary">Cambiar Email</button>
                </form>
            </div>
            <div class="userSection">
                <p>Cambio de Nombre</p>
                <form action="/src/Controller/userPanelController.php" class="form-group" method="POST">
                    <input type="hidden" name="formulario" value="nombre">
                    <label for="text">Nombre Actual</label>
                    <input type="text" name="actual" id="nactual">
                    <label for="text">Nuevo Nombre</label>
                    <input type="text" name="nuevo" id="nombre">
                    <button type="submit" class="button button-secondary">Cambiar Nombre</button>
                </form>
            </div>
            <div class="userSection">
                  <p>Mis Reportes</p>
                  <p>Aqui saldra, tus reportes</p>
                  <button class="button button-secondary">Ver Reportes</button>
            </div>
            <div class="userSection">
                  <p>Mis Ventas</p>
                  <br>
                  <p>Ventas Realizadas: <span class="ventas"><?php  $ventas = $db->contadorVentas($_SESSION['id']); echo count($ventas);  ?></span></p>
                  
            </div>
            <div class="userSection">
                  <p>Mis Anuncios</p>
                  <br>
                  <p>Haz click en el botón para ver tus anuncios activos</p>
                  <a href="/anunciosUsuario"><button class="button button-secondary">Ver Anuncios</button></a>
            </div>
        </section>

    </main>
</body>

</html>
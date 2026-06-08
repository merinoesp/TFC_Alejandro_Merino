<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Cambiada</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>
    <main class="message">
        <div class="message-container">
            <h1>Contraseña Cambiada Correctamente</h1>
            <p>Cierra la sesión y iniciala de nuevo.</p>
            
            <a href="/cerrarSesion"><button class="button button-primary">Cerrar Sesión</button></a>
            
        </div>
    </main>
</body>
</html>
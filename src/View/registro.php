<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <script defer src="/public/assets/js/validarRegister.js"></script>
    <title>Registro — Car2iu</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>
    <main class="main-register">
        <section class="section-form">
            <h1>Registro de Usuario</h1>
            <form action="/src/Controller/procesarFormulario.php" method="POST" class="form-group" id="form">
                <input type="hidden" name="formulario" value="register">

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>

                <label for="password_repeat">Repetir contraseña:</label>
                <input type="password" name="password_repeat" id="password_repeat" required>
                <span id="password-match-msg" style="font-size:0.85em; display:none;"></span>

                <label for="telefono">Teléfono:</label>
                <input type="tel" name="telefono" id="telefono">

                <button type="submit" class="button button-primary">Registrarse</button>
            </form>

            <?php
            $error = $_GET['error'] ?? null;
            if ($error === 'duplicado') {
                echo '<div class="error-container"><p>El nombre o email ya están registrados.</p></div>';
            }
            ?>

            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </section>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <title>Iniciar Sesión — Car2iu</title>
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>
    <main class="main-register">
        <section class="section-form">
            <h1>Inicio de Sesión</h1>
            <form action="/src/Controller/procesarFormulario.php" method="POST" class="form-group" id="form">
                <input type="hidden" name="formulario" value="login">

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
                 <br>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required>
                         <br>
                <button type="submit" class="button button-primary">Iniciar Sesión</button>
            </form>

            <?php
            $error = $_GET['error'] ?? null;
            if ($error !== null) {
                $mensajes = [
                    '1'       => 'Contraseña incorrecta.',
                    '2'       => 'Usuario no registrado.',
                    'no_user' => 'No existe ninguna cuenta con ese email.',
                ];
                $msg = $mensajes[$error] ?? 'Error desconocido.';
                echo '<div class="error-container"><p>' . htmlspecialchars($msg) . '</p></div>';
            }
            ?>

            <p>¿No tienes cuenta? <a href="registro.php">Créala aquí</a></p>
        </section>
    </main>
</body>
</html>

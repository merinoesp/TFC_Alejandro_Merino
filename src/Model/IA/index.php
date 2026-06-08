<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA Car2iu</title>
    <link rel="stylesheet" href="../../../public/assets/css/styles.css">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/View/partials/nav.php'; ?>
    <main class="ia-main">
        <div class="ia-container">
            <div class="chat-header">
                <span class="chat-header-dot"></span>
                <h2>Car2iu IA</h2>
            </div>
            <div class="chat-box" id="chat-box">
                <div class="chat-empty" id="logo">
                    <p>Inicia una conversación</p>
                </div>
            </div>
            <form class="chat-bar" id="chat-form">
                <input type="text" id="mensaje" placeholder="Escribe un mensaje…" autocomplete="off" required>
                <button type="submit" class="button button-primary" id="send">Preguntar</button>
            </form>
        </div>
    </main>
</body>

</html>
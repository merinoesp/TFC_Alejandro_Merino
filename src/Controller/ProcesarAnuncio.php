<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
session_start();

// ── Seguridad: solo usuarios logueados y NO admin ───────────────────────────
if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);

if ($db->verificarAdmin($_SESSION['id'])) {
    header('Location: /');
    exit();
}

// ── CSRF token ───────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
        http_response_code(403);
        die('Token de seguridad inválido. Vuelve atrás y reintenta.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST['formulario'] ?? '';

    switch ($form) {
        case 'crear':
            // Sanitizar y validar entradas
            $titulo      = trim(htmlspecialchars($_POST['titulo'] ?? '', ENT_QUOTES, 'UTF-8'));
            $marca       = trim(htmlspecialchars($_POST['marca'] ?? '', ENT_QUOTES, 'UTF-8'));
            $anio        = filter_var($_POST['anio'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1900, 'max_range' => 2099]]);
            $kilometraje = filter_var($_POST['kilometraje'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
            $precio      = filter_var($_POST['precio'] ?? 0, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);
            $descripcion = trim(htmlspecialchars($_POST['descripcion'] ?? '', ENT_QUOTES, 'UTF-8'));
            $ubicacion   = trim(htmlspecialchars($_POST['ubicacion'] ?? '', ENT_QUOTES, 'UTF-8'));

            if (!$titulo || !$marca || $anio === false || $kilometraje === false || $precio === false || !$descripcion || !$ubicacion) {
                header('Location: /crearAnuncio?err=datos');
                exit();
            }

            // Validar imagen
            if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
                header('Location: /crearAnuncio?err=upload');
                exit();
            }

            $formatos_permitidos = ['image/jpeg', 'image/png', 'image/webp'];
            $tipo_archivo = mime_content_type($_FILES['imagen']['tmp_name']);

            if (!in_array($tipo_archivo, $formatos_permitidos)) {
                header('Location: /crearAnuncio?err=formato');
                exit();
            }

            // Tamaño máximo 5 MB
            if ($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
                header('Location: /crearAnuncio?err=tamano');
                exit();
            }

            $extension      = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $extensiones_ok = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($extension, $extensiones_ok)) {
                header('Location: /crearAnuncio?err=formato');
                exit();
            }

            $nombre_archivo = uniqid('anuncio_', true) . '.' . $extension;
            // Ruta física absoluta desde DOCUMENT_ROOT
            $dir_fisico = $_SERVER['DOCUMENT_ROOT'] . '/uploads/anuncios/';
            if (!is_dir($dir_fisico)) {
                mkdir($dir_fisico, 0755, true);
            }
            $ruta_fisica = $dir_fisico . $nombre_archivo;
            $ruta_db     = 'uploads/anuncios/' . $nombre_archivo;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_fisica)) {
                $db->nuevoAnuncio($titulo, $marca, $anio, $kilometraje, $precio, $descripcion, $ruta_db, $ubicacion);
                header('Location: /?success=1');
                exit();
            }

            header('Location: /crearAnuncio?err=upload');
            break;

        case 'editar':
            // Pendiente
            break;
    }
}

header('Location: /crearAnuncio');
exit();

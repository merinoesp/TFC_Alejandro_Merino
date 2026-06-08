<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

$db = new Database('localhost', 'root', '', 'car2iu', 3306);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST['formulario'] ?? '';

    switch ($form) {
        case 'crear':
    $titulo = $_POST['titulo'];
    $marca = $_POST['marca'];
    $anio = $_POST['anio'];
    $kilometraje = $_POST['kilometraje'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $ubicacion = $_POST['ubicacion'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

        // Sanitizar nombre: eliminar caracteres no permitidos y generar nombre único
        $extension = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
        $nombre_archivo = uniqid('anuncio_', true) . '.' . $extension;
        $ruta_fisica = "../../uploads/anuncios/" . $nombre_archivo;
        $ruta_db = "uploads/anuncios/" . $nombre_archivo;

        $formatos_permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        $tipo_archivo = mime_content_type($_FILES['imagen']['tmp_name']);

        if (in_array($tipo_archivo, $formatos_permitidos) && move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_fisica)) {
            
            $db->nuevoAnuncio($titulo, $marca, $anio, $kilometraje, $precio, $descripcion, $ruta_db, $ubicacion);

            header('Location: /?success=1');
            exit();
        }
    }
    header('Location: /?err=upload');
    break;

        case 'editar':
            // Lógica pendiente
            break;
    }
}
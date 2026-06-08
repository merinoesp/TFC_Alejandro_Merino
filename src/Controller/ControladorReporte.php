<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

// Debe estar logueado
if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

$db   = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$conn = $db->dbConnect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario  = (int)$_POST['id_usuario'];
    $id_anuncio  = (int)$_POST['id_anuncio'];
    $motivoReporte = trim($_POST['rep'] ?? '');

    // Seguridad: no puedes reportar tu propio anuncio
    if ($id_usuario === (int)$_SESSION['id']) {
        header('Location: /?error=autoreporte');
        exit();
    }

    // Validar que el motivo no esté vacío
    if (empty($motivoReporte)) {
        header('Location: /nuevoReporte?id=' . $id_anuncio . '&id_usuario=' . $id_usuario . '&error=vacio');
        exit();
    }

    $db->nuevoReporte($id_anuncio, (int)$_SESSION['id'], $motivoReporte);
    header('Location: /?success=1');
    exit();

} else {
    header('Location: /?error=1');
    exit();
}

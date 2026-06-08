<?php
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

header('Content-Type: application/json');

// Verificar que el usuario está logueado
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);

// Verificar que es admin usando el método existente
if (!$db->verificarAdmin($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Petición inválida']);
    exit;
}

switch ($action) {
    case 'borrarCuenta':
        $result = $db->borrarCuenta($id);
        echo json_encode(['success' => (bool)$result]);
        break;

    case 'marcarLeido':
        $result = $db->marcarLeido($id);
        echo json_encode(['success' => (bool)$result]);
        break;

    case 'borrarAnuncio':
        $result = $db->borrarAnuncio($id);
        echo json_encode(['success' => (bool)$result]);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción desconocida']);
        break;
}

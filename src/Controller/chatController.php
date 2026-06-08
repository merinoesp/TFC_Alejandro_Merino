<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$uid = (int)$_SESSION['id'];
$db  = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$action = $_GET['action'] ?? '';

switch ($action) {

    // Obtener o crear chat y devolver su id
    case 'iniciar':
        $idOtro    = (int)($_POST['id_otro']    ?? 0);
        $idAnuncio = isset($_POST['id_anuncio']) ? (int)$_POST['id_anuncio'] : null;
        if ($idOtro <= 0 || $idOtro === $uid) {
            echo json_encode(['success' => false, 'error' => 'Usuario inválido']); exit;
        }
        $idChat = $db->obtenerOCrearChat($uid, $idOtro, $idAnuncio);
        echo json_encode(['success' => true, 'id_chat' => $idChat]);
        break;

    // Listar chats del usuario actual
    case 'listar':
        $chats = $db->listarChatsUsuario($uid);
        echo json_encode(['success' => true, 'chats' => $chats]);
        break;

    // Mensajes de un chat
    case 'mensajes':
        $idChat = (int)($_GET['id_chat'] ?? 0);
        $info   = $db->infoChat($idChat, $uid);
        if (!$info) { echo json_encode(['success' => false, 'error' => 'Acceso denegado']); exit; }
        $msgs = $db->mensajesChat($idChat, $uid);
        echo json_encode(['success' => true, 'mensajes' => $msgs, 'info' => $info]);
        break;

    // Enviar mensaje
    case 'enviar':
        $idChat    = (int)($_POST['id_chat']   ?? 0);
        $contenido = trim($_POST['contenido']  ?? '');
        if ($idChat <= 0 || $contenido === '' || mb_strlen($contenido) > 1000) {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']); exit;
        }
        $ok = $db->enviarMensaje($idChat, $uid, $contenido);
        echo json_encode(['success' => $ok]);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Acción desconocida']);
}

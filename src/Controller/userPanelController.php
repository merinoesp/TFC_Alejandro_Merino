<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
session_start();
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$conn = $db->dbConnect();

if ($conn) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $form = $_POST['formulario'] ?? '';

        switch ($form) {

            case 'password':
                $passActual = $_POST['actual'];
                $passNueva = password_hash($_POST['nueva'], PASSWORD_DEFAULT);
                $db->cambiarPassword($passActual, $passNueva);
                break;

            case 'email':
                $email = $_POST['actual'];
                $emailNuevo = $_POST['nuevo'];
                $db->cambiarEmail($email, $emailNuevo);
                break;

            case 'nombre':
                $nombre = $_SESSION['usuario'];
                $nuevoNombre = $_POST['nuevo'];
                $db->cambiarNombre($nombre, $nuevoNombre);
                break;

            case 'avatar':
                if (isset($_POST['enviar']) && isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

                    $extension   = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                    $extensiones = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

                    if (!in_array($extension, $extensiones)) {
                        header('Location: /userPanel?avatar=tipo');
                        exit();
                    }

                    $nombre_archivo = 'avatar_' . $_SESSION['id'] . '_' . time() . '.' . $extension;

                    // Ruta física absoluta — evita el error con rutas relativas en InfinityFree
                    $ruta_fisica = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatars/' . $nombre_archivo;
                    $ruta_db     = 'uploads/avatars/' . $nombre_archivo;

                    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $ruta_fisica)) {
                        $db->guardarAvatar($ruta_db, $_SESSION['usuario']);
                        $_SESSION['avatar'] = $ruta_db;
                        header('Location: /userPanel?avatar=ok');
                    } else {
                        header('Location: /userPanel?avatar=error');
                    }
                    exit();
                }
                break;

            case 'eliminarAnuncio':
                header('Content-Type: application/json');
                if (isset($_POST['idAnuncio'])) {
                    $idAnuncio = (int)$_POST['idAnuncio'];
                    // Verificar que el anuncio pertenece al usuario antes de eliminar
                    try {
                        $db->eliminarAnuncio($idAnuncio);
                        echo json_encode(['success' => true, 'message' => 'Anuncio eliminado correctamente']);
                    } catch (Exception $e) {
                        echo json_encode(['success' => false, 'message' => 'Error al eliminar el anuncio']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de anuncio no proporcionado']);
                }
                exit();
                break;

            case 'marcarVendido':
                header('Content-Type: application/json');
                if (isset($_POST['idAnuncio'])) {
                    $idAnuncio = (int)$_POST['idAnuncio'];
                    if ($db->venta($idAnuncio)) {
                        echo json_encode(['success' => true, 'message' => 'Anuncio marcado como vendido']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error al marcar como vendido o anuncio ya vendido']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID de anuncio no proporcionado']);
                }
                exit();
                break;
        }
    }
}

<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
session_start();
$db = new Database('localhost', 'root', '', 'car2iu', 3306);
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
                if (isset($_POST['enviar']) && isset($_FILES['avatar'])) {
                    $nombre_archivo = $_FILES['avatar']['name'];
                    $ruta_temporal = $_FILES['avatar']['tmp_name'];

                   
                    $ruta_fisica = "../../uploads/avatars/" . $nombre_archivo;

                 
                    $ruta_db = "uploads/avatars/" . $nombre_archivo;

                    if (move_uploaded_file($ruta_temporal, $ruta_fisica)) {
                        $db->guardarAvatar($ruta_db, $_SESSION['usuario']);

                       
                        $_SESSION['avatar'] = $ruta_db;

                        header('Location: /');
                        exit();
                    } else {
                        echo "Error: No se pudo mover el archivo a: " . $ruta_fisica;
                    }
                }
                break;

            case 'eliminarAnuncio':
                header('Content-Type: application/json');
                if (isset($_POST['idAnuncio'])) {
                    $idAnuncio = (int)$_POST['idAnuncio'];
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

?>
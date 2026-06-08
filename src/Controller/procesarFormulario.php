<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);
$conn = $db->dbConnect();

if($conn){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $form = $_POST['formulario'] ?? '';

        switch ($form) {

            case 'register':
                $db->registrarUsuario();
                
                break;

            case 'login':
                $db->iniciarSesion();
                break;
        }
    }
}

?>
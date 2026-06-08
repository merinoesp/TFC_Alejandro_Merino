<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

$db = new Database('localhost', 'root', '', 'car2iu', 3306);
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
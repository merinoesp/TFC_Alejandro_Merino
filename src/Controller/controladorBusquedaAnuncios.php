<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';
$db = new Database('sql210.infinityfree.com', 'if0_41267709', 'acakoj56J', 'if0_41267709_car2iu', 3306);

$conn = $db->dbConnect();

if($_SERVER['REQUEST_METHOD'] == "GET") {
    if(isset($_GET['nombre']) !== ""){
     if(isset($_GET["nombre"])) {
        $nombre = $_GET["nombre"];
        $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
        //para limpiar el nombre
        $db->listarAnunciosUsuario($nombre);
    }
    }else{
     $db->listarAnuncios();
    }
}
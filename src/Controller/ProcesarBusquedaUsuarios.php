<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

$db = new Database('localhost', 'root', '', 'car2iu', 3306);
$conn = $db->dbConnect();

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['nombre']) === ''){
        echo 'Introduce un Nombre';
    }else{
        $nombre = isset($_GET['nombre']);
        $db->buscarNombre($nombre);
    }
}

//Esto está a modificar con el tema de el usuario a ver de que forma lo gestiono
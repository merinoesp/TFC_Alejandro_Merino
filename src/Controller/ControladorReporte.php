<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Model/Database.php';

$db = new Database('localhost', 'root', '', 'car2iu', 3306);
$conn = $db->dbConnect();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_usuario = $_POST['id_usuario'];
    $id_anuncio = $_POST['id_anuncio'];
    $nombreUsuario = $_POST['nombre'];
    $tituloAnuncio = $_POST['titulo'];
    $motivoReporte = $_POST['rep'];


    $db->nuevoReporte($id_anuncio,$id_usuario,$motivoReporte);
    //Con esto insertamos el reporte con los datos que hemos obtenido

    header('Location: /?success=1');
}else{
    header('Location: /?error=1');
}



?>
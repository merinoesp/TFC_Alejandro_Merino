<?php
// app/Controllers/ContactoController.php

require_once '../../lib/EmailService.php';

class ContactoController {

    public function enviarMensaje() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $emailUsuario = $_POST['email']; // Viene de la vista
            $asunto = "Confirmación de Registro";
            $mensaje = "<h1>¡Bienvenido!</h1><p>Gracias por unirte.</p>";

            // Ejecutamos el envío
            $resultado = EmailService::enviar($emailUsuario, $asunto, $mensaje);

            if ($resultado['success']) {
                // Cargar vista de éxito o redirigir
                echo "¡Correo enviado!";
            } else {
                // Manejar el error
                echo "Error: " . $resultado['error'];
            }
        }
    }
}
<?php
// lib/EmailService.php

class EmailService {
    // ... (Mantén aquí tus métodos anteriores de configuración SMTP) ...

    public static function enviarReporteAnuncio($destinatario, $tituloAnuncio, $motivoBDD) {
        $mail = self::configurar(); // Usa la configuración SMTP que ya tenemos

        try {
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = "Acción requerida: Reporte de tu anuncio en Car2iu";

            // --- DISEÑO DEL MENSAJE DE REPORTE ---
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #f5c6cb; border-radius: 5px;'>
                <div style='background-color: #721c24; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;'>
                    <h1 style='color: white; margin: 0; font-size: 20px;'>Aviso de Revisión</h1>
                </div>
                
                <div style='padding: 30px; line-height: 1.6; color: #333;'>
                    <p>Hola,</p>
                    <p>Te informamos que hemos recibido un reporte sobre tu anuncio: <strong>\"$tituloAnuncio\"</strong>.</p>
                    
                    <div style='background-color: #fff3f3; border-left: 5px solid #721c24; padding: 15px; margin: 20px 0;'>
                        <strong style='color: #721c24;'>Motivo del reporte:</strong><br>
                        <span style='font-style: italic;'>\"$motivoBDD\"</span>
                    </div>

                    <p>Para evitar que el anuncio sea dado de baja permanentemente, <strong>por favor modifícalo</strong> para que cumpla con nuestras normas de comunidad.</p>
                    
                    <div style='text-align: center; margin-top: 30px;'>
                        <a href='https://car2iu.com/panel/mis-anuncios' 
                           style='background-color: #2c3e50; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold;'>
                           Modificar mi Anuncio
                        </a>
                    </div>
                </div>

                <div style='background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #777;'>
                    &copy; " . date('Y') . " Car2iu Soporte - Seguridad y Confianza
                </div>
            </div>";

            $mail->send();
            return ["success" => true];
        } catch (Exception $e) {
            return ["success" => false, "error" => $mail->ErrorInfo];
        }
    }
}
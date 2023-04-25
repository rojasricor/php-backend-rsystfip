<?php

namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;

class EmailSenderModel extends BaseModel
{
  public function sendEmail() {
    $mail = new PHPMailer();
    $mail->isSMTP();                                           // Usar SMTP
    $mail->Host       = 'smtp.gmail.com';                      // Servidor SMTP
    $mail->SMTPAuth   = true;                                  // Activar autenticación SMTP
    $mail->Username   = 'rsystfip@gmail.com';                 // Nombre de usuario SMTP
    $mail->Password   = '65701167';                        // Contraseña SMTP
    $mail->SMTPSecure = 'tls';                                  // Habilitar encriptación TLS
    $mail->Port       = 587;                                   // Puerto SMTP

    $mail->setFrom('rojasricor@gmail.com', 'RSystfip Inc.');
    $mail->addAddress('rrojas48@itfip.edu.co', 'Ricardo Rojas');
    $mail->addAddress('jmendoza23@itfip.edu.co', 'Jose Manuel');
    $mail->Subject = 'Asunto del correo electrónico';
    $mail->Body    = 'Contenido del correo electrónico';

    if ($mail->send()) {
      echo 'El correo electrónico se envió correctamente';
    } else {
      echo 'Hubo un error al enviar el correo electrónico: ' . $mail->ErrorInfo;
    }
  }
}
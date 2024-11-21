<?php
include_once('../configuracion.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarMail($estadoCompra, $emailUsuario){
    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP();                                
        $mail->Host       = $_ENV['MAIL_HOST'];           
        $mail->SMTPAuth   = true;                            
        $mail->Username   = $_ENV['MAIL_USERNAME'];    
        $mail->Password   = $_ENV['MAIL_SECRET'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['MAIL_PORT'];

        //Recipients
        $mail->setFrom("braianledantes@gmail.com", 'Tienda Angel Wings Jewelry');
        $mail->addAddress($emailUsuario, 'Braian Ledantes');   

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Estado de tu compra';
        $mail->Body    = "El estado de tu compra es: $estadoCompra";


       //verEstructura($mail);

        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
    }

}
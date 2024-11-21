<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailControl
{
    private function enviarMail($usuarioDestino, $titulo, $contenido)
    {
        try {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'];
            $mail->Password   = $_ENV['MAIL_SECRET'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $_ENV['MAIL_PORT'];

            //Recipients
            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Tienda Angel Wings Jewelry');
            $mail->addAddress($usuarioDestino->getusmail(), $usuarioDestino->getusnombre());

            //Content
            $mail->isHTML(true);
            $mail->Subject = $titulo;
            $mail->Body    = $contenido;
            $mail->CharSet = 'UTF-8';

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("No se pudo enviar el mail. Error: {$mail->ErrorInfo}");
        }
    }

    public function enviarMailCompra($idcompra)
    {
        // obtengo la compra
        $abmCompra = new AbmCompra();
        $param = ['idcompra' => $idcompra];
        $colCompras = $abmCompra->buscar($param);
        if (empty($colCompras)) {
            throw new Exception("No se encontró la compra con id: $idcompra");
        }
        $compra = $colCompras[0];

        // obtengo el usuario destino
        $idUsuarioDestino = $compra->getObjUsuario()->getidusuario();

        $abmUsuario = new ABMUsuario();
        $colUsuarios = $abmUsuario->buscar(['idusuario' => $idUsuarioDestino]);
        if (empty($colUsuarios)) {
            throw new Exception("No se encontró el usuario con id: $idUsuarioDestino");
        }
        $usuarioDestino = $colUsuarios[0];
        
        // obtengo el estado de la compra
        $abmEstadoCompra = new AbmCompraEstado();
        $param = ['idcompra' => $compra->getIdcompra()];
        $colCompraEstado = $abmEstadoCompra->buscar($param);
        if (empty($colCompraEstado)) {
            throw new Exception("No se encontró el estado de la compra con id: {$compra->getIdcompra()}");
        }
        $estadoCompra = $colCompraEstado[0];
       
        // obtengo los items de la compra
        $abmCompraItem = new AbmCompraItem();
        $param = ['idcompra' => $compra->getIdcompra()];
        $colCompraItem = $abmCompraItem->buscar($param);
        if (empty($colCompraItem)) {
            throw new Exception("No se encontraron items para la compra con id: {$compra->getIdcompra()}");
        }

        $titulo = "Compra realizada con éxito";
        $contenido = "<h1>Compra realizada con éxito</h1>";
        $contenido .= "<p>Estado de la compra: {$estadoCompra->getobjEstadoTipo()->getCetDescripcion()}</p>";
        $contenido .= "<h2>Items de la compra</h2>";
        $contenido .= "<ul>";
        foreach ($colCompraItem as $compraItem) {
            $contenido .= "<li>{$compraItem->getObjProducto()->getusnombre()} - {$compraItem->getCicantidad()} unidades</li>";
        }
        $contenido .= "</ul>";

        $this->enviarMail($usuarioDestino, $titulo, $contenido);
    }
    
}

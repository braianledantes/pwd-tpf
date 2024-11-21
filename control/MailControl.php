<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailControl {
    /**
     * Envia un mail al usuario destino, utilizando PHPMailer
     */
    private function enviarMail($usuarioDestino, $titulo, $contenido){
        try {
            $mail = new PHPMailer(true);
            //Configuracion del servidor, utilizando variables de entorno
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

    /**
     * Envia un mail al usuario destino, relacionado a una compra especifica  
     */
    public function enviarMailCompra($idcompra)
    {
        // Obtiene la compra
        $abmCompra = new AbmCompra();
        $param = ['idcompra' => $idcompra];
        $colCompras = $abmCompra->buscar($param);
        if (empty($colCompras)) {
            throw new Exception("No se encontró la compra con id: $idcompra");
        }
        $compra = $colCompras[0];

        // Obtiene el usuario destino
        $idUsuarioDestino = $compra->getObjUsuario()->getidusuario();
        $abmUsuario = new ABMUsuario();
        $colUsuarios = $abmUsuario->buscar(['idusuario' => $idUsuarioDestino]);
        if (empty($colUsuarios)) {
            throw new Exception("No se encontró el usuario con id: $idUsuarioDestino");
        }
        $usuarioDestino = $colUsuarios[0];

        // Obtiene el estado de la compra
        $abmEstadoCompra = new AbmCompraEstado();
        $param = ['idcompra' => $compra->getIdcompra()];
        $colCompraEstado = $abmEstadoCompra->buscar($param);
        if (empty($colCompraEstado)) {
            throw new Exception("No se encontró el estado de la compra con id: {$compra->getIdcompra()}");
        }

        // Obtiene los ítems de la compra
        $abmCompraItem = new AbmCompraItem();
        $param = ['idcompra' => $compra->getIdcompra()];
        $colCompraItem = $abmCompraItem->buscar($param);
        if (empty($colCompraItem)) {
            throw new Exception("No se encontraron items para la compra con id: {$compra->getIdcompra()}");
        }

        $titulo = "Compra en Angel Wings Jewelry";
        $contenido = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                h1 { color: #fff; background-color: #7890a8; padding: 10px; text-align: center; }
                h2 { color: #304878; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; }
                th { background-color: #f2f2f2; }
                .item { font-weight: bold; }
                .cantidad { color: #888; }
                .estado { color: #555; }
                .fecha { color: #888; }
            </style>
        </head>
        <body>
            <h1>Gracias por comprar en Angel Wings Jewelry</h1>
            <h2>Pedido: N° # {$compra->getIdcompra()}</h2>
            <h2>Detalle de la compra</h2>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                </tr>";
        foreach ($colCompraItem as $compraItem) {
            $contenido .= "<tr>
                <td class='item'>{$compraItem->getObjProducto()->getusnombre()}</td>
                <td class='cantidad'>{$compraItem->getCicantidad()} unidades</td>
            </tr>";
        }
        $contenido .= "</table>
        <h2>Estados de la compra</h2>
        <table>
            <tr>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>";
    foreach ($colCompraEstado as $compraEstado) {
        $contenido .= "<tr>
            <td class='estado'>{$compraEstado->getObjEstadoTipo()->getCetDescripcion()}</td>
            <td class='fecha'>{$compraEstado->getcefechaini()}</td>
        </tr>";
    }
    $contenido .= "</table>
    </body>
    </html>";

    $this->enviarMail($usuarioDestino, $titulo, $contenido);
}
}
?>
<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

// Verificar que la sesion esta activa y si el usuario tiene acceso al menu actual.
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

try {
    $mailControl = new MailControl();

    // obtiene datos del usuario y verifica que exista.
    $usuario = $session->getUsuario();
    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }
    $idusuario = $usuario->getIdusuario();
    $emailUsuario = $usuario->getusmail();

    // crea una nueva compra
    $abmCompra = new AbmCompra();
    $idCompra = $abmCompra->alta([
        'idusuario' => $idusuario,
        'carrito' => $session->obtenerCarrito()
    ]);

    // vacia el carrito del usuario
    $session->vaciarCarrito();

    //obtengo el estado de la compra
    $ambCompraEstado = new AbmCompraEstado();
    $param=['idcompra'=>$idCompra];
    $compraEstado=$ambCompraEstado->buscar($param);

    if (!empty($compraEstado)) {
        $estadoCompraTipo = $compraEstado[0]->getobjEstadoTipo();
        $descripcionEstadoTipo = $estadoCompraTipo->getCetDescripcion();
        $mailControl->enviarMailCompra($idCompra);
    } else {
        throw new Exception("No se encontro el estado de la compra.");
    }

    echo json_encode([
        'status' => 'success',
        'data' => 'Compra Iniciada. Se le enviará un email con los detalles de la compra.'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

?>

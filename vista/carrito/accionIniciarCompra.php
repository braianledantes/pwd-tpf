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
    // obtiene datos del usuario y verifica que exista.
    $idusuario = $session->getUsuario()->getIdusuario();
    $carrito = $session->obtenerCarrito();

    // crea una nueva compra
    $abmCompra = new AbmCompra();
    $idCompra = $abmCompra->alta([
        'idusuario' => $idusuario,
        'carrito' => $carrito
    ]);

    // vacia el carrito del usuario
    $session->vaciarCarrito();

    $mailControl = new MailControl();
    $mailControl->enviarMailCompra($idCompra);

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

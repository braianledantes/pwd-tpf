<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

try {
    // obtiene el id del usuario
    $usuario = $session->getUsuario();
    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }
    $idusuario = $usuario->getIdusuario();

    // crea una nueva compra
    $abmCompra = new AbmCompra();
    $idCompra = $abmCompra->alta([
        'idusuario' => $idusuario,
        'carrito' => $session->obtenerCarrito()
    ]);

    // vacia el carrito del usuario
    $session->vaciarCarrito();

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

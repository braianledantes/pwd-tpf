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
    // obtiene el id del producto
    $datos = data_submitted();
    $idproducto = $datos['idproducto'];

    // agrega el producto al carrito
    $session->agregarProductoAlCarrito($idproducto, 1);

    echo json_encode([
        'status' => 'success',
        'data' => $session->obtenerCarrito()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

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
    $datos = data_submitted();
    // obtiene el id del producto
    $idproducto = $datos['idproducto'];

    $session->eliminarProductoDelCarrito($idproducto);

    echo json_encode([
        'status' => 'success',
        'data' => 'Producto eliminado del carrito'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

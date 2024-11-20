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
    // obtiene el carrito
    $carrito = $session->obtenerCarrito();

    // si el carrito esta vacio lanza un error
    if (empty($carrito)) {
        throw new Exception('El carrito esta vacio');
    }

    // obtiene el id del usuario
    $usuario = $session->getUsuario();
    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }
    $idusuario = $usuario->getIdusuario();

    // crea una nueva compra
    $abmCompra = new AbmCompra();
    $idCompra = $abmCompra->alta([
        'idusuario' => $idusuario
    ]);
    if ($idCompra <= 0) {
        throw new Exception('Error al iniciar la compra');
    }

    // crea los items de la compra
    $abmCompraItem = new AbmCompraItem();
    foreach ($carrito as $idproducto => $cantidad) {
        $abmCompraItem->alta([
            'idcompra' => $idCompra,
            'idproducto' => $idproducto,
            'cicantidad' => $cantidad
        ]);
    }

    // crea un estado para la compra
    $abmCompraEstado = new AbmCompraEstado();
    $dioEstado = $abmCompraEstado->alta([
        'idcompra' => $idCompra,
        'idcompraestadotipo' => 1 // Iniciada
    ]);

    if (!$dioEstado) {
        $abmCompra->baja(['idcompra' => $idCompra]);
        throw new Exception('Error al iniciar la compra');
    }

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

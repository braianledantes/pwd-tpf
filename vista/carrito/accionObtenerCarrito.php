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
    
    // productos del carrito con su cantidad
    $data = [];
    $total = 0;

    // si el carrito no esta vacio obtiene los productos
    if (!empty($carrito)) {
        $abmProducto = new AbmProducto();
        foreach ($carrito as $idproducto => $cantidad) {
            $productos = $abmProducto->buscar(['idproducto' => $idproducto]);
            if (!empty($productos)) {
                $producto = $productos[0];
                $subtotal = $producto->getProprecio() * $cantidad;
                $total += $subtotal;
                $data[] = [
                    'producto' => $producto->toArray(),
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => ['items' => $data, 'total' => $total]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

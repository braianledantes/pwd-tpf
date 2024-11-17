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
    $data = data_submitted();
    $abmProducto = new ABMProducto();
    $exito = $abmProducto->alta($data);

    if ($exito) {
        echo json_encode([
            'status' => 'success',
            'data' => 'Producto creado con exito'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'data' => 'No se pudo crear el producto'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

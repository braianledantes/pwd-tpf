<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

// verifica que el usuario esté logueado y sea administrador
$session = new Sesion();
if (!$session->estaActiva() || !$session->esAdministrador()) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

try {
    $data = data_submitted();
    $abmProducto = new ABMProducto();
    $exito = $abmProducto->modificacion($data);

    echo json_encode([
        'status' => 'success',
        'data' => 'Producto modificado con exito'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

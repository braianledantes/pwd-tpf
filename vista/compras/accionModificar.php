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
    // obtiene el idcompraestadotipo
    $idcompraestadotipo = $datos['idcompraestadotipo'];
    $idCompra = $datos['idCompra'];

    if (!isset($idcompraestadotipo) || !isset($idCompra)) {
        throw new Exception('Faltan datos');
    }

    $abmCompra = new ABMCompraEstado();
    $abmCompra->alta([
        'idCompra' => $idCompra,
        'idcompraestadotipo' => $idcompraestadotipo
    ]);

    echo json_encode([
        'status' => 'success',
        'data' => 'Compra actualizada'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}
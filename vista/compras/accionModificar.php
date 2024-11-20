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
    // obtiene el idcompraestadotipo
    $idcompraestadotipo = $_GET['idcompraestadotipo'];
    $idCompra = $_GET['idCompra'];

    if (!isset($idcompraestadotipo) || !isset($idCompra)) {
        throw new Exception('Faltan datos');
    }

    if ($idcompraestadotipo < 0 || $idcompraestadotipo > 4) {
        throw new Exception('El estado de la compra no es válido');
    }

    $fechaFin = null;
    if ($idcompraestadotipo == 3 || $idcompraestadotipo == 4) {
        $fechaFin = date('Y-m-d H:i:s');
    }

    $abmCompra = new ABMCompraEstado();
    $abmCompra->modificacion([
        'idCompra' => $idCompra,
        'idcompraestadotipo' => $idcompraestadotipo,
        'cofechafin' => $fechaFin
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
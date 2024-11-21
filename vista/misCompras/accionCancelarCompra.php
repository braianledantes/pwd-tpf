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
    $idCompra = $datos['idcompra'];

    if (!isset($idCompra)) {
        throw new Exception('Falta el id de la compra');
    }

    $abmCompra = new ABMCompraEstado();
    $exito = $abmCompra->alta([
        'idcompra' => $idCompra,
        'idcompraestadotipo' => 4
    ]);

    if (!$exito) {
        throw new Exception('Error al cancelar compra');
    }

    $mailControl = new MailControl();
    $mailControl->enviarMailCompra($idCompra);

    echo json_encode([
        'status' => 'success',
        'data' => 'Compra cancelada'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}
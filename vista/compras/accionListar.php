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
    $abmCompra = new ABMCompra();
    $lista = $abmCompra->buscar(null);

    $abmCompraEstado = new ABMCompraEstado();

    $listaJson = [];

    foreach ($lista as $compra) {
        $comprajson = $compra->toArray();
        // obtiene el ultimo estado de la compra
        $estadosCompra = $abmCompraEstado->buscar('idcompra = ' . $compra->getIdcompra() .' order by idcompraestado decs');
        $comprajson['estado'] = $estadosCompra[0]->toArray();

        $listaJson[] = $comprajson;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $listaJson
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

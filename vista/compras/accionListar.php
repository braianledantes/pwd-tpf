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

    // cambia el order por id decreciente
    usort($lista, function ($a, $b) {
        return $b->getIdcompra() - $a->getIdcompra();
    });

    $abmCompraEstado = new ABMCompraEstado();

    $listaJson = [];

    foreach ($lista as $compra) {
        $comprajson = $compra->toArray();
        // obtiene el ultimo estado de la compra
        $estadosCompra = $abmCompraEstado->buscar('idcompra = ' . $compra->getIdcompra());

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

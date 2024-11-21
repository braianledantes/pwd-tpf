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
    $idUsuario = $session->getUsuario()->getIdusuario();

    $abmCompras = new ABMCompra();
    $lista = $abmCompras->buscar(['idusuario' => $idUsuario]);

    $listaJson = [];

    foreach ($lista as $compra) {
        $comprajson = $compra->toArray();

        // obtiene el ultimo estado de la compra
        $abmCompraEstado = new ABMCompraEstado();
        $estadosCompra = $abmCompraEstado->buscar(['idcompra' => $compra->getIdcompra()]);
        
        // obtiene el ultimo estado de la compra
        $ultimoEstado = $estadosCompra[count($estadosCompra) - 1];
        $comprajson['ultimoestado'] = $ultimoEstado->toArray();

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

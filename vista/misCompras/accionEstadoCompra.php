<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

// Verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

try {
    $usuario = $session->getUsuario();
    $idUsuario = $usuario->getidusuario();
    var_dump($idUsuario); 

    $abmCompra = new ABMCompra();
    $param = ['idusuario' => $idUsuario];
    $listaCompra = $abmCompra->buscar($param); 

    $abmCompraEstado = new ABMCompraEstado();

    $listaJson = [];

    foreach ($listaCompra as $compra) {

            


        // Agregar la compra al arreglo de resultados
        $listaJson[] = $comprajson;
        print_r($listaJson);
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
?>
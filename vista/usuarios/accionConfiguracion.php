<?php 
include_once("../../configuracion.php");
header('Content-Type: application/json');

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() /*|| !$session->tieneAccesoAMenuActual()*/) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

try {
    $data = data_submitted();

    $abmUsuario = new ABMUsuario();

    $nuevoUsuario = $abmUsuario->buscar(['usnombre' => $data['usnombre']]);

    $exito = $abmUsuario->modificacion($data);


    echo json_encode([
        'status' => 'success',
        'data' => 'Usuario modificado con exito'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}
?>
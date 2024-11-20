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

    $abmUsuario = new ABMUsuario();
    $abmUsuarioRol = new abmusuariorol();

    $nuevoUsuario = $abmUsuario->buscar(['usnombre' => $data['usnombre']]);
    $datosUsRol = [
        'idusuario' => $nuevoUsuario[0]->getidusuario(),
        'idrol' => $data['idrol'] // Asigna el rol según el valor recibido en el formulario
    ];

    $exito = $abmUsuario->modificacion($data);
    $exitoModificacionUsuarioRol = $abmUsuarioRol->modificacion($datosUsRol);


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
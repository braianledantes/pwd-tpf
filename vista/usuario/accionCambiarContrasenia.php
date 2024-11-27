<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

try {
    // verifica que el usuario esté logueado y tenga permisos
    $session = new Sesion();
    if (!$session->estaActiva()) {
        throw new Exception('No tiene permisos para realizar esta acción');
    }

    $data = data_submitted();
    $abmUsuarios = new ABMUsuario();
    $abmUsuarios->modificarContrasenia($data);

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
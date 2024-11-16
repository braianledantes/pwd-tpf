<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

// verifica que el usuario esté logueado y sea administrador
$session = new Sesion();
if (!$session->estaActiva() || !$session->esAdministrador()) {
    echo json_encode([
        'status' => 'error',
        'data' => 'No tiene permisos para realizar esta acción'
    ]);
    exit;
}

$data = data_submitted();

try {
    // borra el rol
    $abmRol = new ABMRol();
    $exito = $abmRol->baja($data);

    if ($exito) {
        echo json_encode([
            'status' => 'success',
            'data' => 'Rol eliminado con exito'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'data' => 'No se pudo eliminar el rol'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

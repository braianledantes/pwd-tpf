<?php
include_once("../../configuracion.php");

// verifica que el usuario esté logueado y sea administrador
$session = new Sesion();
if (!$session->estaActiva()) {
    header("Location: ../index.php");
}

if (!$session->esAdministrador()) {
    header('Location: ../');
    exit;
}

header('Content-Type: application/json');
$data = data_submitted();

try {
    $abmMenu = new AbmMenu();
    $exito = $abmMenu->baja($data);

    if ($exito) {
        echo json_encode([
            'status' => 'success',
            'data' => 'Menu eliminado con exito'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'data' => 'No se pudo eliminar el menu'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

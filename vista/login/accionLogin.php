<?php
include_once '../../configuracion.php';
header('Content-Type: application/json');

$sesion = new Sesion();
$data = data_submitted();

try {
    $sesion->iniciarSesion($data);

    if ($sesion->estaActiva()) {
        echo json_encode([
            'status' => 'ok',
            'message' => 'Sesión iniciada correctamente'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Usuario o contraseña incorrectos'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}


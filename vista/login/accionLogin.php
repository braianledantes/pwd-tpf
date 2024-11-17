<?php
include_once '../../configuracion.php';
header('Content-Type: application/json');

// verifica que el usuario no esté logueado
$session = new Sesion();
if ($session->estaActiva()) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ya iniciaste sesión'
    ]);
    exit;
}
$data = data_submitted();

try {
    $session->iniciarSesion($data);

    if ($session->estaActiva()) {
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


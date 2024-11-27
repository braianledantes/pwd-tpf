<?php
include_once '../../configuracion.php';
header('Content-Type: application/json');

try {
    // verifica que el usuario no esté logueado
    $session = new Sesion();
    if ($session->estaActiva()) {
        throw new Exception('Ya inició sesión');
    }

    $datos = data_submitted();

    $abmUsuario = new ABMUsuario();
    $abmUsuario->alta($datos);

    $sesion = new Sesion();
    if (!$sesion->iniciarSesion($datos)) {
        throw new Exception('Error al iniciar sesión');
    }

    echo json_encode([
        'status' => 'ok',
        'message' => 'Usuario registrado con éxito'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
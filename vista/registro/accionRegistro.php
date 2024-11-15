<?php
include_once '../../configuracion.php';
header('Content-Type: application/json');

$datos = data_submitted();

$abmUsuario = new abmusuario();
$usuarioExistente = $abmUsuario->buscar([
    'usnombre' => $datos['usnombre']
]);

if (count($usuarioExistente) > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El usuario ya existe'
    ]);
    exit;
}

$exito = $abmUsuario->alta($datos);
if (!$exito) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al registrar el usuario'
    ]);
    exit;
}

$nuevoUsuario = $abmUsuario->buscar(['usnombre' => $datos['usnombre']]);

$datosUsRol = [
    'idusuario' => $nuevoUsuario[0]->getidusuario(),
    'idrol' => 2, // el id 2 es el rol de cliente
];
$abmUsuarioRol = new ABMUsuarioRol();
$resalta = $abmUsuarioRol->alta($datosUsRol);

if (!$resalta) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al registrar el usuario'
    ]);
    exit;
}

$sesion = new Sesion();
$sesion->iniciarSesion($datos);
$inicioSesion = $sesion->estaActiva();

if (!$inicioSesion) {
    $sesion->cerrar();
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al iniciar sesión'
    ]);
    exit;
}

echo json_encode([
    'status' => 'ok',
    'message' => 'Usuario registrado con éxito'
]);
exit;

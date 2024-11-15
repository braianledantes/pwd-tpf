<?php
include_once '../../configuracion.php';
$datos = data_submitted();

$abmUsuario = new abmusuario();
$usuarioExistente = $abmUsuario->buscar(['usnombre' => $datos['usnombre']]);

if (count($usuarioExistente) > 0) {
    header('Location: ../registro/index.php?messageErr=' . urlencode("Nombre de usuario existente"));
    exit;
}

$exito = $abmUsuario->alta($datos);
if (!$exito) {
    header('Location: ../registro/index.php?messageErr=' . urlencode('Error en el registro'));
    exit;
}

$nuevoUsuario = $abmUsuario->buscar($datos);
$datosUsRol = [
    'idusuario' => $nuevoUsuario[0]->getidusuario(),
    'idrol' => 2, // el id 2 es el rol de cliente
];
$abmUsuarioRol = new ABMUsuarioRol();
$abmUsuarioRol->alta($datosUsRol);

$sesion = new session();
$sesion->iniciar($datos['usnombre'], $datos['uspass']);
$inicioSesion = $sesion->validar();

if (!$inicioSesion) {
    $sesion->cerrar();
    header('Location: ../registro/index.php?messageErr=' . urlencode("Error al iniciar sesión"));
    exit;
} else {
    header('Location: ../index.php');
    exit;
}

?>
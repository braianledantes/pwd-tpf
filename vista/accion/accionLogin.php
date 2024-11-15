<?php
include_once '../../configuracion.php';
$datos = data_submitted();

$sesion = new Session();
$loginUrl = "$PROJECT_PATH/Vista/login/index.php";
$homeUrl = "$PROJECT_PATH/index.php";

if ($sesion->activa()) {
    header("Location: $homeUrl");
    exit();
}

if (!isset($datos['usnombre']) || !isset($datos['uspass'])) {
    header("Location: $loginUrl?messageErr=" . urlencode("Usuario y/o contraseña incorrectos"));
    exit();
}

$inicioSesion = $sesion->iniciar($datos['usnombre'], $datos['uspass']);

if ($inicioSesion) {
    header("Location: $homeUrl");
} else {
    header("Location: $loginUrl?messageErr=" . urlencode("Usuario y/o contraseña incorrectos"));
}

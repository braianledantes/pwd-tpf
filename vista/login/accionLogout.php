<?php
include_once '../../configuracion.php';
header('Content-Type: application/json');

$sesion = new Sesion();
$sesion->cerrar();

echo json_encode([
    'status' => 'ok',
    'message' => 'Sesión cerrada correctamente'
]);
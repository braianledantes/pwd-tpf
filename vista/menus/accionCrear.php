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

$data = data_submitted();
$abmMenu = new AbmMenu();

// TODO: implementar la cracion de un menu

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'data' => 'Menu creado con exito'
]);
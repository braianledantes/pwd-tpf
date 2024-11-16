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

try {
    $data = data_submitted();
    $abmMenu = new AbmMenu();

    $exito = $abmMenu->modificacion($data);    

    $ubicacion = $data['medescripcion'];
    // crea la carpeta con un archivo index.php en base a plantilla.php, dentro de la carpeta "vista"
    $carpeta = "../../vista/" . $ubicacion;
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
        $plantilla = file_get_contents("./plantilla.php");
        file_put_contents($carpeta . "/index.php", $plantilla);
    }

    echo json_encode([
        'status' => 'success',
        'data' => 'Menu modificado con exito'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

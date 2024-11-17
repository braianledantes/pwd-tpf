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
    // trae todos los menus
    $abmMenu = new AbmMenu();
    $lista = $abmMenu->buscar(null);

    // por cada menu obtiene los roles asociados
    $abmMenuRol = new AbmMenuRol();
    $listaMenuRol = $abmMenuRol->buscar(null);

    $listaJson = [];

    // arma un array con los roles asociados a cada menu
    foreach ($lista as $menu) {
        $menuArray = $menu->toArray();
        $roles = [];
        foreach ($listaMenuRol as $menuRol) {
            if ($menuRol->getobjMenu()->getIdmenu() == $menu->getIdmenu()) {
                $roles[] = $menuRol->getobjrol()->toArray();
            }
        }
        $menuArray['roles'] = $roles;

        $listaJson[] = $menuArray;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $listaJson
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'data' => $e->getMessage()
    ]);
}

<?php

include_once("../../configuracion.php");
header('Content-Type: application/json');

try {
    // verifica que el usuario esté logueado y tenga permisos
    $session = new Sesion();
    if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
        throw new Exception('No tiene permisos para realizar esta acción');
    }

    $abmUsuarios = new ABMUsuario();
    $lista = $abmUsuarios->buscar(null);

    $abmUsuarioRoles = new ABMUsuarioRol();
    $listaUsuariosRoles = $abmUsuarioRoles->buscar(null);

    $listaJson = [];
    foreach ($lista as $usuario) {
        $usuarioArray = $usuario->toArray();
        $roles = [];
        foreach ($listaUsuariosRoles as $usuarioRol) {
            if ($usuarioRol->getobjusuario()->getidusuario() == $usuario->getidusuario()) {
                $roles[] = $usuarioRol->getobjrol()->toArray();
            }
        }
        $usuarioArray['roles'] = $roles;

        $listaJson[] = $usuarioArray;
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

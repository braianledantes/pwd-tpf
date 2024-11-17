<?php
include_once ('../../configuracion.php');

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

$datos = data_submitted();

$datosBusqueda['idusuario'] = $datos['idusuario'];

$abmUsuario = new abmUsuario();

$lista = $abmUsuario->buscar($datosBusqueda);

$nuevoUsuario = $abmUsuario->buscar(['usnombre' => $datos['usnombre']]);
$datosUsRol = [
    'idusuario' => $nuevoUsuario[0]->getidusuario(),
    'idrol' => $datos['idrol'] // Asigna el rol según el valor recibido en el formulario
];

if (isset($lista)) {
    $exitoModificacionUsuario = $abmUsuario->modificacion($datos);
    $abmUsuarioRol = new abmusuariorol();
    $exitoModificacionUsuarioRol = $abmUsuarioRol->modificacion($datosUsRol);
    if ($exitoModificacionUsuario || $exitoModificacionUsuarioRol) {
        header('Location: ./index.php?messageOk=' . urlencode("Usuario modificado correctamente"));
        exit;
    } else {
        header('Location: ./index.php?messageErr=' . urlencode("Error en la modificación"));
        exit;
    }
} else {
    $message = "Usuario no encontrado en la base de datos";
    header('Location: ./index.php?messageErr=' . urlencode($message));
    exit;
}
?>
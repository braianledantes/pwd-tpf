<?php
include_once '../../configuracion.php';

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}
$datos = data_submitted();
$abmUsuario = new abmusuario();
$lista = $abmUsuario->buscar($datos);
$idUsuario = $_SESSION['idusuario'];

// Eliminar roles del usuario
$abmUsuarioRol = new abmusuariorol();
$abmUsuarioRol->baja($datos);


if (isset($lista)) {
    if ($lista[0]->getIdusuario() == $idUsuario) {
        header('Location: ./index.php?messageErr=' . urlencode("No se puede eliminar a si mismo"));
    } else {
        $exito = $abmUsuario->baja($datos);
        if ($exito) {
           header('Location: ./index.php?messageOk=' . urlencode("Usuario eliminado"));
        } else {
            header('Location: ./index.php?messageErr=' . urlencode("Error en la eliminacion"));
        }
    }
} else {
    header('Location: ./index.php?messageErr=' . urlencode("Usuario no encontrado en la base de datos"));
}

?>
<?php
include_once '../../configuracion.php';
$datos = data_submitted();

// verifica que el usuario esté logueado y tenga permisos
$session = new Sesion();
if (!$session->estaActiva() || !$session->tieneAccesoAMenuActual()) {
    header("Location: ../login");
}

$idUsuario = $_SESSION['idusuario'];
$retorno = ['exito' => "", 'error' => "", 'fecha' => ""];
$abmUsuario = new abmusuario();

$lista = $abmUsuario->buscar($datos);

if (isset($lista[0])) {
    if ($lista[0]->getIdusuario() == $idUsuario) { //Verifico que el usuario a deshabilitar sea diferente al usuario de la sesion actual
        echo json_encode(['status' => "ERROR"]);
    } else {
        $exito = $abmUsuario->deshabilitarUsuario($datos);

        ($exito) ? $retorno['exito'] = "EXITO" : $retorno['error'] = "ERROR";
        $lista = $abmUsuario->buscar($datos);
        $fecha = $lista[0]->getUsdeshabilitado();
        $retorno['fecha'] = $fecha;
        echo json_encode(['status' => "EXITO", 'fecha' => $retorno['fecha']]);
    }
} else {
    echo json_encode(['status' => "ERROR"]);
}

?>
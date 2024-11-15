<?php
include_once '../../configuracion.php';
$datos = data_submitted();

$sesion = new session();
if (!$sesion->activa()) {
    header('Location: ../login/login.php?message=' . urlencode("No ha iniciado sesión"));
    exit;
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
<?php
include_once '../../configuracion.php';

$sesion = new Sesion();
$sesion->cerrar();

header("Location: $PROJECT_PATH/vista");
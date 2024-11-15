<?php
include_once '../configuracion.php';

$usuario = new Usuario();

echo "<h2>Listando usuarios</h2>";
$usuarios = $usuario->listar();
verEstructura($usuarios);
<?php
include_once '../configuracion.php';

$menu = new Menu();

echo "<h2>Listando Menus</h2>";
$menus = $menu->listar();
verEstructura($menus);



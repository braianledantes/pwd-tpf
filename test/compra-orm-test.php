<?php
include_once '../configuracion.php';

$compra = new Compra();
$usuario = new Usuario();

// carga el usuario con id 1
$usuario->setidusuario(1);
$usuario->cargar();

echo "<h2>Listando compras</h2>";
$compras = $compra->listar();
verEstructura($compras);

echo "<h2>Insertando compra 1</h2>";
$compra->setear(1, "2021-06-01", $usuario);
$r1 = $compra->insertar();
verEstructura($r1);
$compras = $compra->listar();
verEstructura($compras);

echo "<h2>Modificando compra 1</h2>";
$compra->setcofecha("2021-06-02 11:22:33");
$r2 = $compra->modificar();
verEstructura($r2);
$compras = $compra->listar();
verEstructura($compras);


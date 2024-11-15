<?php
include_once '../configuracion.php';

$producto = new Producto();

echo "<br>Listando productos<br>";
$productos = $producto->listar();
verEstructura($productos);

echo "<br>Insertando producto 1<br>";
$producto->setear(1, "Producto 1", "detalle producto 1", 1);
$r1 = $producto->insertar();
verEstructura($r1);

echo "<br>Modificando producto 1<br>";
$producto->setprodetalle("detalle producto 1 modificado");
$r2 = $producto->modificar();
verEstructura($r2);

$productos = $producto->listar();
verEstructura($productos);

echo "<br>Eliminando producto 1<br>";
$r3 = $producto->eliminar();
verEstructura($r3);
$productos = $producto->listar();
verEstructura($productos);

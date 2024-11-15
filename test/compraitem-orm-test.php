<?php
include_once '../configuracion.php';

$compraitem = new CompraItem();
$producto = new Producto();
$compra = new Compra();

echo "<h2>Listando compraitems</h2>";
$compraitems = $compraitem->listar();
verEstructura($compraitems);

// echo "<h2>Insertando compraitem 1</h2>";
// $producto->setidproducto(16);
// $producto->cargar();
// $compra->setIdcompra(9);
// $compra->cargar();
// $compraitem->setear(10, $producto, $compra);
// $r1 = $compraitem->insertar();

echo "<h2>Modificando compraitem 1</h2>";
$producto->setidproducto(18);
$compra->setIdcompra(10);
$compraitem->setearConClave(1, 12, $producto, $compra);
$r2 = $compraitem->modificar();
verEstructura($r2);

echo "<h2>Listando compraitems</h2>";
$compraitems = $compraitem->listar();
verEstructura($compraitems);

echo "<h2>Buscando compraitem 1</h2>";
$compraitem->setIdcompraitem(1);
$compraitem->cargar();
verEstructura($compraitem);

echo "<h2>Borrando compraitem 1</h2>";
$compraitem->setIdcompraitem(1);
$r3 = $compraitem->eliminar();

echo "<h2>Listando compraitems</h2>";
$compraitems = $compraitem->listar();
verEstructura($compraitems);

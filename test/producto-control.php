<?php
include_once '../configuracion.php';

$abmProducto = new ABMProducto();

$datos = [
    'accion' => 'nuevo',
    'idproducto' => 0,
    'pronombre' => 'Producto 100',
    'prodetalle' => 'detalle producto 100',
    'procantstock' => 100
];

// $r1 = $abmProducto->abm($datos);
// echo "Alta: " . $r1 . "<br>";

$r2 = $abmProducto->abm([
    'accion' => 'editar',
    'idproducto' => 23,
    'pronombre' => 'Producto 1',
    'prodetalle' => 'detalle producto 1 modificado',
    'procantstock' => 1
]);

echo "Modificacion: " . $r2 . "<br>";

$r3 = $abmProducto->abm([
    'accion' => 'borrar',
    'idproducto' => 23,
    'pronombre' => 'Producto 1',
    'prodetalle' => 'detalle producto 1 modificado',
    'procantstock' => 1
]);

echo "Baja: " . $r3 . "<br>";

$productos = $abmProducto->buscar(null);
verEstructura($productos);


<?php
include_once '../configuracion.php';

$abmCompra = new ABMCompra();

$r1 = $abmCompra->abm([
    'accion' => 'nuevo',
    'idusuario' => 1
]);
echo "Alta: " . $r1 . "<br>";

$r2 = $abmCompra->abm([
    'accion' => 'editar',
    'idcompra' => 15,
    'cofecha' => '2021-06-01',
    'idusuario' => 1
]);
echo "Modificacion: " . $r2 . "<br>";

$r3 = $abmCompra->abm([
    'accion' => 'borrar',
    'idcompra' => 15,
    'cofecha' => '2021-06-01',
    'idusuario' => 1
]);
echo "Baja: " . $r3 . "<br>";

$compras = $abmCompra->buscar([
    'idusuario' => 1,
    'cofecha' => '2024-11-09 08:43:05'
]);
verEstructura($compras);
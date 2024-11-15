<?php
include_once '../configuracion.php';

$abmCompraItem = new ABMCompraItem();

$r1 = $abmCompraItem->abm([
    'accion' => 'nuevo',
    'cicantidad' => 13,
    'idproducto' => 17,
    'idcompra' => 9
]);
echo "Alta: " . $r1 . "<br>";

$lista = $abmCompraItem->buscar(null);
verEstructura($lista);

$r2 = $abmCompraItem->abm([
    'accion' => 'editar',
    'idcompraitem' => 2,
    'cicantidad' => 2,
    'idproducto' => 18,
    'idcompra' => 9
]);
echo "Modificacion: " . $r2 . "<br>";

$r3 = $abmCompraItem->abm([
    'accion' => 'borrar',
    'idcompraitem' => 2,
    'cicantidad' => 2,
    'idproducto' => 18,
    'idcompra' => 9
]);
echo "Baja: " . $r3 . "<br>";
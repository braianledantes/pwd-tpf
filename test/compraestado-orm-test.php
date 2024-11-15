<?php
include_once '../configuracion.php';

$compraestado = new CompraEstado();

echo "<h2>Listando CompraEstado</h2>";
$compraestadoList = $compraestado->listar();
verEstructura($compraestadoList);

// echo "<h2>Insertar CompraEstado</h2>";
// $compra = new Compra();
// $compra->setidcompra(10);
// $compraestadotipo = new CompraEstadoTipo();
// $compraestadotipo->setidcompraestadotipo(2);

// $compraestado->setobjEstadoTipo($compraestadotipo);
// $compraestado->setObjCompra($compra);
// $compraestado->insertar();

echo "<h2>Modificar CompraEstado</h2>";
$compraestado2 = $compraestado->listar()[0];
$compraestado2->setcefechaini(null);
$compraestado2->setcefechafin(null);
$compraestado2->modificar();

echo "<h2>Eliminar CompraEstado</h2>";
$compraestado3 = $compraestado->listar()[0];
$compraestado3->eliminar();

echo "<h2>Listando CompraEstado</h2>";
$compraestadoList = $compraestado->listar();
verEstructura($compraestadoList);


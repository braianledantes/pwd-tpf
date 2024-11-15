<?php
include_once '../configuracion.php';

$abmCompraEstado = new ABMCompraEstado();

// $r1 = $abmCompraEstado->abm([
//     'accion' => 'nuevo',
//     'idcompra' => 9,
//     'idcompraestadotipo' => 1,
//     'cefechaini' => '2021-06-01',
//     'cefechafin' => '2021-06-02'
// ]);

// echo "Alta: " . $r1 . "<br>";

$lista = $abmCompraEstado->buscar(null);
verEstructura($lista);

// actualiza el estado de la compra con id 9

$r2 = $abmCompraEstado->abm([
    'accion' => 'editar',
    'idcompraestado' => 11,
    'idcompra' => 9,
    'idcompraestadotipo' => 3,
    'cefechaini' => '2024-11-01',
    'cefechafin' => '2024-11-30'
]);

// elige el estado de la compra con id 9

$r3 = $abmCompraEstado->abm([
    'accion' => 'borrar',
    'idcompraestado' => 9,
]);

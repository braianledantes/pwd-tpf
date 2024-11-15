<?php
include_once '../configuracion.php';

$compraestadotipo = new CompraEstadoTipo();

echo "<h2>Listando CompraEstadoTipo</h2>";
$compraestadotipos = $compraestadotipo->listar();
verEstructura($compraestadotipos);
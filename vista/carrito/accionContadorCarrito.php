<?php
include_once("../../configuracion.php");
header('Content-Type: application/json');

$session = new Sesion();
if ($session->estaActiva()) {
    $carrito = $session->obtenerCarrito();
    $cantidadCarrito = count($carrito);

    echo json_encode(['totalProductos' => $cantidadCarrito]);
} else {

    echo json_encode(['totalProductos' => 0]);
}
?>

<?php
include_once('accionMailer.php');

// Supongamos que tienes una variable $estadoCompra que contiene el estado de la compra
$estadoCompra = 'Compra exitosa'; // Esto debería ser dinámico según tu lógica
$emailDestino = 'cliente@example.com'; // El email del cliente

// Llama a la función para enviar el correo
enviarMail($estadoCompra, $emailDestino);
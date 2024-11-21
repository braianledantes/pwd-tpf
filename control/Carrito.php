<?php

/**
 * Clase que representa un carrito de compras en la sesión del usuario.	
 */
class Carrito {
    private Sesion $sesion;

    public function __construct()
    {
        $this->sesion = new Sesion();
    }


    /**
     * Agrega un producto al carrito. Si no existe el carrito, lo crea.
     * Si no esta el producto, lo agrega y si ya esta, aumenta la cantidad.
     */
    public function agregarProductoAlCarrito($idproducto, $cantidad = 1)
    {
        if (!$this->sesion->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }
        
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (!isset($_SESSION['carrito'][$idproducto])) {
            $_SESSION['carrito'][$idproducto] = $cantidad;
        } else {
            $_SESSION['carrito'][$idproducto] += $cantidad;
        }

        return $_SESSION['carrito'];
    }

    /**
     * Devuelve el carrito del usuario actual.
     */
    public function obtenerCarrito()
    {
        if (!isset($_SESSION['idusuario'])) {
            throw new Exception('No hay un usuario logueado');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        return $_SESSION['carrito'];
    }

    /**
     * Vacia el carrito del usuario actual.
     */
    public function vaciarCarrito()
    {
        if (!isset($_SESSION['idusuario'])) {
            throw new Exception('No hay un usuario logueado');
        }

        $_SESSION['carrito'] = [];
    }
}
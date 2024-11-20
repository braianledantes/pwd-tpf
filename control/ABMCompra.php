<?php
class ABMCompra
{

    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compra
     */
    private function cargarObjeto($param)
    {
        $objCompra = null;

        if (
            array_key_exists('idcompra', $param)  and array_key_exists('cofecha', $param) and array_key_exists('idusuario', $param)
        ) {
            $objCompra = new Compra();
            $objUsuario = new Usuario();
            $objUsuario->setidusuario($param['idusuario']);
            $objCompra->setear($param['idcompra'], $param['cofecha'], $objUsuario);
        }
        return $objCompra;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Compra
     */

    private function cargarObjetoConClave($param)
    {
        $objCompra = null;

        if (array_key_exists('idcompra', $param)) {
            $objCompra = new Compra();
            $objCompra->setIdcompra($param['idcompra']);
        }
        return $objCompra;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompra']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $carrito = $param['carrito'];

        // si el carrito esta vacio lanza un error
        if (empty($carrito)) {
            throw new Exception('El carrito esta vacio');
        }

        $param['idcompra'] = null;
        $param['cofecha'] = null;
        $compra = $this->cargarObjeto($param);
        if ($compra == null || !$compra->insertar()) {
            throw new Exception('Error al insertar la compra');
        }

        $idCompra = $compra->getIdcompra();

        
        // verifica que los productos del carrito existan y tengan stock suficiente
        $abmProducto = new AbmProducto();
        foreach ($carrito as $idproducto => $cantidad) {
            $producto = $abmProducto->buscar(['idproducto' => $idproducto]);
            if (empty($producto)) {
                $this->baja(['idcompra' => $idCompra]);
                throw new Exception('Producto no encontrado');
            }
            $producto = $producto[0];
            if ($producto->getprocantstock() < $cantidad) {
                $this->baja(['idcompra' => $idCompra]);
                throw new Exception('Stock insuficiente para el producto ' . $producto->getusnombre());
            }
        }
        
        // crea los items de la compra y actualiza el stock de los productos
        $abmCompraItem = new AbmCompraItem();
        foreach ($carrito as $idproducto => $cantidad) {
            $abmCompraItem->alta([
                'idcompra' => $idCompra,
                'idproducto' => $idproducto,
                'cicantidad' => $cantidad
            ]);

            $producto = $abmProducto->buscar(['idproducto' => $idproducto])[0];
            $producto->setprocantstock($producto->getprocantstock() - $cantidad);
            $producto->modificar();
        }

        // crea un estado para la compra (Iniciada)
        $abmCompraEstado = new AbmCompraEstado();
        $dioEstado = $abmCompraEstado->alta([
            'idcompra' => $idCompra,
            'idcompraestadotipo' => 1 // Iniciada
        ]);

        if (!$dioEstado) {
            $this->baja(['idcompra' => $idCompra]);
            throw new Exception('Error al iniciar la compra');
        }
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompra']))
                $where .= " and idcompra =" . $param['idcompra'];
            if (isset($param['cofecha']))
                $where .= " and cofecha ='" . $param['cofecha'] . "'";
            if (isset($param['idusuario']))
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
        }
        $objCompra = new Compra();
        $arreglo = $objCompra->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }
}

<?php
class ABMCompraItem
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
     * @return CompraItem
     */
    private function cargarObjeto($param)
    {
        $objCompraItem = null;
        if (
            array_key_exists('idcompraitem', $param)  
            and array_key_exists('cicantidad', $param) 
            and array_key_exists('idproducto', $param)
            and array_key_exists('idcompra', $param)
        ) {
            $objCompraItem = new CompraItem();
            $objProducto = new Producto();
            $objProducto->setidproducto($param['idproducto']);
            $objCompra = new Compra();
            $objCompra->setIdcompra($param['idcompra']);
            $objCompraItem->setearConClave($param['idcompraitem'], $param['cicantidad'], $objProducto, $objCompra);
        }
        return $objCompraItem;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraItem
     */

    private function cargarObjetoConClave($param)
    {
        $objCompraItem = null;

        if (array_key_exists('idcompraitem', $param)) {
            $objCompraItem = new CompraItem();
            $objCompraItem->setIdcompraitem($param['idcompraitem']);
        }
        return $objCompraItem;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraitem']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $param['idcompraitem'] = null;
        $elObjtTabla = $this->cargarObjeto($param);
        //        verEstructura($elObjtTabla);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
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
            if (isset($param['idcompraitem']))
                $where .= " and idcompraitem =" . $param['idcompraitem'];
            if (isset($param['idcompra']))
                $where .= " and idcompra ='" . $param['idcompra'] . "'";
            if (isset($param['idproducto']))
                $where .= " and idproducto ='" . $param['idproducto'] . "'";
                if (isset($param['cicantidad']))
                $where .= " and cicantidad ='" . $param['cicantidad'] . "'";
        }
        $objCompraItem = new CompraItem();
        $arreglo = $objCompraItem->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }
}

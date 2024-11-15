<?php

class ABMCompraEstado
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
     * @return CompraEstado
     */
    private function cargarObjeto($param)
    {
        $objCompraEstatado = null;

        if (
            array_key_exists('idcompraestado', $param)
            and array_key_exists('idcompra', $param)
            and array_key_exists('idcompraestadotipo', $param)
            and array_key_exists('cefechaini', $param)
            and array_key_exists('cefechafin', $param)
        ) {
            $objCompraEstatado = new CompraEstado();
            $objCompra = new Compra();
            $objCompra->setidcompra($param['idcompra']);
            $objCompraEstadoTipo = new CompraEstadoTipo();
            $objCompraEstadoTipo->setidcompraestadotipo($param['idcompraestadotipo']);

            $objCompraEstatado->setearConClave(
                $param['idcompraestado'],
                $param['cefechaini'],
                $param['cefechafin'],
                $objCompraEstadoTipo,
                $objCompra,
            );
        }
        return $objCompraEstatado;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstado
     */

    private function cargarObjetoConClave($param)
    {
        $objCompraEstatado = null;

        if (array_key_exists('idcompraestado', $param)) {
            $objCompraEstatado = new CompraEstado();
            $objCompraEstatado->setIdcompreestado($param['idcompraestado']);
        }
        return $objCompraEstatado;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idcompraestado']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $param['idcompraestado'] = null;
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
        echo "Estoy en modificacion";
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
            if (isset($param['idcompraestado']))
                $where .= " and idcompraestado =" . $param['idcompraestado'];
            if (isset($param['idcompra']))
                $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
            if (isset($param['idcompraestadotipo']))
                $where .= " and cefechaini =" . $param['cefechaini'];
            if (isset($param['cefechaini']))
                $where .= " and cefechafin =" . $param['cefechafin'];
            if (isset($param['cefechafin']))
                $where .= " and cefechafin =" . $param['cefechafin'];
        }
        $objCompraEstatado = new CompraEstado();
        $arreglo = $objCompraEstatado->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }
}

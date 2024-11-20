<?php

class ABMCompraEstadoTipo
{
    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idcompraestadotipo']))
                $where .= " and idcompraestadotipo =" . $param['idcompraestadotipo'];
            if (isset($param['cetdescripcion']))
                $where .= " and cetdescripcion =" . $param['cetdescripcion'];
            if (isset($param['cetdetalle']))
                $where .= " and cetdetalle =" . $param['cetdetalle'];
        }
        $arreglo = CompraEstadoTipo::listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }
}

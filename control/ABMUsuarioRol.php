<?php
class ABMUsuarioRol
{

    public function buscar($param)
    {
        $where = " true ";

        if ($param != null) {
            if (isset($param['idusuario'])) {
                $where .= " and idusuario ='" . $param['idusuario'] . "'";
            }

            if (isset($param['idrol'])) {
                $where .= " and idrol ='" . $param['idrol'] . "'";
            }
        }

        $rolUsuario = new UsuarioRol();
        $arreglo = $rolUsuario->listar($where);

        return $arreglo;
    }

    public function modificacion($param)
    {
        $resp = false;
        $objUsRol = new UsuarioRol();
        $abmRol = new ABMRol();
        $listaRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $abmUsuario = new ABMUsuario();
        $listaUsuario = $abmUsuario->buscar(['idusuario' => $param['idusuario']]);
        $objUsRol->setear($listaUsuario[0], $listaRol[0]);
        if ($objUsRol->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        $objRel = new UsuarioRol();
        $abmUs = new ABMUsuario();
        $arrayUs = $abmUs->buscar(['idusuario' => $param['idusuario']]);
        $abmRol = new ABMRol();
        $objRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $objRel->setear($arrayUs[0], $objRol[0]);

        if ($objRel->eliminar()) {
            $resp = true;
        }

        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $objUsuarioRol = new UsuarioRol();
        $abmUs = new ABMUsuario();
        $arrayUs = $abmUs->buscar(['idusuario' => $param['idusuario']]);
        $abmRol = new ABMRol();
        $objRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        var_dump($objRol);
        $objUsuarioRol->setear($arrayUs[0], $objRol[0]);

        if ($objUsuarioRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }
}
?>
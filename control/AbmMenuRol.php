<?php
class AbmMenuRol
{

    public function buscar($param)
    {
        $where = " true ";

        if ($param != null) {
            if (isset($param['idmenu'])) {
                $where .= " and idmenu ='" . $param['idmenu'] . "'";
            }

            if (isset($param['idrol'])) {
                $where .= " and idrol ='" . $param['idrol'] . "'";
            }
        }

        $menuRol = new MenuRol();
        $arreglo = $menuRol->listar($where);

        return $arreglo;
    }

    public function modificacion($param)
    {
        $resp = false;
        $objMenuRol = new MenuRol();
        $abmRol = new AbmRol();
        $listaRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $abmMenu = new AbmMenu();
        $listaUsuario = $abmMenu->buscar(['idmenu' => $param['idmenu']]);
        $objMenuRol->setear($listaUsuario[0], $listaRol[0]);
        if ($objMenuRol->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function baja($param)
    {
        $resp = false;
        $objRel = new MenuRol();
        $abmMenu = new AbmMenu();
        $arrayUs = $abmMenu->buscar(['idmenu' => $param['idmenu']]);
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
        $objMenuRol = new MenuRol();
        $abmUs = new AbmMenu();
        $arrayUs = $abmUs->buscar(['idmenu' => $param['idmenu']]);
        $abmRol = new AbmRol();
        $objRol = $abmRol->buscar(['idrol' => $param['idrol']]);
        $objMenuRol->setear($arrayUs[0], $objRol[0]);

        if ($objMenuRol->insertar()) {
            $resp = true;
        }
        return $resp;
    }
}
?>
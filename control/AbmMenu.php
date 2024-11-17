<?php
class AbmMenu
{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Menu
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (array_key_exists('idmenu', $param) and array_key_exists('menombre', $param)) {
            $obj = new Menu();
            $objmenu = null;
            if (isset($param['idpadre'])) {
                $objmenu = new Menu();
                $objmenu->setIdmenu($param['idpadre']);
                $objmenu->cargar();
            }
            if (!isset($param['medeshabilitado'])) {
                $param['medeshabilitado'] = null;
            } else {
                $param['medeshabilitado'] = date("Y-m-d H:i:s");
            }
            $obj->setear($param['idmenu'], $param['menombre'], $param['medescripcion'], $objmenu, $param['medeshabilitado']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Menu
     */
    private function cargarObjetoConClave($param)
    {
        $obj = null;

        if (isset($param['idmenu'])) {
            $obj = new Menu();
            $obj->setIdmenu($param['idmenu']);
        }
        return $obj;
    }


    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idmenu']))
            $resp = true;
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $idRol = $param['idrol'];
        // verifica que el rol exista
        $abmRol = new AbmRol();
        $rol = $abmRol->buscar(['idrol' => $idRol]);
        if (empty($rol)) {
            throw new Exception("El rol no existe");
        }
        // Si no existe el menu padre lo setea en null
        if (isset($param['idpadre'])) {
            $menuPadre = $this->buscar(['idmenu' => $param['idpadre']]);
            if (empty($menuPadre)) {
                throw new Exception('El menu padre no existe');
            }
        } else {
            $param['idpadre'] = null;
        }

        $param['idmenu'] = null; // no se setea el id ya que es autoincremental
        $param['medeshabilitado'] = null; // no se setea la fecha de deshabilitado ya que es null
        $elObjtTabla = $this->cargarObjeto($param);
        // Si no existe lo inserta
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            // crea la relacion entre el rol y el menu
            $abmMenuRol = new AbmMenuRol();
            $abmMenuRol->alta(['idrol' => $idRol, 'idmenu' => $elObjtTabla->getIdmenu()]);
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
        // borra los roles asociados al menu
        $abmMenuRol = new AbmMenuRol();
        $listaMenuRoles = $abmMenuRol->buscar(['idmenu' => $param['idmenu']]);
        foreach ($listaMenuRoles as $menuRol) {
            $abmMenuRol->baja([
                'idrol' => $menuRol->getobjRol()->getIdrol(),
                'idmenu' => $param['idmenu']
            ]);
        }
        // borra el menu
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null) {
                $resp = $elObjtTabla->eliminar();
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
        $resp = false;
        // verifica que el rol exista
        $abmRol = new AbmRol();
        $rol = $abmRol->buscar(['idrol' => $param['idrol']]);
        if (empty($rol)) {
            throw new Exception("El rol no existe");
        }
        // verifica que el menu padre exista sino lo setea en null
        if (isset($param['idpadre'])) {
            $menuPadre = $this->buscar(['idmenu' => $param['idpadre']]);
            if (empty($menuPadre)) {
                throw new Exception('El menu padre no existe');
            }
        } else {
            $param['idpadre'] = null;
        }

        // modifica el menu
        if ($this->seteadosCamposClaves($param)) {
            $elObjtMenu = $this->cargarObjeto($param);
            if ($elObjtMenu != null) {
                // modifica el menu
                $elObjtMenu->modificar();
                // borra las relaciones anteriores del menu con el rol
                $abmMenuRol = new AbmMenuRol();
                $listamenusroles = $abmMenuRol->buscar(['idmenu' => $elObjtMenu->getIdmenu()]);
                foreach ($listamenusroles as $menurol) {
                    $abmMenuRol->baja([
                        'idrol' => $menurol->getobjRol()->getIdrol(),
                        'idmenu' => $elObjtMenu->getIdmenu()
                    ]);
                }
                // crea la nueva relacion
                $abmMenuRol->alta(['idrol' => $param['idrol'], 'idmenu' => $elObjtMenu->getIdmenu()]);
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idmenu']))
                $where .= " and idmenu =" . $param['idmenu'];
            if (isset($param['medescripcion']))
                $where .= " and medescripcion ='" . $param['medescripcion'] . "'";
        }
        $arreglo = Menu::listar($where);
        return $arreglo;
    }
}
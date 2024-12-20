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

        $ubicacion = $param['medescripcion'];

        $idRoles = []; // arreglo con los id de los roles
        $abmRol = new AbmRol();

        // verifica que existan todos los roles
        if (isset($param['roles']) && is_array($param['roles'])) {
            $rolesParam = $param['roles'];
            foreach ($rolesParam as $idRol) {
                $rol = $abmRol->buscar(['idrol' => $idRol]);
                if (empty($rol)) {
                    throw new Exception("El rol no existe");
                }
                $idRoles[] = $idRol;
            }
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
        $menu = $this->cargarObjeto($param);
        // Si no existe lo inserta
        if ($menu != null and $menu->insertar()) {
            // crea las relaciones entre el menu y los roles
            $this->insertarRelaciones($menu->getIdmenu(), $idRoles);

            $this->crearCarpetaDeMenu($ubicacion);
            $resp = true;
        }
        return $resp;
    }

    /**
     * Crea la carpeta con un archivo index.php en base a plantilla.php, dentro de la carpeta "vista"
     */
    private function crearCarpetaDeMenu($ubicacion)
    {
        $carpeta = "../../vista/" . $ubicacion;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
            $plantilla = file_get_contents("./plantilla.php");
            file_put_contents($carpeta . "/index.php", $plantilla);
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
        // borra los roles asociados al menu
        $this->borrarRelaciones($param['idmenu']);
        // borra el menu
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null) {
                $resp = $elObjtTabla->eliminar();
            }
        }

        return $resp;
    }

    private function insertarRelaciones($idmenu, $idRoles)
    {
        $abmMenuRol = new AbmMenuRol();
        foreach ($idRoles as $idRol) {
            $abmMenuRol->alta(['idrol' => $idRol, 'idmenu' => $idmenu]);
        }
    }

    private function borrarRelaciones($idmenu)
    {
        $abmMenuRol = new AbmMenuRol();
        $listaMenuRoles = $abmMenuRol->buscar(['idmenu' => $idmenu]);
        foreach ($listaMenuRoles as $menuRol) {
            $abmMenuRol->baja([
                'idrol' => $menuRol->getobjRol()->getIdrol(),
                'idmenu' => $idmenu
            ]);
        }
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        $resp = false;

        $ubicacion = $param['medescripcion'];

        $idRoles = []; // arreglo con los id de los roles
        $abmRol = new AbmRol();

        // verifica que existan todos los roles
        if (isset($param['roles']) && is_array($param['roles'])) {
            $rolesParam = $param['roles'];
            foreach ($rolesParam as $idRol) {
                $rol = $abmRol->buscar(['idrol' => $idRol]);
                if (empty($rol)) {
                    throw new Exception("El rol no existe");
                }
                $idRoles[] = $idRol;
            }
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

        // modifica el menu
        if ($this->seteadosCamposClaves($param)) {
            $menu = $this->cargarObjeto($param);
            if ($menu != null) {
                // modifica el menu
                $menu->modificar();
                // borra las relaciones anteriores del menu con los roles
                $this->borrarRelaciones($menu->getIdmenu());
                // crea las relaciones entre el menu y los roles
                $this->insertarRelaciones($menu->getIdmenu(), $idRoles);

                $this->crearCarpetaDeMenu($ubicacion);
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

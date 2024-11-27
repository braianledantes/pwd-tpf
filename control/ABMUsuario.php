<?php
class ABMUsuario
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
        if ($datos['accion'] == 'borrar_rol') {
            if ($this->borrar_rol($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo_rol') {
            if ($this->alta_rol($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param)
    {
        $objUs = null;
        if (array_key_exists('usnombre', $param) && array_key_exists('usmail', $param) && array_key_exists('uspass', $param) ) {
            $objUs = new usuario();
            $objUs->setear(
                '',
                $param['usnombre'],
                $param['uspass'],
                $param['usmail'],
                ''
            );
        }
        return $objUs;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Usuario
     */

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idusuario'])) {
            $obj = new Usuario();
            $obj->setear($param['idusuario'], null, null, null, null);
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
        if (isset($param['idusuario']))
            $resp = true;
        return $resp;
    }

    /**
     * @throws Exception si no se pudo insertar el usuario
     * @throws Exception si faltan datos obligatorios
     * @throws Exception si el usuario ya existe
     * @param array $param con los datos del usuario (usnombre, usmail, uspass, roles)
     */
    public function alta($param)
    {
        if (!isset($param['usnombre']) || !isset($param['usmail']) || !isset($param['uspass'])) {
            throw new Exception('Faltan datos obligatorios');
        }

        // si no se seleccionaron roles, se asigna el rol de cliente por defecto (2)
        if (!isset($param['roles']) || !is_array($param['roles']) || count($param['roles']) == 0) {
            $param['roles'] = [2];
        }

        // verifica que el usuario no exista por nombre
        $listaUsuarios = $this->buscar(['usnombre' => $param['usnombre']]);
        if (count($listaUsuarios) > 0) {
            throw new Exception('El usuario ya existe');
        }
        // verifica que el usuario no exista por mail
        $listaUsuarios = $this->buscar(['usmail' => $param['usmail']]);
        if (count($listaUsuarios) > 0) {
            throw new Exception('El usuario ya existe');
        }
        
        // hasheo de contraseña
        $passHasheada = hashearContrasenia($param['uspass']);
        $param['uspass'] = $passHasheada;

        $objUsuario = $this->cargarObjeto($param);

        if (!$objUsuario->insertar()) {
            throw new Exception('Error al insertar el usuario');
        }

        // asigna los roles al usuario
        foreach ($param['roles'] as $rol) {
            $this->alta_rol(['idusuario' => $objUsuario->getIdusuario(), 'idrol' => $rol]);
        }
    }

    public function borrar_rol($param)
    {
        $resp = false;
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $elObjtTabla->setearConClave($param['idusuario'], $param['idrol']);
            $resp = $elObjtTabla->eliminar();
        }

        return $resp;
    }

    /**
     * Permite agregar un rol a un usuario
     * @throws Exception si no se pudo insertar el rol
     */
    public function alta_rol($param)
    {
        if (isset($param['idusuario']) && isset($param['idrol'])) {
            $elObjtTabla = new UsuarioRol();
            $elObjtTabla->setearConClave($param['idusuario'], $param['idrol']);
            if (!$elObjtTabla->insertar()) {
                throw new Exception('Error al insertar el rol');
            }
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
        // hasheo de contraseña
        $passHasheada = hashearContrasenia($param['uspass']);
        $param['uspass'] = $passHasheada;

        $resp = false;
        $objUs = new usuario();
        $objUs->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        if ($objUs->modificar()) {
            $resp = true;
        }
        return $resp;
    }

    public function darRoles($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }
        $obj = new UsuarioRol();
        $arreglo = $obj->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
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
            if (isset($param['idusuario']))
                $where .= " and idusuario =" . $param['idusuario'];
            if (isset($param['usnombre']))
                $where .= " and usnombre ='" . $param['usnombre'] . "'";
            if (isset($param['usmail']))
                $where .= " and usmail ='" . $param['usmail'] . "'";
            if (isset($param['uspass']))
                $where .= " and uspass ='" . $param['uspass'] . "'";
            if (isset($param['usdeshabilitado']))
                $where .= " and usdeshabilitado ='" . $param['usdeshabilitado'] . "'";
        }
        $usuario = new Usuario();
        $arreglo = $usuario->listar($where);
        return $arreglo;
    }

    public function deshabilitarUsuario($param)
    {
        $resp = false;
        $objUsuario = $this->cargarObjetoConClave($param);
        $listadoProductos = $objUsuario->listar("idusuario=" . $param['idusuario']);
        if (count($listadoProductos) > 0) {
            $estadoUsuario = $listadoProductos[0]->getUsdeshabilitado();
            if ($estadoUsuario == '0000-00-00 00:00:00') {
                if ($objUsuario->estado(date("Y-m-d H:i:s"))) {
                    $resp = true;
                }
            } else {
                if ($objUsuario->estado()) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }

    public function habilitarUsuario($param) {
        $resp = false;
        $objUsuario = $this->cargarObjetoConClave($param);
        $listadoProductos = $objUsuario->listar("idusuario=" . $param['idusuario']);
        if (count($listadoProductos) > 0) {
            $estadoUsuario = $listadoProductos[0]->getUsdeshabilitado();
            if ($estadoUsuario != '0000-00-00 00:00:00') {
                if ($objUsuario->estado('0000-00-00 00:00:00')) {
                    $resp = true;
                }
            }
        }
        return $resp;
    }
    
}
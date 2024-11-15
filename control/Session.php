<?php
class Session
{

    // Constructor
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados.
     */
    public function iniciar($nombreUsuario, $psw)
    {
        $resp = false;
        $obj = new ABMUsuario();
        $param['usnombre'] = $nombreUsuario;
        $param['uspass'] = $psw;
        // obtiene un usuario que no este deshabilitado
        // esta deshabilitado si usdeshabilitado es distinto de '0000-00-00 00:00:00'
        $param['usdeshabilitado'] = '0000-00-00 00:00:00';

        $resultado = $obj->buscar($param);
        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            $_SESSION['idusuario'] = $usuario->getidusuario();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }

    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar()
    {
        $resp = false;
        if ($this->activa() && isset($_SESSION['idusuario']))
            $resp = true;
        return $resp;
    }

    /**
     *Devuelve true o false si la sesión está activa o no.
     */
    public function activa()
    {
        $activa = false;
        if (isset($_SESSION['idusuario'])) {
            $activa = true;
        }
        return $activa;
    }

    /**
     * Devuelve el usuario logeado.
     */
    public function getUsuario()
    {
        $usuario = null;
        if ($this->validar()) {
            $obj = new ABMUsuario();
            $param['idusuario'] = $_SESSION['idusuario'];
            $resultado = $obj->buscar($param);
            if (count($resultado) > 0) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }

    /**
     * Obtiene los roles del usuario logeado.
     */
    public function getRoles() {
        $roles = array();
        if ($this->validar()) {
            $abmUsuarioRol = new ABMUsuarioRol();
            $rolesUsuario = $abmUsuarioRol->buscar(['idusuario' => $_SESSION['idusuario']]);
            $roles = array_map(function ($rol) {
                return $rol->getobjrol();
            }, $rolesUsuario);
        }
        return $roles;
    }

    /**
     * Verifica que el usuario tenga el rol de administrador.
     */
    public function esAdministrador()
    {
        $esAdmin = false;
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            $rolDescription = strtolower($rol->getrodescripcion());
            if ($rolDescription == 'administrador') {
                $esAdmin = true;
                break;
            }
        }
        return $esAdmin;
    }

    /**
     * Verifica que el usuario tenga el rol de cliente.
     */
    public function esCliente()
    {
        $esCliente = false;
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            if ($rol->getrodescripcion() == 'cliente') {
                $esCliente = true;
                break;
            }
        }
        return $esCliente;
    }

    /**
     * Verifica que el usuario tenga el rol de deposito.
     */
    public function esDeposito()
    {
        $esCliente = false;
        $roles = $this->getRoles();
        foreach ($roles as $rol) {
            if ($rol->getrodescripcion() == 'deposito') {
                $esCliente = true;
                break;
            }
        }
        return $esCliente;
    }

    /**
     *Cierra la sesión actual.
     */
    public function cerrar()
    {
        $resp = true;
        session_destroy();
        //$_SESSION['idusuario']=null;
        return $resp;
    }
}

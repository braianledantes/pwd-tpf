<?php
class Sesion
{
    public function __construct()
    {
        // Inicia la sesión si no está iniciada con un tiempo de vida de 24 horas.
        if (session_status() == PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 86400,
            ]);
        }
    }

    /**
     * Inicia la sesión con el usuario y contraseña ingresados.
     */
    public function iniciarSesion($data)
    {
        $resp = false;
        $obj = new ABMUsuario();
        $psw = $data['uspass'];
        $param['usnombre'] = $data['usnombre'];
        // obtiene un usuario que no este deshabilitado
        // esta deshabilitado si usdeshabilitado es distinto de '0000-00-00 00:00:00'
        $param['usdeshabilitado'] = '0000-00-00 00:00:00';

        $resultado = $obj->buscar($param);
        // verifica que el usuario exista
        if (count($resultado) > 0) {
            $usuario = $resultado[0];
            // verifica que la contraseña sea correcta
            if ($usuario && verificarContrasenia($psw, $usuario->getuspass())) {
                // guarda el id del usuario en la sesión
                $_SESSION['idusuario'] = $usuario->getidusuario();
            }
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }

    /**
     * Verifica si el usuario tiene acceso al menú actual.
     */
    public function tieneAccesoAMenuActual(): bool
    {
        $tieneAcceso = false;
        $idusuario = $_SESSION['idusuario'];
        // obtiene el menu actual
        $INICIO = strtolower($GLOBALS['INICIO']);
        $uri = strtolower($_SERVER['REQUEST_URI']);
        $menuActual = str_replace($INICIO, '', $uri);

        // obtiene el los roles del usuario
        $abmUsuarioRol = new ABMUsuarioRol();
        $rolesUsuario = $abmUsuarioRol->buscar(['idusuario' => $idusuario]);

        foreach ($rolesUsuario as $rolUsuario) {
            $rol = $rolUsuario->getobjrol();

            $abmMenuRol = new ABMMenuRol();
            $menus = $abmMenuRol->buscar(['idrol' => $rol->getidrol()]);
            // verifica si existe algun menu que empiece con $menuActual
            foreach ($menus as $menu) {
                $menuDescription = strtolower($menu->getobjMenu()->getMedescripcion());
                if (strpos($menuActual, $menuDescription) === 0) {
                    $tieneAcceso = true;
                    break;
                }
            }
        }

        return $tieneAcceso;
    }

    /**
     * Obtiene los roles del usuario logeado.
     */
    private function tieneRol($descripcion)
    {
        $tieneElRol = false;
        $roles = array();
        // obtiene todos los roles del usuario
        if (isset($_SESSION['idusuario'])) {
            $abmUsuarioRol = new ABMUsuarioRol();
            $rolesUsuario = $abmUsuarioRol->buscar(['idusuario' => $_SESSION['idusuario']]);
            $roles = array_map(function ($rol) {
                return $rol->getobjrol();
            }, $rolesUsuario);
        }
        // verifica si el usuario tiene el rol de administrador
        foreach ($roles as $rol) {
            $rolDescription = strtolower($rol->getrodescripcion());
            if ($rolDescription == $descripcion) {
                $tieneElRol = true;
                break;
            }
        }
        return $tieneElRol;
    }

    /**
     * Verifica que el usuario tenga el rol de administrador.
     */
    public function esAdministrador()
    {
        return $this->tieneRol('administrador');
    }

    /**
     * Verifica que el usuario tenga el rol de cliente.
     */
    public function esCliente()
    {
        return $this->tieneRol('cliente');
    }

    /**
     * Verifica que el usuario tenga el rol de deposito.
     */
    public function esDeposito()
    {
        return $this->tieneRol('deposito');
    }

    /**
     * Verifica si hay un usuario con la sesión activa.
     */
    public function estaActiva()
    {
        return isset($_SESSION['idusuario']);
    }

    /**
     * Cierra la sesión actual.
     */
    public function cerrar()
    {
        session_destroy();
    }
}

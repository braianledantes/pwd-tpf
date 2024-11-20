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
        if ($this->estaActiva()) {
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
     * Obtiene todos los menus del usuario logeado segun los roles que tenga.
     * Hay que tener en cuenta que un usuario puede tener varios roles y un rol puede tener varios menus.
     */
    public function obtenerMenusDelUsuario()
    {
        $menus = array();
        if ($this->estaActiva()) {
            $idusuario = $_SESSION['idusuario'];
            // obtiene el los roles del usuario
            $abmUsuarioRol = new ABMUsuarioRol();
            $rolesUsuario = $abmUsuarioRol->buscar(['idusuario' => $idusuario]);

            foreach ($rolesUsuario as $rolUsuario) {
                $rol = $rolUsuario->getobjrol();

                $abmMenuRol = new ABMMenuRol();
                $menusRol = $abmMenuRol->buscar(['idrol' => $rol->getidrol()]);
                // obtiene los menus del rol
                foreach ($menusRol as $menuRol) {
                    $menu = $menuRol->getobjMenu();
                    $idMenu = $menu->getidmenu();
                    $menus[$idMenu] = $menu;
                }
            }
        }

        return $menus;
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
     * Consigue a un usuario de la bd
     * @return $datosUsuario
     */
    public function getUsuario(): Usuario | null
    {
        $abmUsuario = new abmusuario();
        $where = ['idusuario' => $_SESSION['idusuario']];
        $listaUsuarios = $abmUsuario->buscar($where);

        if ($listaUsuarios >= 1) {
            $datosUsuario = $listaUsuarios[0];
        }

        return $datosUsuario;
    }

    /**
     * Agrega un producto al carrito. Si no existe el carrito, lo crea.
     * Si no esta el producto, lo agrega y si ya esta, aumenta la cantidad.
     */
    public function agregarProductoAlCarrito($idproducto, $cantidad = 1)
    {
        if (!$this->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (!isset($_SESSION['carrito'][$idproducto])) {
            $_SESSION['carrito'][$idproducto] = $cantidad;
        } else {
            $_SESSION['carrito'][$idproducto] += $cantidad;
        }

        return $_SESSION['carrito'];
    }

    /**
     * Disminuye la cantidad de un producto en el carrito.
     */
    public function disminuirCantidadDelProducto($idproducto)
    {
        if (!$this->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$idproducto])) {
            $_SESSION['carrito'][$idproducto] -= 1;
            if ($_SESSION['carrito'][$idproducto] <= 0) {
                unset($_SESSION['carrito'][$idproducto]);
            }
        }

        return $_SESSION['carrito'];
    }

    /**
     * Elimina un producto del carrito.
     */
    public function eliminarProductoDelCarrito($idproducto)
    {
        if (!$this->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$idproducto])) {
            unset($_SESSION['carrito'][$idproducto]);
        }

        return $_SESSION['carrito'];
    }

    /**
     * Devuelve el carrito del usuario actual.
     */
    public function obtenerCarrito()
    {
        if (!$this->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        return $_SESSION['carrito'];
    }

    /**
     * Vacia el carrito del usuario actual.
     */
    public function vaciarCarrito()
    {
        if (!$this->estaActiva()) {
            throw new Exception('No hay un usuario logueado');
        }

        $_SESSION['carrito'] = [];
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

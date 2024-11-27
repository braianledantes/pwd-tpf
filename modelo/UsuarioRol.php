<?php
class UsuarioRol
{
    private $objusuario;
    private $objrol;


    private $mensajeoperacion;


    public function __construct()
    {
        $this->objusuario = new Usuario();
        $this->objrol = new Rol();
    }
    public function setear($objusuario, $objrol)
    {
        $this->setobjusuario($objusuario);
        $this->setobjrol($objrol);
    }

    public function setearConClave($idusuario, $idjrol)
    {
        $this->getobjrol()->setidrol($idjrol);
        $this->getobjusuario()->setidusuario($idusuario);
    }

    public function getobjusuario()
    {
        return $this->objusuario;
    }
    public function setobjusuario($objusuario)
    {
        $this->objusuario = $objusuario;
    }
    public function getobjrol()
    {
        return $this->objrol;
    }
    public function setobjrol($objrol)
    {
        $this->objrol = $objrol;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    /**
     * Carga los datos de una relacion entre usuario y rol desde la bd ,usando el idusuario y idrol
     */
    public function cargar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "SELECT * FROM usuariorol WHERE idrol = " . $this->getobjrol()->getidrol() . " AND idusuario = " . $this->getobjusuario()->getidusuario() . ";";
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();

                    $obj1 = new Usuario();
                    $obj1->setidusuario($row['idusuario']);
                    $obj1->cargar();
                    $obj2 = new Rol();
                    $obj2->setidrol($row['idrol']);
                    $obj2->cargar();
                    $this->setear($obj1, $obj2);
                }
            }
        } else {
            $this->setmensajeoperacion("usuariorol->listar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Inserta una nueva relacion entre usuario y rol en la bd.
     */
    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO usuariorol(idrol,idusuario)  VALUES(" . $this->getobjrol()->getidrol() . "," . $this->getobjusuario()->getidusuario() . ");";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuariorol->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("usuariorol->insertar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Modifica una relacion entre usuario y rol existente en la bd.
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idUsuario = $this->getObjUsuario()->getIdusuario();
        $idRol = $this->getObjRol()->getIdrol();
        $sql = " UPDATE usuariorol SET ";
        $sql .= " idrol = " . $idRol;
        $sql .= " WHERE idusuario =" . $idUsuario;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsRolacion->modificar 1: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("UsRolacion->modificar 2: " . $base->getError());
        }

        return $resp;
    }

    /**
     * Elimina una relacion entre usuario y rol en la bd.
     */
    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idrol=" . $this->getobjrol()->getidrol() . " AND idusuario =" . $this->getobjusuario()->getidusuario() . ";";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuariorol->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("usuariorol->eliminar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Elimina todas las relaciones de usuario.
     */
    public function eliminarRolesDeUsuario($idusuario)
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM usuariorol WHERE idusuario= $idusuario";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuariorol->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("usuariorol->eliminar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Lista todos los roles de usuario segun el parametro ingresado.
     */
    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new UsuarioRol();

                        $obj->getobjusuario()->setidusuario($row['idusuario']);
                        $obj->getobjrol()->setidrol($row['idrol']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("usuariorol->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}
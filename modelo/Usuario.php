<?php

class Usuario
{
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;

    private $mensajeoperacion;


    public function __construct()
    {
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
        $this->mensajeoperacion = "";
    }
    public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado)
    {
        $this->setidusuario($idusuario);
        $this->setusnombre($usnombre);
        $this->setuspass($uspass);
        $this->setusmail($usmail);
        $this->setusdeshabilitado($usdeshabilitado);
    }

    public function getidusuario()
    {
        return $this->idusuario;
    }
    public function setidusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }
    public function getusnombre()
    {
        return $this->usnombre;
    }
    public function setusnombre($usnombre)
    {
        $this->usnombre = $usnombre;
    }
    public function getuspass()
    {
        return $this->uspass;
    }
    public function setuspass($uspass)
    {
        $this->uspass = $uspass;
    }
    public function getusmail()
    {
        return $this->usmail;
    }
    public function setusmail($usmail)
    {
        $this->usmail = $usmail;
    }
    public function getusdeshabilitado()
    {
        return $this->usdeshabilitado;
    }
    public function setusdeshabilitado($usdeshabilitado)
    {
        $this->usdeshabilitado = $usdeshabilitado;
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
     * Carga los datos de un usuario desde la bd, usando el idusuario.
    */    
    public function cargar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getidusuario();
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                }
            }
        } else {
            $this->setmensajeoperacion("usuarios->listar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Inserta un usuario en la bd.
     */
    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO usuario(usnombre,uspass,usmail,usdeshabilitado)  VALUES('" . $this->getusnombre() . "','" . $this->getuspass() . "','" . $this->getusmail() . "','0000-00-00 00:00:00');";
        if ($db->Iniciar()) {
            if ($elid = $db->Ejecutar($sql)) {
                $this->setidusuario($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("usuarios->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("usuarios->insertar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Modifica un usuario existente en la bd.
     */
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usnombre= '" . $this->getUsnombre() . "', uspass= '" . $this->getUspass() . "', usmail= '" . $this->getUsmail() . "', usdeshabilitado= '" . $this->getUsdeshabilitado() . "' WHERE idusuario=" . $this->getIdusuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Elimina un usuario de la bd.
     */
    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM usuario WHERE idusuario=" . $this->getidusuario();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("usuarios->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("usuarios->eliminar: " . $db->getError());
        }
        return $resp;
    }

    /**
     * Lista todos los usuarios que coinciden con el parametro ingresado.
     */
    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {   
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new Usuario();
                        $obj->setidusuario($row['idusuario']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("usuarios->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }

    /**
     * Modifica el estado de deshabilitacion de un usuario en la bd, se usa para habilitar o deshabilitar a un usuario
     */
    public function estado($param = "")
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "UPDATE usuario SET usdeshabilitado='" . $param . "' WHERE idusuario=" . $this->getIdusuario();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Usuario->estado: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Usuario->estado: " . $base->getError());
        }
        return $resp;
    }

    /**
     * Convierte un obj usuario en un array asociativo
     */
    public function toArray()
    {
        return array(
            'idusuario' => $this->getidusuario(),
            'usnombre' => $this->getusnombre(),
            'uspass' => $this->getuspass(),
            'usmail' => $this->getusmail(),
            'usdeshabilitado' => $this->getusdeshabilitado()
        );
    }
}
<?php
class Rol
{
    private $idrol;
    private $rodescripcion;


    private $mensajeoperacion;


    public function __construct()
    {
        $this->idrol = "";
        $this->rodescripcion = "";
    }
    public function setear($idrol, $rodescripcion)
    {
        $this->setidrol($idrol);
        $this->setrodescripcion($rodescripcion);
    }

    public function getidrol()
    {
        return $this->idrol;
    }
    public function setidrol($idrol)
    {
        $this->idrol = $idrol;
    }
    public function getrodescripcion()
    {
        return $this->rodescripcion;
    }
    public function setrodescripcion($rodescripcion)
    {
        $this->rodescripcion = $rodescripcion;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function cargar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getidrol();
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);
                }
            }
        } else {
            $this->setmensajeoperacion("rol->listar: " . $db->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO rol(rodescripcion)  VALUES('" . $this->getrodescripcion() . "');";
        if ($db->Iniciar()) {
            if ($elid = $db->Ejecutar($sql)) {
                $this->setidrol($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("rol->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->insertar: " . $db->getError());
        }
        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "UPDATE rol SET rodescripcion='" . $this->getrodescripcion() . "' " .
            " WHERE idrol=" . $this->getidrol();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("rol->modificar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->modificar: " . $db->getError());
        }
        return $resp;
    }



    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getidrol();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql) > 0) {
                $resp =  true;
            } else {

                $this->setmensajeoperacion("rol->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("rol->eliminar: " . $db->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new Rol();
                        //print_r($row);
                        $obj->setidrol($row['idrol']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("rol->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}

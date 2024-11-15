<?php

class Producto
{
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;

    private $mensajeoperacion;


    public function __construct()
    {
        $this->idproducto = "";
        $this->pronombre = "";
        $this->prodetalle = "";
        $this->procantstock = "";
        $this->mensajeoperacion = "";
    }
    public function setear($idproducto, $pronombre, $prodetalle, $procantstock)
    {
        $this->setidproducto($idproducto);
        $this->setusnombre($pronombre);
        $this->setprodetalle($prodetalle);
        $this->setprocantstock($procantstock);
    }

    public function getidproducto()
    {
        return $this->idproducto;
    }
    public function setidproducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }
    public function getusnombre()
    {
        return $this->pronombre;
    }
    public function setusnombre($pronombre)
    {
        $this->pronombre = $pronombre;
    }
    public function getprodetalle()
    {
        return $this->prodetalle;
    }
    public function setprodetalle($prodetalle)
    {
        $this->prodetalle = $prodetalle;
    }
    public function getprocantstock()
    {
        return $this->procantstock;
    }
    public function setprocantstock($procantstock)
    {
        $this->procantstock = $procantstock;
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
        $sql = "SELECT * FROM producto WHERE idproducto = " . $this->getidproducto();
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();
                    $this->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                }
            }
        } else {
            $this->setmensajeoperacion("producto->listar: " . $db->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO producto(pronombre,prodetalle,procantstock)  VALUES('" . $this->getusnombre() . "','" . $this->getprodetalle() . "','" . $this->getprocantstock() . "');";
        if ($db->Iniciar()) {
            if ($elid = $db->Ejecutar($sql)) {
                $this->setidproducto($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $db->getError());
        }
        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "UPDATE producto SET pronombre='" . $this->getusnombre() . "' ,prodetalle='" . $this->getprodetalle() . "',procantstock='" . $this->getprocantstock() . "'"
           . " WHERE idproducto=" . $this->getidproducto();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("producto->modificar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->modificar: " . $db->getError());
        }
        return $resp;
    }
    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM producto WHERE idproducto=" . $this->getidproducto();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("producto->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("producto->eliminar: " . $db->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM producto ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {   
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new Producto();
                        $obj->setidproducto($row['idproducto']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("producto->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}

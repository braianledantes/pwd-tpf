<?php

class CompraEstadoTipo
{
    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;

    private $mensajeoperacion;


    public function __construct()
    {
        $this->idcompraestadotipo = "";
        $this->cetdescripcion = "";
        $this->cetdetalle = "";

        $this->mensajeoperacion = "";
    }
    public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle)
    {
        $this->setidcompraestadotipo($idcompraestadotipo);
        $this->setCetDescripcion($cetdescripcion);
        $this->setCetDetalle($cetdetalle);
    }

    public function getidcompraestadotipo()
    {
        return $this->idcompraestadotipo;
    }
    public function setidcompraestadotipo($idcompraestadotipo)
    {
        $this->idcompraestadotipo = $idcompraestadotipo;
    }
    public function getCetDescripcion()
    {
        return $this->cetdescripcion;
    }
    public function setCetDescripcion($cetdescripcion)
    {
        $this->cetdescripcion = $cetdescripcion;
    }
    public function getCetDetalle()
    {
        return $this->cetdetalle;
    }
    public function setCetDetalle($cetdetalle)
    {
        $this->cetdetalle = $cetdetalle;
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
        $sql = "SELECT * FROM compraestadotipo WHERE idcompraestadotipo = " . $this->getidcompraestadotipo();
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                }
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->listar: " . $db->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO compraestadotipo(cetdescripcion,cetdetalle)  VALUES('" . $this->getCetDescripcion() . "','" . $this->getCetDetalle() . "');";
        if ($db->Iniciar()) {
            if ($elid = $db->Ejecutar($sql)) {
                $this->setidcompraestadotipo($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->insertar: " . $db->getError());
        }
        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "UPDATE compraestadotipo SET cetdescripcion='" . $this->getCetDescripcion() . "' ,cetdetalle='" . $this->getCetDetalle() . "'"
           . " WHERE idcompraestadotipo=" . $this->getidcompraestadotipo();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->modificar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->modificar: " . $db->getError());
        }
        return $resp;
    }
    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM compraestadotipo WHERE idcompraestadotipo=" . $this->getidcompraestadotipo();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->eliminar: " . $db->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {   
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new CompraEstadoTipo();
                        $obj->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("compraestadotipo->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}

<?php
class CompraEstado
{
    private $idcompraestado;
    private $cefechaini;
    private $cefechafin;
    private $objEstadoTipo;
    private $objCompra;

    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompraestado = "";
        $this->cefechaini = null;
        $this->cefechafin = null;
        $this->objEstadoTipo = new CompraEstadoTipo();
    }

    public function getidcompraestado()
    {
        return $this->idcompraestado;
    }
    public function setIdcompreestado($idcompraestado)
    {
        $this->idcompraestado = $idcompraestado;
    }
    public function getobjEstadoTipo()
    {
        return $this->objEstadoTipo;
    }
    public function setobjEstadoTipo($objEstadoTipo)
    {
        $this->objEstadoTipo = $objEstadoTipo;
    }
    public function getObjCompra()
    {
        return $this->objCompra;
    }
    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }
    public function getcefechaini()
    {
        return $this->cefechaini;
    }
    public function setcefechaini($cefechaini)
    {
        $this->cefechaini = $cefechaini;
    }
    public function getcefechafin()
    {
        return $this->cefechafin;
    }
    public function setcefechafin($cefechafin)
    {
        $this->cefechafin = $cefechafin;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function setear($cefechaini, $cefechafin, $objEstadoTipo, $objCompra)
    {
        $this->setcefechaini($cefechaini);
        $this->setcefechafin($cefechafin);
        $this->setobjEstadoTipo($objEstadoTipo);
        $this->setObjCompra($objCompra);
    }

    public function setearConClave($idcompraestado, $cefechaini, $cefechafin, $objEstadoTipo, $objCompra)
    {
        $this->setIdcompreestado($idcompraestado);
        $this->setcefechaini($cefechaini);
        $this->setcefechafin($cefechafin);
        $this->setobjEstadoTipo($objEstadoTipo);
        $this->setObjCompra($objCompra);
    }

    public function cargar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "SELECT * FROM compraestado WHERE idcompraestado = " . $this->getidcompraestado() . ";";
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();

                    $objEstadoTipo = new CompraEstadoTipo();
                    $objEstadoTipo->setidcompraestadotipo($row['idcompraestadotipo']);
                    $objEstadoTipo->cargar();
                    $objCompra = new Compra();
                    $objCompra->setIdcompra($row['idcompra']);
                    $objCompra->cargar();

                    $this->setear($row['cefechaini'], $row['cefechafin'], $objEstadoTipo, $objCompra);
                }
            }
        } else {
            $this->setmensajeoperacion("compraestado->listar: " . $db->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO compraestado(idcompra,idcompraestadotipo) VALUES("
            . $this->getObjCompra()->getidcompra() . ","
            . $this->getobjEstadoTipo()->getidcompraestadotipo() . ");";

        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestado->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->insertar: " . $db->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "UPDATE compraestado SET cefechafin='" . $this->getcefechafin() . "'";
        if ($this->getObjCompra() != null)
            $sql .= ",idcompra= " . $this->getObjCompra()->getIdcompra();
        else
            $sql .= ",idcompra= null";
        if ($this->getobjEstadoTipo() != null)
            $sql .= ",idcompraestadotipo='" . $this->getobjEstadoTipo()->getidcompraestadotipo() . "'";
        else
            $sql .= " ,idcompraestadotipo=null";
        if ($this->getcefechaini() != null && $this->getcefechaini() != "")
            $sql .= ",cefechaini='" . $this->getcefechaini() . "'";
        else
            $sql .= ",cefechaini=null";
        if ($this->getcefechafin() != null && $this->getcefechafin() != "")
            $sql .= ",cefechafin='" . $this->getcefechafin() . "'";
        else
            $sql .= ",cefechafin=null";
        $sql .= " WHERE idcompraestado = " . $this->getidcompraestado();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("CompraEstado->modificar 1: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("CompraEstado->modificar 2: " . $db->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM compraestado WHERE idcompraestado = " . $this->getidcompraestado() . ";";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestado->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->eliminar: " . $db->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM compraestado ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $objEstadoTipo = new CompraEstadoTipo();
                        $objEstadoTipo->setidcompraestadotipo($row['idcompraestadotipo']);
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row['idcompra']);

                        $obj = new CompraEstado();
                        $obj->setearConClave($row['idcompraestado'], $row['cefechaini'], $row['cefechafin'], $objEstadoTipo, $objCompra);

                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("compraestado->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}

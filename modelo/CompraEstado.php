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

    /**
     * Carga los datos de un estado de compra desde la bd, utilizando el idcompraestado
     */
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

    /**
     * Inserta un nuevo estado de compra en la bd.
     */
    public function insertar()
    {
        $idcompra = $this->getObjCompra()->getIdcompra();
        $idcompraestadotipo = $this->getobjEstadoTipo()->getidcompraestadotipo();
        $cefechafin = $this->getcefechafin();

        $resp = false;
        $db = new BaseDatos();

        if ($cefechafin != null) {
            $cefechafin = "'$cefechafin'";
        } else {
            $cefechafin = "null";
        }

        $sql = "INSERT INTO compraestado(idcompra, cefechafin, idcompraestadotipo) VALUES($idcompra, $cefechafin, $idcompraestadotipo)";

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

    /**
     * Modifica un estado de compra en la bd.
     */
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

    /**
     * Elimina un estado de compra de la bd.
     */
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

    /**
     * Lista todos los estados de compra que coinciden con el parametro ingresado.
     */
    public static function listar($parametro = "")
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
                        $objEstadoTipo->cargar();
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row['idcompra']);

                        $obj = new CompraEstado();
                        $obj->setearConClave($row['idcompraestado'], $row['cefechaini'], $row['cefechafin'], $objEstadoTipo, $objCompra);

                        array_push($arreglo, $obj);
                    }
                }
            }
        }
        return $arreglo;
    }

    /**
     * Convierte el objeto compraEstado a un array.
     */
    public function toArray() {
        $objCompra = $this->getObjCompra();
        $objEstadoTipo = $this->getobjEstadoTipo();
        return array(
            "idcompraestado" => $this->getidcompraestado(),
            "cefechaini" => $this->getcefechaini(),
            "cefechafin" => $this->getcefechafin(),
            "idcompra" => $objCompra->getIdcompra(),
            "compraestadotipo" => $objEstadoTipo->toArray()
        );
    }
}
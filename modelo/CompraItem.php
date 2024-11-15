<?php
class CompraItem
{
    private $idcompraitem;
    private $cicantidad;
    private $objProducto;
    private $objCompra;

    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompraitem = "";
        $this->cicantidad = 0;
        $this->objProducto = new Producto();
        $this->objCompra = new Compra();
    }

    public function getIdcompraitem()
    {
        return $this->idcompraitem;
    }

    public function setIdcompraitem($idcompraitem)
    {
        $this->idcompraitem = $idcompraitem;
    }

    public function getCicantidad()
    {
        return $this->cicantidad;
    }

    public function setCicantidad($cicantidad)
    {
        $this->cicantidad = $cicantidad;
    }

    public function getObjProducto()
    {
        return $this->objProducto;
    }
    public function setObjProducto($objProducto)
    {
        $this->objProducto = $objProducto;
    }
    public function getObjCompra()
    {
        return $this->objCompra;
    }
    public function setObjCompra($objCompra)
    {
        $this->objCompra = $objCompra;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($valor)
    {
        $this->mensajeoperacion = $valor;
    }

    public function setear($cicantidad, $objProducto, $objCompra)
    {
        $this->setCicantidad($cicantidad);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
    }

    public function setearConClave($idcompraitem, $cicantidad, $objProducto, $objCompra)
    {
        $this->setIdcompraitem($idcompraitem);
        $this->setCicantidad($cicantidad);
        $this->setObjProducto($objProducto);
        $this->setObjCompra($objCompra);
    }

    public function cargar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "SELECT * FROM compraitem WHERE idcompraitem = " . $this->getIdcompraitem() . ";";
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $db->Registro();

                    $objProducto = new Producto();
                    $objProducto->setidproducto($row['idproducto']);
                    $objCompra = new Compra();
                    $objCompra->setIdcompra($row['idcompra']);

                    $this->setear($row['cicantidad'], $objProducto, $objCompra);
                }
            }
        } else {
            $this->setmensajeoperacion("compraitem->listar: " . $db->getError());
        }
        return $resp;
    }

    public function insertar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "INSERT INTO compraitem(idcompra,idproducto,cicantidad) VALUES("
            . $this->getObjCompra()->getidcompra() . ","
            . $this->getObjProducto()->getidproducto() . ","
            . $this->getCicantidad() . ");";

        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraitem->insertar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->insertar: " . $db->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "UPDATE compraitem SET cicantidad='" . $this->getCicantidad() . "'";
        if ($this->getObjCompra() != null)
            $sql .= ",idcompra= " . $this->getObjCompra()->getIdcompra();
        else
            $sql .= ",idcompra= null";
        if ($this->getObjProducto() != null)
            $sql .= ",idproducto='" . $this->getObjProducto()->getidproducto() . "'";
        else
            $sql .= " ,idproducto=null";
        $sql .= " WHERE idcompraitem = " . $this->getIdcompraitem();
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraitem->modificar 1: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->modificar 2: " . $db->getError());
        }
        return $resp;
    }



    public function eliminar()
    {
        $resp = false;
        $db = new BaseDatos();
        $sql = "DELETE FROM compraitem WHERE idcompraitem = " . $this->getIdcompraitem() . ";";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraitem->eliminar: " . $db->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->eliminar: " . $db->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $db = new BaseDatos();
        $sql = "SELECT * FROM compraitem ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($db->Iniciar()) {
            $res = $db->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $db->Registro()) {
                        $obj = new CompraItem();

                        $objProducto = new Producto();
                        $objProducto->setidproducto($row['idproducto']);
                        $objCompra = new Compra();
                        $objCompra->setIdcompra($row['idcompra']);

                        $obj->setearConClave($row['idcompraitem'], $row['cicantidad'], $objProducto, $objCompra);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setmensajeoperacion("compraitem->listar: " . $db->getError());
            }
        }
        return $arreglo;
    }
}

<?php
class Compra
{
    private $idcompra;
    private $cofecha;
    private $objusuario;

    private $mensajeoperacion;

    public function __construct()
    {
        $this->idcompra = "";
        $this->cofecha = "";
        $this->objusuario = null;
        $this->mensajeoperacion = "";
    }

    public function getIdcompra()
    {
        return $this->idcompra;
    }

    public function setIdcompra($idcompra)
    {
        $this->idcompra = $idcompra;
    }

    public function getCofecha()
    {
        return $this->cofecha;
    }

    public function setCofecha($cofecha)
    {
        $this->cofecha = $cofecha;
    }

    public function getObjusuario()
    {
        return $this->objusuario;
    }

    public function setObjusuario($objusuario)
    {
        $this->objusuario = $objusuario;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function setear($idcompra, $cofecha, $objusuario)
    {
        $this->setIdcompra($idcompra);
        $this->setCofecha($cofecha);
        $this->setObjusuario($objusuario);
    }

    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra WHERE idcompra = " . $this->getIdcompra();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $objusuario = null;
                    if ($row['idusuario'] != null or $row['idusuario'] != '') {
                        $objusuario = new Usuario();
                        $objusuario->setidusuario($row['idusuario']);
                    }
                    $this->setear($row['idcompra'], $row['cofecha'], $objusuario);
                }
            }
        } else {
            $this->setmensajeoperacion("Compra->cargar: " . $base->getError()[2]);
        }
        return $resp;
    }

    /**
     * La compra siempre la crea con la fecha actual
     */
    public function insertar()
    {
        $usuario = $this->getObjusuario();
        if ($usuario === null) {
            $this->setmensajeoperacion("Compra->insertar: Debe cargar un usuario");
            return false;
        } else {
            $usuario->cargar();
        }

        $resp = false;

        $base = new BaseDatos();
        $sql = "INSERT INTO compra(idusuario) VALUES('" . $usuario->getidusuario() . "');";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdcompra($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compra->insertar: " . $base->getError()[2]);
            }
        } else {
            $this->setmensajeoperacion("Compra->insertar: " . $base->getError()[2]);
        }
        return $resp;
    }

    public function modificar()
    {
        $usuario = $this->getObjusuario();
        if ($usuario === null) {
            $this->setmensajeoperacion("Compra->modificar: Debe cargar un usuario");
            return false;
        }

        $resp = false;

        $base = new BaseDatos();
        $sql = "UPDATE compra SET idusuario='" . $usuario->getidusuario() . "', cofecha='" . $this->getCofecha() . "' WHERE idcompra='" . $this->getIdcompra() . "'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compra->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $sql = "DELETE FROM compra WHERE idcompra =" . $this->getIdcompra();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Compra->eliminar: " . $base->getError());
        }
        return $resp;
    }

    public static  function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {

                while ($row = $base->Registro()) {
                    $obj = new Compra();
                    $objusuario = null;
                    if ($row['idcompra'] != null) {
                        $objusuario = new Usuario();
                        $objusuario->setidusuario($row['idusuario']);
                    }
                    $obj->setear($row['idcompra'], $row['cofecha'], $objusuario);
                    array_push($arreglo, $obj);
                }
            }
        }

        return $arreglo;
    }
}

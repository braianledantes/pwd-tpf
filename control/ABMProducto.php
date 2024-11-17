<?php
class ABMProducto
{

    public function abm($datos)
    {
        $resp = false;
        if ($datos['accion'] == 'editar') {
            if ($this->modificacion($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'borrar') {
            if ($this->baja($datos)) {
                $resp = true;
            }
        }
        if ($datos['accion'] == 'nuevo') {
            if ($this->alta($datos)) {
                $resp = true;
            }
        }
        return $resp;
    }
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Producto
     */
    private function cargarObjeto($param)
    {
        $obj = null;

        if (
            array_key_exists('idproducto', $param)  and array_key_exists('pronombre', $param) and array_key_exists('prodetalle', $param)
            and array_key_exists('procantstock', $param) and array_key_exists('proprecio', $param) and array_key_exists('prourlimagen', $param)
        ) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['proprecio'], $param['prourlimagen']);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Producto
     */

    private function cargarObjetoConClave($param)
    {
        $obj = null;
        if (isset($param['idproducto'])) {
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param['idproducto']))
            $resp = true;
        return $resp;
    }

    public function alta($param)
    {
        $resp = false;
        $param['idproducto'] = null;
        // si la imagen fue cargada, la sube al servidor
        if (array_key_exists('proimagen', $param) && $param['proimagen']['error'] == UPLOAD_ERR_OK) {
            $param['prourlimagen'] = $this->subirImagen($param['proimagen'], uniqid());
        } else {
            // si no se cargo una imagen, se setea a null
            $param['prourlimagen'] = null;
        }
        // crea el objeto y lo inserta en la base de datos
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }

    private function subirImagen($proimagen, $nombreImagen)
    {
        // carpeta donde se guardan las imagenes
        $folder = $GLOBALS['ROOT'] . "imagenes/productos/";
        // obtiene la extencion de la imagen
        $extencion = pathinfo($proimagen['name'], PATHINFO_EXTENSION);
        // crea el nombre de la imagen
        $nombreImagen = $nombreImagen . "." . $extencion;
        $imageubicacion = $folder . $nombreImagen;
        $prourlimagen = $GLOBALS['HOST'] . "imagenes/productos/" . $nombreImagen;
        // crea la carpeta si no existe
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        // copia la imagen al servidor
        move_uploaded_file($proimagen['tmp_name'], $imageubicacion);
        return $prourlimagen;
    }

    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param)
    {
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjetoConClave($param);
            if ($elObjtTabla != null and $elObjtTabla->eliminar()) {
                $resp = true;
            }
        }

        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param)
    {
        // si la imagen fue cargada, la sube al servidor
        if (array_key_exists('proimagen', $param) && $param['proimagen']['error'] == UPLOAD_ERR_OK) {
            $param['prourlimagen'] = $this->subirImagen($param['proimagen'], uniqid());
        } else {
            // si no se cargo una imagen, se setea a null
            $param['prourlimagen'] = null;
        }
        // modifica el objeto en la base de datos
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return array
     */
    public function buscar($param)
    {
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idproducto']))
                $where .= " and idproducto =" . $param['idproducto'];
            if (isset($param['pronombre']))
                $where .= " and pronombre ='" . $param['pronombre'] . "'";
            if (isset($param['prodetalle']))
                $where .= " and prodetalle ='" . $param['prodetalle'] . "'";
            if (isset($param['uspass']))
                $where .= " and procantstock ='" . $param['procantstock'] . "'";
            if (isset($param['procantstock']))
                $where .= " and procantstock ='" . $param['procantstock'] . "'";
        }
        $obj = new Producto();
        $arreglo = $obj->listar($where);
        //echo "Van ".count($arreglo);
        return $arreglo;
    }
}
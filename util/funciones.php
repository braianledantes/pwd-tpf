<?php

/**
 * Función que retorna los datos enviados por el usuario
 */
function data_submitted()
{
    $datos = [];
    foreach ($_GET as $key => $value) {
        $datos[$key] = $value;
    }
    foreach ($_POST as $key => $value) {
        $datos[$key] = $value;
    }
    foreach ($datos as $key => $value) {
        if ($value == '' || $value == null) {
            unset($datos[$key]);
        }
    }
    return $datos;
}

function verEstructura($e)
{
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}

spl_autoload_register(function ($class_name) {
    //echo "class ".$class_name ;
    $directorys = array(
        $GLOBALS['ROOT'] . 'Modelo/',
        $GLOBALS['ROOT'] . 'Modelo/Conector/',
        $GLOBALS['ROOT'] . 'Control/',
        //  $GLOBALS['ROOT'].'util/class/',
    );

    $continue = true;
    $pos = 0;
    while ($continue && $pos < count($directorys)) {
        if (file_exists($directorys[$pos] . $class_name . '.php')) {
            require_once($directorys[$pos] . $class_name . '.php');
            $continue = false;
        } 
        $pos++;
    }
});

?>
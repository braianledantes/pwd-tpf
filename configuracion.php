<?php
/////////////////////////////
// CONFIGURACION APP//
/////////////////////////////

//variable que almacena el directorio del proyecto
$PROJECT_PATH = '/pwd-tpf';

$GLOBALS['PROJECT_PATH'] = $PROJECT_PATH;
$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'] . $PROJECT_PATH . "/";
$GLOBALS['INICIO'] = $PROJECT_PATH . '/vista';
$GLOBALS['HOST'] = 'http://localhost' . $PROJECT_PATH . '/';
include_once('util/funciones.php');

// trae las librerias de composer
require "vendor/autoload.php";

// Carga las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable($GLOBALS['ROOT']);
$dotenv->load();
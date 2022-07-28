<?php 

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');

// CONTROLADORES
require_once "controladores/ruta.controlador.php";
require_once "controladores/get.controlador.php";
require_once "controladores/post.controlador.php";
require_once "controladores/put.controlador.php";
require_once "controladores/delete.controlador.php";

// MODELOS
require_once "modelos/get.modelo.php";
require_once "modelos/post.modelo.php";
require_once "modelos/put.modelo.php";
require_once "modelos/delete.modelo.php";

require_once "vendor/autoload.php";

$index = new ControladorRutas();
$index -> index();

?>
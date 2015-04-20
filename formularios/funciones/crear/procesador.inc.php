<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
require_once($root . "librerias/soap/nusoap.php");
$log = "";
$configuraciones = new Configuraciones();
$validaciones = new Validaciones();
$funciones = new Funciones();

$modulo = $validaciones->recibir('modulo');
$nombre = $validaciones->recibir('nombre');
$parametros = $validaciones->recibir('parametros');
$cuerpo = $validaciones->recibir('cuerpo');
$descripcion = $validaciones->recibir('descripcion');
$estado = "ACTIVA";

$funcion = $funciones->crear();
$funciones->actualizar($funcion, "modulo", $modulo);
$funciones->actualizar($funcion, "nombre", $nombre);
$funciones->actualizar($funcion, "parametros", $parametros);
$funciones->actualizar($funcion, "cuerpo", $cuerpo);
$funciones->actualizar($funcion, "descripcion", $descripcion);
$funciones->actualizar($funcion, "estado", $estado);
// Sincronización si se esta en modo <<desarrollo>>
if ($configuraciones->modo == "desarrollo") {
  $tfuncion = $funciones->consultar($funcion);
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/agb/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("funcion", array("funcion" => $tfuncion));
  $log = "Modo desarrollo: Sincronizando Actualización.";
}
/** JavaScripts * */
$f->JavaScript("console.log('" . $log . "');");
$f->JavaScript("if(itable){itable.refresh();}");
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
?>
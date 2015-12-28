<?php

require_once($root . "librerias/soap/nusoap.php");
$configuraciones = new Configuraciones();

if ($configuraciones->modo == "desarrollo") {
  $v = new Validaciones();
  $aff = new Aplicacion_Framework_Funciones();
  $funcion = $aff->consultar($v->recibir("funcion"));
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/insside/sincronizacion.php");
  $error = $cliente->getError();
  $result_funcion = $cliente->call("Framework_Funcion", array("funcion" => $funcion));
  $result_codigo = $cliente->call("Framework_Codigo", array("codigo" => $codigo));
  echo($error);
}
?>
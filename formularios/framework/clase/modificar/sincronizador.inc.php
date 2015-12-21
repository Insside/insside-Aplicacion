<?php

require_once($root . "librerias/soap/nusoap.php");
$configuraciones = new Configuraciones();

if ($configuraciones->modo == "desarrollo") {
  $v = new Validaciones();
  $afc = new Aplicacion_Framework_Clases();
  $clase = $afc->consultar($v->recibir("clase"));
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/insside/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("Framework_Clase", array("clase" => $clase));
  echo($error);
}
?>
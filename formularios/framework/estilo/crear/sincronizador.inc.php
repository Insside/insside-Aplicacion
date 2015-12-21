<?php
require_once($root . "librerias/soap/nusoap.php");
$configuraciones = new Configuraciones();

if ($configuraciones->modo == "desarrollo") {
  echo("Sincronizando");
  $v = new Validaciones();
  $afe = new Aplicacion_Framework_Estilos();
  $estilo = $afe->consultar($v->recibir("estilo"));
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/insside/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("Framework_Estilo", array("estilo" => $estilo));
  echo($error);
}
?>
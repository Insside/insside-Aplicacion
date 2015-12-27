<?php
require_once($root . "librerias/soap/nusoap.php");
$configuraciones = new Configuraciones();

if ($configuraciones->modo == "desarrollo") {
  echo("Sincronizando Estilo");
  $v = new Validaciones();
  $ae = new Aplicacion_Estilos();
  $estilo = $ae->consultar($v->recibir("estilo"));
  print_r($estilo);
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/insside/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("Aplicacion_Estilo", array("estilo" => $estilo));
  print_r($error);
  print_r($result);
}
?>
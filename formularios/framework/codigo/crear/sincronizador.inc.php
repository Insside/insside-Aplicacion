<?php
require_once($root . "librerias/soap/nusoap.php");
$configuraciones = new Configuraciones();

if ($configuraciones->modo == "desarrollo") {
  echo("Sincronizando");
  $v = new Validaciones();
  $afc = new Aplicacion_Framework_Codigos();
  $codigo = $afc->consultar($v->recibir("codigo"));
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/insside/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("Framework_Codigo", array("codigo" => $codigo));
  echo($error);
}
?>
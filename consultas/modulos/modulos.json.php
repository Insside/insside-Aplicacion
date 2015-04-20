<?php

$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
/** Variables Recibidas * */
$transaccion = @$_REQUEST['transaccion'];
$estado = @$_REQUEST['estado'];
$buscar = @$_REQUEST['buscar'];
$cadenas = new Cadenas();

/* * Variables Definidas * */
$automatizaciones = new Automatizaciones();
$usuarios = new Usuarios();
$cadenas = new Cadenas();
$tabla = "aplicacion_modulos";

$page = 1;
$perpage = 50;
$n = 0;
$pagination = false;

if (isset($_REQUEST["page"])) {
  $pagination = true;
  $page = intval($_REQUEST["page"]);
  $perpage = intval($_REQUEST["perpage"]);
  $n = ( $page - 1 ) * $perpage;
}

if (!empty($buscar)) {
  $buscar = "WHERE(" . $automatizaciones->like($tabla, $buscar) . ")";
} elseif (!empty($estado)) {
  $buscar = "WHERE(`estado`='" . strtoupper($estado) . "')";
} else {
  $buscar = "";
}
$db = new MySQL();
$sql['sql'] = "SELECT * FROM `" . $tabla . "` " . $buscar . " ;";
//echo($sql['sql']);
$consulta = $db->sql_query($sql['sql']);
$fila = $db->sql_fetchrow($consulta);
$total = $db->sql_numrows();

$limit = "";

if ($pagination) {
  $limit = "LIMIT $n, $perpage";
}
$sql = ("SELECT * FROM `" . $tabla . "` " . $buscar . " ORDER BY `modulo` ASC " . $limit);
$consulta = $db->sql_query($sql);
$ret = array();
while ($fila = $db->sql_fetchrow($consulta)) {
  array_push($ret, $fila);
}
$db->sql_close();
echo json_encode(array("page" => $page, "total" => $total, "data" => $ret));
?>
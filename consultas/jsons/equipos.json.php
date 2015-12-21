<?php

/**
 * Este archivo retorna el resultado de una consulta sobre el listadod e suscriptores en formto JSON
 * responde a una variable llamada busqueda que define el patron del dato a buscar y una variable llamada
 * criterio que de ser recibida delimita la busqueda del patron la los registros consultando un campo
 * especifico de los mismos
 * */
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
$cadenas = new Cadenas();
$automatizaciones = new Automatizaciones();
$usuarios = new Usuarios();
//------ Variables Reibidas
/* @var $criterio type String Representa en campo a buscar */
/* @var $buscar type String Representa el dato a buscar */
$criterio = @$_REQUEST['criterio'];
$buscar = @$_REQUEST['buscar'];
$pagina = @$_REQUEST['page'];
$cantidad = $_REQUEST["perpage"];
//---- Definiendo la expresión SQL de busqueda
if (!empty($buscar)) {
  $buscar = "WHERE(" . ($automatizaciones->like("usuarios_equipos", $buscar)) . ")";
} else {
  $buscar = "";
}
//----------------------------------------------------
$page = 1;
$perpage = 50;
$n = 0;
$pagination = false;

if (!empty($pagina)) {
  $pagination = true;
  $page = intval($pagina);
  $perpage = intval($cantidad);
  $n = ( $page - 1 ) * $perpage;
}
//$sorton = @$_REQUEST["sorton"];
//$sortby = @$_REQUEST["sortby"];
$db = new MySQL();
$acentos = $db->sql_query("SET NAMES 'utf8'");
$sql = "SELECT * FROM `usuarios_equipos` " . $buscar . " ;";
$result = $db->sql_query($sql);
$fila = $db->sql_fetchrow($result);
$total = $db->sql_numrows();

$limit = "";

if ($pagination) {
  $limit = "LIMIT $n, $perpage";
}
$sql = "SELECT * FROM `usuarios_equipos` " . $buscar . " ORDER BY `equipo` ASC " . $limit . "";
$result = $db->sql_query($sql);
//echo($sql);
$ret = array();
while ($fila = $db->sql_fetchrow($result)) {
//  $suscriptor = "<a href=\"#\" onClick=\"MUI.Suscriptores_Suscriptor_Visualizar('" . $fila['suscriptor'] . "');\">" . $fila['suscriptor'] . "</a>";
  $fila['creador'] = "&nbsp;<a href=\"#\" onClick=\"MUI.Raiz_Creador('" . $fila['creador'] . "');\"><img src=\"imagenes/16x16/usuario-16x16.png\"></a>";
  $fila['descripcion'] = $cadenas->recortar($fila['descripcion'], "180");
  array_push($ret, $fila);
}
$db->sql_close();
$ret = array("page" => $page, "total" => $total, "data" => $ret);
echo json_encode($ret);
?>
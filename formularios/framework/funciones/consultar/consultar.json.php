<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root."modulos/solicitudes/librerias/Configuracion.cnf.php");
$sesion = new Sesion();
$modulos = new Modulos();
$automatizaciones = new Automatizaciones();
$usuarios = new Usuarios();
$cadenas = new Cadenas();
$validaciones=new Validaciones();
/** Variables Recibidas * */
$transaccion = $validaciones->recibir('transaccion');
$estado = $validaciones->recibir('estado');
$buscar = $validaciones->recibir('buscar');
$clase=$validaciones->recibir('clase');
/* * Variables Definidas * */
$tabla = "aplicacion_framework_funciones";

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
  $buscar = "WHERE(`estado`='" . strtoupper($estado) . "' AND `clase`='" .$clase. "')";
} else {
  $buscar ="WHERE(`clase`='" .$clase. "')";
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
$sql = ("SELECT * FROM `" . $tabla . "` " . $buscar . " ORDER BY `nombre` ASC " . $limit);
$consulta = $db->sql_query($sql);
$json= array();
$dato= array();
while ($fila = $db->sql_fetchrow($consulta)) {
  $dato["funcion"]=  $fila['funcion'];
  $dato["clase"]=  $fila['clase'];
  $dato["detalles"]="<b>".$fila['nombre']."</b>(<i><u>".$fila['parametros']."</u></i>): <i>".$cadenas->recortar($fila['descripcion'],"100")." </i>";
  $dato["fecha"]=$fila["fecha"];
  $dato["hora"]=$fila["hora"];
  array_push($json, $dato);
}
$db->sql_close();
echo json_encode(array("page" => $page, "total" => $total,"sql" => $sql, "data" => $json));
?>
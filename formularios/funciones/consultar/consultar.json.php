<?php
$root = (!isset($root)) ? "../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
/* * Variables Definidas * */
$sesion = new Sesion();
$modulos = new Aplicacion_Modulos();
$automatizaciones = new Automatizaciones();
$usuarios = new Usuarios();
$cadenas = new Cadenas();
$tabla = "aplicacion_funciones";
/** Variables Recibidas * */
$transaccion = @$_REQUEST['transaccion'];
$estado = @$_REQUEST['estado'];
$buscar = @$_REQUEST['buscar'];



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

$consulta = $db->sql_query("SELECT * FROM `" . $tabla . "` " . $buscar . " ORDER BY  `modificacion` DESC " . $limit);

$ret = array();
$funcion = array();
while ($fila = $db->sql_fetchrow($consulta)) {
  $modulo = $modulos->consultar($fila['modulo']);
  $creador = $usuarios->consultar($fila['creador']);
  $funcion['nombre'] = ((!empty($modulo['nombre'])) ? $modulo['nombre'] . "_" . $fila["nombre"] : $fila["nombre"]);
  $fila['modulo'] = $modulo['nombre'];
    $fila['detalles'] = "<b>" . $funcion['nombre'] . "</b><i>(" . $fila['parametros'] . ")</i>: ".$fila['descripcion'];
  $fila['creador'] = "&nbsp;<a href=\"#\" onClick=\"MUI.Notificacion('" . $creador['alias'] . "');\"><img src=\"imagenes/16x16/usuario-16x16.png\"></a>";
  
  array_push($ret, $fila);
}
$db->sql_close();
echo json_encode(array("page" => $page, "total" => $total, "data" => $ret));
?>
<?php

$root=(!isset($root))?"../../../":$root;
require_once($root."modulos/suscriptores/librerias/Configuracion.cnf.php");

$page=1;
$perpage=50;
$n=0;
$pagination=false;

if(isset($_REQUEST["page"])){
  $pagination=true;
  $page=intval($_REQUEST["page"]);
  $perpage=intval($_REQUEST["perpage"]);
  $n=( $page-1 )*$perpage;
}

if(isset($_REQUEST["buscar"])){
  $buscar=$_REQUEST["buscar"];
  $buscar="";
  //$buscar = "WHERE `suscriptor` LIKE '%" . $buscar . "%' OR `identificacion` LIKE '%" . $buscar . "%' OR `nombres` LIKE '%" . $buscar . "%' OR `apellidos` LIKE '%" . $buscar . "%' OR `direccion` LIKE '%" . $buscar . "%' OR `referencia` LIKE '%" . $buscar . "%' OR `estrato` LIKE '%" . $buscar . "%' OR `predial` LIKE '%" . $buscar . "%' OR `latitud` LIKE '%" . $buscar . "%' OR `longitud` LIKE '%" . $buscar . "%' OR `correo` LIKE '%" . $buscar . "%' OR `telefonos` LIKE '%" . $buscar . "%' OR `creado` LIKE '%" . $buscar . "%' OR `actualizado` LIKE '%" . $buscar . "%' OR `creador` LIKE '%" . $buscar . "%' OR `actualizador` LIKE '%" . $buscar . "%' OR `diametro` LIKE '%" . $buscar . "%' ";
}else{
  $buscar="";
}
// this variables Omnigrid will send only if serverSort option is true
//$sorton = @$_REQUEST["sorton"];
//$sortby = @$_REQUEST["sortby"];
$db=new MySQL();
$acentos=$db->sql_query("SET NAMES 'utf8'");
$sql['sql']="SELECT * FROM `aplicacion_formularios` ".$buscar." ;";
//echo($sql['sql']);
$result=$db->sql_query($sql['sql']);
$fila=$db->sql_fetchrow($result);
$total=$db->sql_numrows();

$limit="";

if($pagination){
  $limit="LIMIT $n, $perpage";
}

$result=$db->sql_query("SELECT * FROM `aplicacion_formularios` ".$buscar." ORDER BY `formulario` DESC ".$limit."");

$ret=array();
while($fila=$db->sql_fetchrow($result)) {
  $fila['formulario']="&nbsp;<a href=\"\">".$fila['formulario']."</a>";
  $fila['nombre']="&nbsp;".$fila['name'];
  $fila['descripcion']="&nbsp;".$fila['descripcion'];
  //$fila['suscriptor'] = "&nbsp;<span><a href=\"#\" onClick=\"parent.MUI.Suscriptores_Suscriptor('" . $fila['suscriptor'] . "');\">" . $fila['suscriptor'] . "</a></span>";
  //$fila['nombre'] = "&nbsp;<span><b>" . $cadenas->capitalizar($fila['nombres'] . " " . $fila['apellidos']) . "</b></span>";
  //$fila['gis'] = (isset($fila['latitud']) && isset($fila['longitud'])) ? "<img src=\"../../imagenes/16x16/geo-16x16.png\" width=\"16\" height=\"16\" >" : "";
  //$fila['direccion'] = "&nbsp;" . $fila['direccion'];
  array_push($ret,$fila);
}
$db->sql_close();

$ret=array("page"=>$page,"total"=>$total,"data"=>$ret);

echo json_encode($ret);
?>
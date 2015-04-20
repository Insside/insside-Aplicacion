<?php

$root=(!isset($root))?"../../../../":$root;
require_once($root."modulos/solicitudes/librerias/Configuracion.cnf.php");
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\ La consulta se realiza recibiendo el parametro suscriptor//
//\\ en formato JSON, el parametro es extraido de los datos//
//\\ del JSON para ser utilizado.//
// Para probar si funciona
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
//echo('<pre>');print_r($_REQUEST);echo('</pre>');
$transaccion=@$_REQUEST['transaccion'];
if(isset($_REQUEST['datos'])){
  $jdatos=json_decode($_REQUEST['datos']);
  foreach($jdatos as $nombre=> $valor){
    $datos[$nombre]=$valor;
  } $pais=$datos['pais'];
  $region=$datos['region'];
}elseif(isset($_REQUEST['pais'])){
  $pais=$_REQUEST['pais'];
  $region=$_REQUEST['region'];
}$selected="";
$db=new MySQL();
$acentos=$db->sql_query("SET NAMES 'utf8'");
$sql="SELECT * FROM `ciudades` WHERE(`pais`='".$pais."' AND `region`='".$region."') ORDER BY `nombre` ASC";
$consulta=$db->sql_query($sql);
$html=('<select name="ciudad'.$transaccion.'"id="ciudades'.$transaccion.'">');
$conteo=0;
while($fila=$db->sql_fetchrow($consulta)) {
  $html.=('<option value="'.$fila['ciudad'].'"'.(($selected==$fila['ciudad'])?"selected":"").'>'.$fila['nombre'].'</option>');
  $conteo++;
}$db->sql_close();
$html.=("</select>");
$dato['objeto']="select";
$dato['html']=$html;
echo json_encode($dato);
?>
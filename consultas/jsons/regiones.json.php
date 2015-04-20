<?php

$root=(!isset($root))?"../../../../":$root;
require_once($root."modulos/aplicacion/librerias/Configuracion.cnf.php");
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
//\\//\\//\\//\\//\\//\\//\\//\\//
//\\ La consulta se realiza recibiendo el parametro suscriptor
//\\ en formato JSON, el parametro es extraido de los datos
//\\ del JSON para ser utilizado.
//\\ $suscriptor=@$_REQUEST['suscriptor'];
// Para probar si funciona
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
//echo('<pre>');print_r($_REQUEST);echo('</pre>');
$transaccion=$_REQUEST['transaccion'];
if(isset($_REQUEST['datos'])){
  $jdatos=json_decode($_REQUEST['datos']);
  foreach($jdatos as $nombre=> $valor){
    $datos[$nombre]=$valor;
  } $pais=$datos['pais'];
}elseif(isset($_REQUEST['pais'])){
  $pais=$_REQUEST['pais'];
}$selected="";
$db=new MySQL();
$sql="SELECT * FROM `regiones` WHERE(`pais`='".$pais."') ORDER BY `nombre` ASC";
$consulta=$db->sql_query($sql);
$html=('<select name="region'.$transaccion.'"id="region'.$transaccion.'" onChange="eval(actualizacion_ciudades'.$transaccion.'())">');
$conteo=0;
while($fila=$db->sql_fetchrow($consulta)) {
  $html.=('<option value="'.$fila['region'].'"'.(($selected==$fila['region'])?"selected":"").'>'.$fila['nombre'].'</option>');
  $conteo++;
}$db->sql_close();
$html.=("</select>");
$dato['objeto']="select";
$dato['html']=$html;
echo(json_encode($dato));
?>
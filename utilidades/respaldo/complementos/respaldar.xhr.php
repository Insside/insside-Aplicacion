<?php 
$root = (!isset($root)) ? "../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

$respaldos["conteo"] = 0;
$directorio = "../";
if (!($obertura = opendir($directorio)))
 die("No se puede abrir el directorio");
while ($contenido = readdir($obertura)) {
 if ($contenido != "." && $contenido != "..") {
  //echo "<li>$contenido</li>";
  if (stripos($contenido, '.rsa') !== FALSE) {
   $respaldos["conteo"]++;
  }
 }
}
closedir($obertura);
?>
<style>
 #complementos{padding: 10px;}
 #complementos p{font-size: 14px; line-height: 12px; }
 #complementos .numero{font-size: 50px; line-height: 36px; color: #375D81; text-align: right;font-weight: bold; padding: 10px; background-color: #f2f2f2;}
 #complementos .critico{font-size: 50px; line-height: 36px; color: red; text-align: right;font-weight: bold; padding: 10px; background-color: #f2f2f2;}
 #complementos h2{font-size: 14px; line-height: 12px; text-align: center; padding: 5px; background-color: #cccccc;}
</style>
<h2>Copias De Seguridad</h2>
<p class="critico"><?php  echo($respaldos["conteo"]); ?></p>
<br>


<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");


$transaccion = isset($_REQUEST['transaccion']) ? $_REQUEST['transaccion'] : time();
$f = new Formularios($transaccion);
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
echo($f->apertura());
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
if (!isset($_REQUEST['trasmision'])) {
  require_once($root . "modulos/aplicacion/formularios/framework/codigo/eliminar/formulario.inc.php");
} else {
  require_once($root . "modulos/aplicacion/formularios/framework/codigo/eliminar/procesador.inc.php");
}
//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\//\\
echo($f->generar());
echo($f->controles());
echo($f->cierre());
?>
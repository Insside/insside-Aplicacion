<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/solicitudes/librerias/Configuracion.cnf.php");
Sesion::init();
/** Variables **/
$validaciones=new Validaciones();
$transaccion=$validaciones->recibir("transaccion");
$trasmision = $validaciones->recibir("trasmision");
$f = new Formularios($transaccion);
echo($f->apertura());
/** <formulario> **/
/** Valores **/

$html="<div id=\"i100x100_bloqueado\" style=\"float: left;\"></div>";
$html.="<div class=\"notificacion\"><p>La sesión ha finalizado por favor ingrese nuevamente. "
        . "Es posible que esta notificación se produzca por fallos en la conexión con el servidor corporativo, "
        . "por su seguridad y la de la entidad, o debido a reiteradas desconexiones el sistema ha "
        . "determinado que deberá iniciar sesión nuevamente. Si este mensaje se torna persistente por "
        . "favor contacte al departamento de sistemas e indique que está presentando problemas de "
        . "conectividad y requiere que su conexión con la intranet sea verificada. Presione continuar para "
        . "ser re direccionado al inicio de sesión.</p></div>";
/** Campos **/
$f->campos['continuar']=$f->button("continuar".$f->id, "button","Continuar");
/** Celdas **/
$f->celdas['info']=$f->celda("",$html,"","notificacion");
/** Filas **/
$f->fila["info"]=$f->fila($f->celdas['info'],"notificacion");
/** Compilando **/
$f->filas($f->fila['info']);
/** Botones **/
$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScripts **/
$f->eClick("continuar".$f->id,"location.reload(true);");
/** </formulario> **/
echo($f->generar());
echo($f->controles());
echo($f->cierre());
?>
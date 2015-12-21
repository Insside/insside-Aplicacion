<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/solicitudes/librerias/Configuracion.cnf.php");
Sesion::init();
/** Variables **/
$cadenas = new Cadenas();
$fechas = new Fechas();
$paises = new Paises();
$regiones = new Regiones();
$ciudades = new Ciudades();
$sectores = new Sectores();
$validaciones = new Validaciones();
$usuario=Sesion::usuario();
/** Valores **/
$valores['aforo']=time();
$valores['solicitud']=$validaciones->recibir("solicitud");
$valores['observacion']=$validaciones->recibir("_observación");
$valores['fecha']=$fechas->hoy();
$valores['hora']=$fechas->ahora();
$valores['creador']=$usuario['usuario'];

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

$f->JavaScript("MUI.titleWindow($('".($f->ventana)."'),\"Notificación Critica\");");
$f->JavaScript("MUI.resizeWindow($('".($f->ventana)."'),{width: 480,height:240});");
$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");
$f->eClick("continuar".$f->id,"MUI.closeWindow($('".$f->ventana."'));location.reload(true);");
?>
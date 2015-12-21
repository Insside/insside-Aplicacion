<?php
/** Variables * */
$cadenas = new Cadenas();
$fechas = new Fechas();
$validaciones = new Validaciones();
$itable=$validaciones->recibir("itable");
/** Valores * */
if(!empty($itable)){$f->oculto("itable",$itable);}
$f->campos['identidad']=$f->text("identidad","",64,"");
$f->campos['clase']=$f->text("clase","",64,"");
$f->campos['etiqueta']=$f->text("etiqueta","",64,"");
$f->campos['estado']=$f->text("estado","",64,"");
$f->campos['descripcion']=$f->textarea("descripcion","","textarea",25,80,false,false,false,255);
$f->campos['registrar']=$f->button("registrar".$f->id,"submit","Registrar");
$f->campos['cancelar']=$f->button("cancelar".$f->id,"button","Cancelar");
// Celdas
$f->celdas['identidad']=$f->celda("Identidad (ID):",$f->campos['identidad']);
$f->celdas['clase']=$f->celda("Clase (CLASS):",$f->campos['clase']);
$f->celdas['etiqueta']=$f->celda("Etiqueta (HTML):",$f->campos['etiqueta']);
$f->celdas['estado']=$f->celda("Estado:",$f->campos['estado']);
$f->celdas['descripcion']=$f->celda("Descripción:",$f->campos['descripcion']);
// Filas
$f->fila["elementos"]=$f->fila($f->celdas['identidad'].$f->celdas['clase'].$f->celdas['etiqueta'].$f->celdas['estado']);
$f->fila["descripcion"]=$f->fila($f->celdas['descripcion']);
//Compilacion
$f->filas($f->fila['elementos']);
$f->filas($f->fila['descripcion']);
$f->botones($f->campos['cancelar'],"inferior-derecha");
$f->botones($f->campos['registrar'],"inferior-derecha");
/** JavaScripts * */
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'),\"Crear Estilo\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'),{width: 750,height:250});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>
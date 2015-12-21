<?php
$validaciones=new Validaciones();
$clases=new Aplicacion_Framework_Clases();
$v=$clases->consultar($validaciones->recibir("clase"));
$v["contenido"]=$clases->codensador($v["clase"]);
/** Campos **/
$f->campos['contenido']=$f->iAreaCode("contenido","javascript",$v['contenido'],"","480");
$f->celdas["contenido"]=$f->celda("Contenido:",$f->campos['contenido']);
$f->fila["f1"]=$f->fila($f->celdas["contenido"]);
/** Compilando **/
$f->filas($f->fila['f1']);

/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('".($f->ventana)."'),\"Publicar / Compartir\");");
$f->JavaScript("MUI.resizeWindow($('".($f->ventana)."'),{width:800,height:480});");
$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");$f->eClick("cancelar".$f->id,"MUI.closeWindow($('".$f->ventana."'));");
?>



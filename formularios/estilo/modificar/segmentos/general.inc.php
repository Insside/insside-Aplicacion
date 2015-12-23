<?php
/** Campos **/
$f->campos['estilo']=$f->text("estilo",$v['estilo'],"10","required",true);
$f->campos['identidad']=$f->text("identidad",$v['identidad'],"64","",false);
$f->campos['clase']=$f->text("clase",$v['clase'],"64","",false);
$f->campos['etiqueta']=$f->text("etiqueta",$v['etiqueta'],"64","",false);
$f->campos['estado']=$f->text("estado",$v['estado'],"64","",false);
$f->campos['css'] = $f->iAreaCode("css", "css", $v['css']);
$f->campos['css_firefox'] =$f->iAreaCode("css_firefox", "css", $v['css_firefox']);
$f->campos['css_chrome'] = $f->iAreaCode("css_chrome", "css", $v['css_chrome']);
$f->campos['css_iexplorer'] =$f->iAreaCode("css_iexplorer", "css", $v['css_iexplorer']);
$f->campos['css_opera'] =$f->iAreaCode("css_opera", "css", $v['css_opera']);
$f->campos['descripcion']=$f->text("descripcion",$v['descripcion'],"lo","",false);
$f->campos['version']=$f->text("version",$v['version'],"oubl","",true);
$f->campos['fecha']=$f->text("fecha",$v['fecha'],"10","",true);
$f->campos['hora']=$f->text("hora",$v['hora'],"8","",true);
$f->campos['creador']=$f->text("creador",$v['creador'],"10","",true);
$f->campos['ayuda']=$f->button("ayuda".$f->id, "button","Ayuda");
$f->campos['cancelar']=$f->button("cancelar".$f->id, "button","Cancelar");
$f->campos['continuar']=$f->button("continuar".$f->id, "submit","Continuar");
/** Celdas **/
$f->celdas["estilo"]=$f->celda("Estilo:",$f->campos['estilo']);
$f->celdas["identidad"]=$f->celda("Identidad:",$f->campos['identidad']);
$f->celdas["clase"]=$f->celda("Clase:",$f->campos['clase']);
$f->celdas["etiqueta"]=$f->celda("Etiqueta:",$f->campos['etiqueta']);
$f->celdas["estado"]=$f->celda("Estado:",$f->campos['estado']);
$f->celdas["css"]=$f->celda("Css:",$f->campos['css']);
$f->celdas["css_firefox"]=$f->celda("Css_Firefox:",$f->campos['css_firefox']);
$f->celdas["css_chrome"]=$f->celda("Css_Chrome:",$f->campos['css_chrome']);
$f->celdas["css_iexplorer"]=$f->celda("Css_Iexplorer:",$f->campos['css_iexplorer']);
$f->celdas["css_opera"]=$f->celda("Css_Opera:",$f->campos['css_opera']);
$f->celdas["descripcion"]=$f->celda("Descripcion:",$f->campos['descripcion']);
$f->celdas["version"]=$f->celda("Version:",$f->campos['version']);
$f->celdas["fecha"]=$f->celda("Fecha:",$f->campos['fecha']);
$f->celdas["hora"]=$f->celda("Hora:",$f->campos['hora']);
$f->celdas["creador"]=$f->celda("Creador:",$f->campos['creador']);
/** Filas **/
//$f->fila["fila1"]=$f->fila($f->celdas["estilo"].$f->celdas["identidad"].$f->celdas["clase"].$f->celdas["etiqueta"]);
//$f->fila["fila2"]=$f->fila($f->celdas["estado"].$f->celdas["css"].$f->celdas["css_firefox"].$f->celdas["css_chrome"]);
//$f->fila["fila3"]=$f->fila($f->celdas["css_iexplorer"].$f->celdas["css_opera"].$f->celdas["descripcion"].$f->celdas["version"]);
//$f->fila["fila4"]=$f->fila($f->celdas["fecha"].$f->celdas["hora"].$f->celdas["creador"]);


$f->fila["fila1"] = $f->fila($f->celdas["estilo"] .$f->celdas["identidad"] . $f->celdas["clase"] . $f->celdas["etiqueta"] . $f->celdas["estado"] . $f->celdas["version"]);
$f->fila["fila2"] = $f->fila($f->celdas["css"]);
$f->fila["css_general"] = $f->fila["fila1"] . $f->fila["fila2"];
?>
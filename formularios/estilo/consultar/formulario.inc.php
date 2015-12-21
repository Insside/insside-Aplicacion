<?php
/** Variables * */
$ae=new Aplicacion_Estilos();
/** Valores * */
$v=$ae->consultar($validaciones->recibir("estilo"));
//$v['css']=$ae->expresion($estilo);
$v['css']=urldecode($v['css']);
/** Campos **/
$itable=$validaciones->recibir("itable");
if(!empty($itable)){$f->oculto("itable",$itable);}
$f->campos['estilo']=$f->text("estilo",$v['estilo'],"10","required",true);
$f->campos['identidad']=$f->text("identidad",$v['identidad'],"64","",true);
$f->campos['clase']=$f->text("clase",$v['clase'],"64","",true);
$f->campos['etiqueta']=$f->text("etiqueta",$v['etiqueta'],"64","",true);
$f->campos['estado']=$f->text("estado",$v['estado'],"64","",true);
$f->campos['css'] = $f->iAreaCode("css", "css", $v['css']);
$f->campos['css_firefox'] =$f->iAreaCode("css_firefox", "css", $v['css_firefox']);
$f->campos['css_chrome'] = $f->iAreaCode("css_chrome", "css", $v['css_chrome']);
$f->campos['css_iexplorer'] =$f->iAreaCode("css_iexplorer", "css", $v['css_iexplorer']);
$f->campos['css_opera'] =$f->iAreaCode("css_opera", "css", $v['css_opera']);
$f->campos['descripcion']=$f->text("descripcion",$v['descripcion'],"lo","",true);
$f->campos['version']=$f->text("version",$v['version'],"oubl","",true);
$f->campos['fecha']=$f->text("fecha",$v['fecha'],"10","",true);
$f->campos['hora']=$f->text("hora",$v['hora'],"8","",true);
$f->campos['creador']=$f->text("creador",$v['creador'],"10","",true);
$f->campos['ayuda']=$f->button("ayuda".$f->id, "button","Ayuda");
$f->campos['cancelar']=$f->button("cancelar".$f->id, "button","Cerrar");
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
$f->fila["fila1"]=$f->fila($f->celdas["estilo"].$f->celdas["identidad"].$f->celdas["clase"].$f->celdas["etiqueta"]);
$f->fila["fila2"]=$f->fila($f->celdas["estado"].$f->celdas["css"].$f->celdas["css_firefox"].$f->celdas["css_chrome"]);
$f->fila["fila3"]=$f->fila($f->celdas["css_iexplorer"].$f->celdas["css_opera"].$f->celdas["descripcion"].$f->celdas["version"]);
$f->fila["fila4"]=$f->fila($f->celdas["fecha"].$f->celdas["hora"].$f->celdas["creador"]);

/** Filas * */
require_once($root."modulos/aplicacion/formularios/estilo/modificar/segmentos/general.inc.php");
require_once($root."modulos/aplicacion/formularios/estilo/modificar/segmentos/firefox.inc.php");
require_once($root."modulos/aplicacion/formularios/estilo/modificar/segmentos/chrome.inc.php");
require_once($root."modulos/aplicacion/formularios/estilo/modificar/segmentos/opera.inc.php");
require_once($root."modulos/aplicacion/formularios/estilo/modificar/segmentos/iexplorer.inc.php");
$f->fila["tabs"] = ""
        . "<ul id=\"tabs\" class=\"iTabs\">"
        . "<li><a class=\"tab\" href=\"#\" id=\"it1\">CSS General</a></li>"
        . "<li><a class=\"tab\" href=\"#\" id=\"it3\">Firefox</a></li>"
        . "<li><a class=\"tab\" href=\"#\" id=\"it4\">Chrome</a></li>"
        . "<li><a class=\"tab\" href=\"#\" id=\"it5\">Opera</a></li>"
        . "<li><a class=\"tab\" href=\"#\" id=\"it6\">IExplorer</a></li>"
        . "</ul>";
$f->fila["home"] = ""
        . "<div id=\"home\">"
        . "<div class=\"feature\">" . $f->fila["css_general"] . "</div>"
        . "<div class=\"feature\">" . $f->fila["css_firefox"] . "</div>"
        . "<div class=\"feature\">" . $f->fila["css_chrome"] . "</div>"
        . "<div class=\"feature\">" . $f->fila["css_opera"] . "</div>"
        . "<div class=\"feature\">" . $f->fila["css_iexplorer"] . "</div>"
        . "</div>";
/** Compilando * */
$f->filas($f->fila['tabs']);
$f->filas($f->fila['home']);
/** Botones * */
//$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['cancelar'], "inferior-derecha");
//$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScripts * */
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'),\"Publicar / Compartir\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'),{width: 750,height:460});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>
<script type="text/javascript">
  var tabs = new iTabs('.tab', '.feature', {
    autoplay: false,
    transitionDuration: 500,
    slideInterval: 3000,
    hover: true
  });
</script>
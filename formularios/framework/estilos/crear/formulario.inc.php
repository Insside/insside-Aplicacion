<?php
/** Variables **/
$cadenas = new Cadenas();
$fechas = new Fechas();
$paises = new Paises();
$regiones = new Regiones();
$ciudades = new Ciudades();
$sectores = new Sectores();
$validaciones = new Validaciones();
/** Valores **/
$valores['estilo']=time();
$valores['clase']=$validaciones->recibir("clase");
$valores['subclase']=$validaciones->recibir("_subclase");
$valores['etiqueta']=$validaciones->recibir("_etiqueta");
$valores['estado']=$validaciones->recibir("_estado");
$valores['css']=$validaciones->recibir("_css");
$valores['css_firefox']=$validaciones->recibir("_css_firefox");
$valores['css_chrome']=$validaciones->recibir("_css_chrome");
$valores['css_iexplorer']=$validaciones->recibir("_css_iexplorer");
$valores['css_opera']=$validaciones->recibir("_css_opera");
$valores['descripcion']=$validaciones->recibir("_descripcion");
$valores['version']=$validaciones->recibir("_version");
$valores['fecha']=$validaciones->recibir("_fecha");
$valores['hora']=$validaciones->recibir("_hora");
$valores['creador']=$validaciones->recibir("_creador");
/** Campos **/
$f->campos['estilo']=$f->text("estilo",$valores['estilo'],"10","required codigo",true);
$f->campos['clase']=$f->text("clase",$valores['clase'],"64","required codigo",true);
$f->campos['subclase']=$f->text("subclase",$valores['subclase'],"64","required",false);
$f->campos['etiqueta']=$f->text("etiqueta",$valores['etiqueta'],"64","",false);
$f->campos['estado']=$f->text("estado",$valores['estado'],"64","",true);
$f->campos['css']=$f->iAreaCode("css","css",$valores['css']);
$f->campos['css_firefox']=$f->text("css_firefox",$valores['css_firefox'],"lo","",true);
$f->campos['css_chrome']=$f->text("css_chrome",$valores['css_chrome'],"lo","",true);
$f->campos['css_iexplorer']=$f->text("css_iexplorer",$valores['css_iexplorer'],"lo","",true);
$f->campos['css_opera']=$f->text("css_opera",$valores['css_opera'],"lo","",true);
$f->campos['descripcion']=$f->text("descripcion",$valores['descripcion'],"lo","",true);
$f->campos['version']=$f->text("version",$valores['version'],"oubl","",true);
$f->campos['fecha']=$f->text("fecha",$valores['fecha'],"10","",true);
$f->campos['hora']=$f->text("hora",$valores['hora'],"8","",true);
$f->campos['creador']=$f->text("creador",$valores['creador'],"10","",true);
$f->campos['ayuda']=$f->button("ayuda".$f->id, "button","Ayuda");
$f->campos['cancelar']=$f->button("cancelar".$f->id, "button","Cancelar");
$f->campos['continuar']=$f->button("continuar".$f->id, "submit","Continuar");
/** Celdas **/
$f->celdas["estilo"]=$f->celda("Estilo:",$f->campos['estilo']);
$f->celdas["clase"]=$f->celda("Clase:",$f->campos['clase']);
$f->celdas["subclase"]=$f->celda("Subclase:",$f->campos['subclase']);
$f->celdas["etiqueta"]=$f->celda("Etiqueta:",$f->campos['etiqueta']);
$f->celdas["estado"]=$f->celda("Estado:",$f->campos['estado']);
$f->celdas["css"]=$f->celda("Código CSS Generico:",$f->campos['css']);
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
$f->fila["tabs"]=""
        . "<ul id=\"tabs\">"
        . "<li><a class=\"tab\" href=\"#\" id=\"one\">Datos</a></li>"
        . "<li><a class=\"tab\" href=\"#\" id=\"two\">Descripcion</a></li>"
        ."<li><a class=\"tab\" href=\"#\" id=\"one\">Firefox</a></li>"
         ."<li><a class=\"tab\" href=\"#\" id=\"one\">Chrome</a></li>"
         ."<li><a class=\"tab\" href=\"#\" id=\"one\">Opera</a></li>"
         ."<li><a class=\"tab\" href=\"#\" id=\"one\">IExplorer</a></li>"
        ."</ul>";
$f->fila["fila1"]=$f->fila($f->celdas["estilo"].$f->celdas["clase"].$f->celdas["subclase"].$f->celdas["etiqueta"].$f->celdas["estado"].$f->celdas["version"]);
$f->fila["fila2"]=$f->fila($f->celdas["css"]);

$f->fila["datos"]=$f->fila["fila1"].$f->fila["fila2"];
$f->fila["css_firefox"]=$f->fila($f->celdas["css_firefox"]);
$f->fila["css_chrome"]=$f->fila($f->celdas["css_chrome"]);
$f->fila["css_opera"]=$f->fila($f->celdas["css_opera"]);
$f->fila["css_iexplorer"]=$f->fila($f->celdas["css_iexplorer"]);
$f->fila["descripcion"]=$f->fila($f->celdas["descripcion"]);

//$f->fila["fila4"]=$f->fila($f->celdas["fecha"].$f->celdas["hora"].$f->celdas["creador"]);

$f->fila["home"]=""
        . "<div id=\"home\">"
        . "<div class=\"feature\">".$f->fila["datos"]."</div>"
        . "<div class=\"feature\">".$f->fila["descripcion"]."</div>"
        . "<div class=\"feature\">".$f->fila["css_firefox"]."</div>"
        . "<div class=\"feature\">".$f->fila["css_chrome"]."</div>"
         . "<div class=\"feature\">".$f->fila["css_opera"]."</div>"
         . "<div class=\"feature\">".$f->fila["css_iexplorer"]."</div>"
        ."</div>";




/** Compilando **/
$f->filas($f->fila['tabs']);
$f->filas($f->fila['home']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['cancelar'], "inferior-derecha");
$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('".($f->ventana)."'),\"Publicar / Compartir\");");
$f->JavaScript("MUI.resizeWindow($('".($f->ventana)."'),{width: 750,height:480});");
$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");$f->eClick("cancelar".$f->id,"MUI.closeWindow($('".$f->ventana."'));");
?>
<script type="text/javascript">
var tabs = new iTabs('.tab','.feature',{
autoplay: false,
transitionDuration:500,
slideInterval:3000,
hover:true
});
</script>
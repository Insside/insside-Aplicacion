<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
/** Variables * */
$v=new Validaciones();
$cadenas = new Cadenas();
$fechas = new Fechas();
$paises = new Paises();
$regiones = new Regiones();
$ciudades = new Ciudades();
$sectores = new Sectores();
$funciones = new Funciones();
$modulos = new Aplicacion_Modulos();

$funcion = $funciones->consultar($v->recibir("funcion"));
$itable=$v->recibir("itable");
/** Valores * */
$valores = $funcion;
/** Campos * */
$f->oculto('codigo' . $f->id, "");
$f->oculto('itable' ,$itable);
$f->campos['funcion'] = $f->text("funcion", $valores['funcion'], "10", "required automatico", false);
$f->campos['modulo'] = $modulos->combo("modulo", $valores['modulo']);
$f->campos['nombre'] = $f->text("nombre", $valores['nombre'], "64", "required", false);
$f->campos['parametros'] = $f->text("parametros", $valores['parametros'], "160", "", false);
$f->campos['cuerpo'] = $f->text("cuerpo", urldecode($valores['cuerpo']), "125", "", true);
$f->campos['descripcion'] = $f->text("descripcion", $valores['descripcion'], "lo", "", true);
$f->campos['version'] = $f->text("version", ($valores['version']), "3,2", "", true);
$f->campos['creacion'] = $f->text("creacion", $valores['creacion'], "10", "", true);
$f->campos['modificacion'] = $f->text("modificacion", $valores['modificacion'], "10", "", true);
$f->campos['estado'] = $f->text("estado", $valores['estado'], "128", "required", true);
$f->campos['creador'] = $f->text("creador", $valores['creador'], "10", "", true);
$f->campos['actualizar'] = $f->button("actualizar" . $f->id, "submit", "Actualizar");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button", "Cancelar");
/** Celdas * */
$f->celdas["funcion"] = $f->celda("Función:", $f->campos['funcion'], "", "w100");
$f->celdas["modulo"] = $f->celda("Modulo:", $f->campos['modulo'], "", "w150");
$f->celdas["nombre"] = $f->celda("Nombre:", $f->campos['nombre'], "", "w250");
$f->celdas["parametros"] = $f->celda("Parametros:", $f->campos['parametros']);
$f->celdas["cuerpo"] = $f->celda("Cuerpo:", $f->campos['cuerpo']);
$f->celdas["descripcion"] = $f->celda("Descripción:", $f->campos['descripcion']);
$f->celdas["version"] = $f->celda("Versión:", $f->campos['version'], "", "w50");
$f->celdas["creacion"] = $f->celda("Creación:", $f->campos['creacion']);
$f->celdas["modificacion"] = $f->celda("Modificacion:", $f->campos['modificacion']);
$f->celdas["estado"] = $f->celda("Estado:", $f->campos['estado']);
$f->celdas["creador"] = $f->celda("Creador:", $f->campos['creador']);
/** Filas * */
$f->fila["fila1"] = $f->fila($f->celdas["funcion"] . $f->celdas["modulo"] . $f->celdas["nombre"] . $f->celdas["parametros"] . $f->celdas["version"]);
$f->fila["fila2"] = $f->fila($f->celdas["cuerpo"] . $f->celdas["descripcion"]);
$f->fila["fila3"] = $f->fila($f->celdas["creacion"] . $f->celdas["modificacion"] . $f->celdas["estado"]);
$f->fila["fila4"] = $f->fila($f->celdas["creador"]);
$f->fila["fila5"] = "<pre id=\"editor" . $f->id . "\">" . urldecode(($valores['cuerpo'])) . "</pre>";
/** Compilando * */
$f->filas($f->fila['fila1']);
//$f->filas($f->fila['fila2']);
//$f->filas($f->fila['fila3']);
//$f->filas($f->fila['fila4']);
$f->filas($f->fila['fila5']);
//$f->botones($f->campos['cancelar']);
$f->botones($f->campos['actualizar']);
/** Controlando Eventos * */
$f->eClick("guardar" . $f->id, "\$('actualizar". $f->id."').click();");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 800, height:400});");
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 800, height: 300, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));
  var editor<?php echo($f->id) ?> = ace.edit("editor<?php echo($f->id) ?>");
  editor<?php echo($f->id) ?>.setTheme("ace/theme/twilight");
  editor<?php echo($f->id) ?>.getSession().setMode("ace/mode/javascript");


  if ($('actualizar<?php echo($f->id); ?>')) {
    $('actualizar<?php echo($f->id); ?>').addEvent('click', function(e) {
      $('codigo<?php echo($f->id) ?>').value = editor<?php echo($f->id) ?>.getValue();
    });
  }

  if ($('cancelar<?php echo($f->id); ?>')) {
    $('cancelar<?php echo($f->id); ?>').addEvent('click', function(e) {
      MUI.closeWindow($('<?php echo($f->ventana); ?>'));
    });
  }

</script>




<style type="text/css" media="screen">
  #editor<?php echo($f->id) ?> {
    margin: 0;
    position: relative;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 230px;
  }
</style>

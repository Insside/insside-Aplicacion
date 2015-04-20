<?php
$root=(!isset($root))?"../../../../":$root;
require_once($root."modulos/aplicacion/librerias/Configuracion.cnf.php");
$modulos=new Modulos();

$html = "<h1>Adjuntar Archivo del Proveedor.</h1>";
$html.="<p>En este formulario podrá adjuntar los archivos de la digitalización de los diferentes documentos físicos solicitados a los proveedores. Para adjuntar un documento deberá hacer clic en Adjuntar archivo local-Examinar. Recuerde que “no debe tener el archivo abierto” cuando lo vaya a adjuntar y debe verificar que el archivo esté guardado con un nombre “corto”.</p>";
$f->campos['modulo']=$modulos->combo("modulo","");
$f->campos['nombre'] = $f->text("nombre", "", 64, "required");
$f->campos['parametros'] = $f->text("parametros", "", 160, "");
$f->campos['descripcion'] = $f->textarea("descripcion", "", "textarea", 25, 80, false, false, false, 255);
$f->campos['registrar'] = $f->button("registrar" . $transaccion, "submit", "Registrar");
$f->campos['cancelar'] = $f->button("cancelar" . $transaccion, "button", "Cancelar");
// Celdas
$f->celdas["modulo"] = $f->celda("Modulo:", $f->campos['modulo'],"","w150");
$f->celdas['nombre'] = $f->celda("Nombre Función:", $f->campos['nombre']);
$f->celdas['parametros'] = $f->celda("Parametros Requeridos:", $f->campos['parametros']);
$f->celdas['descripcion'] = $f->celda("Descripción:", $f->campos['descripcion']);
// Filas
$f->fila["nombre"] = $f->fila($f->celdas['modulo'].$f->celdas['nombre']);
$f->fila["parametros"] = $f->fila($f->celdas['parametros']);
$f->fila["descripcion"] = $f->fila($f->celdas['descripcion']);
//Compilacion
$f->filas($f->fila['nombre']);
$f->filas($f->fila['parametros']);
$f->filas($f->fila['descripcion']);
$f->botones($f->campos['cancelar']);
$f->botones($f->campos['registrar']);
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 350, height: 300, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));

  if ($('cancelar<?php echo($transaccion); ?>')) {
    $('cancelar<?php echo($transaccion); ?>').addEvent('click', function(e) {
      MUI.closeWindow($('<?php echo($f->ventana); ?>'));
    });
  }


</script>
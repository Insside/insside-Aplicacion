<?php
$estilos = new Estilos();
$cadenas = new Cadenas();

$transaccion = @$_REQUEST['transaccion'];
$estilo = @$_REQUEST['estilo'];
$_estilo = @$_REQUEST['_estilo'];
$identidad = @$_REQUEST['identidad'];
$clase = @$_REQUEST['clase'];
$etiqueta = @$_REQUEST['etiqueta'];
$estado = @$_REQUEST['estado'];
$css['codigo'] = stripslashes(@$_REQUEST['css' . $transaccion]);
$descripcion = @$_REQUEST['descripcion'];

$css['inicial'] = strpos($css['codigo'], "{");
$css['final'] = strrpos($css['codigo'], "}");
if ($css['inicial'] > 0 && $css['final'] > 0) {
  $css['codigo'] = substr($css['codigo'], $css['inicial'] + 1, $css['final'] - $css['inicial'] - 1);
}
//$css['codigo']=$cadenas->saltos($css['codigo']);
//$css['codigo']=$cadenas->tabulados($css['codigo']);

$estilos->actualizar($estilo, "estilo", $_estilo);
$estilos->actualizar($estilo, "identidad", $identidad);
$estilos->actualizar($estilo, "clase", $clase);
$estilos->actualizar($estilo, "etiqueta", urlencode($etiqueta));
$estilos->actualizar($estilo, "estado", $estado);
$estilos->actualizar($estilo, "css", urlencode($css['codigo']));
$estilos->actualizar($estilo, "descripcion", urlencode($descripcion));
?>
<script type="text/javascript">
  //MUI.Aplicacion_Funciones('activa');
  MUI.closeWindow($('<?php echo($f->ventana); ?>'));
</script>


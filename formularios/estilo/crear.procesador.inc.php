<?php
$estilos=new Estilos();
$identidad=@$_REQUEST['identidad'];
$clase=@$_REQUEST['clase'];
$etiqueta=@$_REQUEST['etiqueta'];
$estado=@$_REQUEST['estado'];
$descripcion=@$_REQUEST['descripcion'];

$estilos->crear($identidad,$clase,urlencode($etiqueta),$estado,urlencode($descripcion));
?>

<script type="text/javascript">
  //MUI.Aplicacion_Funciones('activa');
  MUI.closeWindow($('<?php echo($f->ventana); ?>'));
</script>


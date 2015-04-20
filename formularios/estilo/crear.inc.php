<?php
$f->campos['identidad']=$f->text("identidad","",64,"");
$f->campos['clase']=$f->text("clase","",64,"");
$f->campos['etiqueta']=$f->text("etiqueta","",64,"");
$f->campos['estado']=$f->text("estado","",64,"");
$f->campos['descripcion']=$f->textarea("descripcion","","textarea",25,80,false,false,false,255);
$f->campos['registrar']=$f->button("registrar".$transaccion,"submit","Registrar");
$f->campos['cancelar']=$f->button("cancelar".$transaccion,"button","Cancelar");
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
$f->botones($f->campos['cancelar']);
$f->botones($f->campos['registrar']);
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 640, height: 250, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));
</script>
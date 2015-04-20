<?php
$f->campos['nombre']=$f->text("nombre".$transaccion,"",64,"required");
$f->campos['buscar']=$f->button("buscar".$transaccion,"button","Buscar / Filtrar");
// Celdas
$f->celdas['nombre']=$f->celda("Nombre Función:",$f->campos['nombre']);
// Filas
$f->fila["nombre"]=$f->fila($f->celdas['nombre']);
//Compilacion
$f->filas($f->fila['nombre']);
$f->botones($f->campos['buscar']);
?>
<script type="text/javascript">
  if ($('buscar<?php echo($transaccion); ?>')) {
    $('buscar<?php echo($transaccion); ?>').addEvent('click', function(e) {
      MUI.Aplicacion_Funciones_Busqueda($('nombre<?php echo($transaccion); ?>').value);
    });
  }
</script>
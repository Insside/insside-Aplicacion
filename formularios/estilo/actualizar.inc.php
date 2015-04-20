<?php
$estilos=new Estilos();
$estilo=$estilos->consultar($_REQUEST['estilo']);

$f->oculto('estilo',$estilo['estilo']);
$f->oculto('css'.$transaccion,urldecode($estilo['css']));
$f->oculto('transaccion',$transaccion);
$f->campos['estilo']=$f->text("_estilo",$estilo['estilo'],64,"codigo");
$f->campos['identidad']=$f->text("identidad",$estilo['identidad'],64,"");
$f->campos['clase']=$f->text("clase",$estilo['clase'],64,"");
$f->campos['etiqueta']=$f->text("etiqueta",urldecode($estilo['etiqueta']),64,"");
$f->campos['estado']=$f->text("estado",$estilo['estado'],64,"");
$f->campos['descripcion']=$f->textarea("descripcion",$estilo['descripcion'],"textarea",25,80,false,false,false,255);
$f->campos['registrar']=$f->button("registrar".$transaccion,"submit","Actualizar");
$f->campos['cancelar']=$f->button("cancelar".$transaccion,"button","Cancelar");
// Celdas
$f->celdas['estilo']=$f->celda("Codigo (Estilo):",$f->campos['estilo']);
$f->celdas['identidad']=$f->celda("Identidad (ID):",$f->campos['identidad']);
$f->celdas['clase']=$f->celda("Clase (CLASS):",$f->campos['clase']);
$f->celdas['etiqueta']=$f->celda("Etiqueta (HTML):",$f->campos['etiqueta']);
$f->celdas['estado']=$f->celda("Estado:",$f->campos['estado']);
$f->celdas['descripcion']=$f->celda("Descripción:",$f->campos['descripcion']);
// Filas
$f->fila["elementos"]=$f->fila($f->celdas['estilo'].$f->celdas['identidad'].$f->celdas['clase'].$f->celdas['etiqueta'].$f->celdas['estado']);
$f->fila["descripcion"]=$f->fila($f->celdas['descripcion']);


$codigo="";
$codigo.=(!empty($estilo['identidad'])?" #".$estilo['identidad']:"")."";
$codigo.=(!empty($estilo['clase'])?" .".$estilo['clase']:"")."";
$codigo.=(!empty($estilo['etiqueta'])?" ".urldecode($estilo['etiqueta']):"");
$codigo.="{".(urldecode($estilo['css']))."}";
$codigo=str_replace("{","{\r",$codigo);
$codigo=str_replace(";",";\r",$codigo);
$f->fila["descripcion2"]="<pre id=\"editor".$transaccion."\">".$codigo."</pre>";

//Compilacion
$f->filas($f->fila['elementos']);
$f->filas($f->fila['descripcion2']);
$f->botones($f->campos['cancelar']);
$f->botones($f->campos['registrar']);
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 640, height: 350, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));
  var editor<?php echo($transaccion) ?> = ace.edit("editor<?php echo($transaccion) ?>");
  editor<?php echo($transaccion) ?>.setTheme("ace/theme/clouds");
  editor<?php echo($transaccion) ?>.getSession().setMode("ace/mode/css");

  if ($('<?php echo($f->id); ?>')) {
    $('<?php echo($f->id); ?>').addEvent('submit', function(e) {
      console.log('iMIS: Enviando formulario [id]=<?php echo($f->id); ?>');
      e.stop();
      $('css<?php echo($transaccion) ?>').value = editor<?php echo($transaccion) ?>.getValue();
      this.set('send', {
        onSuccess: function(html) {
        },
        onFailure: function(xhr) {
        }
      });
    }).send();
  }


  if ($('cancelar<?php echo($transaccion); ?>')) {
    $('cancelar<?php echo($transaccion); ?>').addEvent('click', function(e) {
      MUI.closeWindow($('<?php echo($f->ventana); ?>'));
    });
  }









</script>




<style type="text/css" media="screen">
  #editor<?php echo($transaccion) ?> {
    margin: 0;
    position: relative;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 200px;
  }
</style>
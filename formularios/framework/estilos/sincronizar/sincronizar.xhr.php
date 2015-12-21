<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$v = new Validaciones();
$transaccion = $v->recibir("transaccion");
$clase=$v->recibir("clase");
?>
<div id="diviSynchrony" class="iSynchrony"></div>
<script>
  var synchrony = new iSynchrony($("diviSynchrony"), {
    'debug': true,
    'url': 'modulos/aplicacion/formularios/framework/estilos/sincronizar/sincronizar.json.php?clase=<?php echo($clase);?>'
  });
</script>
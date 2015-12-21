<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$v = new Validaciones();
$transaccion = $v->recibir("transaccion");
$funcion=$v->recibir("funcion");
?>
<style>
  .synchrony{width: 100%;border-style: outset;border: 1px solid #cccccc;}
  .synchrony .header{font-weight: bold;text-align: center; text-transform:capitalize;}
  .synchrony .row{display: table-row;border: 1px solid #cccccc;}
  .synchrony .column {
    display: table-cell;
    border: 1px solid #cccccc;
    padding-left: 4px;
    padding-right:4px;
    float: none;
  }
</style>
<div id="synchrony" class="synchrony"></div>

<script>
  var synchrony = new iSynchrony($("synchrony"), {
    'debug': true,
    'url': 'modulos/aplicacion/formularios/framework/codigos/sincronizar/sincronizar.json.php?funcion=<?php echo($funcion);?>'
  });
</script>
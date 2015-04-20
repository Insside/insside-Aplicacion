<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root . "modulos/solicitudes/librerias/Configuracion.cnf.php");
$sesion = new Sesion();
$validaciones = new Validaciones();
$funciones=new Aplicacion_Framework_Funciones();
$clases=new Aplicacion_Framework_Clases();


$transaccion = $validaciones->recibir('transaccion');
$estado = $validaciones->recibir('estado');
$buscar = $validaciones->recibir('buscar');
$funcion=$funciones->consultar($validaciones->recibir('funcion'));
$clase=$clases->consultar($funcion['clase']);

$ruta = "modulos/aplicacion/formularios/framework/codigos/consultar/consultar.json.php";
$datos = "?transaccion=" . $transaccion . "&buscar=" . $buscar . "&estado=" . $estado . "&funcion=" . $funcion['funcion'];
$url = $ruta . $datos;
$itable="itablecodigos";
?>
<script type="text/javascript"> 
  function filtrar<?php echo($transaccion); ?>() {<?php echo($itable);?>.filter($('filter').value);}
  function desfiltrar<?php echo($transaccion); ?>() {<?php echo($itable);?>.clearFilter();}
  function seleccion_Click<?php echo($transaccion); ?>(evt) {var str = 'row: ' + evt.row + ' indices: ' + evt.indices;str += ' id: ' + evt.target.getDataByRow(evt.row).id;}
  function buscar_Click<?php echo($transaccion); ?>(button, grid) {MUI.Aplicacion_Componentes_Busqueda();}
  function imprimir_Click<?php echo($transaccion); ?>(button, grid) {}
  function explorar_Click<?php echo($transaccion); ?>(button, grid) {var indices = <?php echo($itable);?>.getSelectedIndices();if (indices.length == 0) {return;}for (var i = 0; i < indices.length; i++) {var funcion= <?php echo($itable);?>.getDataByRow(indices[i]).funcion;MUI.Aplicacion_Framework_Clase_Consultar(funcion);}}
  function editar_Click<?php echo($transaccion); ?>(button, grid) {var indices = <?php echo($itable);?>.getSelectedIndices();if (indices.length == 0) {return;}for (var i = 0; i < indices.length; i++) {var funcion= <?php echo($itable);?>.getDataByRow(indices[i]).funcion;MUI.Aplicacion_Framework_Funcion_Actualizar(funcion);}}
  function crear_Click<?php echo($transaccion); ?>(button, grid) {MUI.Aplicacion_Framework_Codigo_Crear('<?php echo($funcion['funcion']); ?>');}
  function eliminar_Click<?php echo($transaccion); ?>(button, grid) {var indices = <?php echo($itable);?>.getSelectedIndices();if (indices.length == 0) {return;}for (var i = 0; i < indices.length; i++) {var codigo= <?php echo($itable);?>.getDataByRow(indices[i]).codigo;MUI.Aplicacion_Framework_Codigo_Eliminar(codigo);}}

  var cmu = [
    {header: "Código", dataIndex: 'codigo', dataType: 'string', align: 'center', width: 75},
    {header: "Función", dataIndex: 'funcion', dataType: 'string', align: 'center', width: 75},
    {header: "Versión", dataIndex: 'version', dataType: 'string', align: 'center', width:50},
    {header: "Descripción", dataIndex: 'descripcion', dataType: 'string', width: 400},
    {header: "Fecha", dataIndex: 'fecha', dataType: 'date', width: 70},
    {header: "Hora", dataIndex: 'hora', dataType: 'string', width: 55}
  ];
  window.addEvent("domready", function() {
    <?php echo($itable);?> = new iTable('<?php echo($itable);?><?php echo($transaccion); ?>', {
      columnModel: cmu,
      buttons: [
        {name: 'Agregar', bclass: 'pNuevo', onclick: crear_Click<?php echo($transaccion); ?>},
        {name: 'Eliminar', bclass: 'pEliminar', onclick: eliminar_Click<?php echo($transaccion); ?>}
      ],
      url: "<?php echo($url); ?>",
      perPageOptions: [500, 1000, 1500, 2000],
      perPage: 500,
      page: 1,
      pagination: true,
      serverSort: true,
      showHeader: true,
      alternaterows: true,
      sortHeader: false,
      resizeColumns: true,
      multipleSelection: true,
      width: $('central').getSize().x,
      height: $('central').getSize().y
    });

    <?php echo($itable);?>.addEvent('click', seleccion_Click<?php echo($transaccion); ?>);
    MUI.titlePanel($('central'),"<span style=\"color:#004080;\">Insside Framework JavaScript</span> / <span style=\"color:#008000;\">MUI.<?php echo($clase['nombre']);?></span> /  <span style=\"color:#FF0000;\"><?php echo($funcion['nombre']."(".$funcion['parametros'].")");?></span>");
  });
</script>
<div id="<?php echo($itable);?><?php echo($transaccion); ?>" style="width:100%" ></div>
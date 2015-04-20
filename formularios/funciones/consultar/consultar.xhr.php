<?php
/** Variables Recibidas * */
$transaccion = @$_REQUEST['transaccion'];
$estado = @$_REQUEST['estado'];
$buscar = @$_REQUEST['buscar'];
?>
<script type="text/javascript" src="plugins/iTable/iTable.js?<?php echo(time()); ?>"></script>
<script type="text/javascript">
  function filterGrid() {
    itable.filter($('filter').value);
  }
  function clearFilter() {
    itable.clearFilter();
  }
  function onGridSelect(evt) {
    var str = 'row: ' + evt.row + ' indices: ' + evt.indices;
    str += ' id: ' + evt.target.getDataByRow(evt.row).id;
  }
  function buscarClick(button, grid) {
    parent.MUI.Suscriptores_Buscar('');
  }
  function imprimirClick(button, grid) {
    //MUI.Distribucion_Instalaciones_Imprimir();
  }

  var cmu = [
    {header: "Funcion", dataIndex: 'funcion', dataType: 'string', width: 80},
    {header: "Detalles", dataIndex: 'detalle', dataType: 'string', width: 550},
    {header: "Versión", dataIndex: 'version', dataType: 'string', width: 95},
    {header: "<a href=\"#\" onClick=\"parent.MUI.Notificacion('Creador');\">C</a>", dataIndex: 'creador', dataType: 'string', width: 33}
  ];

  window.addEvent("domready", function() {
    //$('filterbt').addEvent("click", filterGrid);
    //$('clearfilterbt').addEvent("click", clearFilter);

    itable = new iTable('mygrid', {
      columnModel: cmu,
      buttons: [
        {name: 'Agregar', bclass: 'pNuevo', onclick: MUI.Aplicacion_Funcion_Crear},
        {name: 'Buscar', bclass: 'pBuscar', onclick: MUI.Aplicacion_Busqueda_Funciones}
        //{name: 'Delete', bclass: 'delete', onclick: buscarClick}
        //{separator: true},
        // {name: 'Duplicate', bclass: 'duplicate', onclick: gridButtonClick}
      ],
      url: "modulos/aplicacion/formularios/funciones/consultar/consultar.json.php?transaccion=<?php echo($transaccion); ?>&buscar=<?php echo($buscar); ?>&estado=<?php echo($estado); ?>",
      perPageOptions: [250,500,1000,2000],
      perPage: 250,
      page: 1,
      pagination: true,
      serverSort: true,
      showHeader: true,
      alternaterows: true,
      sortHeader: false,
      resizeColumns: true,
      multipleSelection: true,
      // uncomment this if you want accordion behavior for every row
      /*
       accordion:true,
       accordionRenderer:accordionFunction,
       autoSectionToggle:false,
       */

      width: $('central').getSize().x,
      height: $('central').getSize().y
    });

    itable.addEvent('click', onGridSelect);
  });
</script>
<div id="mygrid" style="width:100%" ></div>
<script type="text/javascript">
  // Estas funciones son invocadas desde la barra de tareas
  function tBuscar(texto) {
    MUI.Suscriptores_Solicitudes_Buscar(texto);
    return(false);
  }
</script>
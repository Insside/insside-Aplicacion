<?php
/** Variables Recibidas * */
$transaccion = @$_REQUEST['transaccion'];
$estado = @$_REQUEST['estado'];
$buscar = @$_REQUEST['buscar'];
?>
<script type="text/javascript">
  function filterGrid() {
    datagrid.filter($('filter').value);
  }
  function clearFilter() {
    datagrid.clearFilter();
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
    {header: "Modulo", dataIndex: 'modulo', dataType: 'string', align: 'right', width: 80},
    {header: "Nombre", dataIndex: 'nombre', dataType: 'string', width: 150},
    {header: "Titulo", dataIndex: 'titulo', dataType: 'string', width: 200}
  ];

  window.addEvent("domready", function() {
    //$('filterbt').addEvent("click", filterGrid);
    //$('clearfilterbt').addEvent("click", clearFilter);

    datagrid = new iTable('mygrid', {
      columnModel: cmu,
      buttons: [
        //{name: 'Agregar', bclass: 'pNuevo', onclick: MUI.Aplicacion_Estilos_Crear},
        //{name: 'Buscar', bclass: 'pBuscar', onclick: MUI.Aplicacion_Estilos_Busqueda}
        //{name: 'Delete', bclass: 'delete', onclick: buscarClick}
        //{separator: true},
        // {name: 'Duplicate', bclass: 'duplicate', onclick: gridButtonClick}
      ],
      url: "modulos/aplicacion/consultas/modulos/modulos.json.php?transaccion=<?php echo($transaccion); ?>&buscar=<?php echo($buscar); ?>&estado=<?php echo($estado); ?>",
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
      // uncomment this if you want accordion behavior for every row
      /*
       accordion:true,
       accordionRenderer:accordionFunction,
       autoSectionToggle:false,
       */

      width: $('central').getSize().x,
      height: $('central').getSize().y
    });

    datagrid.addEvent('click', onGridSelect);
  });
</script>
<div id="mygrid" style="width:100%" ></div>
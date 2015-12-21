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
  var cmu = [
    {header: "Equipo", dataIndex: 'equipo', dataType: 'number', width: 75},
    {header: "Nombre", dataIndex: 'nombre', dataType: 'string', width: 100},
    {header: "Descripción", dataIndex: 'descripcion', dataType: 'string', width: 300},
    {header: "Fecha", dataIndex: 'fecha', dataType: 'string', width: 75},
    {header: "Hora", dataIndex: 'hora', dataType: 'string', width: 75},
    {header: "<a href=\"#\" onClick=\"parent.MUI.Notificacion('Creador');\">C</a>", dataIndex: 'creador', dataType: 'string', width: 33}
  ];
  window.addEvent("domready", function() {
    //$('filterbt').addEvent("click", filterGrid);
    //$('clearfilterbt').addEvent("click", clearFilter);
    datagrid = new iTable('mygrid', {
      columnModel: cmu,
      buttons: [
        //{name: 'Buscar', bclass: 'pBuscar', onclick: MUI.Suscriptores_Complementos_Buscador}
        //{separator: true},
        // {name: 'Duplicate', bclass: 'duplicate', onclick: gridButtonClick}
      ],
      url: "modulos/usuarios/consultas/jsons/equipos.json.php?criterio=<?php echo(@$_REQUEST['criterio']); ?>&buscar=<?php echo(@$_REQUEST['buscar']); ?>",
      perPageOptions: [50, 100, 200, 400, 800],
      perPage: 50,
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
              //$('mygrid').setSize($('central').getSize().x,$('central').getSize().y);
    });

    datagrid.addEvent('click', onGridSelect);
  });
</script>
<div id="mygrid" style="width:100%" ></div>
<script type="text/javascript">
  // Estas funciones son invocadas desde la barra de tareas
  function tBuscar(texto) {
    MUI.Suscriptores_Buscar(texto);
    return(false);
  }
</script>


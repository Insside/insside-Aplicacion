<html> <head>  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">  <link rel="stylesheet" media="screen" href="../../../plugins/iTable/iTable.css" type="text/css" />  <script type="text/javascript" src="../../../scripts/mootools-core-1.4.5-full-nocompat.js"></script>  <script type="text/javascript" src="../../../scripts/mootools-more-1.4.0.1.js"></script>  <script type="text/javascript" src="../../../plugins/iTable/iTable.js"></script>  <script type="text/javascript">   function filterGrid() {    datagrid.filter($('filter').value);   }   function clearFilter() {    datagrid.clearFilter();   }   function onGridSelect(evt) {    var str = 'row: ' + evt.row + ' indices: ' + evt.indices;    str += ' id: ' + evt.target.getDataByRow(evt.row).id;   }   function buscarClick(button, grid) {    alert("BUSCA");    //parent.MUI.Suscriptores_Buscar('');   }   var cmu = [    {     header: "Formulario",     dataIndex: 'formulario',     dataType: 'number',     width: 95    },    {     header: "Nombre",     dataIndex: 'nombre',     dataType: 'string',     width: 200    },    {     header: "Descripción",     dataIndex: 'descripcion',     dataType: 'string',     width: 300    },    {     header: "Fecha",     dataIndex: 'fecha',     dataType: 'string',     width: 90    },    {     header: "Hora",     dataIndex: 'hora',     dataType: 'string',     width: 75    }   ];   window.addEvent("domready", function() {    //$('filterbt').addEvent("click", filterGrid);    //$('clearfilterbt').addEvent("click", clearFilter);    datagrid =new iTable('mygrid', {     columnModel: cmu,     buttons: [      //{name: 'Buscar', bclass: 'magnifier', onclick: buscarClick},      //{name: 'Delete', bclass: 'delete', onclick: buscarClick}      //{separator: true},      // {name: 'Duplicate', bclass: 'duplicate', onclick: gridButtonClick}     ],     url: "../jsons/formularios.json.php?buscar=<?php  echo(@$_REQUEST['buscar']); ?>",     perPageOptions: [15, 30, 60, 120, 240],     perPage: 25,     page: 1,     pagination: true,     serverSort: true,     showHeader: true,     alternaterows: true,     sortHeader: false,     resizeColumns: true,     multipleSelection: true,     // uncomment this if you want accordion behavior for every row     /*      accordion:true,      accordionRenderer:accordionFunction,      autoSectionToggle:false,      */     width: '100%',     height: document.body.clientHeight    });    datagrid.addEvent('click', onGridSelect);   });  </script> </head> <body>  <div id="mygrid" style="width:100%" ></div>  <script type="text/javascript">   // Estas funciones son invocadas desde la barra de tareas   function tBuscar(texto) {    MUI.Suscriptores_Buscar(texto);    return(false);   }  </script> </body></html>
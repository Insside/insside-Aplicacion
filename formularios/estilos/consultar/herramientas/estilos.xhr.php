<?php
$root = (!isset($root)) ? "../../../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$validaciones = new Validaciones();
$funciones = new Aplicacion_Framework_Funciones();
/*
  /**
 * Esta herramienta solo proveera un boton para regresar a la clase raiz de la cual emanal las 
 * funciones observadas en la tabla.
 */
?>
<div class="toolbox divider">
  <a href="#" onClick="MUI.Aplicacion_Framework_Estilos();"><img src="imagenes/16x16/retroceder.png" class="icon16"/></a>
  <a href="#" onClick="MUI.Aplicacion_Framework_Estilos_Sincronizar('<?php echo($_REQUEST["clase"]);?>');"><img src="imagenes/016x016/upload.png" class="icon16"/></a>
</div>
<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
Sesion::init();
/** Librerias del Modulo **/
require_once($root."modulos/aplicacion/librerias/Aplicacion_Usuarios.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Permisos.class.php");
require_once($root."modulos/aplicacion/librerias/Funciones.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Estilos.class.php");
require_once($root."modulos/aplicacion/librerias/Estructuras.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Menus.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Framework_Funciones.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Framework_Clases.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Framework_Estilos.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Framework_Codigos.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Modulos.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Modulos_Componentes.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Permisos.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion_Usuarios.class.php");
require_once($root."modulos/aplicacion/librerias/Aplicacion.class.php");

?>
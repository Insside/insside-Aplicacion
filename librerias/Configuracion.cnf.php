<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
// Librerias Modulo Aplicación
require_once($root . "modulos/aplicacion/librerias/Aplicacion.class.php");
require_once($root . "modulos/aplicacion/librerias/Funciones.class.php");
require_once($root . "modulos/aplicacion/librerias/Estilos.class.php");
require_once($root . "modulos/aplicacion/librerias/Estructuras.class.php");
require_once($root . "modulos/aplicacion/librerias/Menus.class.php");
require_once($root . "modulos/aplicacion/librerias/Aplicacion_Framework_Clases.class.php");
require_once($root . "modulos/aplicacion/librerias/Aplicacion_Framework_Funciones.class.php");
require_once($root . "modulos/aplicacion/librerias/Aplicacion_Framework_Codigos.class.php");
require_once($root . "modulos/aplicacion/librerias/Aplicacion_Modulos_Componentes.class.php");
// Otros Modulos
require_once($root . "modulos/usuarios/librerias/Permisos.class.php");
require_once($root . "modulos/usuarios/librerias/Usuarios.class.php");
?>
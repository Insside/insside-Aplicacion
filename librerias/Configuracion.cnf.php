<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Configuracion.cnf.php");
Sesion::init();
/** Librerias Complementarias **/
if(!class_exists('Fechas')) {require_once($root."librerias/Fechas.class.php");}
if(!class_exists('Usuarios')) {require_once($root."modulos/usuarios/librerias/Usuarios.class.php");}
if(!class_exists('Permisos')) {require_once($root."modulos/usuarios/librerias/Permisos.class.php");}
/** Librerias del Modulo **/
$directorio=$root."modulos/aplicacion/librerias/";
if(!class_exists('Aplicacion_Usuarios')) {require_once($directorio."Aplicacion_Usuarios.class.php");}
if(!class_exists('Aplicacion_Permisos')) {require_once($directorio."Aplicacion_Permisos.class.php");}
if(!class_exists('Funciones')) {require_once($directorio."Funciones.class.php");}
if(!class_exists('Estilos')) {require_once($directorio."Estilos.class.php");}
if(!class_exists('Estructuras')) {require_once($directorio."Estructuras.class.php");}
if(!class_exists('Menus')) {require_once($directorio."Menus.class.php");}
if(!class_exists('Aplicacion_Framework_Clases')) {require_once($directorio."Aplicacion_Framework_Clases.class.php");}
if(!class_exists('Aplicacion_Framework_Funciones')) {require_once($directorio."Aplicacion_Framework_Funciones.class.php");}
if(!class_exists('Aplicacion_Framework_Codigos')) {require_once($directorio."Aplicacion_Framework_Codigos.class.php");}
if(!class_exists('Aplicacion_Modulos')) {require_once($directorio."Aplicacion_Modulos.class.php");}
if(!class_exists('Aplicacion_Modulos_Componentes')) {require_once($directorio."Aplicacion_Modulos_Componentes.class.php");}
if(!class_exists('Aplicacion')) {require_once($directorio."Aplicacion.class.php");}
?>
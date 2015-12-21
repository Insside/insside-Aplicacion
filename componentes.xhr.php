<?php
$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
Sesion::init();
$usuario=Sesion::usuario();

$menus = new Aplicacion_Menus();
echo($menus->menu("0000009000",$usuario['usuario']));

?>
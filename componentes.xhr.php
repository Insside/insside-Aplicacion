<?php

$root = (!isset($root)) ? "../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

$menus = new Menus();
echo($menus->menu("0000009000"));

?>
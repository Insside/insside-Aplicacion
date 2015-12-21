<?php
/**
 * Este archivo recibe el nombre del archivo a eliminar y realiza la accion si valoraciones adiciones su
 * proceso implica dos acciones eliminar el registro de la base de datos y eliminar fisicamente el archivo
 * */

$itable=$validaciones->recibir("itable");
$clase=$validaciones->recibir("clase");
$afc=new Aplicacion_Framework_Clases();
$afc->eliminar($clase); 
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
$f->JavaScript("if(".$itable."){".$itable.".refresh();}");
?>
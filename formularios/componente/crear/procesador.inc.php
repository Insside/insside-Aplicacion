<?php
$validaciones=new Validaciones();
$datos['componente']=$validaciones->recibir('componente');
$datos['herencia']=$validaciones->recibir('herencia');
$datos['titulo']=$validaciones->recibir('titulo');
$datos['descripcion']=$validaciones->recibir('descripcion');
$datos['funcion']=$validaciones->recibir('funcion');
$datos['icono']=$validaciones->recibir('icono');
$datos['peso']=$validaciones->recibir('peso');
$datos['estado']=$validaciones->recibir('estado');
$datos['permiso']=$validaciones->recibir('permiso');
$datos['fecha']=$validaciones->recibir('fecha');
$datos['hora']=$validaciones->recibir('hora');
$datos['creador']=$validaciones->recibir('creador');
$componentes= new Aplicacion_Modulos_Componentes();
$componentes->crear($datos);
/** JavScripts **/
$f->JavaScript("if(itable_componentes){itable_componentes.refresh();}");
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
?>
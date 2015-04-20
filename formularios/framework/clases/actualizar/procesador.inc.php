<?php

/* 
 * Copyright (c) 2014, Alexis
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */
/** procesador.inc.php Codigo fuente archivo procesador **/
$cadenas = new Cadenas();
$fechas = new Fechas();
$validaciones = new Validaciones();
$clases=new Aplicacion_Framework_Clases();
/** Clase representativa Del Objeto **/
/** Campos Recibidos **/
$datos=array();
$datos['clase']=$validaciones->recibir("clase");
$datos['implements']=$validaciones->recibir("implements");
$datos['extends']=$validaciones->recibir("extends");
$datos['nombre']=$validaciones->recibir("nombre");
$datos['descripcion']=$validaciones->recibir("descripcion");
$datos['fecha']=$validaciones->recibir("fecha");
$datos['hora']=$validaciones->recibir("hora");
$datos['creador']=$validaciones->recibir("creador");
$clases->actualizar($datos['clase'],"implements",$datos['implements']);
$clases->actualizar($datos['clase'],"extends",$datos['extends']);
$clases->actualizar($datos['clase'],"nombre",$datos['nombre']);
$clases->actualizar($datos['clase'],"descripcion",$datos['descripcion']);
/** JavaScripts **/
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
$f->JavaScript("if(itableclases){itableclases.refresh();}");
?>

<?php
require_once($root . "librerias/soap/nusoap.php");
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
$v = new Validaciones();
$afc=new Aplicacion_Framework_Clases();
/** Campos Recibidos **/
$itable=$v->recibir("itable");
$datos=array();
$datos['clase']=$v->recibir("clase");
$datos['implements']=$v->recibir("implements");
$datos['extends']=$v->recibir("extends");
$datos['nombre']=$v->recibir("nombre");
$datos['descripcion']=$v->recibir("descripcion");
$datos['fecha']=$v->recibir("fecha");
$datos['hora']=$v->recibir("hora");
$datos['creador']=$v->recibir("creador");
$afc->actualizar($datos['clase'],"implements",$datos['implements']);
$afc->actualizar($datos['clase'],"extends",$datos['extends']);
$afc->actualizar($datos['clase'],"nombre",$datos['nombre']);
$afc->actualizar($datos['clase'],"descripcion",$datos['descripcion']);
$afc->actualizar($datos['clase'],"fecha",$fechas->hoy());
$afc->actualizar($datos['clase'],"hora",$fechas->ahora());
/** Sincronización con remoto **/
require_once($root."modulos/aplicacion/formularios/framework/clase/modificar/sincronizador.inc.php");
/** JavaScripts **/
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
$f->JavaScript("if(".$itable."){".$itable.".refresh();}");
?>

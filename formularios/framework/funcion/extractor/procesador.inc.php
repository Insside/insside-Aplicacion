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
/** procesador.inc.php Codigo fuente archivo procesador **/
$cadenas = new Cadenas();
$fechas = new Fechas();
$v = new Validaciones();

/** Campos Recibidos **/
$itable=$v->recibir("itable");
$clase=$v->recibir("clase");
$code=$v->recibir("codigo");
/** Procesando los datos **/
$separador=strpos(":", $code);
$nombre=$cadenas->antesde(":",$code);
$parametros=$cadenas->entre("(",")", $code);
$contenido=$cadenas->entreelprimeryultimo("{","},", $code);
//echo("<br>Nombre: ".$nombre."<br>");
//echo("<br>Parametros: ".$parametros."<br>");
//echo("<br>Contenido: ".$contenido."<br>");
$funcion=array();
$funcion['funcion']=$v->recibir("funcion");
$funcion['nombre']=$nombre;
$funcion['parametros']=$parametros;
$funcion['descripcion']="";
$funcion['clase']=$v->recibir("clase");
$funcion['fecha']=$fechas->hoy();
$funcion['hora']=$fechas->ahora();
$funcion['creador']=$v->recibir("creador");
$aff=new Aplicacion_Framework_Funciones();
$aff->crear($funcion);
/** Crear el codigo **/
$codigo=array();
$codigo['codigo']=time();
$codigo['funcion']=$funcion['funcion'];
$codigo['contenido']= urlencode(stripslashes($contenido));
$codigo['descripcion']="";
$codigo['version']="0.0";
$codigo['fecha']=$fechas->hoy();
$codigo['hora']=$fechas->ahora();
$afc=new Aplicacion_Framework_Codigos();
$afc->crear($codigo);
require_once($root."modulos/aplicacion/formularios/framework/funcion/extractor/sincronizador.inc.php");
/** JavaScripts **/
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
$f->JavaScript("if(".$itable."){".$itable.".refresh();}");
?>
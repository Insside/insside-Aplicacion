<?php

$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
require_once($root . "librerias/soap/nusoap.php");
$validaciones = new Validaciones();
$configuraciones = new Configuraciones();
$fechas = new Fechas();
$funciones = new Funciones();
/*
 * Copyright (c) 2013, Alexis
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
$funcion = $funciones->consultar($validaciones->recibir('funcion'));
$modulo = $validaciones->recibir('modulo');
$nombre = $validaciones->recibir('nombre');
$parametros = $validaciones->recibir('parametros');
$cuerpo = stripslashes($validaciones->recibir('codigo' . $f->id));
$descripcion = $validaciones->recibir('descripcion');
$estado = $validaciones->recibir('estado');
$version = $funcion['version'] + 0.001;
$modificacion = $fechas->hoy();
$log = "";

if (!empty($modulo)) {
  $funciones->actualizar($funcion['funcion'], 'modulo', $modulo);
}
if (!empty($nombre)) {
  $funciones->actualizar($funcion['funcion'], 'nombre', $nombre);
}
$funciones->actualizar($funcion['funcion'], 'parametros', $parametros);
if (!empty($cuerpo)) {
  $funciones->actualizar($funcion['funcion'], 'cuerpo', (urlencode($cuerpo)));
}
if (!empty($descripcion)) {
  $funciones->actualizar($funcion['funcion'], 'descripcion', $descripcion);
}
$funciones->actualizar($funcion['funcion'], 'version', $version);
$funciones->actualizar($funcion['funcion'], 'modificacion', $modificacion);
// Sincronización
if ($configuraciones->modo == "desarrollo") {
  $tfuncion = $funciones->consultar($funcion['funcion']);
  $cliente = new nusoap_client("http://" . $configuraciones->intranet . "/agb/sincronizacion.php");
  $error = $cliente->getError();
  $result = $cliente->call("funcion", array("funcion" => $tfuncion));
  $log = "Modo desarrollo: Sincronizando Actualizacion.".$error;
}



//echo("<pre style=\"font-size:10px; line-height:8px;\">");
//print_r($_REQUEST);
//echo("</pre>");
$f->JavaScript("console.log('" . $log . "');");
$f->JavaScript("if(itable){itable.refresh();}");
$f->JavaScript("MUI.closeWindow($('" . ($f->ventana) . "'));");
?>
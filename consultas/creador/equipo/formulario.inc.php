<?php
$empleados = new Empleados();
$usuarios = new Usuarios();
$equipos=new Usuarios_Equiposs();
/** Variables Recibidas **/
$transaccion=$validaciones->recibir("transaccion");
$usuario=$usuarios->consultar($validaciones->recibir("usuario"));
$equipo=$equipos->consultar($usuario['equipo']);
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
/** Variables **/
/** Valores **/
$valores=$equipo;
/** Campos **/
$f->campos['equipo']=$f->campo("equipo",$valores['equipo']);
$f->campos['nombre']=$f->campo("nombre",$valores['nombre']);
$f->campos['descripcion']=$f->campo("descripcion",$valores['descripcion']);
$f->campos['creador']=$f->campo("creador",$valores['creador']);
$f->campos['fecha']=$f->campo("fecha",$valores['fecha']);
$f->campos['hora']=$f->campo("hora",$valores['hora']);
$f->campos['cerrar']=$f->button("cerrar".$f->id,"button","Cerrar");
$f->campos['actualizar']=$f->button("actualizar".$f->id,"button","Actualizar");
/** Celdas **/
$f->celdas["equipo"] = $f->celda("Equipo:", $f->campos['equipo']);
$f->celdas["nombre"] = $f->celda("Nombre:", $f->campos['nombre']);
$f->celdas["descripcion"] = $f->celda("Descripcion:", $f->campos['descripcion']);
$f->celdas["creador"] = $f->celda("Creador:", $f->campos['creador']);
$f->celdas["fecha"] = $f->celda("Fecha:", $f->campos['fecha']);
$f->celdas["hora"] = $f->celda("Hora:", $f->campos['hora']);
/** Filas **/
$f->fila["fila1"] = $f->fila($f->celdas["equipo"].$f->celdas["nombre"]);
$f->fila["fila2"] = $f->fila($f->celdas["descripcion"]);
$f->fila["fila3"] = $f->fila($f->celdas["creador"].$f->celdas["fecha"].$f->celdas["hora"]);
/** Compilando **/
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
//$f->botones($f->campos["cerrar"]);
//$f->botones($f->campos["actualizar"]);
/** JavaScripts **/
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 540, height: 295});");
//$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
?>
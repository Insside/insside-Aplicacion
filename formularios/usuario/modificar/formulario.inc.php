<?php
/** Variables **/
$sesion=new Sesion();
$cadenas = new Cadenas();
$fechas = new Fechas();
$validaciones = new Validaciones();
$empleados=new Empleados();
$equipos=new Usuarios_Equiposs();
$usuarios=new Usuarios();

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

/** Valores **/
$usuario=$usuarios->consultar($validaciones->recibir("usuario"));
$valores=$usuario;
$itable=$validaciones->recibir("itable");
/** Campos **/
$f->oculto("itable",$itable); 
$f->campos['usuario']=$f->text("usuario",$valores['usuario'], "15","required codigo", true);
$f->campos['empleado']=$empleados->combo("empleado",$valores['empleado']);
$f->campos['alias']=$f->text("alias",$valores['alias'], "64","required", false);
$f->campos['clave']=$f->clave("clave",$valores['clave'], "64","required", false);
$f->campos['equipo']=$equipos->combo("equipo",$valores['equipo']);
$f->campos['fecha']=$f->text("fecha",$valores['fecha'], "10","required automatico", true);
$f->campos['hora']=$f->text("hora",$valores['hora'], "8","required automatico", true);
$f->campos['creador']=$f->text("creador",$valores['creador'], "10","required automatico", true);
$f->campos['ayuda'] = $f->button("ayuda" . $f->id, "button","Ayuda");
$f->campos['estado'] =$usuarios->combo_estado("estado",$valores['estado'],"");
$f->campos['roles'] = $f->button("roles" . $f->id, "button","Roles");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button","Cancelar");
$f->campos['continuar'] = $f->button("continuar" . $f->id, "submit","Modificar");
/** Celdas **/
$f->celdas["usuario"] = $f->celda("Código de Usuario:", $f->campos['usuario']);
$f->celdas["empleado"] = $f->celda("Perfil de Empleado:", $f->campos['empleado']);
$f->celdas["alias"] = $f->celda("Alias de Usuario:", $f->campos['alias']);
$f->celdas["clave"] = $f->celda("Clave:", $f->campos['clave']);
$f->celdas["equipo"] = $f->celda("Equipo:", $f->campos['equipo']);
$f->celdas["fecha"] = $f->celda("Fecha:", $f->campos['fecha']);
$f->celdas["hora"] = $f->celda("Hora:", $f->campos['hora']);
$f->celdas["estado"] = $f->celda("Estado:", $f->campos['estado']);
$f->celdas["creador"] = $f->celda("Creador:", $f->campos['creador']);
/** Filas **/
$f->fila["fila1"] = $f->fila($f->celdas["usuario"].$f->celdas["fecha"].$f->celdas["hora"].$f->celdas["creador"]);
$f->fila["fila2"] = $f->fila($f->celdas["empleado"]);
$f->fila["fila3"] = $f->fila($f->celdas["alias"].$f->celdas["clave"]);
$f->fila["fila4"] = $f->fila($f->celdas["equipo"]);
$f->fila["fila5"] = $f->fila($f->celdas["estado"]);
/** Compilando **/
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
$f->filas($f->fila['fila4']);
$f->filas($f->fila['fila5']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['roles'], "inferior-derecha");
$f->botones($f->campos['cancelar'], "inferior-derecha");
$f->botones($f->campos['continuar'], "inferior-derecha");
/** Javascripts **/
//MUI.Usuarios_Usuario_Roles
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Modificar Usuario\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 480, height:305});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("roles" . $f->id, "MUI.Usuarios_Usuario_Roles('".$valores['usuario']."');MUI.closeWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>

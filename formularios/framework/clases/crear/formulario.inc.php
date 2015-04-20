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

/** Variables **/
$sesion=new Sesion();
$cadenas = new Cadenas();
$fechas = new Fechas();
$paises = new Paises();
$regiones = new Regiones();
$ciudades = new Ciudades();
$sectores = new Sectores();
$validaciones = new Validaciones();
/** Valores **/
$usuario=$sesion->usuario();
$valores['clase']=time();
$valores['implements']=$validaciones->recibir("implements");
$valores['extends']=$validaciones->recibir("extends");
$valores['nombre']=$validaciones->recibir("_nombre");
$valores['descripcion']=$validaciones->recibir("_descripcion");
$valores['fecha']=$fechas->hoy();
$valores['hora']=$fechas->ahora();
$valores['creador']=$usuario['usuario'];
/** Campos **/
$f->campos['clase']=$f->text("clase",$valores['clase'],"10","required codigo",true);
$f->campos['nombre']=$f->text("nombre",$valores['nombre'],"254","required",false);
$f->campos['implements']=$f->text("implements",$valores['implements'],"254","",false);
$f->campos['extends']=$f->text("extends",$valores['extends'],"254","",false);
$f->campos['descripcion']=$f->textarea("descripcion", $valores['descripcion'], "h150 p10", "1000", "", false);
$f->campos['fecha']=$f->text("fecha",$valores['fecha'],"10","required automatico",true);
$f->campos['hora']=$f->text("hora",$valores['hora'],"8","required automatico",true);
$f->campos['creador']=$f->text("creador",$valores['creador'],"10","required automatico",true);
$f->campos['ayuda']=$f->button("ayuda".$f->id, "button","Ayuda");
$f->campos['cancelar']=$f->button("cancelar".$f->id, "button","Cancelar");
$f->campos['continuar']=$f->button("continuar".$f->id, "submit","Continuar");
/** Celdas **/
$f->celdas["clase"]=$f->celda("Clase:",$f->campos['clase']);
$f->celdas["nombre"]=$f->celda("Nombre:",$f->campos['nombre']);
$f->celdas["implements"]=$f->celda("Implements:",$f->campos['implements']);
$f->celdas["extends"]=$f->celda("Extends:",$f->campos['extends']);
$f->celdas["descripcion"]=$f->celda("Descripcion:",$f->campos['descripcion']);
$f->celdas["fecha"]=$f->celda("Fecha:",$f->campos['fecha']);
$f->celdas["hora"]=$f->celda("Hora:",$f->campos['hora']);
$f->celdas["creador"]=$f->celda("Creador:",$f->campos['creador']);
/** Filas **/
$f->fila["fila1"]=$f->fila($f->celdas["clase"].$f->celdas["fecha"].$f->celdas["hora"].$f->celdas["creador"]);
$f->fila["fila2"]=$f->fila($f->celdas["nombre"].$f->celdas["implements"].$f->celdas["extends"]);
$f->fila["fila3"]=$f->fila($f->celdas["descripcion"]);
/** Compilando **/
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['cancelar'], "inferior-derecha");
$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('".($f->ventana)."'),\"Publicar / Compartir\");");
$f->JavaScript("MUI.resizeWindow($('".($f->ventana)."'),{width:480,height:300});");
$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");$f->eClick("cancelar".$f->id,"MUI.closeWindow($('".$f->ventana."'));");

?>



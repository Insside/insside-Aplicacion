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
$cadenas = new Cadenas();
$fechas = new Fechas();
$validaciones = new Validaciones();
$codigos=new Aplicacion_Framework_Codigos();
/** Valores **/
$v['codigo']=time();
$v['funcion']=$validaciones->recibir("funcion");
$v['contenido']=$codigos->ultimo($v['funcion']);
$v['version']=$codigos->version($v['funcion']);
$v['fecha']=$fechas->hoy();
$v['hora']=$fechas->ahora();
$v['descripcion']="Actualizacion v".$v['version']." ".$v['fecha']." ".$v['hora'];
/** Campos **/
$f->oculto("itable",$validaciones ->recibir("itable"));
$f->campos['codigo']=$f->text("codigo",$v['codigo'],"10","required codigo center",true);
$f->campos['funcion']=$f->text("funcion",$v['funcion'],"10","required codigo center",true);
$f->campos['contenido']=$f->iAreaCode("contenido","javascript",$v['contenido']);
$f->campos['descripcion']=$f->text("descripcion",$v['descripcion'],"lo","",false);
$f->campos['version']=$f->text("version",$v['version'],"3","automatico",false);
$f->campos['fecha']=$f->text("fecha",$v['fecha'],"10","required automatico",true);
$f->campos['hora']=$f->text("hora",$v['hora'],"8","required automatico",true);
$f->campos['ayuda']=$f->button("ayuda".$f->id, "button","Ayuda");
$f->campos['cancelar']=$f->button("cancelar".$f->id, "button","Cancelar");
$f->campos['continuar']=$f->button("continuar".$f->id, "submit","Continuar");
/** Celdas **/
$f->celdas["codigo"]=$f->celda("Código de Referencia:",$f->campos['codigo']);
$f->celdas["funcion"]=$f->celda("Función Relacionada:",$f->campos['funcion']);
$f->celdas["contenido"]=$f->celda("Contenido:",$f->campos['contenido']);
$f->celdas["descripcion"]=$f->celda("Descripción de Versionamiento:",$f->campos['descripcion']);
$f->celdas["version"]=$f->celda("Versión:",$f->campos['version']);
$f->celdas["fecha"]=$f->celda("Fecha:",$f->campos['fecha']);
$f->celdas["hora"]=$f->celda("Hora:",$f->campos['hora']);
/** Filas **/
$f->fila["fila1"]=$f->fila($f->celdas["codigo"].$f->celdas["funcion"].$f->celdas["version"].$f->celdas["fecha"].$f->celdas["hora"]);
$f->fila["fila2"]=$f->fila($f->celdas["descripcion"]);
$f->fila["fila3"]=$f->fila($f->celdas["contenido"]);
/** Compilando **/
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
/** Botones **/
$f->botones($f->campos['ayuda'], "inferior-izquierda");
$f->botones($f->campos['cancelar'], "inferior-derecha");
$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('".($f->ventana)."'),\"Crear Código\");");
$f->JavaScript("MUI.resizeWindow($('".($f->ventana)."'),{width: 750,height:490});");
$f->JavaScript("MUI.centerWindow($('".$f->ventana."'));");$f->eClick("cancelar".$f->id,"MUI.closeWindow($('".$f->ventana."'));");

?>

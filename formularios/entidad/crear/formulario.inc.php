<?php
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

//$f = new Formulario();
$estructuras = new Estructuras();
// Campos
$f->campos['info'] = "<p>Seleccione la tabla a partir de la cual se extractara la pseudo clase. Este componente del "
        . "módulo aplicaciones tiene por objetivo agilizar el desarrollo de nuevas clases, extractando los datos "
        . "base del código para la generación automática de los mismos desde las tablas en la base de datos.</p>";
$f->campos['tabla'] = $estructuras->combo("tabla", "");
$f->campos['generar'] = $f->button("generar" . $transaccion, "submit", "Generar");
$f->campos['cancelar'] = $f->button("cancelar" . $transaccion, "button", "Cancelar");

// Celdas
$f->celdas['info'] = $f->celda("", $f->campos['info']);
$f->celdas['tabla'] = $f->celda("Tabla:", $f->campos['tabla']);
// Filas
$f->fila["info"] = $f->fila($f->celdas['info']);
$f->fila["tabla"] = $f->fila($f->celdas['tabla']);
//Compilacion
$f->filas($f->fila['info']);
$f->filas($f->fila['tabla']);
$f->botones($f->campos['generar']);
$f->botones($f->campos['cancelar']);
/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Crear Clase - Entidad v1.0\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 400, height:305});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>
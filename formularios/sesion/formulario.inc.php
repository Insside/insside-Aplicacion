<?php

$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
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

$transaccion = $validaciones->recibir("transaccion");
/** Variables * */
$cadenas = new Cadenas();
$fechas = new Fechas();
$validaciones = new Validaciones();
/** Valores * */
$valores['usuario'] ="";
$valores['clave'] ="";
/** Campos * */
$f->campos['logo'] = "<img class=\"avatar\" src=\"modulos/aplicacion/imagenes/avatar.png\" />";
$f->campos['facebook'] = "<img class=\"\" src=\"modulos/aplicacion/imagenes/facebook-login-button.png\" width=\"100%\" />";
$f->campos['usuario'] = $f->text("usuario", $valores['usuario'], "15", "required user", false,false,"Usuario o correo electrónico ");
$f->campos['clave'] = $f->password("clave", $valores['clave'], "64", "required password", false,false,"Contraseña / Clave");
$f->campos['ayuda'] = $f->button("ayuda" . $f->id, "button", "Ayuda");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button", "Cancelar");
$f->campos['continuar'] = $f->button("continuar" . $f->id, "submit", "Continuar","signing");
/** Celdas * */
$f->celdas["logo"] = $f->celda("", $f->campos['logo'], "", "sinfondo");
$f->celdas["facebook"] = $f->celda("", $f->campos['facebook'], "", "sinfondo");
$f->celdas["usuario"] = $f->celda("", $f->campos['usuario'],"","sinfondo");
$f->celdas["clave"] = $f->celda("", $f->campos['clave'],"","sinfondo");
/** Filas * */
$f->fila["fila0"] = $f->fila($f->celdas["logo"]);
$f->fila["fila1"] = $f->fila($f->celdas["facebook"]);
$f->fila["fila2"] = $f->fila($f->celdas["usuario"]);
$f->fila["fila3"] = $f->fila($f->celdas["clave"]);
$f->fila["fila4"] = $f->fila($f->campos['continuar']);
$f->fila["fila5"] = $f->fila("<a href=\"#\" onClic=\"MUI.Usuarios_Recuperar_Clave();\" class=\"requestpassword\">¿Has olvidado tu contraseña?</a>");

/** Compilando * */
$f->filas("<div class=\"sesion\">");
$f->filas($f->fila['fila0']);
//$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
$f->filas($f->fila['fila4']);
$f->filas($f->fila['fila5']);
$f->filas("</div>");
/** Botones * */
//$f->botones($f->campos['ayuda'], "inferior-izquierda");
//$f->botones($f->campos['cancelar'], "inferior-derecha");
//$f->botones($f->campos['continuar'], "inferior-derecha");
/** JavaScript **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Iniciar Sesión\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 300, height: 400});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
$f->JavaScript("new OverText('usuario',{});");
$f->JavaScript("new OverText('clave',{});");
$f->eClick("cancelar" . $f->id, "MUI.closeWindow($('" . $f->ventana . "'));");
?>
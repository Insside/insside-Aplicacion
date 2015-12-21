<?php
$empleados = new Empleados();
$usuarios = new Usuarios();
/** Variables Recibidas **/
$transaccion=$validaciones->recibir("transaccion");
$usuario=$usuarios->consultar($validaciones->recibir("usuario"));
//print_r($_REQUEST);
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

/** Clases Declaradas E Inicializadas * */
$perfil = $empleados->perfil($usuario['empleado']);
/** Campos * */
$f->campos['empleado'] = $f->campo("empleado", $perfil['empleado']);
$f->campos['nombres'] = $f->campo("nombres", $perfil['nombres']);
$f->campos['apellidos'] = $f->campo("apellidos", $perfil['apellidos']);
$f->campos['direccion'] = $f->campo("direccion", $perfil['direccion']);
$f->campos['telefono'] = $f->campo("telefono", $perfil['telefono']);
$f->campos['correo'] = $f->campo("correo", $perfil['correo']);
$f->campos['sexo'] = $f->campo("sexo", $perfil['sexo']);
$f->campos['creado'] = $f->campo("creado", $perfil['creado']);
$f->campos['actualizado'] = $f->campo("actualizado", $perfil['actualizado']);
$f->campos['creador'] = $f->campo("creador", $perfil['creador']);
$f->campos['foto'] ="<img src=\"".$perfil['foto']."\" width=\"200\" height=\"267\"/>";
$f->campos['cerrar'] = $f->button("cerrar" . $f->id, "button", "Cerrar");
$f->campos['actualizar'] = $f->button("actualizar" . $f->id, "button", "Actualizar");
/** Celdas * */
$f->celdas["empleado"] = $f->celda("Perfil:", $f->campos['empleado']);
$f->celdas["nombres"] = $f->celda("Nombres:", $f->campos['nombres']);
$f->celdas["apellidos"] = $f->celda("Apellidos:", $f->campos['apellidos']);
$f->celdas["direccion"] = $f->celda("Dirección:", $f->campos['direccion']);
$f->celdas["telefono"] = $f->celda("Teléfonos:", $f->campos['telefono']);
$f->celdas["correo"] = $f->celda("Correo Electrónico:", $f->campos['correo']);
$f->celdas["sexo"] = $f->celda("Sexo:", $f->campos['sexo']);
$f->celdas["creado"] = $f->celda("Creado:", $f->campos['creado']);
$f->celdas["actualizado"] = $f->celda("Actualizado:", $f->campos['actualizado']);
$f->celdas["creador"] = $f->celda("Creador:", $f->campos['creador']);

$f->fila['sf1']=$f->fila($f->celdas["empleado"]);
$f->fila['sf2']=$f->fila($f->celdas["nombres"] . $f->celdas["apellidos"]);
$f->fila['sf3']=$f->fila($f->celdas["direccion"]);
$f->fila['sf4']=$f->fila($f->celdas["telefono"]);
$f->fila['sf5']=$f->fila($f->celdas["correo"]);


$f->celdas["foto"] = $f->celda("", $f->campos['foto'],"","w200");
$f->celdas["datos"] = $f->celda("",$f->fila['sf1'].$f->fila['sf2'].$f->fila['sf3'].$f->fila['sf4'].$f->fila['sf5']);
/** Filas * */
$f->fila["f1"] =$f->fila($f->celdas["foto"].$f->celdas["datos"]);
//$f->fila["fila1"] = $f->fila($f->celdas["empleado"] . $f->celdas["nombres"] . $f->celdas["apellidos"]);
//$f->fila["fila2"] = $f->fila($f->celdas["direccion"] . $f->celdas["telefono"] . $f->celdas["correo"]);
//$f->fila["fila3"] = $f->fila($f->celdas["sexo"] . $f->celdas["creado"] . $f->celdas["actualizado"]);
//$f->fila["fila4"] = $f->fila($f->celdas["creador"]);
/** Compilando * */
$f->filas($f->fila['f1']);
//$f->filas($f->fila['fila2']);
//$f->filas($f->fila['fila3']);
//$f->filas($f->fila['fila4']);
//$f->botones($f->campos["cerrar"]);
//$f->botones($f->campos["actualizar"]);
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 540, height: 295});");
//$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
?>
<?php
$root = (!isset($root)) ? "../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$validaciones=new Validaciones();
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
$usuario=Sesion::usuario();
$v['uid']=$usuario['usuario'];
$v['criterio']=$validaciones->recibir("criterio");
$v['valor']=$validaciones->recibir("valor");
$v['fechainicial']=$validaciones->recibir("fechainicial");
$v['fechafinal']=$validaciones->recibir("fechafinal");
$v['transaccion']=$validaciones->recibir("transaccion");
$v['url']="modulos/aplicacion/formularios/funciones/consultar/consultar.json.php?"
        . "uid=".$v['uid']
        . "&criterio=".$v['criterio']
        . "&valor=".$v['valor']
        . "&fechainicial=".$v['fechainicial']
        . "&fechafinal=".$v['fechafinal']
        . "&transaccion=".$v['transaccion'];

/** Creación de la tabla **/
$tabla = new iTable(array("id" => time(), "url" => $v['url'],"perPageOptions"=>array("1000","1500")));
$tabla->boton('btnCrear', 'Crear', '', "MUI.Aplicacion_Funcion_Crear", "pNuevo");
$tabla->boton('btnModificar', 'Modificar', 'funcion', "MUI.Aplicacion_Funcion_Modificar", "pEditar");
//$tabla->boton('btnEliminar', 'Eliminar', 'usuario', "MUI.Usuarios_Roles_Rol_Eliminar", "pEliminar");
$tabla->boton('btnBuscar', 'Buscar', '', "MUI.Usuarios_Usuarios_Complemento_Buscar", "pBuscar");
//$tabla->boton('btnRoles', 'Roles', 'usuario', "MUI.Usuarios_Usuario_Roles", "pRoles");
$tabla->columna('cFuncion', 'Función', 'funcion', 'string', '85', 'center', 'false');
//$tabla->columna('cModulo', 'Modulo', 'modulo', 'string', '75', 'left', 'false');
$tabla->columna('cDetalle', 'Detalles', 'detalles', 'string', '650', 'left', 'false');
//$tabla->columna('cCreador', 'Creador', 'creador', 'date', '75', 'center', 'false');
$tabla->columna('cFecha', 'Creacion', 'creacion', 'date', '75', 'center', 'false');
$tabla->columna('cModificacion', 'Modificación', 'modificacion', 'date', '90', 'center', 'false');
$tabla->generar();
?>
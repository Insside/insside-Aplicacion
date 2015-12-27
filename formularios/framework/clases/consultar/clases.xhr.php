<?php
$root = (!isset($root)) ? "../../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$validaciones=new Validaciones();
/*
 * Copyright (c) 2015, Alexis
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
$herencia = $validaciones->recibir('herencia');

$v['uid']=$usuario['usuario'];
$v['criterio']=$validaciones->recibir("criterio");
$v['valor']=$validaciones->recibir("valor");
$v['inicio']=$validaciones->recibir("inicio");
$v['fin']=$validaciones->recibir("fin");
$v['transaccion']=$validaciones->recibir("transaccion");
$v['url']="modulos/aplicacion/formularios/framework/clases/consultar/clases.json.php?"
        . "herencia=".$herencia
        . "uid=".$v['uid']
        . "&criterio=".$v['criterio']
        . "&valor=".$v['valor']
        . "&inicio=".$v['inicio']
        . "&fin=".$v['fin']
        . "&transaccion=".$v['transaccion'];

/** Creación de la tabla **/
$tabla = new iTable(array("id" => time(), "url" => $v['url'],"perPageOptions"=>array(100,200)));
$tabla->boton('btnCrear', 'Crear',array("indice"=>"","directo"=>$herencia), "MUI.Aplicacion_Framework_Clase_Crear", "pNuevo");
$tabla->boton('btnVer', 'Visualizar', 'clase', "MUI.Aplicacion_Framework_Clase_Consultar", "pAbrir");
$tabla->boton('btnEliminar', 'Eliminar', 'clase', "MUI.Aplicacion_Framework_Clase_Eliminar", "pEliminar");
$tabla->boton('btnModificar', 'Modificar', 'clase', "MUI.Aplicacion_Framework_Clase_Modificar", "pEditar");
$tabla->boton('btnExplorar', 'Explorar', 'clase', "MUI.Aplicacion_Framework_Clase_Explorar", "pBuscar");
$tabla->columna('cClases', 'Clase', 'clase', 'string', '90', 'center', 'false');
$tabla->columna('cDetalles', 'Detalles', 'detalles', 'string', '700', 'left', 'false');
$tabla->columna('cFecha', 'Fecha', 'fecha', 'date', '80', 'center', 'false');
$tabla->columna('cHora', 'Hora', 'hora', 'string', '60', 'center', 'false');
$tabla->generar();
?>
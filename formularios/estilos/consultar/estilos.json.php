<?php
$root = (!isset($root)) ? "../../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
$validaciones=new Validaciones();
$cadenas=new Cadenas();
header('Content-Type: application/json');
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


$usuario = Sesion::usuario();

/** Variables Recibidas * */
$v["clase"]= $validaciones->recibir("clase");
$v['criterio'] = $validaciones->recibir("criterio");
$v['valor'] = $validaciones->recibir("valor");
$v['inicio'] = $validaciones->recibir("inicio");
$v['fin'] = $validaciones->recibir("fin");
$v['transaccion'] = $validaciones->recibir("transaccion");
$v['page'] = $validaciones->recibir("page");
$v['perpage'] = $validaciones->recibir("perpage");
/** Verificaciones * */
/**
 * Se evalua el comportamiento en caso de no recibir el periodo inicial y final de la consulta para lo 
 * cual se presuponen la fecha de la primera solicitud y la ultima que se hallan registrado por
 * el usuario activo en el sistema de atencion de solicitudes.
 */
$v['inicio'] = empty($v['inicio']) ? "0000-00-00" : $v['inicio'];
$v['fin'] = empty($v['fin']) ? "2018-01-01" : $v['fin'];

/* * Variables Definidas * */
if (!empty($v['page'])) {
  $pagination = true;
  $page = intval($v['page']);
  $perpage = intval($v['perpage']);
  $n = ( $page - 1 ) * $perpage;
  $limite = "LIMIT $n, $perpage";
} else {
  $pagination = false;
  $page = 1;
  $perpage = 20;
  $n = 0;
  $limite = "LIMIT $n, $perpage";
}
/**
 * En este segmento se evalua si se esta recibiendo o no un criterio y un valor a buscar segun el 
 * criterio adicionalmente se contempla la propiedad y responsabilidad del usuario activo sobre los 
 * registros visualizados. En terminos de criterios existe un criterio especial que se utiliza para
 * identificar una peticion en la que solo se desean ver aquellas solicitudes que se encuentran 
 * pendientes de respuesta, ese criterio es "estado", donde no existe ningun campo denominado 
 * estado pero se usa para definir si los registros se muestran como se hace habitualmente o 
 * solamente aquellos que correspondan a peticiones a la espera de respuesta.
 * */
if (!empty($v['criterio']) && !empty($v['valor']) && $v['criterio'] != "estado") {
  $buscar = "WHERE( (`fecha` BETWEEN '" . $v['inicio'] . "' AND '" . $v['fin'] . "')AND(`" . $v['criterio'] . "` LIKE '%" . $v['valor'] . "%'))";
} else {
  $buscar = "WHERE(`fecha` BETWEEN '" . $v['inicio'] . "' AND '" . $v['fin'] . "')";
}

$db = new MySQL();
$consulta = $db->sql_query("SELECT * FROM `aplicacion_estilos` " . $buscar . " ORDER BY `identidad`,`clase`,`etiqueta` DESC;");
$total = $db->sql_numrows($consulta);
$sql = "SELECT * FROM `aplicacion_estilos` " . $buscar . " ORDER BY `identidad`,`clase`,`etiqueta` DESC " . $limite;

$consulta = $db->sql_query($sql);
$ret = array();
while ($fila = $db->sql_fetchrow($consulta)) {
  $fila['detalle'] = "<b>";
  $fila['detalle'].=(!empty($fila['identidad']) ? "#" . $fila['identidad'] : "") . " ";
  $fila['detalle'].=(!empty($fila['clase']) ? "." . $fila['clase'] : "") . " ";
  $fila['detalle'].=(!empty($fila['etiqueta']) ? urldecode($fila['etiqueta']) : "");
  $fila['detalle'].=(!empty($fila['estado']) ? (":" . $fila['estado']) : "");
  $fila['detalle'].="</b>{" . $cadenas->saltos(urldecode($fila['css'])) . "}";
  array_push($ret, $fila);
}

$db->sql_close();
echo json_encode(array("sql" => $sql, "uid" => $usuario['usuario'], "page" => $page, "total" => $total, "data" => $ret));
?>
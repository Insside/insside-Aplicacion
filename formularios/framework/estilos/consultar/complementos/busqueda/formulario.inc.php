<?php

$root = (!isset($root)) ? "../../../../../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
$fechas=new Fechas();
$usuarios = new Usuarios();
/** Valores * */
$valores['criterio'] = $validaciones->recibir("criterio");
$valores['valor'] = $validaciones->recibir("valor");
/** Campos * */
$f->oculto("fechainicial", "2012-01-01");
$f->oculto("fechafinal", $fechas->hoy());
$f->campos['criterio'] = $usuarios->criterios("criterio", $valores['criterio']);
$f->campos['valor'] = $f->text("valor", $valores['valor'], "32", "", false);

$f->campos['buscar'] = $f->button("buscar" . $f->id, "submit", "Filtrar");
/** Celdas * */
$f->celdas["criterio"] = $f->celda("Criterio:", $f->campos['criterio']);
$f->celdas["valor"] = $f->celda("Valor:", $f->campos['valor']);
/** Filas * */
$f->fila["fila1"] = $f->fila($f->celdas["criterio"]);
$f->fila["fila2"] = $f->fila($f->celdas["valor"]);
/** Compilando * */
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
/** Botones * */
$f->botones($f->campos['buscar'], "inferior-izquierda");
?>
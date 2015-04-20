<?php // Recorre la tabla de suscriptores// revisa y actualiza una a una todas las direcciones//\\//\\ Cargando Librerias
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");


$suscriptores =new Suscriptores();$db =new MySQL();$sql = "SELECT `suscriptores`.`suscriptor`,`suscriptores`.`direccion` FROM `suscriptores`;";$consulta = $db->sql_query($sql);while ($fila = $db->sql_fetchrow($consulta)) { $direccion = trim($fila['direccion']); $direccion = str_replace(' 2Do.piso ', ' Segundo Piso ', $direccion); $direccion = $cadenas->capitalizar($direccion); $suscriptores->actualizar($fila['suscriptor'], "direccion", $direccion); echo("\n" . $direccion);}$db->sql_close();?>
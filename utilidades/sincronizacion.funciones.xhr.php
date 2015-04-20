<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/MySQL.class.php");
require_once($root . "librerias/soap/nusoap.php");
require_once($root."modulos/aplicacion/librerias/Funciones.class.php");
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

/**
 * Description of sincronizacion
 *
 * @author Alexis
 */


$cliente = new nusoap_client("http://200.110.168.178/agb/sincronizacion.php");

$error = $cliente->getError();
if ($error) { echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";}

$db=new MySQL();
$consulta=$db->sql_query("SELECT * FROM `agb`.`aplicacion_funciones`;");
while($fila=$db->sql_fetchrow($consulta)){
  $result = $cliente->call("funcion", array("funcion" =>$fila));
}
$db->sql_close();

if ($cliente->fault) {
  echo "<h2>Fault</h2><pre>";
  print_r($result);
  echo "</pre>";
} else {
  $error = $cliente->getError();
  if ($error) {
    echo "<h2>Error</h2><pre>" . $error . "</pre>";
  } else {
    echo "<h2>Proceso Concluido</h2><pre>";
    echo $result;
    echo "</pre>";
  }
}




















?>
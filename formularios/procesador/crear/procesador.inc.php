<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
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
$transaccion = $validaciones->recibir('transaccion');
$tabla =  $validaciones->recibir('tabla');
$cadenas = new Cadenas();

$db = new MySQL();
$consulta = $db->sql_query("DESCRIBE `$tabla`");
$campos=array();
while ($fila = $db->sql_fetchrow($consulta)) {
  array_push($campos, $fila);
}
$db->sql_close();

$codigo = "&lt;?php\n";
$codigo.= "/** procesador.inc.php Codigo fuente archivo procesador **/\n";
$codigo.= "\$cadenas = new Cadenas();\n";
$codigo.= "\$fechas = new Fechas();\n";
$codigo.= "\$validaciones = new Validaciones();\n";
$codigo.= "/** Clase representativa Del Objeto **/\n";
$codigo.=("\$clase=new Clase();\n");
$codigo.= "/** Campos Recibidos **/\n";
$codigo.=("\$datos=array();\n");
for($i=0;$i<count($campos);$i++){
  $codigo.="\$datos['".$campos[$i]['Field']."']=\$validaciones->recibir(\"".$campos[$i]['Field']."\");\n";
}
$codigo.=("\$codigo=\$clase->crear(\$datos);\n");
$codigo.= "/** JavaScripts **/\n";
$codigo.=("\$itable=\$validaciones->recibir(\"itable\");\n");
$codigo.=("if(!empty(\$itable)){\$f->JavaScript(\"if(\".\$itable.\"){\".\$itable.\".refresh();}\");}\n");
$codigo.=("\$f->JavaScript(\"MUI.closeWindow($('\" . (\$f->ventana) . \"'));\");\n");
$codigo.=("?>");

$f->fila["editor"] = "<pre id=\"editor" . $transaccion . "\">" . $codigo . "</pre>";
$f->filas($f->fila['editor']);
/** JavaScripts **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'), \"Código PHP\");");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 750, height:480});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
?>
<script type="text/javascript">
  var editor<?php echo($transaccion) ?> = ace.edit("editor<?php echo($transaccion) ?>");
  editor<?php echo($transaccion) ?>.setTheme("ace/theme/twilight");
  editor<?php echo($transaccion) ?>.getSession().setMode("ace/mode/php");
</script>
<style type="text/css" media="screen">
  #editor<?php echo($transaccion) ?> {margin: 0;position: relative;top: 0;bottom: 0;left: 0;right: 0;height: 435px;}
</style>
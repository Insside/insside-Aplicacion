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
$transaccion = @$_REQUEST['transaccion'];
$tabla = @$_REQUEST['tabla'];
$cadenas = new Cadenas();

$db = new MySQL();
$consulta = $db->sql_query("DESCRIBE `$tabla`");
$campos=array();
while ($fila = $db->sql_fetchrow($consulta)) {
  array_push($campos, $fila);
}
$db->sql_close();


$codigo = "&lt;?php\n";
$codigo.= "class ".$tabla."{\n";
$codigo.= "\t\tfunction crear(\$datos){\n";
$codigo.="\t\t\t\$db = new MySQL();\n";
$codigo.="\t\t\t\$sql =\"INSERT INTO `".$tabla."` SET \"";
for($i=0;$i<count($campos);$i++){
  $field=$campos[$i]['Field'];
  $codigo.="\n\t\t\t\t.\"";
  $codigo.="`".$field."`='\".\$datos['".$field."'].\"'";
  if(isset($campos[$i+1]['Field'])){$codigo.=",";}else{}
  
  $codigo.="\"";
}
$codigo.="\n\t\t\t\t.\";\";\n";
$codigo.="\t\t\t\$db->sql_query(\$sql);\n";
$codigo.="\t\t\t\$db->sql_close();\n";
$codigo.= "\t\t}\n\n";

$codigo.= "\t\tfunction actualizar(\$".$campos[0]['Field'].",\$campo,\$valor){\n";
$codigo.="\t\t\t\$db = new MySQL();\n";
$codigo.="\t\t\t\$sql =\"UPDATE `".$tabla."` \"\n";
$codigo.="\t\t\t\t .\"SET `\".\$campo .\"`='\".\$valor . \"' \"\n";
$codigo.="\t\t\t\t .\"WHERE `".$campos[0]['Field']."`='\".\$".$campos[0]['Field'].".\"';\";\n";
$codigo.="\t\t\t\$db->sql_query(\$sql);\n";
$codigo.="\t\t\t\$db->sql_close();\n";
$codigo.= "\t\t}\n"; 

$codigo.= "\t\tfunction eliminar(\$".$campos[0]['Field']."){\n";
$codigo.="\t\t\t\$db = new MySQL();\n";
$codigo.="\t\t\t\$sql =\"DELETE FROM `".$tabla."` \"\n";
$codigo.="\t\t\t\t .\"WHERE `".$campos[0]['Field']."`='\".\$".$campos[0]['Field'].".\"';\";\n";
$codigo.="\t\t\t\$db->sql_query(\$sql);\n";
$codigo.="\t\t\t\$db->sql_close();\n";
$codigo.= "\t\t}\n"; 

$codigo.= "\t\tfunction consultar(\$".$campos[0]['Field']."){\n";
$codigo.="\t\t\t\$db = new MySQL();\n";
$codigo.="\t\t\t\$sql =\"SELECT * FROM `".$tabla."` \"\n";
$codigo.="\t\t\t\t .\"WHERE `".$campos[0]['Field']."`='\".\$".$campos[0]['Field'].".\"';\";\n";
$codigo.="\t\t\t\$consulta=\$db->sql_query(\$sql);\n";
$codigo.="\t\t\t\$fila =\$db->sql_fetchrow(\$consulta);\n";
$codigo.="\t\t\t\$db->sql_close();\n";
$codigo.="\t\t\treturn(\$fila);\n";
$codigo.= "\t\t}\n"; 

$codigo.= "\t}\n";

$f->fila["editor"] = "<pre id=\"editor" . $transaccion . "\">" . $codigo . "</pre>";
$f->filas($f->fila['editor']);
?>
<script type="text/javascript">
  var editor<?php echo($transaccion) ?> = ace.edit("editor<?php echo($transaccion) ?>");
  editor<?php echo($transaccion) ?>.setTheme("ace/theme/twilight");
  editor<?php echo($transaccion) ?>.getSession().setMode("ace/mode/php");
  MUI.titleWindow($('<?php echo($f->ventana); ?>'), "Estructuras v.1");
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 750, height: 480, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));
  if ($('cancelar<?php echo($transaccion); ?>')) {
    $('cancelar<?php echo($transaccion); ?>').addEvent('click', function(e) {
      MUI.closeWindow($('<?php echo($f->ventana); ?>'));
    });
  }
</script>
<style type="text/css" media="screen">
  #editor<?php echo($transaccion) ?> {margin: 0;position: relative;top: 0;bottom: 0;left: 0;right: 0;height: 400px;}
</style>


<?php 
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

$accion = @$_REQUEST['accion'];
$transaccion = @$_REQUEST['transaccion'];
$formulario =new Formularios($transaccion);
$campo['confirmar'] = "<input type = \"submit\" value=\"Confirmar\" id=\"confirmar" . $formulario->id . "\" name=\"confirmar" . $formulario->id . "\">";
$campo['cancelar'] = "<input type = \"button\" value=\"Cancelar\" id=\"cancelar" . $formulario->id . "\" name=\"cancelar" . $formulario->id . "\">";

if (empty($accion)) {
 echo($formulario->apertura());
 ?>
 <input type="hidden" name="accion" value="respaldar" />
 <div id="notificacion">
  <div class="row">
   <div class="cell" style=""><div id="i100x100_respaldo" style="float: left;"></div></div>
   <div class="cell mensaje"><b>¿Desea realmente crear una copia de seguridad?</b>. Recuerde que este proceso paraliza temporalmente las transacciones, y la información que los usuarios estén trasfiriendo hacia la base de datos puede perderse irrecuperablemente. Si está seguro de realizar este procedimiento presione continuar de lo contrario presione cancelar o cierre la presente notificación. Recuerde que los respaldos de la información generados por este sistema están encriptados y el archivo generado es de naturaleza privada, por lo cual exclusivo para el uso de iMIS:ESP.</div>
  </div>
  <div class="row">
   <div id="herramientas">
    <div class="cboton" style="float: right;"><?php  echo($campo['cancelar']); ?></div>
    <div class="cboton" style="float: right;"><?php  echo($campo['confirmar']); ?></div>
   </div>
  </div>

 </div>
 <?php 
 echo($formulario->cierre());
} else {
 $db =new MySQL();
 $db_server = $db->servidor();
 $db_name = $db->db();
 $db_username = $db->usuario();
 $db_password = $db->clave();
 $filename = time() . ".sql";
//------------------------------------------------------------------------------------------
// No tocar
 error_reporting(E_ALL & ~E_NOTICE);
 define('Str_VERS', "2.0.0");
 define('Str_DATE', "27/09/2013");
//------------------------------------------------------------------------------------------
// Funciones

 error_reporting(E_ALL & ~E_NOTICE);

 function fetch_table_dump_sql($table, $fp = 0) {
  $rows_en_tabla = 0;
  $tabledump = "--\n";

  gzwrite($fp, $tabledump);
  $tabledump = "-- Table structure for table `$table`\n";

  gzwrite($fp, $tabledump);
  $tabledump = "--\n\n";

  gzwrite($fp, $tabledump);

  $tabledump = query_first("SHOW CREATE TABLE $table");
  strip_backticks($tabledump['Create Table']);
  $tabledump = "DROP TABLE IF EXISTS $table;\n" . $tabledump['Create Table'] . ";\n\n";

  gzwrite($fp, $tabledump);

  $tabledump = "--\n";

  gzwrite($fp, $tabledump);
  $tabledump = "-- Dumping data for table `$table`\n";
  gzwrite($fp, $tabledump);
  $tabledump = "--\n\n";

  gzwrite($fp, $tabledump);

  $tabledump = "LOCK TABLES $table WRITE;\n";

  gzwrite($fp, $tabledump);

  $rows = query("SELECT * FROM $table");
  $numfields = mysql_num_fields($rows);
  while ($row = fetch_array($rows, DBARRAY_NUM)) {
   $tabledump = "INSERT INTO $table VALUES(";
   $fieldcounter = -1;
   $firstfield = 1;
// campos
   while (++$fieldcounter < $numfields) {
    if (!$firstfield) {
     $tabledump .= ', ';
    } else {
     $firstfield = 0;
    }
    if (!isset($row["$fieldcounter"])) {
     $tabledump .= 'NULL';
    } else {
     $tabledump .= "'" . mysql_real_escape_string($row["$fieldcounter"]) . "'";
    }
   }
   $tabledump .= ");\n";

   gzwrite($fp, $tabledump);
   $rows_en_tabla++;
  }
  free_result($rows);
  $tabledump = "UNLOCK TABLES;\n";
  gzwrite($fp, $tabledump);

  return $rows_en_tabla;
 }

 function strip_backticks(&$text) {
  return $text;
 }

 function fetch_array($query_id = -1) {
  if ($query_id != -1) {
   $query_id = $query_id;
  }
  $record = mysql_fetch_array($query_id);
  return $record;
 }

 function problemas($msg) {
  $errdesc = mysql_error();
  $errno = mysql_errno();
  $message = "<br>";
  $message .= "- Ha habido un problema accediendo a la Base de Datos<br>";
  $message .= "- Error $appname: $msg<br>";
  $message .= "- Error mysql: $errdesc<br>";
  $message .= "- Error número mysql: $errno<br>";
  $message .= "- Script: " . getenv("REQUEST_URI") . "<br>";
  $message .= "- Referer: " . getenv("HTTP_REFERER") . "<br>";

  echo( "</strong><br><br><hr><center><small>" );
  setlocale(LC_TIME, "spanish");
  echo strftime("%A %d %B %Y&nbsp;-&nbsp;%H:%M:%S", time());
  echo( "<br>&copy;2005 <a href=\"mailto:insidephp@gmail.com\">Inside PHP</a><br>" );
  echo( "vers." . Str_VERS . "<br>" );
  echo( "</small></center>" );
  echo( "</BODY>" );
  echo( "</HTML>" );
  die("");
 }

 function free_result($query_id = -1) {
  if ($query_id != -1) {
   $query_id = $query_id;
  }
  return @mysql_free_result($query_id);
 }

 function query_first($query_string) {
  $res = query($query_string);
  $returnarray = fetch_array($res);
  free_result($res);
  return $returnarray;
 }

 function query($query_string) {
  $query_id = mysql_query($query_string);
  if (!$query_id) {
   problemas("Invalid SQL: " . $query_string);
  }
  return $query_id;
 }

 @set_time_limit(0);
 echo("<div id=\"notificacion\">");
 echo("<div class=\"row\">");
 echo("<div class=\"cell\"><div id=\"i100x100_asegurado\" style=\"float: left;\"></div></div></div>");
 echo("<div class = \"cell mensaje\">");
 echo( "<p>El respaldo de toda la información contenida en la base de datos ha sido generado
  satisfactoriamente y el archivo resultante ha sido debidamente mediante encriptado y almacenado.
  Si desea descargar una copia de este archivo presione el enlace de la parte inferior a este mensaje.</p>
 " );
 $error = false;
 $tablas = 0;
 $total_tablas = 0;
 $total_rows = 0;
 $filename = $filename . ".gz";
 $hay_Zlib = true;
 // echo( "- Ya que está disponible Zlib, salvaré la Base de Datos comprimida, como '$filename'<br>" );

 if (!$error) {
  $dbconnection = @mysql_connect($db_server, $db_username, $db_password);
  if ($dbconnection)
   $db = mysql_select_db($db_name);
  if (!$dbconnection || !$db) {
   //echo( "<br>" );
   // echo( "- La conexion con la Base de datos ha fallado: " . mysql_error() . "<br>" );
   $error = true;
  } else {
   //echo( "<br>" );
   //echo( "- He establecido conexion con la Base de datos.<br>" );
  }
 }

 if (!$error) {
// MySQL versión
  $result = mysql_query('SELECT VERSION() AS version');
  if ($result != FALSE && @mysql_num_rows($result) > 0) {
   $row = mysql_fetch_array($result);
  } else {
   $result = @mysql_query('SHOW VARIABLES LIKE \'version\'');
   if ($result != FALSE && @mysql_num_rows($result) > 0) {
    $row = mysql_fetch_row($result);
   }
  }
  if (!isset($row)) {
   $row['version'] = '3.21.0';
  }
 }

 if (!$error) {
  $el_path = getenv("REQUEST_URI");
  $el_path = substr($el_path, strpos($el_path, "/"), strrpos($el_path, "/"));

  $result = query('SHOW tables');
//$result = mysql_list_tables($db_name);
  if (!$result) {
   echo("<!--Error, no puedo obtener la lista de las tablas.-->");
   echo("<!--MySQL Error: " . mysql_error() . "-->");
   $error = true;
  } else {
   $t_start = time();
   $filehandle = gzopen($filename, 'w6');
   if (!$filehandle) {
    $el_path = getenv("REQUEST_URI");
    $el_path = substr($el_path, strpos($el_path, "/"), strrpos($el_path, "/"));
    echo( "<!-- No he podido crear '$filename' en '$el_path/'. Por favor, asegúrese de -->" );
    echo( "<!-- &nbsp;&nbsp;que dispone de privilegios de escritura. -->" );
   } else {
    $tabledump = "-- Dump de la Base de Datos\n";
    gzwrite($filehandle, $tabledump);
    setlocale(LC_TIME, "spanish");
    $tabledump = "-- Fecha: " . strftime("%A %d %B %Y - %H:%M:%S", time()) . "\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "--\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "-- Version: " . Str_VERS . ", del " . Str_DATE . ", jalexiscv@gmail.com\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "-- Soporte y Updaters: jalexiscv@gmail.com\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "--\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "-- Host: `$db_server`  Database: `$db_name`\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "-- ------------------------------------------------------\n";
    gzwrite($filehandle, $tabledump);
    $tabledump = "-- Server version  " . $row['version'] . "\n\n";
    gzwrite($filehandle, $tabledump);
    echo("<br>");
    $result = query('SHOW tables');
    while ($currow = fetch_array($result, DBARRAY_NUM)) {
     $total_tablas++;
     $st = number_format($total_tablas, 0, ',', '.');
     echo("<!--&nbsp;&nbsp;&nbsp;Tablas - Rows procesados: $st ---> ");
     $total_rows += fetch_table_dump_sql($currow[0], $filehandle);
     $sc = number_format($total_rows, 0, ',', '.');
     echo("<!--$sc<br>-->");
     fwrite($filehandle, "\n");
     gzwrite($filehandle, "\n");
     $tablas++;
    }
    echo("<!--<br>-->");
    $tabledump = "\n-- Dump de la Base de Datos Completo.";
    gzwrite($filehandle, $tabledump);
    gzclose($filehandle);
    $t_now = time();
    $t_delta = $t_now - $t_start;
    if (!$t_delta)
     $t_delta = 1;
    $t_delta = floor(($t_delta - (floor($t_delta / 3600) * 3600)) / 60) . " minutos y "
        . floor($t_delta - (floor($t_delta / 60)) * 60) . " segundos.";
    //echo( "- He salvado las $tablas tablas en $t_delta<br>" );
    //echo( "<br>" );
    // echo( "- El Dump de la Base de Datos está completo.<br>" );
    //echo( "- He salvado la Base de Datos en: $el_path/$filename<br>" );
    $size = number_format(filesize($filename), 0, ',', '.');
    $archivo = explode(".", $filename);
    echo( "<p><b>Desacargar</b>: </strong><a href=\"modulos/aplicacion/utilidades/respaldo/" . $archivo[0] . ".rsa\">" . $archivo[0] . ".rsa</a></p>" );
    echo( "<p><b>Peso</b>: " . $size . " bytes</p>" );
   }
  }
 }
 if ($dbconnection)
  mysql_close();
// Encripto el archivo creado para evitar riesgos de seguridad
// Esta accion eliminara el archivo creado remplazandolo por una version encriptada del mismo
 $e =new imis\Encriptar();
 $e->cifrar_archivo($filename);





 // Finalizacion del contenido tras realizar el respaldo
 echo("</div>");
 echo("<div class=\"row\">");
 echo("<div id=\"herramientas\">");
 // echo("<div class=\"cboton\" style=\"float: right;\">" . $campo['cancelar'] . "</div>");
 // echo("<div class=\"cboton\" style=\"float: right;\">" . $campo['confirmar'] . "</div>");
 echo("</div>");
 echo("</div>");
}
?>
<?php  if (empty($accion)) { ?>

 <script type="text/javascript">
  // El elemento formulario prevalida cada trasmision por defecto, no se debe redeclarar la validacion de los formularios
  if ($('confirmar<?php  echo($formulario->id); ?>')) {
   $('confirmar<?php  echo($formulario->id); ?>').addEvent('click', function(e) {

   });
  }
  if ($('cancelar<?php  echo($formulario->id); ?>')) {
   $('cancelar<?php  echo($formulario->id); ?>').addEvent('click', function(e) {
    MUI.closeWindow($('<?php  echo($formulario->ventana); ?>'));
   });
  }


 </script>
<?php  } ?>
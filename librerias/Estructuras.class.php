<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

class Estructuras {

  var $sesion;
  var $fechas;
  var $formularios;

  function Estructuras() {
    $this->sesion = new Sesion();
    $this->fechas = new Fechas();
  }

  function combo($id, $selected, $class = "") {
    $db = new MySQL();
    $sql = "SHOW TABLES";
    $consulta = $db->sql_query($sql);
    $html = ('<select name="' . $id . '"id="' . $id . '" class="' . $class . '" >');
    $conteo = 0;
    while ($fila = $db->sql_fetchrow($consulta)) {
      $html.=('<option value="' . $fila['Tables_in_'.$db->db()] . '"' . (($selected == $fila['Tables_in_'.$db->db()]) ? "selected" : "") . '>' . $fila['Tables_in_'.$db->db()] . '</option>');
      $conteo++;
    }
    $db->sql_close();
    $html.=("</select>");
    return($html);
  }

  function campo() {

  }

}

?>
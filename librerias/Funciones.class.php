<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

class Funciones {

  var $tabla = "aplicacion_funciones";
  var $campo = "funcion";
  var $sesion;

  function Funciones() {
    $this->sesion = new Sesion();
    $this->existencia();
    $permisos = new Permisos();
    $permisos->crear("APLICACION-FUNCIONES", "Permite acceder al componente funciones, para el modulo aplicacion.", "SISTEMA");
    $permisos->crear("APLICACION-FUNCIONES-R", "Permite visualizar la lista de funciones del  sistema.", "SISTEMA");
    $permisos->crear("APLICACION-FUNCIONES-W", "Permite registrar o actualizar la información y codigo fuente de las funciones.", "SISTEMA");
    $permisos->crear("APLICACION-FUNCIONES-D", "Permite eliminar o desactivar las funciones existentes en el sistema", "SISTEMA");
  }

  function crear($funcion = "") {
    $funcion = (!empty($funcion)) ? $funcion : time();
    $db = new MySQL();
    $sql = "INSERT INTO `aplicacion_funciones` SET 	"
            . "`funcion`='" . $funcion . "',`nombre`='f" . $funcion . "',`version`='0.001',	`creacion`='" . date('Y-m-d', time()) . "',`modificacion`='" . date('Y-m-d', time()) . "';";
    echo($sql);
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($funcion);
  }

  function eliminar($campo) {
    $db = new MySQL();
    $consulta = $db->sql_query("DELETE FROM `" . $this->tabla . "` WHERE `" . $this->campo . "`=" . $campo . ";");
    $db->sql_close();
  }

  function actualizar($funcion, $campo, $valor) {
    $db = new MySQL();
    $sql = "UPDATE `aplicacion_funciones` SET `" . $campo . "`='" . $valor . "' WHERE `funcion`='" . $funcion . "';";
    //echo("<br>".$sql);
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  function consultar($funcion) {
    $db = new MySQL();
    $consulta = $db->sql_query("SELECT * FROM `aplicacion_funciones` WHERE `funcion` = '" . $funcion . "';");
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  //\\//\\//\\//\\//\\//\\//\\//\\//\\//\\ Funciones De Verificación E Integración En El Sistema
  function existencia() {
    $db = new MySQL();
    $existencia = $this->sesion->consultar("tabla-" . $this->tabla);
    if (empty($existencia)) {
      $this->sesion->registrar("tabla-" . $this->tabla, $db->sql_tablaexiste($this->tabla));
    } else {
      if ($this->sesion->consultar("tabla-" . $this->tabla) == false) {
        $this->inicializar();
      }
    }$db->sql_close();
  }

  function sql() {
    //return("CREATE TABLE IF NOT EXISTS `funciones` (`funcion` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000',`nombre` varchar(32) NOT NULL,`parametros` varchar(160) DEFAULT NULL,`cuerpo` blob,`descripcion` blob,`version` double(3,2) DEFAULT '0.01',`creacion` date DEFAULT NULL,`modificacion` date DEFAULT NULL,`estado` enum('ACTIVA','DESHABILITADA') NOT NULL DEFAULT 'DESHABILITADA',PRIMARY KEY (`funcion`))");
  }

  function inicializar() {
    $sql = $this->sql();
    $db = new MySQL();
    $consulta = $db->sql_query($sql);
    $db->sql_close();
  }

  //\\//\\//\\//\\//\\//\\ Componentes Graficos
  function combo_estado($selected) {
    $etiquetas = array("Activa", "Deshabilitada");
    $valores = array("ACTIVA", "DESHABILITADA");
    $c = new Componentes();
    return($c->combo_datos("estado", $etiquetas, $valores, $selected, "height:30px; width:100%; font-size:26px;margin:0; padding-bottom:3"));
  }

  function combo($name, $selected) {
    $modulos = new Modulos();
    $db = new MySQL();
    $sql = "SELECT * FROM `aplicacion_funciones` ORDER BY `modulo`,`nombre` ASC";
    $consulta = $db->sql_query($sql);
    $html = ('<select name="' . $name . '"id="' . $name . '">');
    $html.=('<option value="0000000000">0000000000: Ninguna</option>');
    $conteo = 0;
    while ($fila = $db->sql_fetchrow($consulta)) {
      $modulo = $modulos->consultar($fila['modulo']);
      $funcion = ((!empty($modulo['nombre'])) ? $modulo['nombre'] . "_" . $fila["nombre"] : $fila["nombre"]);
      $html.=('<option value="' . $fila['funcion'] . '"' . (($selected == $fila['funcion']) ? "selected" : "") . '>' . $fila['funcion'] . ": " . $funcion . '</option>');
      $conteo++;
    } $db->sql_close();
    $html.=("</select>");
    return($html);
  }

}

//$funciones=new Funciones();
//echo($funciones->crear());
?>
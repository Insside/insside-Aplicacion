<?php

if (!class_exists('Aplicacion_Framework_Funciones')) {

  class Aplicacion_Framework_Funciones {

    /**
     * Este metodo permite crear una función JavaScript y almacenarla en la base de datos, que 
     * posteriormente sera cargada como componente de la interfaz grafica
     * @param type $datos
     */
    function crear($datos = array()) {
      $db = new MySQL();
      $sql = "INSERT INTO `aplicacion_framework_funciones` SET "
              . "`funcion`='" . $datos["funcion"] . "',"
              . "`nombre`='" . $datos["nombre"] . "',"
              . "`parametros`='" . $datos["parametros"] . "',"
              . "`descripcion`='" . $datos["descripcion"] . "',"
              . "`clase`='" . $datos["clase"] . "',"
              . "`fecha`='" . $datos["fecha"] . "',"
              . "`hora`='" . $datos["hora"] . "',"
              . "`creador`='" . $datos["creador"] . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function actualizar($funcion, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `aplicacion_framework_funciones` "
              . "SET `" . $campo . "`='" . $valor . "' "
              . "WHERE `funcion`='" . $funcion . "';";
      $db->sql_query($sql);
      $db->sql_close();
      echo($sql);
    }

    function eliminar($funcion) {
      $db = new MySQL();
      $sql = "DELETE FROM `aplicacion_framework_funciones` "
              . "WHERE `funcion`='" . $funcion . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function consultar($funcion) {
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_framework_funciones` "
              . "WHERE `funcion`='" . $funcion . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }
    /**
     * Retorna el numero total de funciones asociado a una clase especifica.
     * @param type $clase
     * @return type
     */
    function conteo($clase) {
      $db = new MySQL();
      $sql = "SELECT COUNT(*) AS  `conteo` FROM `aplicacion_framework_funciones` "
              . "WHERE `clase`='" . $clase . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila["conteo"]);
    }

  }

}
?>
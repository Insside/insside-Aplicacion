<?php

if (!class_exists('Aplicacion_Funciones')) {

  class Aplicacion_Funciones {

    /**
     * Permite consultar y obtener los datos que conforman una función.
     * @param type $funcion
     * @return type
     */
    function consultar($funcion) {
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_funciones` WHERE `funcion`='" . $funcion . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

    /**
     * Este metodo permite crear una función JavaScript y almacenarla en la base de datos, que 
     * posteriormente sera cargada como componente de la interfaz grafica
     * @param type $datos
     */
    function crear($datos = array()) {
      $db = new MySQL();
      $sql = "INSERT INTO `aplicacion_funciones` SET "
              . "`funcion`='" . $datos["funcion"] . "',"
              . "`modulo`='" . $datos["modulo"] . "',"
              . "`nombre`='" . $datos["nombre"] . "',"
              . "`cuerpo`='" . $datos["cuerpo"] . "',"
              . "`parametros`='" . $datos["parametros"] . "',"
              . "`descripcion`='" . $datos["descripcion"] . "',"
              . "`version`='" . $datos["version"] . "',"
              . "`creacion`='" . $datos["creacion"] . "',"
              . "`modificacion`='" . $datos["modificacion"] . "',"
              . "`estado`='" . $datos["estado"] . "',"
              . "`creador`='" . $datos["creador"] . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function actualizar($funcion, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `aplicacion_funciones` "
              . "SET `" . $campo . "`='" . $valor . "' "
              . "WHERE `funcion`='" . $funcion . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function eliminar($funcion) {
      $db = new MySQL();
      $sql = "DELETE FROM `aplicacion_funciones` "
              . "WHERE `funcion`='" . $funcion . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    /**
     * Este metodo permite verificar la existencia de una funcion, si la funcion existe el metodo 
     * retornara verdadero(TRUE) de lo contrario retornara falso(FALSE).
     * @param type $funcion
     * @return type
     */
    function existe($funcion) {
      $f = $this->consultar($funcion);
      if (isset($f["funcion"]) && $f["funcion"] == $funcion) {
        $existe = true;
      } else {
        $existe = false;
      }
      return($existe);
    }

    /**
     * Este metodo permite sincronizar una función si la funcion no existe el metodo la creara, si la
     * funcion existe el metodo actualizara los datos actualizables. Cuando se produce una actualizacion
     * el versionamiento de la funcion se incrementa en 0.001.
     * @param type $datos
     */
    function sincronizar($datos = array()) {
      $funcion = $datos["funcion"];
      if (!$this->existe($funcion)) {
        echo("CREADA");
        $this->crear($datos);
      } else {
        echo("ACTUALIZADA");
        $funcion = $this->consultar($funcion);
        $version = $funcion['version'] + 0.001;
        $this->actualizar($datos["funcion"], "modulo", $datos["modulo"]);
        $this->actualizar($datos["funcion"], "nombre", $datos["nombre"]);
        $this->actualizar($datos["funcion"], "cuerpo", $datos["cuerpo"]);
        $this->actualizar($datos["funcion"], "parametros", $datos["parametros"]);
        $this->actualizar($datos["funcion"], "descripcion", $datos["descripcion"]);
        $this->actualizar($datos["funcion"], "modificacion", date('Y-m-d', time()));
        $this->actualizar($datos["funcion"], "version", $version);
      }
    }

  }

}
?>
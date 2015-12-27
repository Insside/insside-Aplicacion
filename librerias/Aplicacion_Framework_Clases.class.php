<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "librerias/Fechas.class.php");
require_once($root . "librerias/MySQL.class.php");

/*
 * Copyright (c) 2014, Alexis
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
 * Description of Aplicacion_Framework_Clases
 *
 * @author Alexis
 */
if (!class_exists('Aplicacion_Framework_Clases')) {

  class Aplicacion_Framework_Clases {

    function crear($datos) {
      $db = new MySQL();
      $sql = "INSERT INTO `aplicacion_framework_clases` SET `clase`='" . $datos['clase'] . "';";
      $db->sql_query($sql);
      $db->sql_close();
      $this->actualizar($datos['clase'], 'implements', $datos['implements']);
      $this->actualizar($datos['clase'], 'extends', $datos['extends']);
      $this->actualizar($datos['clase'], 'tipo', $datos['tipo']);
      $this->actualizar($datos['clase'], 'nombre', $datos['nombre']);
      $this->actualizar($datos['clase'], 'descripcion', $datos['descripcion']);
      $this->actualizar($datos['clase'], 'fecha', $datos['fecha']);
      $this->actualizar($datos['clase'], 'hora', $datos['hora']);
      $this->actualizar($datos['clase'], 'creador', $datos['creador']);
      return($sql);
    }

    function actualizar($clase, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `aplicacion_framework_clases` "
              . "SET `" . $campo . "`='" . $valor . "' "
              . "WHERE `clase`='" . $clase . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function eliminar($clase) {
      $db = new MySQL();
      $sql = "DELETE FROM `aplicacion_framework_clases` "
              . "WHERE `clase`='" . $clase . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function consultar($clase) {
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_framework_clases` "
              . "WHERE `clase`='" . $clase . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

    function codensador($clase) {
      $clase = $this->consultar($clase);
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_framework_funciones` WHERE `clase` ='" . $clase['clase'] . "' ORDER BY `nombre`;";
      $consulta = $db->sql_query($sql);

      if ($clase['tipo']=="class") {
        $js = "var " . $clase['nombre'] . "=new Class({\n";
      } else {
        $js = "" . $clase['nombre'] . "={\n";
      }


      if (!empty($clase['implements'])) {
        $js.="Implements:[" . $clase['implements'] . "],\n";
      }
      if (!empty($clase['extends'])) {
        $js.="Extends: " . $clase['extends'] . ",\n";
      }
      while ($fila = $db->sql_fetchrow($consulta)) {
        if ($fila['nombre'] == "options") {
          $js.="" . $fila['nombre'] . ":{\n";
        } else {
          $js.="" . $fila['nombre'] . ":function(" . $fila['parametros'] . "){\n";
        }
//          $js.="try{\n";
        $sql_codigo = "SELECT * FROM `aplicacion_framework_codigos`  WHERE `funcion`='" . $fila['funcion'] . "' ORDER BY `codigo` DESC;";
        $consulta_codigo = $db->sql_query($sql_codigo);
        $fila_codigo = $db->sql_fetchrow($consulta_codigo);
        $js.=(urldecode($fila_codigo['contenido']));
//          $js.="}catch(error){\n";
//          $js.="MUI.Aplicacion_Framework_Advertencia('<b><u>'+error.message+'</u>: </b>'+error.stack);";
//          $js.="}finally{\n";
//          $js.="}\n";
        $js.="\n},\n";
      }
      $js.="version:function(){return('" . $this->version($clase) . "');}\n";
      if ($clase['tipo']=="class") {
        $js.="});\n";
      } else {
        $js.="};\n";
      }


      $db->sql_close();
      //return(Compactador::minify($js));
      return($js);
    }

    /**
     * Retorna la version calculada de una clase
     * @param type $class
     */
    function version($class) {
      return(0);
    }

    /**
     * Retorna el numero total de clases existentes.
     * @param type $clase
     * @return type
     */
    function conteo() {
      $db = new MySQL();
      $sql = "SELECT COUNT(*) AS  `conteo` FROM `aplicacion_framework_clases`;";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila["conteo"]);
    }

    function tipos($nombre, $seleccionado) {
      $etiquetas = array("Clase", "Objeto");
      $valores = array("class", "object");
      return($this->select($nombre, $etiquetas, $valores, $seleccionado, ""));
    }

    /**
     * Permite crear un combo <<select>> proporsionando directamente los datos de generación y los valores
     * a listar, el formato apariencia del combo se define mediante CSS asignado por su <<id>>, el atributo <<class>> se adiciona para controlar validaciones
     * en tiempo de ejecución, siendo una funcionalidad opcional y a criterio al momento de realizarse la implementación.
     * @param type $nombre nombre del combo.
     * @param type $name
     * @param type $etiquetas
     * @param type $valores
     * @param type $selected
     * @return type
     */
    function select($id, $etiquetas, $valores, $selected, $clase = "campo") {
      if (empty($selected)) {
        $selected = isset($_REQUEST['_' . $id]) ? $_REQUEST['_' . $id] : "";
      }
      $html = ('<select name="' . $id . '"id="' . $id . '"  class="' . $clase . '">');
      for ($i = 0; $i < count($valores); $i++) {
        $html.=('<option value="' . $valores[$i] . '"' . (($selected == $valores[$i]) ? "selected" : "") . '>' . $etiquetas[$i] . '</option>');
      }$html.=("</select>");
      return($html);
    }

  }

}
?>
<?php

$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");
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
if (!class_exists('Aplicacion_Framework_Estilos')) {

  class Aplicacion_Framework_Estilos {

    function crear($p = array()) {
      $db = new MySQL();
      $sql = ""
              . "INSERT INTO `aplicacion_framework_estilos` SET "
              . "`estilo`='" . $p["estilo"] . "',"
              . "`clase`='" . $p["clase"] . "',"
              . "`subclase`='" . $p["subclase"] . "',"
              . "`etiqueta`='" . $p["etiqueta"] . "',"
              . "`estado`='" . $p["estado"] . "',"
              . "`css`='" . ($this->almacenamiento($p["css"])) . "',"
              . "`css_firefox`='" . ($this->almacenamiento($p["css_firefox"])) . "',"
              . "`css_chrome`='" . ($this->almacenamiento($p["css_chrome"])) . "',"
              . "`css_iexplorer`='" . ($this->almacenamiento($p["css_iexplorer"])) . "',"
              . "`css_opera`='" . ($this->almacenamiento($p["css_opera"])) . "',"
              . "`descripcion`='" . ($p["descripcion"]) . "',"
              . "`version`='" . $p["version"] . "',"
              . "`fecha`='" . $p["fecha"] . "',"
              . "`hora`='" . $p["hora"] . "',"
              . "`creador`='" . $p["creador"] . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function actualizar($estilo, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `aplicacion_framework_estilos` SET `" . $campo . "`='" . $valor . "' WHERE `estilo`='" . $estilo . "';";
      $db->sql_query($sql);
      $db-> sql_close();
    }

    function eliminar($estilo) {
      $db = new MySQL();
      $sql = "DELETE FROM `aplicacion_framework_estilos` WHERE `estilo`='" . $estilo . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function consultar($estilo) {
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_framework_estilos` WHERE `estilo`='" . $estilo . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

    function codensador($estilo = array()) {
      $cadenas = new Cadenas();
      $css = $this->expresion($estilo);
      $css = $cadenas->saltos($css);
      return("\n" . $css . "");
    }

    /**
     * Para que el editor grafico del codigo CSS comprenda adecuadamente los elementos que se
     * estan codificando, estos deben estar totalmente descritos segun las normas del css, por tal 
     * motivo al momento de redactar el codigo este debera estar rodeado {}, y almacenar solamente
     * el contenido entre los brazos.
     * @param type $css
     * @return type
     */
    function almacenamiento($css) {
      $inicial = strpos($css, "{");
      $final = strrpos($css, "}");
      if ($inicial > 0 && $final > 0) {
        $css = substr($css, $inicial + 1, $final - $inicial - 1);
      }
      return($css);
    }

    /**
     * Indicado un estilo almacenado en la base de datos, lo retorna con su correcta sintaxis.
     * @param type $estilo
     * @return type
     */
    function expresion($estilo = array()) {
      $afc = new Aplicacion_Framework_Clases();
      $clase = $afc->consultar($estilo["clase"]);
      $css = "\n." . $clase["nombre"] . " ";
      $css.=(!empty($estilo['subclase']) ? "." . $estilo['subclase'] : "") . " ";
      $css.=(!empty($estilo['etiqueta']) ? urldecode($estilo['etiqueta']) : " ");
      $css.=(!empty($estilo['estado']) ? (":" . $estilo['estado']) : " ");
      $css.="{" . (urldecode($estilo['css'])) . "}";
      return($css);
    }

    /**
     * Recibido un estilo estructura y retorna su nombre.
     * @param type $estilo
     * @return type
     */
    function nombre($estilo = array()) {
      $afc = new Aplicacion_Framework_Clases();
      $clase = $afc->consultar($estilo["clase"]);
      $css = "." . $clase["nombre"] . " ";
      $css.=(!empty($estilo['subclase']) ? "." . $estilo['subclase'] : "") . " ";
      $css.=(!empty($estilo['etiqueta']) ? urldecode($estilo['etiqueta']) : " ");
      $css.=(!empty($estilo['estado']) ? (":" . $estilo['estado']) : " ");
      return($css);
    }
    
        /**
     * Retorna el numero total de funciones asociado a una clase especifica.
     * @param type $clase
     * @return type
     */
    function conteo($clase) {
      $db = new MySQL();
      $sql = "SELECT COUNT(*) AS  `conteo` FROM `aplicacion_framework_estilos` "
              . "WHERE `clase`='" . $clase . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila["conteo"]);
    }

  }

}
?>
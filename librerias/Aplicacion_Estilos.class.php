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
if (!class_exists('Aplicacion_Estilos')) {

  class Aplicacion_Estilos {

    function crear($datos) {
      $db = new MySQL();
      $sql = "INSERT INTO `aplicacion_estilos` SET "
              . "`estilo`='" . $datos['estilo'] . "',"
              . "`identidad`='" . $datos['identidad'] . "',"
              . "`clase`='" . $datos['clase'] . "',"
              . "`etiqueta`='" . $datos['etiqueta'] . "',"
              . "`estado`='" . $datos['estado'] . "',"
              . "`css`='" . $datos['css'] . "',"
              . "`css_firefox`='" . $datos['css_firefox'] . "',"
              . "`css_chrome`='" . $datos['css_chrome'] . "',"
              . "`css_iexplorer`='" . $datos['css_iexplorer'] . "',"
              . "`css_opera`='" . $datos['css_opera'] . "',"
              . "`descripcion`='" . $datos['descripcion'] . "',"
              . "`version`='" . $datos['version'] . "',"
              . "`fecha`='" . $datos['fecha'] . "',"
              . "`hora`='" . $datos['hora'] . "',"
              . "`creador`='" . $datos['creador'] . "'"
              . ";";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function actualizar($estilo, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `aplicacion_estilos` "
              . "SET `" . $campo . "`='" . $valor . "' "
              . "WHERE `estilo`='" . $estilo . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function eliminar($estilo) {
      $db = new MySQL();
      $sql = "DELETE FROM `aplicacion_estilos` "
              . "WHERE `estilo`='" . $estilo . "';";
      $db->sql_query($sql);
      $db->sql_close();
    }

    function consultar($estilo) {
      $db = new MySQL();
      $sql = "SELECT * FROM `aplicacion_estilos` "
              . "WHERE `estilo`='" . $estilo . "';";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

  }

}
?>
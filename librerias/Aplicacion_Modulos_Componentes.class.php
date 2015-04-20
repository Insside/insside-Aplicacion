<?php

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

/**
 * Description of Componentes
 *
 * @author Alexis
 */
class Aplicacion_Modulos_Componentes {

//put your code here
  var $sesion;
  var $fechas;

  function Aplicacion_Modulos_Componentes() {
    $this->sesion = new Sesion();
    $this->fechas = new Fechas();
  }

  function consultar($componente) {
    $db = new MySQL();
    $consulta = $db->sql_query("SELECT * FROM `aplicacion_modulos_componentes` WHERE `componente` ='" . $componente . "' ORDER BY `componente`;");
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    $fila['titulo']=urldecode($fila['titulo']);
    $fila['descripcion']=urldecode($fila['descripcion']);
    return($fila);
  }
  
  function eliminar($componente) {
    $db = new MySQL();
    $consulta = $db->sql_query("DELETE FROM `aplicacion_modulos_componentes` WHERE `componente`='".$componente."';");
    $fila = $db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  function crear($datos) {
    $db = new MySQL();
    $sql = "INSERT INTO `aplicacion_modulos_componentes` SET ";
    $sql.="`componente` = '" . $datos['componente'] . "', ";
    $sql.="`herencia` = '" . $datos['herencia'] . "', ";
    $sql.="`titulo` = '" . urlencode($datos['titulo']). "', ";
    $sql.="`descripcion` = '" . urlencode($datos['descripcion']). "', ";
    $sql.="`funcion` = '" . $datos['funcion']. "', ";
    $sql.="`icono` = '" . $datos['icono']. "', ";
    $sql.="`peso` = '" . $datos['peso']. "', ";
    $sql.="`estado` = '" . $datos['estado']. "', ";
    $sql.="`permiso` = '" . $datos['permiso']. "', ";
    $sql.="`fecha` = '" .$datos['fecha']. "', ";
    $sql.="`hora` = '" .$datos['hora']. "', ";
    $sql.="`creador` = '" .$datos['creador']. "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }
  

  function actualizar($componente, $campo, $valor) {
    if($campo=="titulo"||$campo=="descripcion"){$valor=  urlencode($valor);}
    $db = new MySQL();
    $sql = "UPDATE `aplicacion_modulos_componentes` SET `" . $campo . "`='" . $valor . "' WHERE `componente`='" . $componente . "';";
    $consulta = $db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  function combo($name, $selected) {
    $db = new MySQL();
    $sql = "SELECT * FROM `aplicacion_modulos_componentes` ORDER BY `peso`;";
    $consulta = $db->sql_query($sql);
    $html = ('<select name="' . $name . '"id="' . $name . '">');
    $html.=('<option value="0000000000">000:0000000000: Ninguno</option>');

    $conteo = 0;
    while ($fila = $db->sql_fetchrow($consulta)) {
      $html.=('<option value="' . $fila['componente'] . '"' . (($selected == $fila['componente']) ? "selected" : "") . '>' .$fila['componente'] . ": " . $fila['titulo'] . '</option>');
      $conteo++;
    } $db->sql_close();
    $html.=("</select>");
    return($html);
  }

}

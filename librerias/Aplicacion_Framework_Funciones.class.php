<?php

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
 * Description of Aplicacion_Framework_Funciones
 *
 * @author Alexis
 */
class Aplicacion_Framework_Funciones {
		function crear($datos){
			$db = new MySQL();
			$sql ="INSERT INTO `aplicacion_framework_funciones` SET `funcion`='".$datos['funcion']."';";
			$db->sql_query($sql);
			$db->sql_close();
			$this->actualizar($datos['funcion'],'nombre',$datos['nombre']);
			$this->actualizar($datos['funcion'],'parametros',$datos['parametros']);
			$this->actualizar($datos['funcion'],'descripcion',$datos['descripcion']);
			$this->actualizar($datos['funcion'],'clase',$datos['clase']);
			$this->actualizar($datos['funcion'],'fecha',$datos['fecha']);
			$this->actualizar($datos['funcion'],'hora',$datos['hora']);
			$this->actualizar($datos['funcion'],'creador',$datos['creador']);
		}

		function actualizar($funcion,$campo,$valor){
			$db = new MySQL();
			$sql ="UPDATE `aplicacion_framework_funciones` "
				 ."SET `".$campo ."`='".$valor . "' "
				 ."WHERE `funcion`='".$funcion."';";
			$db->sql_query($sql);
			$db->sql_close();
       echo($sql);
		}
		function eliminar($funcion){
			$db = new MySQL();
			$sql ="DELETE FROM `aplicacion_framework_funciones` "
				 ."WHERE `funcion`='".$funcion."';";
			$db->sql_query($sql);
			$db->sql_close();
		}
		function consultar($funcion){
			$db = new MySQL();
			$sql ="SELECT * FROM `aplicacion_framework_funciones` "
				 ."WHERE `funcion`='".$funcion."';";
			$consulta=$db->sql_query($sql);
			$fila =$db->sql_fetchrow($consulta);
			$db->sql_close();
			return($fila);
		}
}

<?php
$usuarios=new Usuarios();
$cadenas=new Cadenas();
/* 
 * Copyright (c) 2015, Alexis
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
$usuario=$usuarios->consultar($validaciones->recibir("usuario"));

$db = new MySQL();
$consulta = $db->sql_query("SELECT * FROM `usuarios_acciones` WHERE(`usuario`='" . $usuario['usuario']. "') ORDER BY `fecha`,`hora` DESC;");
$tabla="<table>"
        . "<tr style=\"  border-bottom: solid 1px #cccccc;padding-bottom: 3px;\">"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>#</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Fecha</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Hora</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Modulo</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Tipo</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Valor</b></td>"
        . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;\"><b>Resumen</b></td>"
        . "</tr>";
$conteo=0;
while($fila=$db->sql_fetchrow($consulta)){
  $conteo++;
  $tabla.="<tr style=\"  border-bottom: solid 1px #cccccc;padding-top: 3px;padding-bottom: 3px;\">"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$conteo."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$fila['fecha']."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$fila['hora']."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$fila['modulo']."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$cadenas->capitalizar($fila['tipo'])."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space: nowrap\">".$cadenas->capitalizar($fila['valor'])."</td>"
          . "<td style=\"  border-right: solid 1px #cccccc;padding-right: 5px;padding-left: 5px;white-space:nowrap;text-overflow: ellipsis;\">".$cadenas->recortar($fila['descripcion'],25)."</td>"
          . "</tr>";
}
$tabla.="</table>";
$db->sql_close();


$f->celdas["tabla"] = $f->celda("",$tabla);
/** Filas **/
$f->fila["tabla"] = $f->fila($f->celdas["tabla"]);
/** Compilando **/
$f->filas($f->fila['tabla']);
/** JavaScript **/
$f->JavaScript("MUI.titleWindow($('" . ($f->ventana) . "'),'Historial Detallado de Acciones <span style=\"color:#cccccc;\">v0.1</span>');");
$f->JavaScript("MUI.resizeWindow($('" . ($f->ventana) . "'), {width: 750, height:400});");
$f->JavaScript("MUI.centerWindow($('" . $f->ventana . "'));");
?>
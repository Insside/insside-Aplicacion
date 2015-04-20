<?php

$root=(!isset($root))?"../../../":$root;
require_once($root."modulos/aplicacion/librerias/Configuracion.cnf.php");

class Estilos {

  var $sesion;
  var $fechas;
  var $permisos;
  var $tabla="aplicacion_estilos";
  var $campo="estilo";

  function Estilos() {
    $this->sesion=new Sesion();
    $this->permisos=new Permisos();
    $this->fechas=new Fechas();
    $this->permisos->crear("APLICACION-ESTILOS","Permite acceder al componente funciones, para el modulo aplicacion.","SISTEMA");
    $this->permisos->crear("APLICACION-ESTILOS-VISUALIZAR","Permite visualizar la lista de funciones del  sistema.","SISTEMA");
    $this->permisos->crear("APLICACION-ESTILOS-ACTUALIZAR","Permite registrar o actualizar la información y codigo fuente de las funciones.","SISTEMA");
    $this->permisos->crear("APLICACION-ESTILOS-ELIMINAR","Permite eliminar o desactivar las funciones existentes en el sistema","SISTEMA");
  }

  function crear($identidad,$clase,$etiqueta,$estado,$descripcion) {
    $db=new MySQL();
    $sql="INSERT INTO `".$this->tabla."` SET";
    $sql.="`estilo`='".time()."',";
    $sql.="`identidad`='".$identidad."',";
    $sql.="`clase`='".$clase."',";
    $sql.="`etiqueta`='".$etiqueta."',";
    $sql.="`estado`='".$estado."',";
    $sql.="`descripcion`='".$descripcion."',";
    $sql.="`version`='0.01',";
    $sql.="`fecha`='".$this->fechas->hoy()."',";
    $sql.="`hora`='".$this->fechas->ahora()."',";
    $sql.="`creador`='".$this->sesion->consultar("usuario")."';";
    echo($sql);
    $consulta=$db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  function consultar($estilo) {
    $db=new MySQL();
    $consulta=$db->sql_query("SELECT * FROM `".$this->tabla."` WHERE `".$this->campo."`='".$estilo."'");
    $fila=$db->sql_fetchrow($consulta);
    $db->sql_close();
    return($fila);
  }

  function actualizar($estilo,$campo,$valor) {
    $db=new MySQL();
    $sql="UPDATE `".$this->tabla."` SET `".$campo."`='".$valor."' WHERE `".$this->campo."`='".$estilo."' ;";
    $consulta=$db->sql_query($sql);
    $db->sql_close();
    return($consulta);
  }

  /*   * *
    function eliminar($campo) {
    $db=new MySQL();
    $consulta=$db->sql_query("DELETE FROM `".$this->tabla."` WHERE `".$this->campo."`=".$campo.";");
    $db->sql_close();
    }




    //\\//\\//\\//\\//\\//\\//\\//\\//\\//\\ Funciones De Verificación E Integración En El Sistema
    function existencia() {


    $db=new MySQL();
    $existencia=$this->sesion->consultar("tabla-".$this->tabla);
    if(empty($existencia)){
    $this->sesion->registrar("tabla-".$this->tabla,$db->sql_tablaexiste($this->tabla));
    }else{
    if($this->sesion->consultar("tabla-".$this->tabla)==false){
    $this->inicializar();
    }
    }$db->sql_close
    ();
    }

    function sql() {
    //return("CREATE TABLE IF NOT EXISTS `funciones` (`funcion` int(11) unsigned zerofill NOT NULL DEFAULT '00000000000',`nombre` varchar(32) NOT NULL,`parametros` varchar(160) DEFAULT NULL,`cuerpo` blob,`descripcion` blob,`version` double(3,2) DEFAULT '0.01',`creacion` date DEFAULT NULL,`modificacion` date DEFAULT NULL,`estado` enum('ACTIVA','DESHABILITADA') NOT NULL DEFAULT 'DESHABILITADA',PRIMARY KEY (`funcion`))"

    );
    }

    function inicializar() {
    $sql=$this->sql();
    $db=new MySQL();
    $consulta=$db->sql_query($sql);
    $db->sql_close
    ();
    }

    //\\//\\//\\//\\//\\//\\ Componentes Graficos
    function combo_estado($selected) {
    $etiquetas=array("Activa","Deshabilitada");
    $valores=array("ACTIVA","DESHABILITADA");
    $c=new Componentes();
    return($c->combo_datos("estado",$etiquetas,$valores,$selected,"height:30px;
    width:100%;
    font-size:26px;
    margin:0;
    padding-bottom:3"));
    }

   * */
}

?>
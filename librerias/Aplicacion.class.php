<?php
$root = (!isset($root)) ? "../../../" : $root;
require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

class Aplicacion {

  var $sesion;
  var $fechas;
  var $modulos;
  var $permiso;

  function Aplicacion() {
    $this->sesion = new Sesion();
    $this->fechas = new Fechas();
    $this->modulos = new Aplicacion_Modulos();
    $permisos = new Aplicacion_Permisos();
    $modulos = new Aplicacion_Modulos();
    $modulo = $modulos->crear("001", "Aplicación", "Modulo Control Del Aplicativo", "");
    $permisos->permiso_crear($modulo, "APLICACION-MODULO-A", "Acceso Modulo Aplicación", "Permite ver y acceder al modulo Aplicación.", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-FUNCIONES-A", "Acceder Componente Funciones", "Permite acceder al componente funciones, para el modulo aplicacion.", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-FUNCIONES-R", "Visualizar Funciones", "Permite visualizar el listado de funciones y sus referencias", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-FUNCIONES-W", "Crear Funciones", "Permite actualizar el contenido y referencias de una funcion", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-FUNCIONES-U", "Actualizar Funciones", "Permite actualizar el contenido y referencias de una funcion", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-FUNCIONES-D", "Eliminar Funciones", "Permite eliminar o desactivar las funciones existentes en el sistema", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-ESTILOS-A", "Acceder Componente Estilos", "Permite acceder al componente estilos, para el modulo aplicacion.", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-ESTILOS-R", "Visualizar Estilos.", "Permite visualizar el listado de estilos y sus referencias", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-ESTILOS-W", "Crear Estilos.", "Permite visualizar el listado de estilos y sus referencias", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-ESTILOS-U", "Actualizar Estilos.", "Permite actualizar el contenido y referencias de un estilo", "0000000000");
    $permisos->permiso_crear($modulo, "APLICACION-ESTILOS-D", "Eliminar o Desactivar Estilos.", "Permite eliminar o desactivar las estilos definidos en el sistema", "0000000000");
  }

}

$aplicacion = new Aplicacion();
?>
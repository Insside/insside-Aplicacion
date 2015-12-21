<?php

if (!class_exists('Aplicacion_Usuarios')) {
  $root = (!isset($root)) ? "../../../" : $root;
  require_once($root . "modulos/aplicacion/librerias/Configuracion.cnf.php");

  /**
   * Description of Aplicacion_Usuarios
   * Esta clase es una copia de la clase Usuarios del modulo usuarios, y se debe colocar
   * directamente apra evitar errores de redundancia ciclica.
   * @author Alexis
   */
  class Aplicacion_Usuarios {

    var $tabla = "usuarios";
    var $indice = "usuario";

    function Aplicacion_Usuarios() {
      
    }

    /**
     * Este metodo permite crear un usuario del sistema, como parametro recibe un vector de 
     * datos que contiene los elementos basicos necesarios para registrar los datos de un usuario
     * en el sistema. La creacion de un nuevo usuario  no implica la asignacion de rol
     * o privilegio alguno al mismo.
     * @param type $datos
     */
    function crear($datos = array()) {
      $db = new MySQL();
      $sql = "INSERT INTO `usuarios_usuarios` SET ";
      $sql.="`usuario`='" . $datos['usuario'] . "',";
      $sql.="`alias`='" . $datos['alias'] . "',";
      $sql.="`clave`='" . $datos['clave'] . "',";
      $sql.="`fecha`='" . $datos['fecha'] . "',";
      $sql.="`hora`='" . $datos['hora'] . "',";
      $sql.="`perfil`='" . $datos['perfil'] . "',";
      $sql.="`equipo`='" . $datos['equipo'] . "',";
      $sql.="`creador`='" . $datos['creador'] . "';";
      $db->sql_query($sql);
      echo($sql);
      $db->sql_close();
    }

    function eliminar($usuario) {
      $db = new MySQL();
      $sql = "DELETE FROM `usuarios_usuarios` WHERE `usuario`=" . $usuario . ";";
      $consulta = $db->sql_query($sql);
      $db->sql_close();
      return($consulta);
    }

    /**
     * Este metodo retorna el id de un usuario a partir de su alias, el dato retornado es la id numerica
     * del usuario registrado en la base de datos.
     * @param type $alias
     * @return type
     */
    function alias($alias) {
      $db = new MySQL();
      $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`alias` = '" . $alias . "');";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila['usuario']);
    }

    function consultar($usuario) {
      $usuario = is_array($usuario) ? $usuario['usuario'] : $usuario;
      $db = new MySQL();
      $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`usuario` = '" . $usuario . "');";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

    function actualizar($usuario, $campo, $valor) {
      $db = new MySQL();
      $sql = "UPDATE `usuarios_usuarios` SET `" . $campo . "`='" . $valor . "' WHERE `usuario`='" . $usuario . "';";
      $consulta = $db->sql_query($sql);
      $db->sql_close();
      return($consulta);
    }

    function identificar($alias, $clave) {
      if (!empty($clave)) {
        $alias = strtoupper($alias);
        $clave = strtoupper($clave);
        $db = new MySQL();
        $sql = "SELECT * FROM `usuarios_usuarios` WHERE(`alias` = '" . $alias . "');";
        $consulta = $db->sql_query($sql);
        $fila = $db->sql_fetchrow($consulta);
        $db->sql_close();
        if ($clave == $fila["clave"]) {
          return(true);
        } else {
          return(false);
        }
      } else {
        return(false);
      }
    }

    function autorizar($uid) {
      $uid = strtoupper($uid);
      $db = new MySQL();
      $consulta = $db->sql_query("SELECT * FROM `aplicacion_roles` WHERE `uid` = '" . $uid . "'");
      $numero_registros = $db->sql_numrows($consulta);
      for ($i = 0; $i < $numero_registros; $i++) {
        $roles[$i] = $db->sql_fetchrow($consulta);
      }

      for ($i = 0; $i < count($roles); $i++) {
        $consulta = $db->sql_query("SELECT * FROM `aplicacion_permisos` WHERE `rid` = '" . $roles[$i][0] . "' ORDER BY `rid`,`pid`");
        $numero_registros = $db->sql_numrows($consulta);
        for ($j = 0; $j < $numero_registros; $j++) {
          $permisos[$j] = $db->sql_fetchrow($consulta);
          $_SESSION[$permisos[$j][1]] = true;
        }
      }

      $db->sql_close();
    }

    function combo($selected) {
      return($this->combo_consulta("usuarios", "alias", "usuario", "usuarios_usuarios", $selected, "", "height:30px; width:160px; font-size:24px;margin:0; padding-bottom:3"));
    }

    function combo_consulta($id, $etiquetas, $valores, $tabla, $selected, $condicion = "", $class = "", $disabled = false) {
      if (empty($selected)) {
        $selected = isset($_REQUEST['_' . $id]) ? $_REQUEST['_' . $id] : "";
      }
      $disabled = ($disabled) ? "disabled=\"disabled\"" : "";
      $condicion = empty($condicion) ? "" : "WHERE(" . $condicion . ")";
      $db = new MySQL();
      $sql = "SELECT * FROM `" . $tabla . "` " . $condicion . " ORDER BY `" . $etiquetas . "`";
      $consulta = $db->sql_query($sql);
      $html = ('<select name="' . $id . '"id="' . $id . '" class="' . $class . '" ' . $disabled . '>');
      $conteo = 0;
      while ($fila = $db->sql_fetchrow($consulta)) {
        $html.=('<option value="' . $fila[$valores] . '"' . (($selected == $fila[$valores]) ? "selected" : "") . '>' . $fila['usuario'] . ":  " . $fila['alias'] . '</option>');
        $conteo++;
      }
      $db->sql_close();
      $html.=("</select>");
      return($html);
    }

    function combo_estado($id, $selected, $class) {
      return($this->select($id, array("Activo", "Deshabilitado"), array("ACTIVO", "DESHABILITADO"), $selected, $class));
    }

    //\\//\\//\\//\\//\\//\\ Estadisticas & Conteos //\\//\\//\\//\\//\\//\\

    function conteo($sql = "") {
      $db = new MySQL();
      $sql = "SELECT Count(`usuario`) AS `conteo` FROM `usuarios_usuarios` " . $sql . ";";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      return(intval($fila['conteo']));
    }

    /**
     * Consulta si un usuario tiene a su disposicion un sierto permiso
     * @param type $permiso
     */

    /**
     * Este metodo permite determinar si un alias es decir un nombre de usuario ya se encuentra registrado en el sistema
     * @param type $alias
     * @return type boolean
     */
    function alias_existente($alias) {
      $db = new MySQL();
      $existencia = $db->sql_query("SELECT * FROM `usuarios_usuarios` WHERE `alias`='" . $alias . "' ;");
      $existe = $db->sql_numrows($existencia);
      $db->sql_close();
      if ($existe == 0) {
        return(false);
      } else {
        return(true);
      }
    }

    function permiso($permiso, $usuario) {
      $politicas = new Usuarios_Politicas();
      $jerarquias = new Usuarios_Jerarquias();
      $roles = $jerarquias->consultar($usuario);
      foreach ($roles as $rol) {
        $asignado = $politicas->consultar($rol['rol'], $permiso);
        if (!empty($asignado['permiso'])) {
          return(true);
        }
      }
      return(false);
    }

    function empleado($usuario) {
      $usuario = $this->consultar($usuario);
      $empleado = $usuario['empleado'];
      $db = new MySQL();
      $sql = "SELECT * FROM `empleados_empleados` WHERE `empleado` = '" . $empleado . "'";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($fila);
    }

    /**
     *  Retorna un elemento html tipo select que contiene los posibles criterios a usar en el componente de 
     * busqueda
     * 
     * @param type $nombre
     * @param type $seleccionado
     * @return type
     */
    function criterios($nombre, $seleccionado) {
      $etiquetas = array("Código del Usuario", "Alias");
      $valores = array("usuario", "alias");
      return($this->select($nombre, $etiquetas, $valores, $seleccionado, ""));
    }

    function nombre($usuario) {
      $cadenas = new Cadenas();
      $usuario = $this->consultar($usuario);
      $db = new MySQL();
      $sql = "SELECT * FROM `usuarios_perfiles` WHERE `perfil` = '" . $usuario['perfil'] . "'";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      return($cadenas->capitalizar($fila['nombres'] . " " . $fila["apellidos"]));
    }

    function perfil($perfil) {
      $cadenas = new Cadenas();
      $db = new MySQL();
      $sql = "SELECT * FROM `usuarios_perfiles` WHERE `perfil` = '" . $perfil . "'";
      $consulta = $db->sql_query($sql);
      $fila = $db->sql_fetchrow($consulta);
      $db->sql_close();
      if (empty($fila)) {
        echo($sql);
      }
      return($fila);
    }

    /**
     * Este metodo retorna la totalidad de los datos asociados a un usuario 
     * especifico proporsionado el codigo del usuario se retornara un vector con
     * la informacion disponible tanto en la tabla usuarios como en perfiles.
     * @param type $usuario
     * @return type
     */
    function usuario($usuario) {
      $u = $this->consultar($usuario);
      $p = $this->perfil($u["perfil"]);
      return(array_merge($u, $p));
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

    /**
     * Este metodo confirma la version de la libreria.
     * 2015-10-02: Creacion del metodo usuario();
     * @return type
     */
    function version() {
      return("4.0");
    }

  }

}
?>
<?php
$sesion=new Sesion();
$cadenas = new Cadenas();
$fechas = new Fechas();
$paises = new Paises();
$regiones = new Regiones();
$ciudades = new Ciudades();
$sectores = new Sectores();
$modulos = new Aplicacion_Modulos();
$componentes = new Aplicacion_Modulos_Componentes();
$funciones = new Funciones();
$permisos = new Usuarios_Permisos();
$validaciones=new Validaciones();

/** Valores * */
$usuario=Sesion::usuario();
$valores['componente'] = time();
$valores['titulo'] = @$_REQUEST["_titulo"];
$valores['descripcion'] = @$_REQUEST["_descripcion"];
$valores['funcion'] = @$_REQUEST["_funcion"];
$valores['icono'] = "i033x033_componente";
$valores['peso'] = "00";
$valores['herencia'] =$validaciones->recibir("herencia");
$valores['permiso'] = @$_REQUEST["_permiso"];
$valores['estado'] = "ACTIVO";
$valores['fecha'] = $fechas->hoy();
$valores['hora'] = $fechas->ahora();
$valores['creador'] = $usuario['usuario'];
/** Campos * */
$f->campos['componente'] = $f->text("componente", $valores['componente'], "10", "required codigo", true);
$f->campos['titulo'] = $f->text("titulo", $valores['titulo'], "128", "required", false);
$f->campos['descripcion'] = $f->text("descripcion", $valores['descripcion'], "256", "required", false);
$f->campos['funcion'] = $funciones->combo("funcion", $valores['funcion']);
$f->campos['icono'] = $f->text("icono", $valores['icono'], "256", "required", false);
$f->campos['peso'] = $f->text("peso", $valores['peso'], "2", "required", false);
$f->campos['herencia'] = $componentes->combo("herencia", $valores['herencia']);
$f->campos['permiso'] = $permisos->combo("permiso", $valores['permiso']);
$f->campos['estado'] = $f->text("estado", $valores['estado'], "128", "", false);
$f->campos['fecha'] = $f->text("fecha", $valores['fecha'], "10", "automatico required", true);
$f->campos['hora'] = $f->text("hora", $valores['hora'], "8", "automatico required", true);
$f->campos['creador'] = $f->text("creador", $valores['creador'], "10", "automatico required", true);
$f->campos['registrar'] = $f->button("registrar" . $f->id, "submit", "Registrar");
$f->campos['cancelar'] = $f->button("cancelar" . $f->id, "button", "Cancelar");
/** Celdas * */
$f->celdas["componente"] = $f->celda("Componente:", $f->campos['componente'], "", "w100");
$f->celdas["titulo"] = $f->celda("Titulo:", $f->campos['titulo']);
$f->celdas["descripcion"] = $f->celda("Descripcion:", $f->campos['descripcion']);
$f->celdas["funcion"] = $f->celda("Funcion:", $f->campos['funcion']);
$f->celdas["icono"] = $f->celda("Icono:", $f->campos['icono']);
$f->celdas["peso"] = $f->celda("Peso:", $f->campos['peso']);
$f->celdas["herencia"] = $f->celda("Herencia (Componente):", $f->campos['herencia']);
$f->celdas["permiso"] = $f->celda("Permiso:", $f->campos['permiso']);
$f->celdas["estado"] = $f->celda("Estado:", $f->campos['estado']);
$f->celdas["fecha"] = $f->celda("Fecha:", $f->campos['fecha'], "", "w100");
$f->celdas["hora"] = $f->celda("Hora:", $f->campos['hora'], "", "w100");
$f->celdas["creador"] = $f->celda("Usuario (Creador):", $f->campos['creador'], "", "w100");
/** Filas * */
$f->fila["fila1"] = $f->fila($f->celdas["componente"] . $f->celdas["herencia"].$f->celdas["permiso"]);
$f->fila["fila2"] = $f->fila($f->celdas["titulo"] . $f->celdas["descripcion"]);
$f->fila["fila3"] = $f->fila($f->celdas["funcion"]);
$f->fila["fila4"] = $f->fila($f->celdas["icono"] . $f->celdas["peso"].$f->celdas["estado"] );
$f->fila["fila5"] = $f->fila($f->celdas["fecha"] . $f->celdas["hora"].$f->celdas["creador"]);
/** Compilando * */
$f->filas($f->fila['fila1']);
$f->filas($f->fila['fila2']);
$f->filas($f->fila['fila3']);
$f->filas($f->fila['fila4']);
$f->filas($f->fila['fila5']);
$f->botones($f->campos['cancelar'],"inferior-derecha");
$f->botones($f->campos['registrar'],"inferior-derecha");
?>
<script type="text/javascript">
  MUI.resizeWindow($('<?php echo($f->ventana); ?>'), {width: 640, height: 315, top: 0, left: 0});
  MUI.centerWindow($('<?php echo($f->ventana); ?>'));
</script>
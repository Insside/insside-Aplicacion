<?php
$root = (!isset($root)) ? "../../../../" : $root;
require_once($root . "modulos/usuarios/librerias/Configuracion.cnf.php");
$fechas = new Fechas();
?>
<div id="desktopTitlebarWrapper">
  <div id="desktopTitlebar">
    <!-- Logotipos & MArcas //-->
    <div class="marca">
      <div class="logo_insside_64x52 o50"></div>
      <div class="plataforma o50">INSSIDE FRAMEWORK</div>
      <div class="aplicativo o90">IMIS</div>
      <div class="plataforma o50">AGUAS DE BUGA S.A. E.S.P</div>
    </div>
    <!-- Reloj //-->
    <div class="reloj">
      <div class="etiqueta">FECHA & HORA</div>
      <div id="divLocalClock" class="MUI clock">08:00</div>
      <div class="etiqueta"><?php echo($fechas->hoy()); ?></div>
    </div>
 
    <!-- Usuario //-->
    <div class="perfil">
      <a href="#" onclick="MUI.Aplicacion_Opciones('<?php echo($usuario["usuario"]); ?>');">
        <div class="foto"><img src="<?php echo($usuario["perfil"]["foto"]); ?>" alt="Usuario"/></div>
        <div class="etiqueta">USUARIO</div>
        <div class="nombre"><?php echo($usuario["nombre"]); ?></div>
        <div class="etiqueta">OPCIONES</div>
      </a>
    </div>
    <!-- Usuario //-->
       <!-- Conector //-->
    <div class="reloj_remoto">
      <div class="etiqueta">ULTIMA CONEXIÓN  </div>
      <div id="divRemoteClock" class="MUI Clock">08:00</div>
      <div class="etiqueta"><?php echo($fechas->hoy()); ?></div>
    </div>



    <!--
    <h1 class="applicationTitle">INSSIDE 2015</h1>
    <h2 class="tagline">AGUAS DE BUGA <span class="taglineEm">S.A. E.S.P. 2015</span></h2>
    <div id="topNav">
      <ul class="menu-right">
        <li>Bienvenido! <a href="#" onclick="InssideUI.notification('Do Something');
            return false;"><?php echo($usuario['alias']); ?></a></li>
        <li><a href="<?php echo(basename(__FILE__)); ?>?accion=finalizar">Salir</a></li>
      </ul>
    </div>
    -->


  </div>
</div>
<!-- JavaScript v0.1 //-->
<script type="text/javascript">
  var localClock = new MUI.Clock($("divLocalClock"), {});
  var remoteClock= new MUI.Clock($("divRemoteClock"), {});
</script>

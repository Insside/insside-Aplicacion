<?php
$f->fila["fila1"] = $f->fila($f->celdas["estilo"] . $f->celdas["clase"] . $f->celdas["subclase"] . $f->celdas["etiqueta"] . $f->celdas["estado"] . $f->celdas["version"]);
$f->fila["fila2"] = $f->fila($f->celdas["css"]);
$f->fila["css_general"] = $f->fila["fila1"] . $f->fila["fila2"];
?>
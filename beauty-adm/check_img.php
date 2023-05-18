<?php

    $img = $_FILES['imagen']['name'];
    $tipo = $_FILES['imagen']['type'];
    $tam = $_FILES['imagen']['size'];
    $ext_permitidas = array('jpg');
    $partes_nombre = explode('.', $img);
    $extension = end( $partes_nombre );
    $ext_correcta = in_array($extension, $ext_permitidas);
    $limite = 500 * 1024;
  $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);
  If (!( $ext_correcta)){
      echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Tipo de archivo no permitido, solo se admiten imagenes formato .jpg</font></div>';

  }
     if ($tam <= $limite && $ext_correcta){
    
   } else {
    echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Imagen de tamaño mas grande que el permitido.</font></div>';
}

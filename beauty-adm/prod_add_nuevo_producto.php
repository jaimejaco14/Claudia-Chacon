<?php 
include '../cnx_data.php';

    $caracteristicas    = $_POST['caracteristicas'];
    $impuesto           = $_POST['sel_impuesto'];
    $sel_unimedida      = $_POST['sel_unimedida'];
    $cod_anterior       = $_POST['cod_anterior'];
    $producto           = $_POST['producto'];
    $descripcion        = $_POST['descripcion'];
    $alias              = $_POST['alias'];
    $precio_f           = $_POST['precio_f'];
    $ctrl_venc          = $_POST['ctrl_venc'];
    $proporcionado      = $_POST['proporcionado'];
    $tipo_com           = $_POST['sel_tipo'];
    $comision           = $_POST['comision'];
    $activo             = $_POST['activo'];
    $costo_inicial      = $_POST['costo_inicial'];
    

    $sql = mysqli_query($conn, "SELECT MAX(procodigo) as maxid FROM btyproducto");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;

    


if($_FILES["file_nuevo"]["name"] != ''){


    if ( $precio_f == null) {
         $precio_f = 0;
    }

    if ($ctrl_venc == null) {
        $ctrl_venc = 0;
    }

    if ($proporcionado == null) {
        $proporcionado = 0;
    }

    if ($activo == null) {
        $activo = 0;
    }

   
    


    $img  = $_FILES['file_nuevo']['name'];
    $tipo = $_FILES['file_nuevo']['type'];
    $tam  = $_FILES['file_nuevo']['size'];
    $ext_permitidas = array('jpg');
    $partes_nombre = explode('.', $img);
    $extension = end( $partes_nombre );
    $ext_correcta = in_array($extension, $ext_permitidas);
    $limite = 1024 * 500;
    $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);

    if (!( $ext_correcta)){
      echo 1;
    }else{

            if ($tam <= $limite && $ext_correcta){
                    $ruta       = "../contenidos/imagenes/producto/";
                    $img        = $_FILES['file_nuevo']['name'];
                    $archivo    = $_FILES['file_nuevo']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    if(move_uploaded_file($archivo,$ruta.$maxid.".".$extension)){
                        $sub=4;
                    }else{
                        $sub='error: '.$_FILES['file_nuevo']['error'];
                    }
                    $imagen = ($maxid).".".$extension;

                    $cons = mysqli_query($conn, "INSERT INTO btyproducto(procodigo, crscodigo, imvcodigo, umecodigo, procodigoanterior, pronombre, prodescripcion, proimagen, proalias, propreciofijo, procontrolvencimiento, proporcionado, protipocomision, procomision, procreacion, proactivo, proestado, procostoinicial, proultactualizacion) VALUES ('$maxid', '$caracteristicas', $impuesto , '$sel_unimedida', $cod_anterior, '$producto', '$descripcion', '$imagen', '$alias', $precio_f, $ctrl_venc, $proporcionado, '$tipo_com', $comision, CURDATE(), $activo, 1, $costo_inicial, NULL) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo $sub;
                    }else{
                        echo 'Error sql';
                    }

            
            } else {
                echo 2;
            }
    }


    }else{
        if ( $precio_f == null) {
         $precio_f = 0;
    }

    if ($ctrl_venc == null) {
        $ctrl_venc = 0;
    }

    if ($proporcionado == null) {
        $proporcionado = 0;
    }

    if ($activo == null) {
        $activo = 0;
    }

        $cons = mysqli_query($conn, "INSERT INTO btyproducto(procodigo, crscodigo, imvcodigo, umecodigo, procodigoanterior, pronombre, prodescripcion, proimagen, proalias, propreciofijo, procontrolvencimiento, proporcionado, protipocomision, procomision, procreacion, proactivo, proestado, procostoinicial,proultactualizacion) VALUES ('$maxid', '$caracteristicas', $impuesto , '$sel_unimedida', $cod_anterior, '$producto', '$descripcion', 'default.jpg', '$alias', $precio_f, $ctrl_venc, $proporcionado, '$tipo_com', $comision, CURDATE(), $activo, 1, $costo_inicial, NULL) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
    }

    mysqli_close($conn);
?>
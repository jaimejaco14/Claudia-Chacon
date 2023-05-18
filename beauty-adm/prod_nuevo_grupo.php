<?php 
    include '../cnx_data.php';
    
    $grupo   = $_POST['txt_grupo'];
    $alias   = $_POST['txt_alias'];
    $descr   = $_POST['txt_descripcion'];
    
if($_FILES["file"]["name"] != ''){



    $sql = mysqli_query($conn, "SELECT MAX(grucodigo) as maxid FROM btygrupo");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;

    $img  = $_FILES['file']['name'];
    $tipo = $_FILES['file']['type'];
    $tam  = $_FILES['file']['size'];
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
                    $ruta       = "imagenes/producto/";
                    $img        = $_FILES['file']['name'];
                    $archivo    = $_FILES['file']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$maxid.".".$extension);
                    $imagen = ($maxid).".".$extension;

                    $cons = mysqli_query($conn, "INSERT INTO btygrupo(grucodigo, tpocodigo, grunombre, grualias, grudescripcion, gruimagen, gruestado) VALUES ('$maxid', 1, '".strtoupper($grupo)."', '".strtoupper($alias)."', '".strtoupper($descr)."', '$imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
            } else {
                echo 2;
            }
    }


    }else{
        $sql = mysqli_query($conn, "SELECT MAX(grucodigo) as maxid FROM btygrupo");
        $e = mysqli_fetch_array($sql);
        $maxid = $e[0]+1;

        $cons = mysqli_query($conn, "INSERT INTO btygrupo(grucodigo, tpocodigo, grunombre, grualias, grudescripcion, gruimagen, gruestado) VALUES ('$maxid', 1, '".strtoupper($grupo)."', '".strtoupper($alias)."', '".strtoupper($descr)."', '', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
    }

    mysqli_close($conn);
?>
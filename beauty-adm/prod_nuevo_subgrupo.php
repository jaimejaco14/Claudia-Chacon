<?php 
    include '../cnx_data.php';

    $grupo      = $_POST['grupo'];
    $subgrupo   = $_POST['txt_subgrupo'];
    $subalias   = $_POST['txt_subalias'];
    $subdescr   = $_POST['txt_subdescripcion'];

    $sql = mysqli_query($conn, "SELECT MAX(sbgcodigo) as maxid FROM btysubgrupo");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;
    
if($_FILES["subfile"]["name"] != ''){




    $img  = $_FILES['subfile']['name'];
    $tipo = $_FILES['subfile']['type'];
    $tam  = $_FILES['subfile']['size'];
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
                    $img        = $_FILES['subfile']['name'];
                    $archivo    = $_FILES['subfile']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$maxid.".".$extension);
                    $imagen = ($maxid).".".$extension;

                    $cons = mysqli_query($conn, "INSERT INTO btysubgrupo(sbgcodigo, grucodigo, sbgnombre, sbgalias, sbgdescripcion, sbgimagen, sbgestado) VALUES ('$maxid', $grupo, '".strtoupper($subgrupo)."', '".strtoupper($subalias)."', '".strtoupper($subdescr)."', '$imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
            } else {
                echo 2;
            }
    }


    }else{
        $cons = mysqli_query($conn, "INSERT INTO btysubgrupo(sbgcodigo, grucodigo, sbgnombre, sbgalias, sbgdescripcion, sbgimagen, sbgestado) VALUES ('$maxid', $grupo, '".strtoupper($subgrupo)."', '".strtoupper($subalias)."', '".strtoupper($subdescr)."', '', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

    }

    mysqli_close($conn);
?>
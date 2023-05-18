<?php 
    include '../cnx_data.php';

    $sublinea       = $_POST['sublinea'];
    $caracter       = $_POST['txt_caracteristica'];
    $carac_alias    = $_POST['txt_car_alias'];
    $carac_desc     = $_POST['txt_car_descp'];


    $sql = mysqli_query($conn, "SELECT MAX(crscodigo) as maxid FROM btycaracteristica");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;

if($_FILES["car_file"]["name"] != ''){


    $img  = $_FILES['car_file']['name'];
    $tipo = $_FILES['car_file']['type'];
    $tam  = $_FILES['car_file']['size'];
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
                    $img        = $_FILES['car_file']['name'];
                    $archivo    = $_FILES['car_file']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$maxid.".".$extension);
                    $imagen = ($maxid).".".$extension;
                    

                    $cons = mysqli_query($conn, "INSERT INTO btycaracteristica(crscodigo, sblcodigo, crsnombre, crsalias, crsdescripcion, crsimagen, crsestado) VALUES ('$maxid', $sublinea, '".strtoupper($caracter)."', '".strtoupper($carac_alias)."', '".strtoupper($carac_desc)."', '$imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
          } else {
                echo 2;
            }
    }


    }else{
        $imagen = "default.jpg";
        $cons = mysqli_query($conn, "INSERT INTO btycaracteristica(crscodigo, sblcodigo, crsnombre, crsalias, crsdescripcion, crsimagen, crsestado) VALUES ('$maxid', $sublinea, '".strtoupper($caracter)."', '".strtoupper($carac_alias)."', '".strtoupper($carac_desc)."', ' $imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
    }

    mysqli_close($conn);
?>
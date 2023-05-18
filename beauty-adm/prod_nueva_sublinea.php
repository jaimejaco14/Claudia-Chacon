<?php 
    include '../cnx_data.php';

    $linea          = $_POST['linea'];
    $sublinea       = $_POST['txt_sublinea'];
    $sublin_lias    = $_POST['txt_sublin_alias'];
    $sublinsubdescr = $_POST['txt_sublin_descricpion'];


    $sql = mysqli_query($conn, "SELECT MAX(sblcodigo) as maxid FROM btysublinea");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;

if($_FILES["sublin_file"]["name"] != ''){


    $img  = $_FILES['sublin_file']['name'];
    $tipo = $_FILES['sublin_file']['type'];
    $tam  = $_FILES['sublin_file']['size'];
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
                    $img        = $_FILES['sublin_file']['name'];
                    $archivo    = $_FILES['sublin_file']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$maxid.".".$extension);
                    $imagen = ($maxid).".".$extension;

                    $cons = mysqli_query($conn, "INSERT INTO btysublinea(sblcodigo, lincodigo, sblnombre, sblalias, sbldescripcion, sblimagen, sblestado) VALUES ('$maxid', $linea, '".strtoupper($sublinea)."', '".strtoupper($sublin_lias)."', '".strtoupper($sublinsubdescr)."', '$imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
            } else {
                echo 2;
            }
    }


    }else{
        $cons = mysqli_query($conn, "INSERT INTO btysublinea(sblcodigo, lincodigo, sblnombre, sblalias, sbldescripcion, sblimagen, sblestado) VALUES ('$maxid', $linea, '".strtoupper($sublinea)."', '".strtoupper($sublin_lias)."', '".strtoupper($sublinsubdescr)."', '', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
    }

    mysqli_close($conn);
?>
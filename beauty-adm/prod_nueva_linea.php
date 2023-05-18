<?php 
    include '../cnx_data.php';

    $subgrupo    = $_POST['subgrupo'];
    $linea       = $_POST['txt_linea'];
    $lin_lias    = $_POST['txt_lin_alias'];
    $linsubdescr = $_POST['txt_lin_descricpion'];

    $sql = mysqli_query($conn, "SELECT MAX(lincodigo) as maxid FROM btylinea");
    $e = mysqli_fetch_array($sql);

    $maxid = $e[0]+1;
    
if($_FILES["lin_file"]["name"] != ''){


    $img  = $_FILES['lin_file']['name'];
    $tipo = $_FILES['lin_file']['type'];
    $tam  = $_FILES['lin_file']['size'];
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
                    $img        = $_FILES['lin_file']['name'];
                    $archivo    = $_FILES['lin_file']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$maxid.".".$extension);
                    $imagen = ($maxid).".".$extension;

                    $cons = mysqli_query($conn, "INSERT INTO btylinea(lincodigo, sbgcodigo, linnombre, linalias, lindescripcion, linimagen, linestado) VALUES ('$maxid', $subgrupo, '".strtoupper($linea)."', '".strtoupper($lin_lias)."', '".strtoupper($linsubdescr)."', '$imagen', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
            } else {
                echo 2;
            }
    }


    }else{
        $cons = mysqli_query($conn, "INSERT INTO btylinea(lincodigo, sbgcodigo, linnombre, linalias, lindescripcion, linimagen, linestado) VALUES ('$maxid', $subgrupo, '".strtoupper($linea)."', '".strtoupper($lin_lias)."', '".strtoupper($linsubdescr)."', '', 1) ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
    }

    mysqli_close($conn);
?>
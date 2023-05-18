<?php 
include '../../cnx_data.php';

$clbcodigo  = $_POST['clbcodigo'];
$documento  = $_POST['no_documento'];
$categoria  = $_POST['categoria'];
$cargo      = $_POST['cargo'];
$nombre     = utf8_decode($_POST['nombres']);
$apellido   = utf8_decode($_POST['apellidos']);
$razon_soc  = $nombre." ".$apellido;
$sexo       = $_POST['sexo'];
$fecha      = $_POST['fecha'];
$fecha_in   = $_POST['fecha_in'];
$direccion  = $_POST['direccion'];
$movil      = $_POST['telefono_movil'];
$fijo       = $_POST['telefono_fijo'];
$email      = $_POST['email'];
$barrio     = $_POST['barrio'];
$ruta       = "../../contenidos/imagenes/colaborador/beauty_erp/";
$ruta_rut   = "documentos/rut/";
$biometrico = $_POST['codbiometrico'];

//print_r($_POST);

if ($notif = $_POST['notif']){
$nmovil = "N";
$nemail = "N";
    for ($i=0;$i<count($notif);$i++)    
    {     
      if  ($notif[$i]==  "movil"){
          $nmovil = "S";
      }
      if  ($notif[$i]==  "email"){
          $nemail = "S";
      }
      
    }
}

/*if ($biometrico == "" || $biometrico == null) 
{
  $biometrico = NULL;
}*/

  

if($_FILES["rut"]["name"] != ''){

    $rut_img = $_FILES['rut']['name'];
    $archivo = $_FILES['rut']['tmp_name'];
    $file_type=$_FILES['rut']['type'];

    if ($file_type=="application/pdf") {

        $partes_nombre = explode('.', $rut_img);
        $extension = end( $partes_nombre );
        move_uploaded_file($archivo,$ruta_rut.$documento.".".$extension);
        $rut_img = $documento.".".$extension;

    }else{
        echo 2;
    }

    if($_FILES["file"]["name"] != ''){

        $img_name = $_FILES['file']['name'];
        $archivo = $_FILES['file']['tmp_name'];
         
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
        move_uploaded_file($archivo,$ruta.$documento.".".$extension);
        $img_name = $documento.".".$extension;

        $sql = mysqli_query($conn, "UPDATE btytercero SET trcnombres= '$nombre', trcapellidos = '$apellido', trcrazonsocial= '$razon_soc', trcdireccion = '$direccion', trctelefonofijo = '$fijo', trctelefonomovil ='$movil', brrcodigo = '$barrio' WHERE trcdocumento = '$documento'");


        $sql1 = mysqli_query($conn, "UPDATE `btycolaborador` SET `clbsexo`= '$sexo',`crgcodigo`='$cargo', `clbemail`='$email',`clbfechanacimiento`='$fecha', clbfechaingreso = '$fecha_in', `clbnotificacionemail`='$nemail',`clbnotificacionmovil`='$nmovil', ctccodigo = '$categoria', cblimagen = '$img_name', clbultactualizacion = CURDATE() WHERE clbcodigo = '".$clbcodigo."' ")or die(mysqli_error($conn));

        if ($sql1) {
          echo 1;
        }

    }else{
        $sql = mysqli_query($conn, "UPDATE btytercero SET trcnombres= '$nombre', trcapellidos = '$apellido', trcrazonsocial= '$razon_soc', trcdireccion = '$direccion', trctelefonofijo = '$fijo', trctelefonomovil ='$movil', brrcodigo = '$barrio' WHERE trcdocumento = '$documento'");


        $sql1 = mysqli_query($conn, "UPDATE `btycolaborador` SET `clbsexo`= '$sexo',`crgcodigo`='$cargo', `clbemail`='$email',`clbfechanacimiento`='$fecha', clbfechaingreso = '$fecha_in', `clbnotificacionemail`='$nemail',`clbnotificacionmovil`='$nmovil', ctccodigo = '$categoria', clbultactualizacion = CURDATE() WHERE clbcodigo = '".$clbcodigo."' ")or die(mysqli_error($conn));

          if ($sql1) {
            echo 1;
          }
    }


  }else{

      if($_FILES["file"]["name"] != ''){

        $img_name = $_FILES['file']['name'];
        $archivo = $_FILES['file']['tmp_name'];
         
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
        move_uploaded_file($archivo,$ruta.$documento.".".$extension);
        $img_name = $documento.".".$extension;

        $sql = mysqli_query($conn, "UPDATE btytercero SET trcnombres= '$nombre', trcapellidos = '$apellido', trcrazonsocial= '$razon_soc', trcdireccion = '$direccion', trctelefonofijo = '$fijo', trctelefonomovil ='$movil', brrcodigo = '$barrio' WHERE trcdocumento = '$documento'");


        $sql1 = mysqli_query($conn, "UPDATE `btycolaborador` SET `clbsexo`= '$sexo',`crgcodigo`='$cargo', `clbemail`='$email',`clbfechanacimiento`='$fecha', clbfechaingreso = '$fecha_in', `clbnotificacionemail`='$nemail',`clbnotificacionmovil`='$nmovil', ctccodigo = '$categoria', cblimagen = '$img_name' WHERE clbcodigo = '".$clbcodigo."' ")or die(mysqli_error($conn));

        if ($sql1) {
          echo 1;
        }else{
          echo "pailas";
        }

    }else{
        $sql = mysqli_query($conn, "UPDATE btytercero SET trcnombres= '$nombre', trcapellidos = '$apellido', trcrazonsocial= '$razon_soc', trcdireccion = '$direccion', trctelefonofijo = '$fijo', trctelefonomovil ='$movil', brrcodigo = '$barrio' WHERE trcdocumento = '$documento'");


        $sql1 = mysqli_query($conn, "UPDATE `btycolaborador` SET `clbsexo`= '$sexo',`crgcodigo`='$cargo', `clbemail`='$email',`clbfechanacimiento`='$fecha', clbfechaingreso = '$fecha_in', `clbnotificacionemail`='$nemail',`clbnotificacionmovil`='$nmovil', ctccodigo = '$categoria' WHERE clbcodigo = '".$clbcodigo."' ")or die(mysqli_error($conn));

          if ($sql1) {
            echo 1;
          }
    }

  }

 mysqli_close($conn);

?>
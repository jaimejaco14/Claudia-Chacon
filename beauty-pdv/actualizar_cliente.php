<?php

include("../cnx_data.php");
// Recibimos por POST los datos procedentes del formulario  
$tabla_db1 = "btytercero";
$tipo_documento = $_POST["tipo_documento"];
$externo=$_POST['externo'];
$nombre = $_POST["nombres"];    
$apellidos = $_POST["apellidos"];
$sexo = $_POST["sexo"];
$documento = $_POST["no_documento"];
$ocupacion = $_POST["ocupacion"];
$barrio = $_POST["barrio"];
if ($_POST["telefono_fijo"] != "") {
  $telefono_fijo = $_POST["telefono_fijo"];
} 
else {
  $telefono_fijo = " ";
}

$telefono_movil = $_POST["telefono_movil"];
$email = $_POST["email"];  
$fecha = $_POST["fecha"];
$direccion = $_POST["direccion"];
$empresa = $_POST["tipo_nombre"];
$razon_social = $_POST["razon_social"];
$dv = $_POST["dv"];
$notif =$_POST["notif"];
$nmovil = "N";
$nemail = "N";
if($fecha==""){
    $v5="null";
}else{
    $v5="'".$fecha."'";
}
if ($_POST['extr'] != "") {
  $extr = $_POST['extr'];
  $barrio = 0;
  $direccion = " ";
} 
else {
  $extr = "N";
}

for ($i=0;$i<count($notif);$i++){     
  if  ($notif[$i]==  "movil"){
    $nmovil = "S";
  }
  if  ($notif[$i]==  "email"){
    $nemail = "S";
  }
  
}
if ($empresa == "S"){
  $ocupacion = 0;
}

  
  $razon = $nombre." ".$apellidos;
  if ($empresa == "S"){
    if(strlen($razon_social)>1){
      $sql="UPDATE btytercero SET  trcnombres='$nombre', trcapellidos='$apellidos', trcrazonsocial='$razon_social', trcdireccion='$direccion', trctelefonofijo='$telefono_fijo', trctelefonomovil='$telefono_movil', brrcodigo='$barrio' WHERE trcdocumento='$documento'";
    }else{
      echo "FALSECAMPO";
          exit();
    }
    
  } 
  else{
    $a=strlen($nombre);
    $b=strlen($apellidos);
    $c=strlen($razon);
    $d=strlen($sexo);
    $e=strlen($ocupacion);



        if(($a*$b*$c*$d*$e)==0){
          echo "FALSECAMPO";
          exit();
        }else{
          $sql="UPDATE btytercero SET tdicodigo='$tipo_documento', trcnombres='$nombre', trcapellidos='$apellidos', trcrazonsocial='$razon', trcdireccion='$direccion', trctelefonofijo='$telefono_fijo', trctelefonomovil='$telefono_movil', brrcodigo='$barrio', trcestado='1' WHERE trcdocumento='$documento'";
        }   
  }
  if (mysqli_query($conn, $sql)) {
      $sql= "SELECT trcdocumento from btycliente where trcdocumento = '$documento'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        $sql="UPDATE btycliente SET cliemail = '$email', ocucodigo = '$ocupacion',clifechanacimiento=$v5 WHERE trcdocumento='$documento'";
        if(mysqli_query($conn,$sql)){
          echo "TRUE";
        }
      } 
      else {
        include 'insert_new_cliente.php';
      }
  }else{
    echo "FALSE";
  }
  
?>
<?php
include '../cnx_data.php';

// Recibimos por POST los datos procedentes del formulario  
$tipo_documento = $_POST["tipo_documento"];
$nombre = $_POST["nombres"];    
$apellidos = $_POST["apellidos"];
$sexo = $_POST["sexo"];
$documento = $_POST["no_documento"];
$ocupacion = $_POST["ocupacion"];
if ("" == $_POST["barrio"]){
	$barrio = $_POST['id_brr'];
} elseif ("" != $_POST["barrio"]) {
	# code...
	$barrio =$_POST["barrio"];
}
$telefono_fijo = $_POST["telefono_fijo"];
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

for ($i=0;$i<count($notif);$i++)    
{     
  if  ($notif[$i]==  "movil"){
      $nmovil = "S";
  }
  if  ($notif[$i]==  "email"){
      $nemail = "S";
  }
  
}

if ($empresa == "S"){
	
	$sexo = 0;
    $ocupacion = 0;
    $sql = "UPDATE `btytercero` SET `trcnombres`= ' ',`trcapellidos`= ' ',`trcrazonsocial`='$razon_social',`trcdireccion`='$direccion',`trctelefonofijo`=$telefono_fijo,`trctelefonomovil`=$telefono_movil, `brrcodigo`= $barrio WHERE trcdocumento =".$documento;

} else {

	$razon_social = $nombre." ".$apellidos;
	$sql = "UPDATE `btytercero` SET `trcnombres`= '$nombre',`trcapellidos`= '$apellidos',`trcrazonsocial`='$razon_social',`trcdireccion`='$direccion',`trctelefonofijo`='$telefono_fijo',`trctelefonomovil`='$telefono_movil',`brrcodigo`='$barrio' WHERE trcdocumento = $documento";

}


if (mysqli_query($conn, $sql)) {

	$sql1 = "UPDATE `btycliente` SET `clisexo`= '$sexo',`ocucodigo`='$ocupacion',`cliemail`='$email', `clifechanacimiento`='$fecha',`clinotificacionemail`='$nemail',`clinotificacionmovil`= '$nmovil',`cliempresa`='$empresa' WHERE trcdocumento = $documento";
	if (mysqli_query($conn, $sql1)) {
		 echo "TRUE";
		} else {
    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
}


   
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
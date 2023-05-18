<?php 

include '../../cnx_data.php';
// Recibimos por POST los datos procedentes del formulario  
$tipo_documento = $_POST["tipo_documento"];
$nombre         = utf8_decode($_POST["nombres"]);    
$apellidos      = utf8_decode($_POST["apellidos"]);
$sexo           = $_POST["sexo"];
$documento      = $_POST["no_documento"];
$cargo          = $_POST['cargo'];
$barrio         = $_POST["barrio"];
$telefono_fijo  = $_POST["telefono_fijo"];
$telefono_movil = $_POST["telefono_movil"];
$email          = $_POST["email"];  
$fecha          = $_POST["fecha"];
$direccion      = $_POST["direccion"];
$empresa        = $_POST["tipo_nombre"];
$razon_social   = $_POST["razon_social"];
$dv             = $_POST["dv"];
$notif          = $_POST["notif"];
$nmovil         = "N";
$nemail         = "N";
$categoria      = $_POST['Categoria'];
$tivincu        = $_POST['tivincu'];
$vinculador     = $_POST['vinculador'];


for ($i=0;$i<count($notif);$i++)    
{     
  if  ($notif[$i]==  "movil"){
      $nmovil = "S";
  }
  if  ($notif[$i]==  "email"){
      $nemail = "S";
  }
  
}


$sql = "SELECT * from btytercero where trcdocumento = '$documento'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {


    include 'insert_colaborador.php';
    // output data of each row
    
} else {
    
  
$razon = $nombre." ".$apellidos;

$sql = mysqli_query($conn, "INSERT INTO btytercero(tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES ('$tipo_documento','$documento','$dv','$nombre', '$apellidos','$razon','$direccion', '$telefono_fijo', '$telefono_movil', '$barrio', '1')")or die(mysqli_error($conn)); 

if ($sql){
    //echo "New record created successfully";
    include 'insert_colaborador.php';
} else {
   // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
  
}




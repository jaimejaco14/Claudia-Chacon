<?php
$secret = "6LcQ9S4UAAAAAIFpvWZS4-aJleleIHrQBgAvsfxt";
 include '../../cnx_data.php';
  
$tabla_db1        = "btytercero";
$tipo_documento   = $_POST["tipo_documento"];
$externo          = $_POST['externo'];
$nombre           = $_POST["nombres"];    
$apellidos        = $_POST["apellidos"];
$sexo             = $_POST["sexo"];
$documento        = $_POST["no_documento"];
$ocupacion        = $_POST["ocupacion"];
$barrio           = $_POST["barrio"];


if ($_POST["telefono_fijo"] != "") 
{
    $telefono_fijo = $_POST["telefono_fijo"];
} 
else 
{
    $telefono_fijo = " ";
}

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


if ($_POST['extr'] != "") 
{
    $extr = $_POST['extr'];
    $barrio = 0;
    $direccion = " ";
} 
else 
{
    $extr = "N";
}

for ($i=0;$i<count($notif);$i++)
{     
      if  ($notif[$i]==  "movil")
      {
        $nmovil = "S";
      }
      if  ($notif[$i]==  "email")
      {
        $nemail = "S";
      }
}


if ($empresa == "S")
{
  $ocupacion = 0;
}


$sql = "SELECT * from btytercero where trcdocumento = '$documento'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    $conn->close();
    include 'insert_new_cliente.php';
  
} 
else 
{  
  
    $razon = $nombre." ".$apellidos;
    if ($empresa == "S")
    {
        
        $sql = "INSERT INTO btytercero(tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES (1,'$documento','$dv',' ', ' ','$razon_social','$direccion', '$telefono_fijo', '$telefono_movil', '$barrio', '1')";
    } 
    else
    {
        $sql = "INSERT INTO btytercero(tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, brrcodigo, trcestado) VALUES ('$tipo_documento','$documento','$dv','$nombre', '$apellidos','$razon','$direccion', '$telefono_fijo', '$telefono_movil', '$barrio', '1')"; 
    }


    if (mysqli_query($conn, $sql)) 
    {
        $conn->close();
        include 'insert_new_cliente.php';
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}


?>
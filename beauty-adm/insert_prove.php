<?php 
include '../cnx_data.php';


 $doco=$_POST['doc'];
 $correo=$_POST['correo'];
 $nombre=$_POST['nombre'];
 $apellido=$_POST['apellido'];
 $barrio=$_POST['barri'];
 $direccion=$_POST['direccion'];
 $telmovil=$_POST['telmovil'];
 $telfijo=$_POST['telfijo'];
 $tipo=$_POST['typo'];
 $rzon=$_POST['razon'];


if ($tipo>1) 
{
	$concat=$nombre." ".$apellido;

	$sql="INSERT INTO `btytercero`(`tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo`, `trcestado`) VALUES ($tipo,$doco,0,'$nombre','$apellido','$concat','$direccion',$telfijo,$telmovil,$barrio,1)";
	if (mysqli_query($conn, $sql)) 
	{
		echo "TRUE";	 
			 
	} 
	else 
	{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

}
else
{

	$sql="INSERT INTO `btytercero`(`tdicodigo`, `trcdocumento`, `trcdigitoverificacion`, `trcnombres`, `trcapellidos`, `trcrazonsocial`, `trcdireccion`, `trctelefonofijo`, `trctelefonomovil`, `brrcodigo`, `trcestado`) VALUES ($tipo,$doco,0,'$rzon','$rzon','$rzon','$direccion',$telfijo,$telmovil,$barrio,1)";

	if (mysqli_query($conn, $sql)) 
	{
		echo "TRUE";	 
			 
	} 
	else 
	{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}


$crr=$_POST['correo'];
$dct=$_POST['doc'];
$tpy=$_POST['typo'];


$sqll= "SELECT * FROM `btyproveedor`";

     	
     	if ($conn->query($sqll))
     	{
            $sqlmax = "SELECT MAX(`prvcodigo`) as m FROM `btyproveedor`";
                                  
            $max = $conn->query($sqlmax);
                  
                  if ($max->num_rows > 0) 
                  {
                        while ($row = $max->fetch_assoc()) 
                        {
                              $cod = $row['m']+1;
                        } 
                  } 
                  else 
                  {
                        $cod = 0;
                                    
                  }
      }




$sql="INSERT INTO `btyproveedor`(`prvcodigo`, `trcdocumento`, `tdicodigo`, `prvemail`, `prvestado`) VALUES ($cod,'$dct','$tpy','$crr',1)";
if (mysqli_query($conn, $sql)) 
{
 	echo "TRUE";
    
    	$conn->close();
 
} 
else 
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


 ?>
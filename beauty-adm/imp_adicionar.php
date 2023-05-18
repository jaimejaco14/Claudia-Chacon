<?php 
include '../cnx_data.php';

$code=$_POST['cod'];
$nom=$_POST['nom'];
$alias=$_POST['alias'];
$tipo=$_POST['tipo'];
$valor=$_POST['valor'];



$sqlb="SELECT * FROM `btyimpuesto_ventas` WHERE imvnombre ='$nom' or imvalias='$alias'";
	$result = $conn->query($sqlb);
		if ($result->num_rows > 0) {

				$sqlb="SELECT * FROM `btyimpuesto_ventas` WHERE (imvnombre ='$nom' or imvalias='$alias') and imvestado=0";
				$result = $conn->query($sqlb);
					if ($result->num_rows > 0) {
						echo "EL REGISTRO SE ENCUENTRA INACTIVO DESEA ACTIVARLO?";
					}else{
						echo"EL REGISTRO YA SE ENCUENTRA, POR FAVOR ASIGNE OTRO NOMBRE Y ALIAS";
					}
		}else{

			$sql="INSERT INTO `btyimpuesto_ventas`(`imvcodigo`, `imvnombre`, `imvalias`, `imvporcentaje`, `imvalor`, `imvestado`) VALUES ($code,'$nom','$alias', '$tipo', '$valor',1)";
					if (mysqli_query($conn, $sql)) { 
						echo "REGISTRO GUARDADO EXITOSAMENTE";
							//echo "New record created successfully";

					} else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
						echo "Error updating record: " . $conn->error;
					}
		}
	
 ?>



<?php 
session_start();
include '../cnx_data.php';

$code=$_POST['codigo'];
$nom=$_POST['nombre'];
$alias=$_POST['alias'];

	if ($_POST['codigo']!="") {
		if ($_POST['nombre']!="") {
			if ($_POST['alias']) {
					$sqlb="SELECT * FROM `btyunidad_medida` WHERE umenombre ='$nom' or umealias='$alias'";
					$result = $conn->query($sqlb);
						if ($result->num_rows > 0) {
							
							$sqlb="SELECT * FROM `btyunidad_medida` WHERE (umenombre ='$nom' or umealias='$alias') and umeestado=0";
							$result = $conn->query($sqlb);
							if ($result->num_rows > 0) {
								echo "EL REGISTRO SE ENCUENTRA INACTIVO DESEA ACTIVARLO?";
							}else{
								echo"EL REGISTRO YA SE ENCUENTRA, POR FAVOR ASIGNE OTRO NOMBRE Y ALIAS";
							}
						}else{

						$sql="INSERT INTO `btyunidad_medida`(`umecodigo`, `umenombre`, `umealias`, `umeestado`) VALUES ($code,'$nom','$alias',1)";
							 if (mysqli_query($conn, $sql)) { 
			            echo "REGISTRO GUARDADO EXITOSAMENTE";
			            //echo "New record created successfully";
			            
			 
			        } else {
			            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			            echo "Error updating record: " . $conn->error;
			            
			        }

  					 }
			}
		}
	}
	
 ?>
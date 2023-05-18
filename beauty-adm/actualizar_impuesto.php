<?php 
session_start();
include '../cnx_data.php';
$code 		=$_POST['codigo']; 
$nombrre	=$_POST['nombre']; 
$alia       =$_POST['alias'];
$tipo		=$_POST['tipo'];
$valor		=$_POST['valor'];

if ($_POST['codigo']!="" ) {
	if ($_POST['nombre']!="") {
		if ($_POST['alias']!="") {
			if ($_POST['valor']!="") {			

			/*$sqlb="SELECT * FROM `btyimpuesto_ventas` WHERE imvnombre ='$nombrre' or imvalias='$alia'";
				$result = $conn->query($sqlb);
					if ($result->num_rows > 0) {

						echo "Ya se encuentra registrado o inactivo ese impuesto ";*/
						$sql="UPDATE `btyimpuesto_ventas` SET `imvnombre`='$nombrre',`imvalias`='$alia', imvporcentaje = $tipo, imvalor = $valor  WHERE `imvcodigo`= '$code'";
							if (mysqli_query($conn, $sql)) { 
			            		echo "Modificado";

			        			} else {
			            			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			            			echo "Error updating record: " . $conn->error;
			            
			        			}
					}else{

					}
				}
			}
		}
	

	mysqli_close($conn);


?>


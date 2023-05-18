<?php 
include '../cnx_data.php';
$code=$_POST['codigo']; 
$nombrre=$_POST['nombre']; 
$alia=$_POST['alias'];
if ($_POST['codigo']!="" ) {
	if ($_POST['nombre']!="") {
		if ($_POST['alias']!="") {
			$sqlb="SELECT * FROM `btyunidad_medida` WHERE umenombre ='$nombrre' or umealias='$alia'";
					$result = $conn->query($sqlb);
						if ($result->num_rows > 0) {

							echo "Ya se encuentra registrada o inactiva esa unidad de medida ";
						}else{

				$sql="UPDATE `btyunidad_medida` SET `umenombre`='$nombrre',`umealias`='$alia' WHERE `umecodigo`= '$code'";
		 if (mysqli_query($conn, $sql)) { 
            echo "Modificado";

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }

			}
		}
	}
}

?>
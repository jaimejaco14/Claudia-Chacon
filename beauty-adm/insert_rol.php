<?php
include '../cnx_data.php';
if ($_POST['rol_name'] != "") {
	$name = $_POST['rol_name'];
	$alias= $_POST['rol_alias'];
	$sqlmax = "SELECT MAX(`tiucodigo`) m FROM `btytipousuario`";
	$result = $conn->query($sqlmax);
	if ($result->num_rows > 0) {
		while ( $row = $result->fetch_assoc()) {
			if ($row['m'] == NULL) {
				$cod = 0;
			} else {
				$cod = $row['m'];
			}
		}
	} 
	$cod = $cod + 1;
	$today = date("Y-m-d");
	$sql = "INSERT INTO `btytipousuario`(`tiucodigo`, `tiunombre`, `tiualias`, `tiufecharegistro`, `tiuestado`) VALUES ($cod,'$name','$alias','$today',1)";
	if ($conn->query($sql)){
		echo "TRUE";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}	
?>
<?php
include '../cnx_data.php';
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$dia = $_POST['dia'];

if ($desde != "" and $hasta != "" and $dia != ""){
	$sql = "SELECT * FROM `btyhorario` WHERE hordia = '$dia' and DATE_FORMAT(hordesde, '%H:%i') = '$desde' and DATE_FORMAT(horhasta, '%H:%i')  = '$hasta'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row1 = $result->fetch_assoc();
		if($row1['horestado']== 0){
			echo "FALSE";
		}else{
			echo "FALSE1";
		}
	} 
	else {

		$max = "SELECT MAX(horcodigo) as m FROM btyhorario";
		$result =$conn->query($max);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$cod = $row['m'] + 1;
			} 
		} else {
			$cod = 1;
		}
		$sql1 = "INSERT INTO `btyhorario`(horcodigo, `hordia`, `hordesde`, `horhasta`, `horestado`) VALUES ($cod, '$dia','$desde','$hasta',1)";
		if ($conn->query($sql1)) {

			echo "TRUE";
		}

	}

}
?>
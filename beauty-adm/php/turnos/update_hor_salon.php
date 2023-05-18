<?php
	include("../../../cnx_data.php");
$old = $_POST['old_horario'];
$new = $_POST['nuevo'];
$sln = $_POST['salon'];
$today = date("Y-m-d");

$sql = "UPDATE btyhorario_salon SET slhfechafin='$today' WHERE horcodigo = $old AND slncodigo = $sln";

if ($conn->query($sql)) {

	//$sql2 = "INSERT INTO `btyhorario_salon`(`horcodigo`, `slncodigo`, `slhfechainicio`, `slhfechafin`) VALUES ($new,$sln,'$today','$today')";
	$sql2="UPDATE btyhorario_salon SET horcodigo ='$new' WHERE slncodigo = '$sln' AND horcodigo = '$old'";

	if ($conn->query($sql2)) {
		echo "TRUE";
	}
}else{
	echo "boom!";
}



/*$cod = $_POST['horario_cod'];
$sql = "SELECT horcodigo, hordia, hordesde, horhasta FROM btyhorario WHERE horcodigo = $cod";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['horcodigo'].",";
		echo $row['hordia'].",";
		echo $row['hordesde'].",";
		echo $row['horhasta'].",";
	}
}*/
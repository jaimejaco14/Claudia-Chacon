<?php
include '../../cnx_data.php';
$ptrnombre = $_POST["name"];
$sln = $_POST['sln'];

if($ptrnombre != NULL) {
$sql = "SELECT * FROM btypuesto_trabajo where ptrnombre = '$ptrnombre' AND slncodigo = $sln";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	 while ($row = $result->fetch_assoc()) {
	 	if($row['ptrestado']=='0'){
	 		echo "INAC";
	 	}else{
	 		echo "TRUE";
	 	}
	 } 

} else {
	echo "FALSE";
}
$conn->close();
}
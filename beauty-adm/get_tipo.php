<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT `tpocodigo`, `tponombre`, `tpoalias`, `tpodescripcion`, `tpoimagen`, `tpoestado` FROM `btytipo` WHERE tpocodigo = $cod";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['tponombre'].",";
	   echo $row['tpoalias'].",";
	   echo $row['tpodescripcion'].",";
	   echo $row['tpocodigo'].",";
	}
}
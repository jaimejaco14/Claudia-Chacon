<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT l.`lincodigo`, l.`sbgcodigo`, l.`linnombre`, l.`linalias`, l.`lindescripcion`, l.`linimagen`, s.sbgnombre FROM `btylinea` l INNER JOIN btysubgrupo s ON s.sbgcodigo = l.sbgcodigo WHERE l.lincodigo = $cod ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['linnombre'].",";
	   echo $row['linalias'].",";
	   echo $row['lindescripcion'].",";
	   echo $row['lincodigo'].",";
	   echo $row['sbgcodigo'].",";
	   echo $row['sbgnombre'].",";
	}
}
<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT s.`sbgcodigo`, s.`grucodigo`, s.`sbgnombre`, s.`sbgalias`, s.`sbgdescripcion`, s.`sbgimagen`, g.grunombre FROM `btysubgrupo` s INNER JOIN btygrupo g on g.grucodigo = s.grucodigo WHERE s.sbgcodigo = $cod ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['sbgnombre'].",";
	   echo $row['sbgalias'].",";
	   echo $row['sbgdescripcion'].",";
	   echo $row['sbgcodigo'].",";
	   echo $row['grucodigo'].",";
	   echo $row['grunombre'].",";
	}
}
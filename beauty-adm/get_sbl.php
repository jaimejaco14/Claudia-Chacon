<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT s.`sblcodigo`, s.`lincodigo`, s.`sblnombre`, s.`sblalias`, s.`sbldescripcion`, s.`sblimagen`, s.lincodigo, l.linnombre  FROM `btysublinea` s INNER JOIN btylinea l ON l.lincodigo = s.lincodigo  WHERE sblcodigo = $cod ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['sblnombre'].",";
	   echo $row['sblalias'].",";
	   echo $row['sbldescripcion'].",";
	   echo $row['sblcodigo'].",";
	   echo $row['lincodigo'].",";
	   echo $row['linnombre'].",";
	}
}
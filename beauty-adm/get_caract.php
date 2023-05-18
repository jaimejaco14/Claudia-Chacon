<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT c.`crscodigo`, c.`sblcodigo`, c.`crsnombre`, c.`crsalias`, c.`crsdescripcion`, c.`crsimagen`, sbl.sblcodigo, sbl.sblnombre, l.lincodigo, l.linnombre, sbg.sbgcodigo, sbg.sbgnombre, g.grucodigo, g.grunombre, t.tpocodigo, t.tponombre FROM `btycaracteristica` c INNER JOIN btysublinea sbl ON c.sblcodigo = sbl.sblcodigo INNER JOIN btylinea l ON l.lincodigo = sbl.lincodigo INNER JOIN btysubgrupo sbg ON sbg.sbgcodigo = l.sbgcodigo INNER JOIN btygrupo g ON g.grucodigo = sbg.grucodigo INNER JOIN btytipo t ON t.tpocodigo = g.grucodigo WHERE c.crscodigo = $cod ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['crsnombre'].",";
	   echo $row['crsalias'].",";
	   echo $row['crsdescripcion'].",";
	   echo $row['crscodigo'].",";
	   echo $row['sblcodigo'].",";
	   echo $row['sblnombre'].",";
	   echo $row['lincodigo'].",";
	   echo $row['linnombre'].",";
	   echo $row['sbgcodigo'].",";
	   echo $row['sbgnombre'].",";
	   echo $row['grucodigo'].",";
	   echo $row['grunombre'].",";
	}
}
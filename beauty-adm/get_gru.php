<?php 
include '../cnx_data.php';
$cod = $_POST['cod'];
$sql = "SELECT g.`grucodigo`, g.`tpocodigo`, g.`grunombre`, g.`grualias`, g.`grudescripcion`, g.`gruimagen`, t.tponombre FROM `btygrupo` g INNER JOIN btytipo t ON t.tpocodigo = g.tpocodigo WHERE  g.grucodigo = $cod ";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
	   echo $row['grunombre'].",";
	   echo $row['grualias'].",";
	   echo $row['grudescripcion'].",";
	   echo $row['grucodigo'].",";
	   echo $row['tpocodigo'].",";
	   echo $row['tponombre'].",";
	}
}
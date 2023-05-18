<?php 
include "../cnx_data.php";
$sbl = $_POST['Sublinea'];
$lin = $_POST['Linea'];
$sql = "SELECT s.sblcodigo, s.sblnombre from btysublinea s INNER JOIN btylinea l on l.linnombre = '$lin'  where sblnombre like '".$sbl."%' AND sblestado = 1";
$result = $conn->query($sql);
//echo $sql;
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		echo '<div class="suggest-element"><a onclick="complete_slin(this);" data="'.$row['sblnombre'].'" id="Subgrupos'.$row['sblcodigo'].'">'.utf8_encode($row['sblnombre']).'</a></div>';
	}
}
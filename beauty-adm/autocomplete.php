<?php 
include '../cnx_data.php';
$sbg = $_POST['Subgrupos'];
$sql = "SELECT sbgcodigo, sbgnombre from btysubgrupo where sbgnombre like '".$sbg."%' AND sbgestado = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		echo '<div class="suggest-element"><a onclick="live(this);" data="'.$row['sbgnombre'].'" id="Subgrupos'.$row['sbgcodigo'].'">'.utf8_encode($row['sbgnombre']).'</a></div>';
	}
}
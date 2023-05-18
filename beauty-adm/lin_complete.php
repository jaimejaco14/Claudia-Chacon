<?php 
include '../cnx_data.php';
$sbg = $_POST['Linea'];
$sql = "SELECT lincodigo, linnombre from btylinea where linnombre like '".$sbg."%' AND linestado = 1";
$result = $conn->query($sql);
//echo $sql;
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		echo '<div class="suggest-element"><a onclick="complete_lin(this);" data="'.$row['linnombre'].'" id="Subgrupos'.$row['lincodigo'].'">'.utf8_encode($row['linnombre']).'</a></div>';
	}
}
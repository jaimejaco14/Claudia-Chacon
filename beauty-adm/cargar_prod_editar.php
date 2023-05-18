<?php 
	include '../cnx_data.php';

	$sql = mysqli_query($conn, "SELECT MAX(procodigo) AS id FROM btyproducto");
	$row = mysqli_fetch_array($sql);
	$max = $row[0];

	echo $max+1;

	mysqli_close($conn);
 ?>
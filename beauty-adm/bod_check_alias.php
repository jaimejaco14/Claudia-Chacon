<?php 
	include '../cnx_data.php';

	$alias = $_POST['alias'];

	$sql = mysqli_query($conn, "SELECT bodalias FROM btybodega WHERE bodalias = '$alias'");

	if (mysqli_num_rows($sql) > 0) {
		 echo 1;
	}

	mysqli_close($conn);
 ?>
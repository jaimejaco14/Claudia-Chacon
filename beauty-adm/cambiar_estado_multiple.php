<?php 
	include '../cnx_data.php';

	$id = $_POST['id'];
	$var = $_REQUEST['var'];

	if ($var == 1) {
		
		$sql = mysqli_query($conn, "UPDATE btypuesto_trabajo SET ptrmultiple = 1 WHERE ptrcodigo = $id ");

		if ($sql) {
			echo 1;
		}
	}else{
		$sql = mysqli_query($conn, "UPDATE btypuesto_trabajo SET ptrmultiple = 0 WHERE ptrcodigo = $id ");

		if ($sql) {
			echo 1;
		}
	}


	mysqli_close($conn);
 ?>
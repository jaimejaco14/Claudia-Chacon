<?php 
include '../cnx_data.php';

	$codbio = $_POST['codbio'];

	$sql = mysqli_query($conn, "SELECT a.clbcodigoswbiometrico FROM btycolaborador a WHERE a.clbcodigoswbiometrico = '".$codbio."' ");

	if (mysqli_num_rows($sql) > 0) 
	{
	   echo 1;
	}else{
		echo 0;
	}
	mysqli_close($conn);
 ?>
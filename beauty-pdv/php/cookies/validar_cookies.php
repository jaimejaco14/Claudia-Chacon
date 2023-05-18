<?php 
	session_start();
	header("content-type: application/json");
	include("../../../cnx_data.php");

	$cod_salon 				= $_POST['slncodigo'];
	$_SESSION['cookiesln'] 	= $_POST['slncodigo'];
	$salones = array();

	echo $_POST['slncodigo'];
	mysqli_close($conn);
 ?>
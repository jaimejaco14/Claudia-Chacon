<?php
	session_start();
	$conn = mysqli_connect("localhost", "appbeauty", "bty_ERP@2017", "beauty_erp");

	if (!$conn) 
	{
    		die("Error al establecer conexión con la base de datos. " . mysqli_connect_error());

	}
	
?>

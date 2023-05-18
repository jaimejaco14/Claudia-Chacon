<?php
	
 include '../cnx_data.php';

	
	unset($_SESSION['clbcodigo'], $_SESSION['trcdocumento'], $_SESSION['nombre'], $_SESSION['apellido']);


	header("Location: index.html");
    
session_destroy();
    
?>

<?php

	include("../cnx_data.php");

	$sql = "UPDATE btysesiones SET sesfechafin= CURDATE(),seshorafin= CURTIME(),sesestado= 0 WHERE sescodigo= '".$_SESSION['PDVnumeroSesion']."' and `usucodigo`= '".$_SESSION["PDVcodigoUsuario"]."' ";

	if ($conn->query($sql)) 
	{
		unset($_SESSION['PDVtipo_u'], $_SESSION['PDVcodigoUsuario'], $_SESSION['PDVDb'], $_SESSION['PDVuser_session'], $_SESSION['PDVdocumento'], $_SESSION['PDVslncodigo'], $_SESSION['PDVnumeroSesion'], $_SESSION['PDVnombreCol'], $_SESSION['PDVslnNombre']);

	    	echo "TRUE";
		header("Location: index.php");
    } 
 
?>

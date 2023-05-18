
<?php
	session_start();
	include("../../../cnx_data.php");
	
	mysqli_query($conn,"UPDATE `btysesiones` SET sesfechafin= curdate(),seshorafin=curtime(),vsesestado= 0 WHERE sescodig= '".$_SESSION['sescodigo']."' and usucodigo='".$_SESSION['usucodigo']."' AND sesmodulo='PUNTO DE VENTA'");

	session_unset();
    session_destroy();
    header("Location: ../../index.php");
	
?>

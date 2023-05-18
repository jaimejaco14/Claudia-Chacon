<?php
	include '../cnx_data.php';


	$sql = "UPDATE `btysesiones` SET `sesfechafin`= CURDATE(),`seshorafin`= CURTIME(),`sesestado`= 0 WHERE `sescodigo`= '".$_SESSION['numerosesion']."' and `usucodigo`= '".$_SESSION["codigoUsuario"]."' ";

	if ($conn->query($sql)) 
	{
		unset($_SESSION['Db'], $_SESSION['tipo_u'], $_SESSION['codigoUsuario'], $_SESSION['user_session'], $_SESSION['documento'], $_SESSION['numerosesion']);
	    echo "TRUE";
		header("Location: login.php");
    } 
    else 
    {

	    echo "Error: " . $sql . "" . mysqli_error($conn);

    }
    session_destroy();
?>







<?php 
	session_start();
	include("../../../cnx_data.php");

	$cod_salon   = $_SESSION['PDVslncodigo'];
	$usuario     = $_SESSION['PDVcodigoUsuario'];  
	$comentario  = utf8_decode(strtoupper($_POST['comentario']));

	$QueryCla = mysqli_query($conn,"SELECT * FROM btyturnos_atencion WHERE slncodigo = $cod_salon AND tuafechai = CURDATE() AND tuafechai = tuafechaf"); 

	if (mysqli_num_rows($QueryCla) > 0) 
	{
	 	
		$consulta = mysqli_query($conn, "SELECT tuaobservacionesi FROM btyturnos_atencion WHERE slncodigo = $cod_salon AND tuafechai = CURDATE()");

		if (mysqli_num_rows($consulta) > 0) 
		{

			$t = mysqli_fetch_array($consulta);

			if ($t[0] == NULL)
			{
				$con = mysqli_query($conn, "UPDATE btyturnos_atencion SET usucodigoi = $usuario, tuaobservacionesi = '$comentario' WHERE slncodigo = $cod_salon AND tuafechai = CURDATE()");

				if ($con) 
				{
					echo 1;
				}

			}
			else
			{
	        	echo 2;			
			}
		}
		else
		{
			echo 3;
		}
	}
	else
	{
		echo 4;
	} 


	mysqli_close($conn);

 ?>
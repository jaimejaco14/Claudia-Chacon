<?php 
	session_start();
	include("../../../cnx_data.php");

	$comentario_final 	= utf8_decode(strtoupper($_POST['comentario_final']));
	$salon_turno		= $_SESSION['PDVslncodigo'];
	$usuario			= $_SESSION['PDVcodigoUsuario'];

	$consulta = mysqli_query($conn,"SELECT * FROM btyturnos_atencion WHERE slncodigo = $salon_turno AND tuafechai = CURDATE()");

	if (mysqli_num_rows($consulta) > 0) 
	{
		$QueryCount = mysqli_fetch_array($consulta);

		if ($QueryCount['tuahorai'] == $QueryCount['tuahoraf']) 
		{
			$cons = mysqli_query($conn,"SELECT a.slncodigo, a.tuafechai, a.clbcodigo FROM btycola_atencion a WHERE a.slncodigo = $salon_turno AND a.tuafechai = CURDATE() AND a.colhorasalida IS NULL");

			if (mysqli_num_rows($cons) > 0) 
			{
				 echo 0;
			}
			else
			{
				$sql = mysqli_query($conn, "UPDATE btyturnos_atencion SET tuaobservacionesf = '".utf8_decode($comentario_final)."', usucodigof = '".$_SESSION['PDVcodigoUsuario']."', tuahoraf = CURTIME()  WHERE slncodigo = $salon_turno AND tuafechai = CURDATE()")or die(mysqli_error($conn));
			    if ($sql) 
			    {
			       echo 1;
			    }
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

	

	 
	mysqli_close($conn);
 //$consulta = mysqli_query($conn,"SELECT * FROM btyturnos_atencion WHERE slncodigo = $salon_turno AND tuafechai = CURDATE() AND tuahorai = tuahoraf");
 ?>

<?php 
	//session_start();
	include("../../../cnx_data.php");

	switch ($_POST['opcion']) 
	{
		case 'validarCol':

 			$Query = mysqli_query($conn, "SELECT a.clbcodigo FROM btycola_atencion a WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND a.tuafechai = CURDATE() AND a.coldisponible = 1 AND a.clbcodigo = '".$_POST['clbcodigo']."' ");

 			if (mysqli_num_rows($Query) > 0) 
 			{
 				echo 1;
 			}


			break;

		case 'citaTerminada':
			
			$Query = mysqli_query($conn, "SELECT a.esccodigo FROM btynovedad_cita a WHERE a.citcodigo = '".$_POST['cita']."' AND a.esccodigo = 9 ");

 			if (mysqli_num_rows($Query) > 0) 
 			{
 				echo 1;
 			}
 			else
 			{
 				echo 2;
 			}

 		
			break;
		
		default:
			# code...
			break;
	}


	mysqli_close($conn);
?>
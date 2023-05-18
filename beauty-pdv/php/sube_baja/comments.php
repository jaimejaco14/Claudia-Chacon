<?php 
	session_start();
	include("../../../cnx_data.php");

	switch ($_POST['opcion']) 
	{
		case 'inhabilitar':

			$queryComment = mysqli_query($conn, "SELECT * FROM btyturnos_atencion a WHERE a.slncodigo = '".$_SESSION['PDVslncodigo']."' AND  a.tuafechai = CURDATE()");

			if (mysqli_num_rows($queryComment) > 0) 
			{
				$Fetch = mysqli_fetch_array($queryComment);

				if ($Fetch['tuaobservacionesi'] != "") 
				{
					echo json_encode(array("comentarioInicial" => $Fetch['tuaobservacionesi'], "comentarioFinal" => $Fetch['tuaobservacionesf']));
				}
				else
				{
					echo 2;
				}

				//echo json_encode(array("comentarioInicial" => $Fetch['tuaobservacionesi']));
			}
			else
			{
				echo 3;
			}
			
			break;
		
		default:
			# code...
			break;
	}

	//$Fetch = mysqli_fetch_array($queryComment);a.usucodigoi <> a.usucodigof

				//echo json_encode(array("comentarioInicial" => $Fetch['tuaobservacionesi']));
 ?>
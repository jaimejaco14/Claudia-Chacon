<?php 
	session_start();
	include("../../../cnx_data.php");

	$cod_colaborador 	= $_POST['cod_colaborador'];	$cod_salon          = $_SESSION['PDVslncodigo'];

	$DocColaborador = mysqli_query($conn, "SELECT b.clbcodigo FROM btytercero a JOIN btycolaborador b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['trcdocumento']."'");

	$cod = mysqli_fetch_array($DocColaborador);

	$cod_colaborador = $cod[0];


	$con = mysqli_query($conn,  "SELECT colhorasalida, coldisponible,clbcodigo FROM btycola_atencion WHERE clbcodigo = $cod_colaborador AND slncodigo = $cod_salon AND tuafechai = CURDATE()");

	if (mysqli_num_rows($con) > 0) 
	{
		
		while ($row = mysqli_fetch_array($con)) 
		{
			if ($row['coldisponible'] == 0) 
			{
				echo 1;
			}
			else
			{
				if ($row[0] == null || $row[0] == "null") 
				{	

					$sql = mysqli_query($conn, "UPDATE btycola_atencion SET colhorasalida = CURTIME() WHERE clbcodigo = $cod_colaborador AND slncodigo = $cod_salon AND tuafechai = CURDATE()");
							if ($sql) 
							{
								echo json_encode(array("res" => 8, "cod_colaborador" => $cod_colaborador));
							}			
				}
			}
		}
	}
	else
	{
		echo 9;
	}

	mysqli_close($conn);	

?>
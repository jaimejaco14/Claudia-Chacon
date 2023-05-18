<?php 

//session_start();
	include("../../../cnx_data.php");

	$cliente            = $_REQUEST["cliente"];
	$salon              = $_REQUEST["salon"];
	$servicio           = $_REQUEST["servicio"];
	$fechaAgendamiento  = trim($_REQUEST["fechaAgendamiento"]);
	$colaborador        = $_REQUEST["colaborador"];
	$observaciones      = trim(utf8_encode($_REQUEST["observaciones"]));
	$usuario            = $_SESSION['PDVcodigoUsuario'];
	$camposObligatorios = strlen($cliente) * strlen($salon) * strlen($servicio) * strlen($fechaAgendamiento) * strlen($colaborador);

	$date = strtotime($fechaAgendamiento);


	$fechaper = date("Y-m-d", $date);
	$hra      = date("H:i".":00",$date); 

	//echo $fechaper . "|||||" . $hra;

	//print_r($_REQUEST);


if($camposObligatorios > 0)
{

	$maxcodigo      = "";
	$resultQueryMax = $conn->query("SELECT MAX(citcodigo) AS maxcodigo FROM btycita");

	while($registros = $resultQueryMax->fetch_array())
	{

		$maxcodigo = $registros["maxcodigo"];
	}

	if($maxcodigo == null)
	{

        $maxcodigo = 1;
    }
    else
    {

        $maxcodigo = $maxcodigo + 1;
    }

	$fechaAgendamiento = str_replace("/", "-", $fechaAgendamiento);
	$fechaHora         = explode(" ", $fechaAgendamiento);
	$fecha             = $fechaHora[0];
	$hora              = $fechaHora[1];

	$queryCitasProgramadas = "SELECT * FROM btycita WHERE (clbcodigo = $colaborador) AND (slncodigo = $salon) AND (citfecha = '$fecha') AND (cithora LIKE '%$fechaHora[1]%')";

	//echo $queryCitasProgramadas;

	$resultCitasProgramadas = $conn->query($queryCitasProgramadas);
	//echo mysqli_num_rows($resultCitasProgramadas);

	if(mysqli_num_rows($resultCitasProgramadas) > 0)
	{
		echo json_encode(array("result" => "duplicada"));
	}
	else
	{
		$per = "SELECT a.clbcodigo, a.perhora_desde, a.perhora_hasta FROM btypermisos_colaboradores a WHERE a.clbcodigo= $colaborador AND a.perfecha_desde = '$fechaper' AND a.perestado_tramite = 'AUTORIZADO'";

		$query = mysqli_query($conn,$per)or die(mysqli_error($conn));


		if (mysqli_num_rows($query) > 0) 
		{
				$filas = mysqli_fetch_array($query);
								
			
					if ($hra >= $filas['perhora_desde'] AND $hra < $filas['perhora_hasta']) 
					{					
						echo json_encode(array("result" => 'enpermiso'));
					}
					else
					{
						$sql = "SELECT * FROM btyprogramacion_colaboradores pc INNER JOIN btyturno t ON t.trncodigo = pc.trncodigo WHERE ('$hora' BETWEEN(SUBTIME(t.trninicioalmuerzo, SEC_TO_TIME(1))) AND (subtime(t.trnfinalmuerzo, sec_to_time(1)))) AND pc.prgfecha = '$fecha' AND pc.clbcodigo = $colaborador";
						$sql = mysqli_query($conn, $consulta)or die(mysqli_error($conn));
						//echo $sql;
							$result = $conn->query($sql);



							
							if ($result->num_rows > 0) 
							{
								echo json_encode(array("result" => "almuerzo"));
							} 
							else 
							{
								$resultadoQueryCita = $conn->query("INSERT INTO btycita(citcodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ('$maxcodigo', '$colaborador', '$salon', '$servicio', '$cliente', '$usuario', '$fecha', '$hora', CURDATE(), CURTIME(), '$observaciones')");

								if($resultadoQueryCita != false)
								{
									$conn->query("INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, $maxcodigo, CURDATE(), CURTIME(), $usuario, '')");
									
									echo json_encode(array("result" => "creada"));
								}
								else
								{
									echo json_encode(array("result" => "error"));
								}				
							}						
					}
				
			
		}
		else
		{
			$consulta = "SELECT * FROM btyprogramacion_colaboradores pc INNER JOIN btyturno t ON t.trncodigo = pc.trncodigo WHERE ('$hora' BETWEEN(SUBTIME(t.trninicioalmuerzo, SEC_TO_TIME(1))) AND (subtime(t.trnfinalmuerzo, sec_to_time(1)))) AND pc.prgfecha = '$fecha' AND pc.clbcodigo = $colaborador";
			$sql = mysqli_query($conn, $consulta)or die(mysqli_error($conn));
		
							if (mysqli_num_rows($sql) > 0) 
							{
								echo json_encode(array("result" => "almuerzo", "sql" => $consulta));
							} 
							else 
							{
								$resultadoQueryCita = $conn->query("INSERT INTO btycita(citcodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ('$maxcodigo', '$colaborador', '$salon', '$servicio', '$cliente', '$usuario', '$fecha', '$hora', CURDATE(), CURTIME(), '$observaciones')");

								if($resultadoQueryCita != false)
								{
									$conn->query("INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, $maxcodigo, CURDATE(), CURTIME(), $usuario, '')");
									
									echo json_encode(array("result" => "creada", "sql" => $consulta));
								}
								else
								{

									echo json_encode(array("result" => "error"));
								}				
							}				
		}
	}
}
else
{
	echo json_encode(array("result" => "error"));
}

mysqli_close($conn);


	
?>
<?php 
	session_start();
	include("../../../cnx_data.php");

	$citaActual       = $_POST["cita"];
	$nuevoSalon       = $_POST["sln"];
	$nuevoServicio    = $_POST["ser"];
	$nuevoCliente     = $_POST["cliente"];
	$nuevoColaborador = $_POST["col"];
	$nuevaFecha       = $_POST["fecha"];
	$nuevaObservacion = $_POST["obser"];
	$antiguoEstado    = $_POST["antiguoEstado"];
	$nuevoEstado      = $_POST["nuevoEstado"];
	$nuevaFecha       = str_replace("/", "-", $nuevaFecha);
	$fechaHora        = explode(" ", $nuevaFecha);
	$fecha            = $fechaHora[0];
	$hora             = $fechaHora[1];

	print_r($_POST);

	$sql = "SELECT DISTINCT pc.clbcodigo, t.trcrazonsocial FROM btyprogramacion_colaboradores pc INNER JOIN btycolaborador c ON c.clbcodigo = pc.clbcodigo INNER JOIN btytercero t ON c.trcdocumento = t.trcdocumento INNER JOIN btyturno tu ON tu.trncodigo = pc.trncodigo INNER JOIN btyservicio_colaborador sc ON pc.clbcodigo = sc.clbcodigo INNER JOIN btytipo_programacion tp ON tp.tprcodigo = pc.tprcodigo AND tp.tprlabora = 1";


if ($hora != "" || $fecha != "" || $nuevoSalon != "" || $nuevoServicio != "") 
{
	$sql = $sql. " WHERE";
	if ($fecha != "") 
	{
		$sql = $sql." pc.prgfecha = '$fecha'";
	}
	if ($hora != "") 
	{
	 	$sql = $sql." AND (tu.trndesde <= '$hora' AND tu.trnhasta >= '$hora')";
	}
	if ($nuevoServicio != "") 
	{
	 	$sql = $sql. " AND sc.sercodigo = $nuevoServicio";
	}
	if ($nuevoSalon != "") 
	{
	 	$sql = $sql. " AND pc.slncodigo = $nuevoSalon";
	} 
}


$sql = $sql. " ORDER BY t.trcrazonsocial";

$result = $conn->query($sql)or die(mysqli_error($conn));

if ($result->num_rows > 0) 
{
		$query    = "UPDATE btycita SET clbcodigo = '$nuevoColaborador', slncodigo = '$nuevoSalon', sercodigo = '$nuevoServicio', clicodigo = '8', citfecha = '$fecha', cithora = '$hora', citobservaciones = '$nuevaObservacion' WHERE citcodigo = '$citaActual'";
	$resultQuery = $conn->query($query)or die(mysqli_error($conn));

	if($resultQuery != false)
	{

		if((mysqli_affected_rows($conn) > 0) || ($antiguoEstado != $nuevoEstado))
		{

			if($antiguoEstado != $nuevoEstado)
			{
				$usuario = $_SESSION["PDVcodigoUsuario"];
				$query2  = "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES ($nuevoCliente, '$citaActual', CURDATE(), CURTIME(), '$usuario', '$nuevaObservacion')";
				$conn->query($query2);
			}

			echo json_encode(array("result" => "actualizada"));
		}
		else
		{
			echo json_encode(array("result" => "duplicada"));
		}
	}
	else
	{
		
		echo json_encode(array("result" => "error"));
	}
	
}
else 
{
	echo json_encode(array("result" => "wrong"));
}


	mysqli_close($conn);
?>
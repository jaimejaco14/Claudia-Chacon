<?php
include("../../../cnx_data.php");

$fechaHoraAgendamiento    = explode(" ", $_POST["fecha"]);
$fecha                    = $fechaHoraAgendamiento[0];
$hora                     = $fechaHoraAgendamiento[1];
$salon 					  = $_POST['salon'];
$servicio 				  = $_POST['servicio'];


$sql = "SELECT DISTINCT pc.clbcodigo, t.trcrazonsocial FROM btyprogramacion_colaboradores pc INNER JOIN btycolaborador c ON c.clbcodigo = pc.clbcodigo INNER JOIN btytercero t ON c.trcdocumento = t.trcdocumento INNER JOIN btyturno tu ON tu.trncodigo = pc.trncodigo INNER JOIN btyservicio_colaborador sc ON pc.clbcodigo = sc.clbcodigo INNER JOIN btytipo_programacion tp ON tp.tprcodigo = pc.tprcodigo AND tp.tprlabora = 1";


if ($hora != "" || $fecha != "" || $salon != "" || $servicio != "") 
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

	if ($servicio != "") 
	{
	 	$sql = $sql. " AND sc.sercodigo = $servicio";
	}

	if ($salon != "") 
	{
	 	$sql = $sql. " AND pc.slncodigo = $salon";
	} 
}


$sql = $sql. " ORDER BY t.trcrazonsocial";

$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
	
	while ($row = $result->fetch_assoc()) 
	{
		echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
	}
} 
else 
{
	echo "<option>--HORARIO NO DISPONIBLE--</option>";
}

?>
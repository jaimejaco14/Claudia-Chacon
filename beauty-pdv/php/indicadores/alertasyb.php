<?php 
	session_start();
	include("../../../cnx_data.php");

	$sql = " SELECT b.trnnombre, b.trndesde, b.trnhasta, DATE_FORMAT(SUBTIME(b.trnhasta, SEC_TO_TIME(300)),'%H:%i') AS hora_fin, DATE_FORMAT(CURTIME(), '%H:%i') AS 'horaactual', CASE WHEN SUBTIME(b.trnhasta, SEC_TO_TIME(300)) < CURTIME() THEN 'activado' ELSE 'lol' END AS tiempo_final FROM btyprogramacion_colaboradores a JOIN btyturno b ON a.trncodigo=b.trncodigo WHERE a.slncodigo = ".$_SESSION['PDVslncodigo']." AND a.prgfecha = CURDATE() AND b.trnnombre LIKE '%CIERRE%' ORDER BY b.trnnombre LIMIT 1"; 		
	
	$query = mysqli_query($conn, $sql);

	if (mysqli_num_rows($query) > 0) 
	{
		$row = mysqli_fetch_array($query);
		
		if ($row['horaactual'] ==  $row['hora_fin']) 
		{
		   echo 1;
		}
		else
		{
			echo "INACTIVO ";
		}
		
	}
	else
	{
		echo "NO";
	}

 ?>

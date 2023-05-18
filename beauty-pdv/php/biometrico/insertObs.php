<?php 
	include("../../../cnx_data.php");

	if ($_POST['abmcodigo'] != null) 
	{
		$Query = mysqli_query($conn, "UPDATE btyasistencia_procesada SET apcobservacion = '".utf8_decode($_POST['observac'])."'  WHERE clbcodigo = '".$_POST['clbcodigo']."' AND trncodigo = '".$_POST['trncodigo']."' AND horcodigo = '".$_POST['horcodigo']."' AND slncodigo = '".$_POST['slncodigo']."' AND prgfecha = '".$_POST['prgfecha']."' AND abmcodigo = '".$_POST['abmcodigo']."' ");
		if ($Query) 
		{
			echo 1;
		}
		
	}
	else
	{
		$Query = mysqli_query($conn, "UPDATE btyasistencia_procesada SET apcobservacion = '".utf8_decode($_POST['observac'])."'  WHERE clbcodigo = '".$_POST['clbcodigo']."' AND trncodigo = '".$_POST['trncodigo']."' AND horcodigo = '".$_POST['horcodigo']."' AND slncodigo = '".$_POST['slncodigo']."' AND prgfecha = '".$_POST['prgfecha']."' AND abmcodigo is null ");
		if ($Query) 
		{
			echo 1;
		}
	}


 ?>
<?php
	session_start(); 
	include("../../../cnx_data.php");
    	include("../funciones.php");
//print_r($_POST);
	$Query = mysqli_query($conn, "SELECT MAX(citcodigo) FROM btycita");

	$fetch = mysqli_fetch_array($Query);

	$maxCod = $fetch[0] + 1;

	if ($_POST['selectClienteCitas'] == undefined) 
	{
		$queryDoc = mysqli_query($conn, "SELECT cli.clicodigo FROM btytercero trc JOIN btycliente cli ON trc.tdicodigo=cli.tdicodigo AND trc.trcdocumento=cli.trcdocumento WHERE trc.trcdocumento = '".$_POST['docCli']."' ");
		$fetchDoc = mysqli_fetch_array($queryDoc);

		$documento = $fetchDoc[0];		
	}
	else
	{
		$documento = $_POST['selectClienteCitas'];
	}


	$r = "INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES('".$maxCod."', '".$_POST['selectMedios']."' , '".$_POST['selectColaborador']."', '".$_POST['salon']."', '".$_POST['selectServicio']."', '".$documento."', '".$_SESSION['PDVcodigoUsuario']."', '".$_POST['fecha']."' , '".$_POST['hora']."', CURDATE(), CURTIME(), '".utf8_decode($_POST['obser'])."')";

		$jsonResume = array();

		$QueryInsert = mysqli_query($conn, $r)or die(mysqli_error($conn));

		$QueryResume = mysqli_query($conn, "SELECT a.citcodigo, a.clicodigo, c.trcrazonsocial, d.slnnombre, d.slntelefonomovil, CONCAT(e.sernombre, ' - DUR: ', e.serduracion, ' MIN')AS sernombre, a.citfecha, TIME_FORMAT(a.cithora, '%H:%i')as cithora, g.trcrazonsocial AS cliente, d.slndireccion FROM btycita AS a, btycolaborador AS b, btytercero AS c, btysalon AS d, btyservicio AS e, btycliente AS f, btytercero as g WHERE a.clbcodigo=b.clbcodigo AND c.trcdocumento=b.trcdocumento AND d.slncodigo=a.slncodigo AND e.sercodigo=a.sercodigo AND f.clicodigo=a.clicodigo AND g.trcdocumento=f.trcdocumento AND a.citcodigo = '".$maxCod."'");

			$row = mysqli_fetch_array($QueryResume);

		      $jsonResume[] = array(
		           'id' 		=> $row['citcodigo'],
		           'idcliente' 	=> $row['clicodigo'],
		           'colaborador'=> $row['trcrazonsocial'],
		           'salon' 	=> $row['slnnombre'],
		           'servicio' 	=> $row['sernombre'],
		           'fecha' 	=> $row['citfecha'],
		           'hora' 	=> $row['cithora'],
                       'cliente' 	=> $row['cliente'],
                       'direccion' 	=> $row['slndireccion'],
                       'movil' 	=> $row['slntelefonomovil'],


		      );

		      $jsonResume= utf8_converter($jsonResume);

		      $QueryNvedad = mysqli_query($conn, "INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (1, $maxCod, CURDATE(), CURTIME(), '".$_SESSION['PDVcodigoUsuario']."', '')")or die(mysqli_error($conn));



		if ($QueryInsert && $QueryResume && $QueryNvedad) 
		{
			echo json_encode(array("res" => "success", "cita" => $jsonResume));
		}
		else
		{
			echo json_encode(array("res" => "wrong"));
		}


 ?>
<?php 
	header( 'Content-Type: application/json' );
include '../cnx_data.php';

	$idpermiso 			= $_GET["idpermiso"];
	$cod_colaborador	= $_GET['idcolaborador'];
	$colaborador	    = $_GET['colaborador'];
	$_SESSION['colaborador'] = $colaborador;
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");

	$sql = mysqli_query($conn, "SELECT p.percodigo, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, p.perobservacion_autorizacion,  CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM  btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND  p.clbcodigo = $cod_colaborador ORDER BY p.perestado_tramite DESC");

	
	$array = array();

	while ($row = mysqli_fetch_object($sql)) 
	{
		$array[] = array(
			'codigo' 	=>$row->percodigo,
			'desde'   	=>$row->fecha_desde,
			'hasta'  	=>$row->fecha_hasta,
			'usu_reg'	=>$row->usu_reg,
			'usu_aut'   =>$row->usu_aut,
			'obs_reg'  	=>$row->perobservacion_registro,
			'obs_aut'  	=>$row->perobservacion_autorizacion,
			'fec_aut'  	=>$row->fecha_autori,
			'estado'  	=>$row->estado_tramite
		);
	}

	function utf8_converter($array)
	{
    	array_walk_recursive($array, function(&$item, $key){
		      if(!mb_detect_encoding($item, 'utf-8', true)){
		        $item = utf8_encode($item);
		      }
    	});

    	return $array;
  	}

  	$array = utf8_converter($array); 

  


		require_once 'lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("REPORTE DE PERMISOS ".$_SESSION['colaborador'])
						->setSubject("REPORTE DE PERMISOS")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte sesiones")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");

		//Creacion de imagen de cabecera
		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("./imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(45);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		$reporteExcel->getActiveSheet(0)->getStyle("A6")->getFont()->setBold(true);

		foreach($array as $t)
		{
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado);
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A6", "COLABORADOR: ". $_SESSION['colaborador']);		
		}


		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Código")
						->setCellValue("B8", "Desde")
						->setCellValue("C8", "Hasta")
						->setCellValue("D8", "Usuario Registro")
						->setCellValue("E8", "Usuario Autoriza")
						->setCellValue("F8", "Observaciones Registro")
						->setCellValue("G8", "Observaciones Autorización")
						->setCellValue("H8", "Fecha Autorización")
						->setCellValue("I8", "Estado");
						

		foreach($columnas as $columna)
		{

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:I8")->getFont()->setBold(true);

		foreach($array as $colaborador)
		{			
		
			$reporteExcel->setActiveSheetIndex(0)
					->setCellValue("A".$i, $colaborador["codigo"])
					->setCellValue("B".$i, $colaborador["desde"])
					->setCellValue("C".$i, $colaborador["hasta"])
					->setCellValue("D".$i, $colaborador["usu_reg"])
					->setCellValue("E".$i, $colaborador["usu_aut"])
					->setCellValue("F".$i, $colaborador["obs_reg"])
					->setCellValue("G".$i, $colaborador["obs_aut"])
					->setCellValue("H".$i, $colaborador["fec_aut"])
					->setCellValue("I".$i, $colaborador["estado"])
					->setCellValue("J".$i, $fdo);
					$i++;
		}
		

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Sesiones");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Puestos de Trabajo '.$_SESSION['colaborador'].' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/REPORTE DE PERMISOS ".$_SESSION['colaborador'].".xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}

?>
<?php 
	header( 'Content-Type: application/json' );
	include '../cnx_data.php';
	require_once '../lib/phpexcel/Classes/PHPExcel.php';

	$_SESSION['colaborador'] = $colaborador;
	$fechaGenerado           = date("d-m-Y");
	$horaGenerado            = date("h:i:s a");





		$estado = $_GET['estado'];
		$f1     = $_GET['fechaini'];
		$f2     = $_GET['fechafin'];
		$col    = $_GET['colaborador'];

		
		if ($_GET['estado'] == "REGISTRADO" || $_GET['estado'] == "AUTORIZADO" || $_GET['estado'] == "NO AUTORIZADO" AND $_GET['fechaini'] == "") 
		{			

			$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.perestado_tramite = '$estado'";


			
		}
		else
		{
			if ($_GET['estado'] == 0  AND $_GET['fechaini'] != "" AND $_GET['fechafin'] != "") 
			{
					$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.perfecha_desde >= '".$_GET['fechaini']."' AND p.perfecha_hasta <= '".$_GET['fechafin']."' ";

					
			}
			else
			{
				if ($_GET['colaborador'] == 0  AND $_GET['fechaini'] == "" AND $_GET['fechafin'] == "" AND $_GET['colaborador'] != "") 
				{
					$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND t.trcrazonsocial LIKE '%$col%' ";
				}
				else
				{
					if ($_GET['colaborador'] == 0  AND $_GET['fechaini'] == "" AND $_GET['fechafin'] == "" AND $_GET['colaborador'] == "")
					{
						$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 ";
					}
				}
				
			}
		}
	
						$array = array();
						$query = mysqli_query($conn, $sql);

						while ($row = mysqli_fetch_object($query)) 
						{
							$array[] = array(
								'codigo' 	=>$row->percodigo,
								'col'   	=>$row->col,
								'desde'  	=>$row->fecha_desde,
								'hasta'	    =>$row->fecha_hasta,
								'usu_reg'   =>$row->usu_reg,
								'usu_aut'  	=>$row->usu_aut,
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

  	

						$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
						$i        = 9;
						$reporteExcel = new PHPExcel();
						$reporteExcel->getProperties()
										->setCreator("Beauty ERP")
										->setLastModifiedBy("Beauty ERP")
										->setTitle("REPORTE DE PERMISOS AUTORIZADOS")
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
						$imagenCliente->setPath("../contenidos/imagenes/logo_empresa.jpg");
						$imagenCliente->setHeight(45);
						$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

						$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);

						foreach($array as $t)
						{
							$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado);			
						}


							$reporteExcel->setActiveSheetIndex(0)
											->setCellValue("A8", "Código")
											->setCellValue("B8", "Colaborador")
											->setCellValue("C8", "Desde")
											->setCellValue("D8", "Hasta")
											->setCellValue("E8", "Usuario Registro")
											->setCellValue("F8", "Usuario Autoriza")
											->setCellValue("G8", "Observaciones Registro")
											->setCellValue("H8", "Observaciones Autorización")
											->setCellValue("I8", "Fecha Autorización")
											->setCellValue("J8", "Estado");
						

							foreach($columnas as $columna)
							{

								$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
							}

							$reporteExcel->getActiveSheet(0)->getStyle("A8:J8")->getFont()->setBold(true);

							foreach($array as $colaborador)
							{			
							
								$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, $colaborador["codigo"])
										->setCellValue("B".$i, $colaborador["col"])
										->setCellValue("C".$i, $colaborador["desde"])
										->setCellValue("D".$i, $colaborador["hasta"])
										->setCellValue("E".$i, $colaborador["usu_reg"])
										->setCellValue("F".$i, $colaborador["usu_aut"])
										->setCellValue("G".$i, $colaborador["obs_reg"])
										->setCellValue("H".$i, $colaborador["obs_aut"])
										->setCellValue("I".$i, $colaborador["fec_aut"])
										->setCellValue("J".$i, $colaborador["estado"])
										->setCellValue("K".$i, $fdo);
										$i++;
							}
		

							$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

							$reporteExcel->getActiveSheet(0)->setTitle("Permisos");

							$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

							//Establecer la primera hoja (Colaboradores) como hoja principal
							$reporteExcel->setActiveSheetIndex(0);

							header("Content-Type: application/vnd.ms-excel; charset=utf-8");
							header('Content-Disposition: attachment; filename="Reporte de Permisos - Beauty ERP.xls');
							header('Cache-Control: max-age=0');
							ob_get_clean();
							$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
							
							$exportarReporte->save("php://output");

	

?>
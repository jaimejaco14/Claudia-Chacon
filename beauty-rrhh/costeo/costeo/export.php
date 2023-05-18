<?php 
	include '../../../cnx_data.php';
	require_once '../../../lib/phpexcel/Classes/PHPExcel.php';
	$clb=$_GET['clb'];
	$fd=$_GET['fd'];
	$fh=$_GET['fh'];
	$money=$_GET['money'];
	$valdia=$_GET['valdia'];
	$des=0;
	$nla=0;
	$rcol=$conn->query("SELECT t.trcrazonsocial FROM btycolaborador c NATURAL JOIN btytercero t WHERE c.clbcodigo=".$clb);
	$rwcol=$rcol->fetch_array();

	//$nomcol=mysqli_fetch_array(mysqli_query($conn,"SELECT t.trcrazonsocial FROM btycolaborador c NATURAL JOIN btytercero t WHERE c.clbcodigo=".$clb));

	$fechaGenerado           = date("d-m-Y");
	$horaGenerado            = date("h:i:s a");

	$columnas = array("A", "B", "C", "D");
	$i        = 11;

	$reporteExcel = new PHPExcel();
	$reporteExcel->getProperties()
					->setCreator("Beauty ERP")
					->setLastModifiedBy("Beauty ERP")
					->setTitle("Prorrateo por salones")
					->setSubject("Prorrateo por salones")
					->setDescription("Reporte generado a través de Beauty ERP")
					->setKeywords("beauty ERP reporte prorrateo")
					->setCategory("reportes");
	$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
	//Creacion de imagen de cabecera
	$imagenSalon = new PHPExcel_Worksheet_Drawing();
	$imagenSalon->setName("Imagen corporativa");
	$imagenSalon->setDescription("Imagen corporativa");
	$imagenSalon->setCoordinates("A1");
	$imagenSalon->setPath("../../../contenidos/imagenes/logo_empresa.jpg");
	$imagenSalon->setHeight(35);
	$imagenSalon->setWorksheet($reporteExcel->getActiveSheet(0));

	$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
	$reporteExcel->getActiveSheet(0)->getStyle("A7")->getFont()->setBold(true);
	$reporteExcel->getActiveSheet(0)->getStyle("A8")->getFont()->setBold(true);
	$reporteExcel->getActiveSheet(0)->getStyle("A9")->getFont()->setBold(true);
	$reporteExcel->getActiveSheet(0)->mergeCells("A5:D5");
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);
	$reporteExcel->getActiveSheet(0)->mergeCells("B7:D7");
	$reporteExcel->getActiveSheet(0)->mergeCells("B8:D8");
	$reporteExcel->getActiveSheet(0)->mergeCells("B9:D9");
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A7", "Colaborador");
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("B7", utf8_encode(strtoupper($rwcol[0])));
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A8", "Periodo:");
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("B8", $fd.' a '.$fh);
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A9", "Costo Prorrateado");
	$reporteExcel->setActiveSheetIndex(0)->setCellValue("B9", $money);
	$reporteExcel->getActiveSheet()->getStyle('B7:b9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

	//Escribir en la hoja Salones
	$reporteExcel->setActiveSheetIndex(0)
					->setCellValue("A10", "Salon")
					->setCellValue("B10", "Dias Programados")
					->setCellValue("C10", "Ausencias")
					->setCellValue("D10", "Valor");

	$reporteExcel->getActiveSheet(0)->getStyle("A10:D10")->getFont()->setBold(true);

	$sql="SELECT b.slnnombre,  
		SUM(CASE WHEN b.tprcodigo=1 THEN 1 ELSE 0 END) AS lab,
		SUM(CASE WHEN b.tprcodigo=2 THEN 1 ELSE 0 END) AS des,
		SUM(CASE WHEN b.tprcodigo=1 AND b.aptcodigo IS NULL THEN 1 ELSE 0 END) AS aus,
		SUM(CASE WHEN b.tprcodigo not in (1,2,9) AND b.aptcodigo IS NULL THEN 1 ELSE 0 END) AS otr
		FROM(
		SELECT DISTINCT pc.prgfecha,pc.tprcodigo,ap.aptcodigo,s.slnnombre
		FROM btyprogramacion_colaboradores pc
		LEFT JOIN btyasistencia_procesada ap ON ap.prgfecha=pc.prgfecha AND ap.clbcodigo=pc.clbcodigo AND ap.aptcodigo IN (1,2)
		JOIN btysalon s ON s.slncodigo=pc.slncodigo
		WHERE pc.prgfecha BETWEEN '$fd' AND '$fh' AND pc.clbcodigo=$clb
		GROUP BY pc.prgfecha) AS b
		GROUP BY b.slnnombre";
		//echo $sql;
	$res=$conn->query($sql);
	$numrow=mysqli_num_rows($res);
	while($row=$res->fetch_array()){
		$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, $row['slnnombre'])
								->setCellValue("B".$i, $row['lab'])
								->setCellValue("C".$i, $row['aus'])
								->setCellValue("D".$i, (($row['lab']-$row['aus'])*$valdia));
	$des+=$row['des'];
	$nla+=$row['otr'];
	$i++;
	}
	$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, 'DESCANSOS')
								->setCellValue("B".$i, $des)
								->setCellValue("C".$i, '0')
								->setCellValue("D".$i, ($des*$valdia));
	$i++;
	$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, 'PERMISOS/VACACIONES/OTROS')
								->setCellValue("B".$i, $nla)
								->setCellValue("C".$i, '0')
								->setCellValue("D".$i, ($nla*$valdia));
	
	$reporteExcel->getActiveSheet()->getStyle('I11:I1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	foreach($columnas as $columna){
		$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
	}


	$reporteExcel->getActiveSheet(0)->setTitle("Prorrateo por colaborador");

	$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

	//Establecer la primera hoja (Salones) como hoja principal
	$reporteExcel->setActiveSheetIndex(0);

	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header('Content-Disposition: attachment; filename="Prorrateo por colaborador - Beauty ERP.xls');
	header('Cache-Control: max-age=0');
	ob_get_clean();
	$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
	if ($_POST["enviox"]==1) {
		$exportarReporte->save("tmp/Reporte de Salones ".$_SESSION['user_session'].".xls");
	}else{
	$exportarReporte->save("php://output");
	}
?>
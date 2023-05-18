<?php 
include '../../cnx_data.php';
include '../../lib/phpexcel/Classes/PHPExcel.php';
$opc=$_GET['opc'];

switch($opc){
	case 'mesact':
		$columnas = array("A", "B", "C");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Cumpleaños del mes de".$_GET['mes'])
						->setSubject("cumpleaños")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP cumpleaños")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");

		//Creacion de imagen de cabecera
		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("../../contenidos/imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(45);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		//$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		foreach($array as $t){
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado . " SALON " . $nomsln );
			
		}


		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "DIA")
						->setCellValue("B8", "NOMBRE")
						->setCellValue("C8", "SALON BASE");
						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:C8")->getFont()->setBold(true);
		$sql="SELECT distinct(t.trcrazonsocial),day(c.clbfechanacimiento) as dia,sl.slnnombre
                                    FROM btycolaborador c
                                    JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                                    join btysalon_base_colaborador sb on sb.clbcodigo=c.clbcodigo
                                    join btysalon sl on sl.slncodigo=sb.slncodigo
                                    WHERE MONTH(c.clbfechanacimiento )= MONTH(CURDATE())
                                    AND bty_fnc_estado_colaborador(c.clbcodigo)='vinculado'
                                    and sb.slchasta is null
                                    ORDER BY dia";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$reporteExcel->setActiveSheetIndex(0)
					->setCellValue("A".$i, $row[1])
					->setCellValue("B".$i, utf8_encode($row[0]))
					->setCellValue("C".$i, utf8_encode($row[2]));
					$i++;
		}
		
			
		

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Cumpleaños");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="cumpleaños '.$_GET["mes"].' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/cumpleaños del mes.xls");
		}else{
			$exportarReporte->save("php://output");
		}
	break;
	case 'nextmes':
		$columnas = array("A", "B", "C");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Cumpleaños del mes de".$_GET['mes'])
						->setSubject("cumpleaños")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP cumpleaños")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");

		//Creacion de imagen de cabecera
		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("../../contenidos/imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(45);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		//$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		foreach($array as $t){
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado . " SALON " . $nomsln );
			
		}


		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "DIA")
						->setCellValue("B8", "NOMBRE")
						->setCellValue("C8", "SALON BASE");
						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:C8")->getFont()->setBold(true);
		$sql="SELECT distinct(t.trcrazonsocial),day(c.clbfechanacimiento) as dia,sl.slnnombre
                                    FROM btycolaborador c
                                    JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                                    join btysalon_base_colaborador sb on sb.clbcodigo=c.clbcodigo
                                    join btysalon sl on sl.slncodigo=sb.slncodigo
                                    WHERE MONTH(c.clbfechanacimiento )= IF(MONTH(CURDATE())+1=13,1,MONTH(CURDATE())+1)
                                    AND bty_fnc_estado_colaborador(c.clbcodigo)='vinculado'
                                    and sb.slchasta is null
                                    ORDER BY dia";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$reporteExcel->setActiveSheetIndex(0)
					->setCellValue("A".$i, $row[1])
					->setCellValue("B".$i, utf8_encode($row[0]))
					->setCellValue("C".$i, utf8_encode($row[2]));
					$i++;
		}
		
			
		

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Cumpleaños");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="cumpleaños '.$_GET["mes"].' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/cumpleaños del mes.xls");
		}else{
			$exportarReporte->save("php://output");
		}
	break;
}
?>
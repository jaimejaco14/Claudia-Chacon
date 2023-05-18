<?php
$fecha1=$_GET['f1'];
$fecha2=$_GET['f2'];
$codcol=$_GET['col'];
$nomcol=$_GET['coltxt'];
$opc=$_GET['opc'];
include '../../cnx_data.php';

switch($opc){
	case 'PDF':
		require_once '../../lib/fpdf/fpdf.php';
		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 10);
				$this->Cell(0, 6, "REPORTE INDIVIDUAL DE ASISTENCIA ", 0, 2, 'R');
				$this->Cell(0, 6, "Del ".$_GET['f1']." al ".$_GET['f2'], 0, 2, 'R');
				$this->Cell(0, 6, $_GET['coltxt'], 0, 2, 'R');
				$this->SetFont("Arial", "", 8);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer(){

				$this->SetY(-12);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP", 0, 2,'C');
			}
		}
		$reportePdf = new PDF();

		$reportePdf->AddPage("P", "legal");
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 9);
		//ENCABEZADOS**************************************************
		$reportePdf->Cell(20, 7, "FECHA", 1, 0, "C", 1);
		$reportePdf->Cell(30, 7, "TURNO", 1, 0, "C", 1);
		$reportePdf->Cell(32, 7, "SALON", 1, 0, "C", 1);
		$reportePdf->Cell(27, 7, "REGISTRO", 1, 0, "C", 1);
		$reportePdf->Cell(30, 7, "HORA REGISTRO", 1, 0, "C", 1);
		$reportePdf->Cell(39, 7, "RESULTADO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 7, "VALOR", 1, 0, "C", 1);
		//FIN ENCABEZADOS**********************************************
		$reportePdf->Ln(6);
		//color, tipo y tamaño de letra
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 7);
		//fin color, tipo y tamaño de letra

		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' 
				AND (apt.aptcodigo=2 OR apt.aptcodigo=1) 
				UNION
				SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' 
				AND (apt.aptcodigo=3 OR apt.aptcodigo=1) 
				UNION
				SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, null,null, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol 
				AND ap.abmcodigo IS NULL and ap.aptcodigo=4
				UNION
				SELECT ap.prgfecha, CONCAT(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, IFNULL(NULL, IF((
				SELECT ab.abmnuevotipo
				FROM btyasistencia_procesada ap2
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
				WHERE ap2.prgfecha = ap.prgfecha AND ap2.clbcodigo=ap.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA'))
								, NULL, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ap.abmcodigo IS NULL AND ap.aptcodigo=6
				UNION
				SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' AND apt.aptcodigo=5
				union
				SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' AND apt.aptcodigo=5
				ORDER BY prgfecha asc, abmnuevotipo asc";
		$res=$conn->query($sql);
		$i=0;//variable de control color de fondo intercalado de filas
		while($row=$res->fetch_array()){
			$i++;
			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}
			$reportePdf->Cell(20, 5, $row[0], 1, 0, "C", 1);
			$reportePdf->Cell(30, 5, $row[1], 1, 0, "C", 1);
			$reportePdf->Cell(32, 5, $row[2], 1, 0, "C", 1);
			$reportePdf->Cell(27, 5, $row[3], 1, 0, "C", 1);
			$reportePdf->Cell(30, 5, $row[4], 1, 0, "C", 1);
			$reportePdf->Cell(39, 5, $row[5], 1, 0, "C", 1);
			$reportePdf->Cell(20, 5, $row[6], 1, 0, "R", 1);
			$reportePdf->Ln(5);
		}
		$sqltotal="SELECT concat('$',format(SUM(ap.apcvalorizacion),0)) FROM btyasistencia_procesada ap
					WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol";
		$restotal=$conn->query($sqltotal);
		$total=$restotal->fetch_array();
		$reportePdf->SetFillColor(255);
		$reportePdf->SetFont("Arial", "B", 9);
		$reportePdf->Cell(178, 5, 'TOTAL', 0, 0, "R", 1);
		$reportePdf->Cell(20, 5, $total[0], 1, 0, "R", 1);
		$reportePdf->Output("Reporte individual de asistencia.pdf", "I");
	break;
	case 'XLS':
		require_once '../../lib/phpexcel/Classes/PHPExcel.php';

		$fechaGenerado           = date("d-m-Y");
		$horaGenerado            = date("h:i:s a");

		$columnas = array("A", "B", "C", "D", "E", "F", "G");
		$i        = 9;

		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de salones")
						->setSubject("Reporte de asistencia")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte asistencia")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
		//Creacion de imagen de cabecera
		$imagenSalon = new PHPExcel_Worksheet_Drawing();
		$imagenSalon->setName("Imagen corporativa");
		$imagenSalon->setDescription("Imagen corporativa");
		$imagenSalon->setCoordinates("A1");
		$imagenSalon->setPath("../../contenidos/imagenes/logo_empresa.jpg");
		$imagenSalon->setHeight(35);
		$imagenSalon->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A6", "Colaborador ".$nomcol);

		//Escribir en la hoja Salones
		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "FECHA")
						->setCellValue("B8", "TURNO")
						->setCellValue("C8", "SALON")
						->setCellValue("D8", "REGISTRO")
						->setCellValue("E8", "HORA REGISTRO")
						->setCellValue("F8", "RESULTADO")
						->setCellValue("G8", "VALOR");

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

		$sql="SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' 
				AND (apt.aptcodigo=2 OR apt.aptcodigo=1) 
				UNION
				SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' 
				AND (apt.aptcodigo=3 OR apt.aptcodigo=1) 
				UNION
				SELECT ap.prgfecha, concat(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, null,null, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol 
				AND ap.abmcodigo IS NULL and ap.aptcodigo=4
				UNION
				SELECT ap.prgfecha, CONCAT(tn.trndesde,' a ',tn.trnhasta) AS horario,sl.slnnombre, IFNULL(NULL, IF((
				SELECT ab.abmnuevotipo
				FROM btyasistencia_procesada ap2
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
				WHERE ap2.prgfecha = ap.prgfecha AND ap2.clbcodigo=ap.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA'))
								, NULL, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ap.abmcodigo IS NULL AND ap.aptcodigo=6
				UNION
				SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='SALIDA' AND apt.aptcodigo=5
				union
				SELECT ap.prgfecha, null,sl.slnnombre, ab.abmnuevotipo, ab.abmhora, apt.aptnombre AS estado,concat('$',format(ap.apcvalorizacion,0))
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl on sl.slncodigo=ap.slncodigo
				WHERE ap.prgfecha BETWEEN '$fecha1' AND '$fecha2' AND ap.clbcodigo=$codcol AND ab.abmnuevotipo='ENTRADA' AND apt.aptcodigo=5
				ORDER BY prgfecha asc, abmnuevotipo asc";
		$res=$conn->query($sql);
		$i=9;

		while($row=$res->fetch_array()){

			$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A".$i, $row[0])
						->setCellValue("B".$i, $row[1])
						->setCellValue("C".$i, $row[2])
						->setCellValue("D".$i, $row[3])
						->setCellValue("E".$i, $row[4])
						->setCellValue("F".$i, $row[5])
						->setCellValue("G".$i, $row[6]);
			$i++;
		}

		$reporteExcel->getActiveSheet()->getStyle('G9:G1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");


		$reporteExcel->getActiveSheet(0)->setTitle("Asistencia");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Salones) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Asistencia '.$nomcol.' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/Reporte de Salones ".$_SESSION['user_session'].".xls");
		}else{
		$exportarReporte->save("php://output");
		}
	break;
}



?>
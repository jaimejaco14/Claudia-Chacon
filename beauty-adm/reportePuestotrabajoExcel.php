<?php 
	header( 'Content-Type: application/json' );
	include '../cnx_data.php';
	$salon				= $_REQUEST['salon'];
	$tipoReporte        = $_REQUEST["tipoReporte"];
	$nomsln				= $_REQUEST['nomsalon'];
	$_SESSION['noms']	= $nomsln;
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");

	$sql = mysqli_query($conn, "SELECT p.ptrnombre, p.ptrubicacion, t.tptnombre, p.ptrcodigo, if(p.ptrmultiple = 1, 'Si', 'No')as mult, p.ptrimagen FROM btypuesto_trabajo p INNER JOIN btytipo_puesto t ON t.tptcodigo = p.tptcodigo WHERE p.slncodigo = $salon and p.ptrestado = 1 order by p.ptrnombre asc, t.tptnombre asc ");

	//$_SESSION['salon'] = $row['slnnombre'];

	$array = array();

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'nombre' =>$row->ptrnombre,
			'ubic'   =>$row->ptrubicacion,
			'cargo'  =>$row->tptnombre,
			'mult'   =>$row->mult
		);
	}
/********************************************************************************/



	if($tipoReporte == "excel"){

		require_once '../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de sesiones")
						->setSubject("Reporte de sesiones")
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
		//$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		foreach($array as $t){
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado . " SALON " . $nomsln );
			
		}


		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "NOMBRE")
						->setCellValue("B8", "UBICACIÓN")
						->setCellValue("C8", "CARGO")
						->setCellValue("D8", "MÚLTIPLE");
						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

		foreach($array as $dato){			
		
					$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $dato["nombre"])
							->setCellValue("B".$i, $dato["ubic"])
							->setCellValue("C".$i, $dato["cargo"])
							->setCellValue("D".$i, $dato["mult"]);
							$i++;
			}
		

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Sesiones");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Puestos de Trabajo - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/REPORTE DE PUESTOS DE TRABAJO SALON ".$nomsln.".xls");
		}else{
			$exportarReporte->save("php://output");
		}
	
	} else {
		
	
		require_once '../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE PUESTOS DE TRABAJO SALON " . $_SESSION['noms'] . ".", 0, 2, 'R');
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer(){

				$this->SetY(-12);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP", 0, 2,'C');
				//$this->Cell(0,5,"www.claudiachacon.com", 0, 2,'C');
			}
		}

		

		//Formato de tabla
		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 10);
		$reportePdf->Cell(30, 8, utf8_decode("Nombre"), 1, 0, "C", 1);
		$reportePdf->Cell(170, 8, utf8_decode("Ubicación"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "Cargo", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "Multiple", 1, 0, "C", 1);
		
		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);
		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 10);

		for($i = 0; $i < count($array); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}
			$reportePdf->Ln();
			$reportePdf->Cell(30, 6.5, utf8_decode($array[$i]["nombre"]), 1, 0, "C", 1);
			$reportePdf->Cell(170, 6.5, $array[$i]["ubic"], 1, 0, "C", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["cargo"], 1, 0, "C", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["mult"], 1, 0, "C", 1);
			
			
		}
		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de Puestos de trabajo salon ".$_SESSION['noms'].".pdf", "F");
		}else{
		$reportePdf->Output("Reporte de Puestos de trabajo salon ".$_SESSION['noms'].".pdf", "I");
		}
	}

?>
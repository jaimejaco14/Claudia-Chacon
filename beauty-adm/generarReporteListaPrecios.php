<?php 
	
	include '../cnx_data.php';

	$tipoReporte    = $_REQUEST["tipoReporte"];
	$codLista       = $_REQUEST["codLista"];
	$nomLista       = $_REQUEST["nomLista"];
	$grupo          = $_REQUEST["grupo"];
	$subgrupo       = $_REQUEST["subgrupo"];
	$linea          = $_REQUEST["linea"];
	$sublinea       = $_REQUEST["sublinea"];
	$caracteristica = $_REQUEST["caracteristica"];
	$preciosNulos   = $_REQUEST["preciosNulos"];
	$fechaGenerado  = date("d-m-Y");
	$horaGenerado   = date("h:i:s a");

		$servicios = array();
		$query = "SELECT servicio.sercodigo, servicio.sernombre, preciosServicios.lpsvalor FROM btyservicio servicio INNER JOIN btylista_precios_servicios preciosServicios ON servicio.sercodigo = preciosServicios.sercodigo INNER JOIN bty_vw_servicios_categorias categoria ON servicio.sercodigo = categoria.sercodigo WHERE preciosServicios.lprcodigo = $codLista";
		
		if($grupo != "null"){

			$query .=" AND categoria.grucodigo = $grupo";

			if($subgrupo != "null"){

				$query .= " AND categoria.sbgcodigo = $subgrupo";

				if($linea != "null"){

					$query .= " AND categoria.lincodigo = $linea";

					if($sublinea != "null"){

						$query .= " AND categoria.sblcodigo = $sublinea";

						if($caracteristica != "null"){

							$query .= " AND categoria.crscodigo = $caracteristica";
						}
					}
				}
			}
		}

		if($preciosNulos != 0){

		$query .= " AND preciosServicios.lpsvalor = 0";
		}/*
		else{

			$query .= " AND preciosServicios.lpsvalor = 0";
		}*/

		$query       .= " ORDER BY servicio.sernombre";
		$resultQuery = $conn->query($query);

		while($registros = $resultQuery->fetch_array()){

			$servicios[] = array(
							"codigo"   => $registros["sercodigo"],
							"servicio" => $registros["sernombre"],
							"valor"    => $registros["lpsvalor"]);
		}


	if($tipoReporte == "excel"){

		require_once './lib/phpexcel/Classes/PHPExcel.php';

		$columnas     = array("A", "B", "C", "D");
		$i            = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de servicios - lista de precios")
						->setSubject("Reporte de servicios - lista de precios")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte servicios listas precios")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:D4");
		$reporteExcel->getActiveSheet(0)->mergeCells("A5:D5");
	
		//Creacion de imagen de cabecera
		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("./imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(50);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Cod. Servicio")
						->setCellValue("B8", "Servicio")
						->setCellValue("C8", "Valor")
						->setCellValue("D8", "Nombre de lista");

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:D8")->getFont()->setBold(true);
		//$reporteExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

		foreach($servicios as $servicio){

			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $servicio["codigo"])
							->setCellValue("B".$i, utf8_encode($servicio["servicio"]))
							->setCellValue("C".$i, "$".number_format($servicio["valor"], 0, ",", "."))
							->setCellValue("D".$i, utf8_encode($nomLista));
			$i++;
		}

		$reporteExcel->getActiveSheet(0)->setTitle("Servicios");
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de servicios (Lista de precios) - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		$exportarReporte->save("php://output");
	} 
	else if($tipoReporte == "pdf"){
		require_once './lib/fpdf/fpdf.php';
		class PDF extends FPDF{

			function Header(){

				$this->Image('./imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE LISTA DE PRECIOS", 0, 2, 'R');
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer() {

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

		$reportePdf->Cell(40, 8, utf8_decode("Cod. Servicio"), 1, 0, "C", 1);
		$reportePdf->Cell(90, 8, utf8_encode("Servicio"), 1, 0, "C", 1);
		$reportePdf->Cell(45, 8, utf8_encode("Valor"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Nombre de lista"), 1, 1, "C", 1);

		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		for($i = 0; $i < count($servicios); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}
			$reportePdf->Cell(40, 6.5, $servicios[$i]["codigo"], 1, 0, "C", 1);
			$reportePdf->Cell(90, 6.5, utf8_encode($servicios[$i]["servicio"]), 1, 0, "L", 1);
			$reportePdf->Cell(45, 6.5, utf8_decode($servicios[$i]["valor"]), 1, 0, "L", 1);;
			$reportePdf->Cell(40, 6.5, utf8_encode($nomLista), 1, 1, "L", 1);
		}

		$reportePdf->Output("Reporte de lista de precios.pdf", "I");

	}

	mysqli_close($conn);
?>
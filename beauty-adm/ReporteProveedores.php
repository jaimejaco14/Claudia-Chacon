<?php 
	include '../cnx_data.php';
	$_SESSION['vrbrptprv']=$_POST['dato'];
	$tipoReporte        = $_REQUEST["tipoReporte"];
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");
	$colaboradores      = array();
	$queryColaboradores = $_SESSION['sqlprv'];
	
	//if(!empty($dato)){

		//$queryColaboradores .= " AND (tercero.trcrazonsocial LIKE '%".$dato."%' OR tercero.trcdocumento LIKE '%".$dato."%')";
	//}

	//$queryColaboradores       .= " ORDER BY tercero.trcrazonsocial";

	$resultQueryColaboradores = $conn->query($queryColaboradores);
	
	while($registros = $resultQueryColaboradores->fetch_array()){

		$colaboradores[] = array(
							"nombret"           => $registros["trcrazonsocial"],
							"tipodoc"         	 => $registros["tdialias"],
							"docut"			 => $registros["trcdocumento"],
							"email"             => $registros["prvemail"],
							"direccion"          => $registros["trcdireccion"],
							"dpto"       => $registros["depombre"],
							"localidad"      => $registros["locnombre"],
							"barrio"             => $registros["brrnombre"],
							"telefonom"      => $registros["trctelefonomovil"],
							"telefonof"     => $registros["trctelefonofijo"]
							
							
						);
	}

	if($tipoReporte == "excel" || $_POST["enviox"]==1){

		require_once 'lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de proveedores")
						->setSubject("Reporte de proveedores")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte proveedores")
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
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Proveedor")
						->setCellValue("B8", "Documento")
						->setCellValue("C8", "Correo")
						->setCellValue("D8", "Direccion")
						->setCellValue("E8", "Telefono Movil")
						->setCellValue("F8", "Telefono fijo");
						
						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

		foreach($colaboradores as $colaborador){
		
			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $colaborador["nombret"])
							->setCellValue("B".$i, $colaborador["docut"])
							->setCellValue("C".$i, $colaborador["email"])
							->setCellValue("D".$i, $colaborador["direccion"])
							->setCellValue("E".$i, $colaborador["telefonom"])
							->setCellValue("F".$i, $colaborador["telefonof"]);
						
							
							$i++;
							}

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Proveedores");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Proveedores - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/Reporte de proveedores ".$_SESSION['user_session'].".xls");
		}else{
			$exportarReporte->save("php://output");
		}
		
	
	}else{

		require_once './lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('./imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE SESIONES", 0, 2, 'R');
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

		//Formato de 3 colaboradores por página
	

		//Formato de tabla
		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 11);
		$reportePdf->Cell(80, 8, utf8_decode("Proveedor"), 1, 0, "C", 1);
		//$reportePdf->Cell(30, 8, "Tipo documento", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "No. Documento", 1, 0, "C", 1);
		$reportePdf->Cell(90, 8, "Correo", 1, 0, "C", 1);
		//$reportePdf->Cell(0, 8, "Fecha nacimiento", 1, 0, "C", 1);
		$reportePdf->Cell(45, 8, "Direccion", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "Telefono movil", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "Telefono fijo", 1, 1, "C", 1);
		//$reportePdf->Cell(0, 5, utf8_decode("Notif. móvil"), 1, 0, "C", 1);
		//$reportePdf->Cell(0, 5, "Notif. email", 1, 0, "C", 1);

		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 10);

		for($i = 0; $i < count($colaboradores); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}
			$reportePdf->Cell(80, 6.5, $colaboradores[$i]["nombret"], 1, 0, "C", 1);
			//$reportePdf->Cell(30, 6.5, $colaboradores[$i]["aliasDocumento"], 1, 0, "C");
			$reportePdf->Cell(40, 6.5, ($colaboradores[$i]["docut"]), 1, 0, "C", 1);
			$reportePdf->Cell(90, 6.5, $colaboradores[$i]["email"], 1, 0, "C", 1);
			$reportePdf->Cell(45, 6.5, utf8_decode($colaboradores[$i]["direccion"]), 1, 0, "C", 1);
			$reportePdf->Cell(35, 6.5, $colaboradores[$i]["telefonom"], 1, 0, "C", 1);
			$reportePdf->Cell(35, 6.5, $colaboradores[$i]["telefonof"], 1, 1, "C", 1);
		}

		
		
		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de proveedores ".$_SESSION['user_session'].".pdf", "F");
		}else{
			$reportePdf->Output("Reporte de Sesiones.pdf", "I");
		}
	}

	mysqli_close($conn);

?>
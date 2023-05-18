<?php 
//session_start();
	include '../../cnx_data.php';
	//echo "tine".$_POST['dato'];
	if ($_POST['dato']!="") {
		echo $dato=$_POST['dato'];
		$_SESSION['vrbrptsln']=$_POST['dato'];
	}else{
		$dato               = $_REQUEST["dato"];
	}
	$tipoReporte   = $_REQUEST["tipoReporte"];
	$fechaGenerado = date("d-m-Y");
	$horaGenerado  = date("h:i:s a");
	$querySalones  = "SELECT salon.slncodigo AS slncodigo, salon.slnnombre AS slnnombre, salon.slndireccion AS slndireccion, localidad.locnombre AS locnombre, salon.slnindicativotelefonofijo AS slnindicativotelefonofijo, salon.slntelefonofijo AS slntelefonofijo, salon.slnextensiontelefonofijo AS slnextensiontelefonofijo, salon.slntelefonomovil AS slntelefonomovil, salon.slnemail AS slnemail, salon.slntamano AS slntamano, salon.slnfechaapertura AS slnfechaapertura, salon.slnalias AS slnalias, salon.slnplantas AS slnplantas FROM btysalon salon NATURAL JOIN btylocalidad localidad WHERE salon.slnestado = 1";
	$salones       = array();

	if(!empty($dato)){

		$querySalones .= " AND (slncodigo LIKE '%".$dato."%' OR slnnombre LIKE '%".$dato."%')";
	}

	//$querySalones       .= " ORDER BY salon.slnfechaapertura";
	$querySalones       .= " ORDER BY salon.slnnombre";
	$resultQuerySalones = $conn->query($querySalones);

	while($registros = $resultQuerySalones->fetch_array()){

		$salones[] = array(
						"codigo"        => $registros["slncodigo"],
						"nombre"        => utf8_encode($registros["slnnombre"]),
						"direccion"     => utf8_encode($registros["slndireccion"]),
						"localidad"     => utf8_encode($registros["locnombre"]),
						"indicativo"    => $registros["slnindicativotelefonofijo"],
						"telefonoFijo"  => $registros["slntelefonofijo"],
						"telefonoMovil" => $registros["slntelefonomovil"],
						"email"         => $registros["slnemail"],
						"tamano"        => $registros["slntamano"],
						"fechaApertura" => $registros["slnfechaapertura"],
						"alias"         => utf8_encode($registros["slnalias"]),
						"planta"        => $registros["slnplantas"]
				); 
	}

	function utf8_converter($array){
		array_walk_recursive($array, function(&$item, $key){
			if(!mb_detect_encoding($item, 'utf-8', true)){
				$item = utf8_encode($item);
			}
		});

		return $array;
	}

	$salones= utf8_converter($salones);

	if($tipoReporte == "excel" || $_POST["enviox"]){ 	

		require_once '../../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L");
		$i        = 9;

		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de salones")
						->setSubject("Reporte de salones")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte salones")
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

		//Escribir en la hoja Salones
		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Código")
						->setCellValue("B8", "Nombre")
						->setCellValue("C8", "Alias")
						->setCellValue("D8", "Localidad")
						->setCellValue("E8", "Dirección")
						->setCellValue("F8", "E-mail")
						->setCellValue("G8", "Teléfono fijo")
						->setCellValue("H8", "Indicativo")
						->setCellValue("I8", "Teléfono móvil")
						->setCellValue("J8", "Tamaño")
						->setCellValue("K8", "No. Plantas")
						->setCellValue("L8", "F. Apertura");

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:L8")->getFont()->setBold(true);

		foreach($salones as $salon){
			
			$tamano = new PHPExcel_RichText();
			$tamano->createText($salon["tamano"]."mts");

			$superindice = $tamano->createTextRun('2');
			$superindice->getFont()->setSuperScript(true);

			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $salon["codigo"])
							->setCellValue("B".$i, utf8_encode($salon["nombre"]))
							->setCellValue("C".$i, utf8_encode($salon["alias"]))
							->setCellValue("D".$i, utf8_encode($salon["localidad"]))
							->setCellValue("E".$i, utf8_encode($salon["direccion"]))
							->setCellValue("F".$i, $salon["email"])
							->setCellValue("G".$i, $salon["telefonoFijo"])
							->setCellValue("H".$i, $salon["indicativo"])
							->setCellValue("I".$i, $salon["telefonoMovil"])
							->setCellValue("J".$i, " ".$tamano)
							->setCellValue("K".$i, $salon["planta"])
							->setCellValue("L".$i, $salon["fechaApertura"]);
			$i++;
		}

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Salones'
		$reporteExcel->getActiveSheet(0)->setTitle("Salones");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Salones) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de salones - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/Reporte de Salones ".$_SESSION['user_session'].".xls");
		}else{
		$exportarReporte->save("php://output");
			}
	}
	else{

		require_once "../../lib/fpdf/fpdf.php";

		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE SALONES", 0, 2, 'R');
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

		$reportePdf = new PDF();
		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 10);
		$reportePdf->Cell(15, 8, utf8_decode("Código"), 1, 0, "C", 1);
		$reportePdf->Cell(70, 8, "Nombre", 1, 0, "C", 1);
		//$reportePdf->Cell(20, 8, "Localidad", 1, 0, "C", 1);
		$reportePdf->Cell(75, 8, utf8_decode("Dirección"), 1, 0, "C", 1);
		$reportePdf->Cell(75, 8, "E-mail", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, utf8_decode("Teléfonos"), 1, 0, "C", 1);
		$reportePdf->Cell(17, 8, utf8_decode("Tamaño"), 1, 0, "C", 1);
		$reportePdf->Cell(15, 8, "Plantas", 1, 0, "C", 1);
		$reportePdf->Cell(0, 8, "F. Apertura", 1, 1, "C", 1);

		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		for($i = 0; $i < count($salones); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}

			$reportePdf->Cell(15, 6.5, $salones[$i]["codigo"], 1, 0, "R", 1);
			$reportePdf->Cell(70, 6.5, utf8_decode($salones[$i]["nombre"]." (".$salones[$i]["alias"].")"), 1, 0, "L", 1);
			$reportePdf->Cell(75, 6.5, utf8_decode($salones[$i]["direccion"]), 1, 0, "L", 1);
			$reportePdf->Cell(75, 6.5, $salones[$i]["email"], 1, 0, "L", 1);

			if(!empty($salones[$i]["telefonoFijo"]) && empty($salones[$i]["telefonoMovil"])){

				$reportePdf->Cell(35, 6.5, $salones[$i]["telefonoFijo"], 1, 0, "R", 1);
			}
			elseif(empty($salones[$i]["telefonoFijo"]) && !empty($salones[$i]["telefonoMovil"])){

				$reportePdf->Cell(35, 6.5, $salones[$i]["telefonoMovil"], 1, 0, "R", 1);
			}
			else{

				$reportePdf->Cell(35, 6.5, $salones[$i]["telefonoFijo"]." - ".$salones[$i]["telefonoMovil"], 1, 0, "R", 1);
			}

			$reportePdf->Cell(17, 6.5, $salones[$i]["tamano"]. "mts2", 1, 0, "R", 1);
			$reportePdf->Cell(15, 6.5, $salones[$i]["planta"], 1, 0, "R", 1);
			$reportePdf->Cell(0, 6.5, $salones[$i]["fechaApertura"], 1, 1, "R", 1);
		}

		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de Salones ".$_SESSION['user_session'].".pdf", "F");
		}else{
		$reportePdf->Output("Reporte de salones.pdf", "I");
			}
	}
	
	mysqli_close($conn);
?>
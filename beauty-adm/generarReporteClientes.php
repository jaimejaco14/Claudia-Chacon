<?php 
	//session_start();
	//print_r($_GET);
	include '../cnx_data.php';
	if ($_REQUEST['dato']!="") {
		$dato=$_REQUEST['dato'];
		$_SESSION['vrbrpc']=$_REQUEST['dato'];
	}else{
		$dato               = $_REQUEST["dato"];
	}
	$tipoReporte   = $_REQUEST["tipoReporte"];
	$fechaGenerado = date("d-m-Y");
	$horaGenerado  = date("h:i:s a");
	$clientes      = array();
	$queryClientes = "SELECT tercero.trcdocumento AS trcdocumento, tercero.trcdigitoverificacion AS trcdigitoverificacion, tercero.trcrazonsocial AS trcrazonsocial, identificacion.tdialias AS tdialias, tercero.trcdireccion AS trcdireccion, tercero.trctelefonofijo AS trctelefonofijo, tercero.trctelefonomovil AS trctelefonomovil, cliente.clicodigo AS clicodigo, cliente.clisexo AS clisexo, ocupacion.ocunombre AS ocunombre, cliente.cliextranjero AS cliextranjero, cliente.cliemail AS cliemail, cliente.clifechanacimiento AS clifechanacimiento, cliente.clifecharegistro As clifecharegistro, cliente.clinotificacionmovil AS clinotificacionmovil, cliente.clinotificacionemail AS clinotificacionemail, cliente.cliempresa AS cliempresa FROM btytercero tercero NATURAL JOIN btycliente cliente NATURAL JOIN btytipodocumento identificacion NATURAL JOIN btyocupacion ocupacion WHERE cliente.cliestado = 1";
		
	if(!empty($dato)){

		$queryClientes .=" AND (tercero.trcrazonsocial LIKE '%".$dato."%' OR tercero.trcdocumento LIKE '%".$dato."%')";
	}

	$queryClientes       .= " ORDER BY tercero.trcrazonsocial";
	$resultQueryClientes = $conn->query($queryClientes);

	while($registros = $resultQueryClientes->fetch_array()){

		$clientes[] = array(
						"codigo"             => $registros["clicodigo"],
						"documento"          => $registros["trcdocumento"],
						"digitoVerificacion" => $registros["trcdigitoverificacion"],
						"nombreCliente"      => $registros["trcrazonsocial"],
						"tipoDocumento"      => $registros["tdialias"],
						"direccion"          => $registros["trcdireccion"],
						"telefonoFijo"       => $registros["trctelefonofijo"],
						"telefonoMovil"      => $registros["trctelefonomovil"],
						"sexo"               => $registros["clisexo"],
						"ocupacion"          => $registros["ocunombre"],
						"extranjero"         => $registros["cliextranjero"],
						"email"              => $registros["cliemail"],
						"fechaNacimiento"    => $registros["clifechanacimiento"],
						"fechaRegistro"      => $registros["clifecharegistro"],
						"notificacionMovil"  => $registros["clinotificacionmovil"],
						"notificacionEmail"  => $registros["clinotificacionemail"],
						"empresa"            => $registros["cliempresa"]
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

	$clientes= utf8_converter($clientes);

	//echo json_encode($array);

	//Tipo de reporte escogido: Excel
	if($tipoReporte == "excel"){

		require_once '../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de clientes")
						->setSubject("Reporte de clientes")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte clientes")
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
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		//Escribir en la hoja Clientes
		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Código")
						->setCellValue("B8", "No. documento")
						->setCellValue("C8", "Digito verificación")
						->setCellValue("D8", "Tipo documento")
						->setCellValue("E8", "Nombre")
						->setCellValue("F8", "Sexo")
						->setCellValue("G8", "Ocupación")
						->setCellValue("H8", "Extranjero")
						->setCellValue("I8", "Empresa")
						->setCellValue("J8", "Fecha de nacimiento")
						->setCellValue("K8", "E-mail")
						->setCellValue("L8", "Dirección")
						->setCellValue("M8", "Teléfono fijo")
						->setCellValue("N8", "Teléfono móvil")
						->setCellValue("O8", "Fecha de registro")
						->setCellValue("P8", "Notificación móvil")
						->setCellValue("Q8", "Notificación e-mail");


		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:Q8")->getFont()->setBold(true);

		foreach($clientes as $cliente){

			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $cliente["codigo"])
							->setCellValue("B".$i, $cliente["documento"])
							->setCellValue("C".$i, $cliente["digitoVerificacion"])
							->setCellValue("D".$i, $cliente["tipoDocumento"])
							->setCellValue("E".$i, utf8_encode($cliente["nombreCliente"]))
							->setCellValue("F".$i, $cliente["sexo"])
							->setCellValue("G".$i, utf8_encode($cliente["ocupacion"]))
							->setCellValue("H".$i, $cliente["extranjero"])
							->setCellValue("I".$i, $cliente["empresa"])
							->setCellValue("J".$i, $cliente["fechaNacimiento"])
							->setCellValue("K".$i, $cliente["email"])
							->setCellValue("L".$i, utf8_encode($cliente["direccion"]))
							->setCellValue("M".$i, $cliente["telefonoFijo"])
							->setCellValue("N".$i, $cliente["telefonoMovil"])
							->setCellValue("O".$i, $cliente["fechaRegistro"])
							->setCellValue("P".$i, $cliente["notificacionMovil"])
							->setCellValue("Q".$i, $cliente["notificacionEmail"]);
			$i++;
		}

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Clientes'
		$reporteExcel->getActiveSheet(0)->setTitle("Clientes");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Clientes) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de clientes - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/REPORTE DE CLIENTE .xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}
	}
	//Tipo de reporte escogido: PDF
	else{

		require_once "../lib/fpdf/fpdf.php";

		class PDF extends FPDF{

			function Header(){

				$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE CLIENTES", 0, 2, 'R');
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
		$reportePdf->Cell(30, 8, "No. Documento", 1, 0, "C", 1);
		$reportePdf->Cell(80, 8, "Nombre", 1, 0, "C", 1);
		$reportePdf->Cell(11, 8, "Sexo", 1, 0, "C", 1);
		$reportePdf->Cell(26, 8, "F. Nacimiento", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, utf8_decode("Ocupación"), 1, 0, "C", 1);
		$reportePdf->Cell(20, 8, "Empresa", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Teléfonos"), 1, 0, "C", 1);
		$reportePdf->Cell(54, 8, "E-mail", 1, 0, "C", 1);
		$reportePdf->Cell(0, 8, "F. Registro", 1, 1, "C", 1);

		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		for($i = 0; $i < count($clientes); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}

			$reportePdf->Cell(15, 6.5, $clientes[$i]["codigo"], 1, 0, "R", 1);
			$reportePdf->Cell(30, 6.5, $clientes[$i]["documento"]." - ".$clientes[$i]["digitoVerificacion"]." (".$clientes[$i]["tipoDocumento"].")", 1, 0, "R", 1);
			$reportePdf->Cell(80, 6.5, utf8_decode($clientes[$i]["nombreCliente"]), 1, 0, "L", 1);
			$reportePdf->Cell(11, 6.5, $clientes[$i]["sexo"], 1, 0, "C", 1);
			$reportePdf->Cell(26, 6.5, $clientes[$i]["fechaNacimiento"], 1, 0, "R", 1);
			$reportePdf->Cell(35, 6.5, $clientes[$i]["ocupacion"], 1, 0, "L", 1);
			$reportePdf->Cell(20, 6.5, $clientes[$i]["empresa"], 1, 0, "C", 1);

			if(!empty($clientes[$i]["telefonoFijo"]) && empty($clientes[$i]["telefonoMovil"])){

				$reportePdf->Cell(40, 6.5, $clientes[$i]["telefonoFijo"], 1, 0, "R", 1);
			}
			elseif(empty($clientes[$i]["telefonoFijo"]) && !empty($clientes[$i]["telefonoMovil"])){

				$reportePdf->Cell(40, 6.5, $clientes[$i]["telefonoMovil"], 1, 0, "R", 1);
			}
			else{

				$reportePdf->Cell(40, 6.5, $clientes[$i]["telefonoFijo"]." - ".$clientes[$i]["telefonoMovil"], 1, 0, "R", 1);
			}

			$reportePdf->Cell(54, 6.5, $clientes[$i]["email"], 1, 0, "L", 1);
			$reportePdf->Cell(0, 6.5, $clientes[$i]["fechaRegistro"], 1, 1, "R", 1);
		}
		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de clientes ".$_SESSION['user_session'].".pdf", "F");
		}else{
		$reportePdf->Output("Reporte de clientes.pdf", "I");
		}
	}

	mysqli_close($conn);
?>
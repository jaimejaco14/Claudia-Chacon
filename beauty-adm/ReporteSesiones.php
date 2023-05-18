<?php 

	include '../cnx_data.php';

	$tipoReporte        = $_REQUEST["tipoReporte"];
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");
	$colaboradores      = array();
	$queryColaboradores = $_SESSION['sqlsesiones'];
	$fdo="¡Intento Fallido!";
	$dtdo="Desconectado";
	$acvo="Usuario Activo";
	//if(!empty($dato)){

		//$queryColaboradores .= " AND (tercero.trcrazonsocial LIKE '%".$dato."%' OR tercero.trcdocumento LIKE '%".$dato."%')";
	//}

	//$queryColaboradores       .= " ORDER BY tercero.trcrazonsocial";

	$resultQueryColaboradores = $conn->query($queryColaboradores);
	
	while($registros = $resultQueryColaboradores->fetch_array()){

		$colaboradores[] = array(
							"codigo_s"           => $registros["sescodigo"],
							"codigo_u"         	 => $registros["usucodigo"],
							"sesion"			 => $registros["seslogin"],
							"dirip"             => $registros["sesdireccionipv4wan"],
							"disp"          => $registros["sestipodispotivo"],
							"naveg"       => $registros["sesnavegador"],
							"fechaini"      => $registros["sesfechainicio"],
							"horaini"             => $registros["seshorainicio"],
							"fechafin"      => $registros["sesfechafin"],
							"horafin"     => $registros["seshorafin"],
							"fallo"               => $registros["sesfallida"],
							"estado"              => $registros["sesestado"]
							
						);
	}

	if($tipoReporte == "excel" || $_POST["enviox"]==1){

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
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Sesion")
						->setCellValue("B8", "Direccion IP")
						->setCellValue("C8", "Dispositivo")
						->setCellValue("D8", "Navegador")
						->setCellValue("E8", "Inicio de Sesion")
						->setCellValue("F8", "Fin de Sesion")
						->setCellValue("G8", "Estado de Sesion");
						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

		foreach($colaboradores as $colaborador){
			
			if ($colaborador["estado"]== 0 && $colaborador["fallo"]== 1) {
			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $colaborador["sesion"])
							->setCellValue("B".$i, $colaborador["dirip"])
							->setCellValue("C".$i, $colaborador["disp"])
							->setCellValue("D".$i, $colaborador["naveg"])
							->setCellValue("E".$i, $colaborador["fechaini"]." / ".$colaborador["horaini"])
							->setCellValue("F".$i, $colaborador["fechafin"]." / ".$colaborador["horafin"])
							->setCellValue("G".$i, $fdo);
							}else if ($colaborador["estado"]== 1 && $colaborador["fallo"]== 0){
							$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $colaborador["sesion"])
							->setCellValue("B".$i, $colaborador["dirip"])
							->setCellValue("C".$i, $colaborador["disp"])
							->setCellValue("D".$i, $colaborador["naveg"])
							->setCellValue("E".$i, $colaborador["fechaini"]." / ".$colaborador["horaini"])
							->setCellValue("F".$i, $colaborador["fechafin"]." / ".$colaborador["horafin"])
							->setCellValue("G".$i, $acvo);
							}else{
							$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $colaborador["sesion"])
							->setCellValue("B".$i, $colaborador["dirip"])
							->setCellValue("C".$i, $colaborador["disp"])
							->setCellValue("D".$i, $colaborador["naveg"])
							->setCellValue("E".$i, $colaborador["fechaini"]." / ".$colaborador["horaini"])
							->setCellValue("F".$i, $colaborador["fechafin"]." / ".$colaborador["horafin"])
							->setCellValue("G".$i, $dtdo);
							}
							$i++;
							}

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Sesiones");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Sesiones - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/Reporte de sesiones ".$_SESSION['user_session'].".xls");
		}else{
			$exportarReporte->save("php://output");
		}
		
	
	}else{

		require_once '../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
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
		/*$reportePdf = new PDF();
		
		for($i = 0; $i < count($colaboradores); $i++){

			$reportePdf->AddPage();

			$reportePdf->Ln();
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(25, 25, "Foto", 1, 0);

			if (file_exists('./imagenes/colaborador/'.$colaboradores[$i]["imagen"])) {
    			$reportePdf->Image("./imagenes/colaborador/".$colaboradores[$i]["imagen"], 10, 36, 25);
			} else {
   				 $reportePdf->Image("./imagenes/default.jpg", 10, 36, 25);
			}

			$reportePdf->Cell(165, 12.5,"   ".$colaboradores[$i]["nombre"]. " (".$colaboradores[$i]["cargo"]." - ".$colaboradores[$i]["categoria"].")", 0, 2);
			$reportePdf->Cell(165, 12.5, "   ".$colaboradores[$i]["documento"]." - ".$colaboradores[$i]["digitoVerificacion"]."   ".$colaboradores[$i]["tipoDocumento"], 0, 1);
			$reportePdf->Cell(90, 6.25, utf8_decode("Dirección"), 0, 0);
			$reportePdf->Cell(50, 6.25, "Fecha de nacimiento", 0, 0);
			$reportePdf->Cell(50, 6.25, "Sexo", 0, 1);
			$reportePdf->SetFont("Arial", "", 8);
			$reportePdf->Cell(90, 6.25, $colaboradores[$i]["direccion"]." (".$colaboradores[$i]["barrio"].")", 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["fechaNacimiento"], 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["sexo"], 0, 1);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(90, 6.25, "E-mail", 0, 0);
			$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono fijo"), 0, 0);
			$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono móvil"), 0, 1);
			$reportePdf->SetFont("Arial", "", 8);
			$reportePdf->Cell(90, 6.25, $colaboradores[$i]["email"], 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoFijo"], 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoMovil"], 0, 1);
			$reportePdf->SetFont("Arial", "B", 8);
			$reportePdf->Cell(90, 6.25, "Fecha de ingreso", 0, 0);
			$reportePdf->Cell(50, 6.25, utf8_decode("Notificación móvil"), 0, 0);
			$reportePdf->Cell(50, 6.25, utf8_decode("Notificación e-mail"), 0, 1);
			$reportePdf->SetFont("Arial", "", 8);
			$reportePdf->Cell(90, 6.25, $colaboradores[$i]["fechaIngreso"], 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionMovil"], 0, 0);
			$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionEmail"], 0, 1);
			$reportePdf->Ln();

			$i = $i + 1;

			if($i < count($colaboradores)){

				$reportePdf->Ln();
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(25, 25, "Foto", 1, 0);
		

				if (file_exists('./imagenes/colaborador/'.$colaboradores[$i]["imagen"])) {
	    			$reportePdf->Image("./imagenes/colaborador/".$colaboradores[$i]["imagen"], 10, 111, 25);
				} else {
	   				 $reportePdf->Image("./imagenes/default.jpg", 10, 111, 25);
				}

				$reportePdf->Cell(165, 12.5,"   ".$colaboradores[$i]["nombre"]. " (".$colaboradores[$i]["cargo"]." - ".$colaboradores[$i]["categoria"].")", 0, 2);
				$reportePdf->Cell(165, 12.5, "   ".$colaboradores[$i]["documento"]." - ".$colaboradores[$i]["digitoVerificacion"]."   ".$colaboradores[$i]["tipoDocumento"], 0, 1);
				$reportePdf->Cell(90, 6.25, utf8_decode("Dirección"), 0, 0);
				$reportePdf->Cell(50, 6.25, "Fecha de nacimiento", 0, 0);
				$reportePdf->Cell(50, 6.25, "Sexo", 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["direccion"]." (".$colaboradores[$i]["barrio"].")", 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["fechaNacimiento"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["sexo"], 0, 1);
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(90, 6.25, "E-mail", 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono fijo"), 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono móvil"), 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["email"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoFijo"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoMovil"], 0, 1);
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(90, 6.25, "Fecha de ingreso", 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Notificación móvil"), 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Notificación e-mail"), 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["fechaIngreso"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionMovil"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionEmail"], 0, 1);
				$reportePdf->Ln();
			}				

			$i = $i + 1;

			if($i < count($colaboradores)){

				$reportePdf->Ln();
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(25, 25, "Foto", 1, 0);
				
				if (file_exists('./imagenes/colaborador/'.$colaboradores[$i]["imagen"])) {
	    			$reportePdf->Image("./imagenes/colaborador/".$colaboradores[$i]["imagen"], 10, 186, 25);
				} else {
	   				 $reportePdf->Image("./imagenes/default.jpg", 10, 186, 25);
				}
				$reportePdf->Cell(165, 12.5,"   ".$colaboradores[$i]["nombre"]. " (".$colaboradores[$i]["cargo"]." - ".$colaboradores[$i]["categoria"].")", 0, 2);
				$reportePdf->Cell(165, 12.5, "   ".$colaboradores[$i]["documento"]." - ".$colaboradores[$i]["digitoVerificacion"]."   ".$colaboradores[$i]["tipoDocumento"], 0, 1);
				$reportePdf->Cell(90, 6.25, utf8_decode("Dirección"), 0, 0);
				$reportePdf->Cell(50, 6.25, "Fecha de nacimiento", 0, 0);
				$reportePdf->Cell(50, 6.25, "Sexo", 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["direccion"]." (".$colaboradores[$i]["barrio"].")", 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["fechaNacimiento"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["sexo"], 0, 1);
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(90, 6.25, "E-mail", 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono fijo"), 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Teléfono móvil"), 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["email"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoFijo"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["telefonoMovil"], 0, 1);
				$reportePdf->SetFont("Arial", "B", 8);
				$reportePdf->Cell(90, 6.25, "Fecha de ingreso", 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Notificación móvil"), 0, 0);
				$reportePdf->Cell(50, 6.25, utf8_decode("Notificación e-mail"), 0, 1);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->Cell(90, 6.25, $colaboradores[$i]["fechaIngreso"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionMovil"], 0, 0);
				$reportePdf->Cell(50, 6.25, $colaboradores[$i]["notificacionEmail"], 0, 1);
				$reportePdf->Ln();
			}
		}*/

		//Formato de tabla
		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 11);
		$reportePdf->Cell(60, 8, utf8_decode("Usuario"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "Direccion IP", 1, 0, "C", 1);
		//$reportePdf->Cell(30, 8, "Tipo documento", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "Dispositivo", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, "Navegador", 1, 0, "C", 1);
		//$reportePdf->Cell(0, 8, "Fecha nacimiento", 1, 0, "C", 1);
		$reportePdf->Cell(50, 8, "Inicio de Sesion", 1, 0, "C", 1);
		$reportePdf->Cell(50, 8, "Fin de Sesion", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "Estado de Sesion", 1, 1, "C", 1);
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
			$reportePdf->Cell(60, 6.5, $colaboradores[$i]["sesion"], 1, 0, "C", 1);
			$reportePdf->Cell(40, 6.5, $colaboradores[$i]["dirip"], 1, 0, "C", 1);
			//$reportePdf->Cell(30, 6.5, $colaboradores[$i]["aliasDocumento"], 1, 0, "C");
			$reportePdf->Cell(40, 6.5, ($colaboradores[$i]["disp"]), 1, 0, "C", 1);
			$reportePdf->Cell(40, 6.5, $colaboradores[$i]["naveg"], 1, 0, "C", 1);
			$reportePdf->Cell(50, 6.5, $colaboradores[$i]["fechaini"]." / ".$colaboradores[$i]["horaini"], 1, 0, "C", 1);
			$reportePdf->Cell(50, 6.5, $colaboradores[$i]["fechafin"]." / ".$colaboradores[$i]["horafin"], 1, 0, "C", 1);

			if ($colaboradores[$i]["estado"]== 0 && $colaboradores[$i]["fallo"]== 1) {
				$reportePdf->Cell(35, 6.5, "Intento Fallido", 1, 1, "C", 1);
			}else if ($colaboradores[$i]["estado"]== 1 && $colaboradores[$i]["fallo"]== 0){
				$reportePdf->Cell(35, 6.5,"Usuario Activo", 1, 1, "C", 1);
			}else{
				$reportePdf->Cell(35, 6.5,"Desconectado", 1, 1, "C", 1);
			}
		}

		
		
		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de sesiones ".$_SESSION['user_session'].".pdf", "F");
		}else{
			$reportePdf->Output("Reporte de Sesiones.pdf", "I");
		}
	}

	mysqli_close($conn);

?>
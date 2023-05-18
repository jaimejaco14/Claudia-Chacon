<?php 
	include '../../cnx_data.php';



	/*if ($_POST['dato']!="") 
	{
		$dato					=$_POST['dato'];
		$_SESSION['vrbrptcol']	=$_POST['dato'];
	}
	else
	{
		$dato       = $_REQUEST["dato"];
		$cargo 		= $_REQUEST["cargo"];
		$salon 		= $_REQUEST["salonBase"];
		$perfil 	= $_REQUEST["perfil"];
	}*/
	$datos  = $_REQUEST["dato"];
	$dato 	= json_decode($datos, true);
	$cargo 	= $dato['cargo'];
	$salon 	= $dato['salonBase'];
	$perfil = $dato['perfil'];
	
	$tipoReporte        = $_GET["tipoReporte"];
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");
	$colaboradores      = array();


	$queryColaboradores = "SELECT tercero.trcdocumento AS trcdocumento, tercero.trcdigitoverificacion AS trcdigitoverificacion, tercero.trcrazonsocial AS trcrazonsocial, tercero.trcdireccion AS trcdireccion, tercero.trctelefonofijo AS trctelefonofijo, tercero.trctelefonomovil AS trctelefonomovil, barrio.brrnombre AS brrnombre, identidad.tdinombre AS tdinombre, identidad.tdialias AS tdialias, colaborador.clbcodigo AS clbcodigo, colaborador.clbsexo AS clbsexo, colaborador.clbemail AS clbemail, colaborador.clbfechanacimiento AS clbfechanacimiento, colaborador.clbnotificacionemail AS clbnotificacionemail, colaborador.clbnotificacionmovil AS clbnotificacionmovil, colaborador.clbfechaingreso AS clbfechaingreso, colaborador.cblimagen AS cblimagen,cargo.crgnombre as crgnombre, categ.ctcnombre as ctcnombre, bty_fnc_salon_colaborador(colaborador.clbcodigo) as salonbase FROM btytercero tercero NATURAL JOIN btycolaborador colaborador NATURAL JOIN btytipodocumento identidad NATURAL JOIN btybarrio barrio NATURAL JOIN btycategoria_colaborador categoria NATURAL JOIN btycargo cargo NATURAL JOIN btycategoria_colaborador categ WHERE colaborador.clbestado = 1 and bty_fnc_estado_colaborador(colaborador.clbcodigo)='VINCULADO'";

	

	if ($cargo != 0) 
	{ 
        $queryColaboradores .= " AND cargo.crgcodigo = '".$cargo."'";
    } 
    if ($perfil != 0) 
    {
        $queryColaboradores .= " AND categoria.ctccodigo = '".$perfil."'";
    }
    if ($salon != 0) 
    {
        $queryColaboradores .= " AND bty_fnc_salonbase_col(colaborador.clbcodigo) = $salon";
    }
 
	$queryColaboradores       .= " ORDER BY tercero.trcrazonsocial";

	//echo $queryColaboradores;

	$resultQueryColaboradores = $conn->query($queryColaboradores);

	while($registros = $resultQueryColaboradores->fetch_array())
	{

		
			$colaboradores[] = array(
							"codigo"             => $registros["clbcodigo"],
							"documento"          => $registros["trcdocumento"],
							"digitoVerificacion" => $registros["trcdigitoverificacion"],
							"nombre"             => $registros["trcrazonsocial"],
							"direccion"          => $registros["trcdireccion"],
							"telefonoFijo"       => $registros["trctelefonofijo"],
							"telefonoMovil"      => $registros["trctelefonomovil"],
							"barrio"             => $registros["brrnombre"],
							"tipoDocumento"      => $registros["tdinombre"],
							"aliasDocumento"     => $registros["tdialias"],
							"sexo"               => $registros["clbsexo"],
							"email"              => $registros["clbemail"],
							"fechaNacimiento"    => $registros["clbfechanacimiento"],
							"notificacionEmail"  => $registros["clbnotificacionemail"],
							"notificacionMovil"  => $registros["clbnotificacionmovil"],
							"fechaIngreso"       => $registros["clbfechaingreso"],
							"imagen"             => $registros["cblimagen"],
							"categoria"          => $registros["ctcnombre"],
							"cargo"              => $registros["crgnombre"],
							"salon"              => $registros["salonbase"]
						);
		
		
	}



	if($tipoReporte == "excel" || $_POST["enviox"]==1)
	{

		require_once '../../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de colaboradores")
						->setSubject("Reporte de colaboradores")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte colaboradores")
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
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "Código")
						->setCellValue("B8", "No. Documento")
						->setCellValue("C8", "Digito verificación")
						->setCellValue("D8", "Tipo documento")
						->setCellValue("E8", "Nombre")
						->setCellValue("F8", "Sexo")
						->setCellValue("G8", "Cargo")
						->setCellValue("H8", "Categoría")
						->setCellValue("I8", "Dirección")
						->setCellValue("J8", "Barrio")
						->setCellValue("K8", "Teléfono fijo")
						->setCellValue("L8", "Teléfono móvil")
						->setCellValue("M8", "E-mail")
						->setCellValue("N8", "Fecha de nacimiento")
						->setCellValue("O8", "Fecha de ingreso")
						->setCellValue("P8", "Salon Base");

		foreach($columnas as $columna)
		{
			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:R8")->getFont()->setBold(true);

		foreach($colaboradores as $colaborador)
		{

			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $colaborador["codigo"])
							->setCellValue("B".$i, $colaborador["documento"])
							->setCellValue("C".$i, $colaborador["digitoVerificacion"])
							->setCellValue("D".$i, $colaborador["tipoDocumento"])
							->setCellValue("E".$i, utf8_encode($colaborador["nombre"]))
							->setCellValue("F".$i, $colaborador["sexo"])
							->setCellValue("G".$i, $colaborador["cargo"])
							->setCellValue("H".$i, $colaborador["categoria"])
							->setCellValue("I".$i, utf8_encode($colaborador["direccion"]))
							->setCellValue("J".$i, utf8_encode($colaborador["barrio"]))
							->setCellValue("K".$i, $colaborador["telefonoFijo"])
							->setCellValue("L".$i, $colaborador["telefonoMovil"])
							->setCellValue("M".$i, $colaborador["email"])
							->setCellValue("N".$i, $colaborador["fechaNacimiento"])
							->setCellValue("O".$i, $colaborador["fechaIngreso"])
							->setCellValue("P".$i, $colaborador["salon"]);
			$i++;
		}

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Colaboradores");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de colaboradores - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}

	}
	else
	{

		require_once '../../lib/fpdf/fpdf.php';

		class PDF extends FPDF
		{

			function Header()
			{

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE COLABORADORES", 0, 2, 'R');
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer()
			{

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
		$reportePdf->Cell(10, 8, utf8_decode("Cód"), 1, 0, "C", 1);
		$reportePdf->Cell(30, 8, "No. Documento", 1, 0, "C", 1);
		$reportePdf->Cell(70, 8, "Nombre", 1, 0, "C", 1);
		$reportePdf->Cell(11, 8, "Sexo", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "Cargo", 1, 0, "C", 1);
		$reportePdf->Cell(25, 8, utf8_decode("Categoría"), 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, utf8_decode("Teléfonos"), 1, 0, "C", 1);
		$reportePdf->Cell(60, 8, "E-mail", 1, 0, "C", 1);
		$reportePdf->Cell(20, 8, "F. ingreso", 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "Salon B.", 1,1, "C", 1);


		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		for($i = 0; $i < count($colaboradores); $i++)
		{

			if(($i % 2) == 0)
			{
				$reportePdf->SetFillColor(255, 246, 210);
			}
			else
			{
				$reportePdf->SetFillColor(255);
			}

			$reportePdf->cell(10, 6.5, $colaboradores[$i]["codigo"], 1, 0, "R", 1);
			$reportePdf->cell(30, 6.5, $colaboradores[$i]["documento"]." - ".$colaboradores[$i]["digitoVerificacion"]." (".$colaboradores[$i]["aliasDocumento"].")", 1, 0, "R", 1);
			$reportePdf->cell(70, 6.5, utf8_decode($colaboradores[$i]["nombre"]), 1, 0, "L", 1);
			$reportePdf->cell(11, 6.5, $colaboradores[$i]["sexo"], 1, 0, "C", 1);
			$reportePdf->cell(35, 6.5, utf8_decode($colaboradores[$i]["cargo"]), 1, 0, "L", 1);
			$reportePdf->cell(25, 6.5, utf8_decode($colaboradores[$i]["categoria"]), 1, 0, "L", 1);

			if(!empty($colaboradores[$i]["telefonoFijo"]) && empty($colaboradores[$i]["telefonoMovil"]))
			{
				$reportePdf->cell(35, 6.5, $colaboradores[$i]["telefonoFijo"], 1, 0, "R", 1);
			}
			elseif(empty($colaboradores[$i]["telefonoFijo"]) && !empty($colaboradores[$i]["telefonoMovil"]))
			{
				$reportePdf->cell(35, 6.5, $colaboradores[$i]["telefonoMovil"], 1, 0, "R", 1);
			}
			else
			{
				$reportePdf->cell(35, 6.5, $colaboradores[$i]["telefonoFijo"]." - ".$colaboradores[$i]["telefonoMovil"], 1, 0, "R", 1);
			}

			$reportePdf->cell(60, 6.5, $colaboradores[$i]["email"], 1, 0, "L", 1);
			$reportePdf->cell(20, 6.5, $colaboradores[$i]["fechaIngreso"], 1, 0, "R", 1);
			$reportePdf->cell(35, 6.5, $colaboradores[$i]["salon"], 1, 1, "R", 1);
		}
		if ($_POST["envio"]==1) 
		{
			$reportePdf->Output("tmp/Reporte de colaboradores ".$_SESSION['user_session'].".pdf", "F");
		}
		else
		{
			$reportePdf->Output("Reporte de colaboradores.pdf", "I");
		}
	}

	//mysqli_close($conn);
?>
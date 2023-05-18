<?php 

	header( 'Content-Type: application/json' );
include '../cnx_data.php';

	if ($_POST['dato']!="") {
		$dato=$_POST['dato'];
		$_SESSION['vrbrptsrvc']=$_POST['dato'];
	}else{
		$dato               = $_REQUEST["dato"];
	}
    
    $_SESSION["codigoUsuario"];
    $con = mysqli_query($conn, "SELECT usulogin FROM btyusuario WHERE usucodigo = '".$_SESSION["codigoUsuario"]."' ");
    $s = mysqli_fetch_array($con);
    $_SESSION['usuario'] = $s[0];
	$tiporeporte        = $_REQUEST["tiporeporte"];
	$fechaGenerado      = date("d-m-Y");
	$horaGenerado       = date("h:i:s a");

	$sql = mysqli_query($conn, "SELECT pro.procodigo, pro.pronombre, car.crsnombre, sbl.sblnombre, lin.linnombre, sgr.sbgnombre, gru.grunombre, pro.procodigoanterior FROM btyproducto pro JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sbl ON car.sblcodigo=sbl.sblcodigo JOIN btylinea lin ON sbl.lincodigo=lin.lincodigo JOIN btysubgrupo sgr ON sgr.sbgcodigo=lin.sbgcodigo JOIN btygrupo gru ON gru.grucodigo=sgr.grucodigo");

	$array = array();

	while ($row = mysqli_fetch_object($sql)) {
		$array[] = array(
			'codigo' 	=>$row->procodigo,
			'producto' 	=>$row->pronombre,
			'caracte'   =>$row->crsnombre,
			'sublinea'  =>$row->sblnombre,
			'linea'	 	=>$row->linnombre,
			'subgrupo'  =>$row->sbgnombre,
			'grupo'  	=>$row->grunombre,
			'cod_ant'  	=>$row->procodigoanterior
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
  	$array = utf8_converter($array); 

  

  	if($tiporeporte == "excel"){

		require_once '../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de Productos")
						->setSubject("Reporte de Productos")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte Productos")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:D4");

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
			/*$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE DE PRODUCTOS GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado);	*/		
        		$reporteExcel->setActiveSheetIndex(0)->mergeCells('A5:G5');
        		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE DE PRODUCTOS GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado . " por " .  $_SESSION['usuario']);
		}

		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "CODIGO")
						->setCellValue("B8", "CODIGO ANTERIOR")
						->setCellValue("C8", "PRODUCTO")
						->setCellValue("D8", "CARACTERISTICA")
						->setCellValue("E8", "SUBLINEA")
						->setCellValue("F8", "LINEA")
						->setCellValue("G8", "SUBGRUPO")
						->setCellValue("H8", "GRUPO");

						

		foreach($columnas as $columna){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
		}

		$reporteExcel->getActiveSheet(0)->getStyle("A8:I8")->getFont()->setBold(true);


		foreach($array as $colaborador){			
		
					$reporteExcel->setActiveSheetIndex(0)
					        ->setCellValue("A".$i, $colaborador["codigo"])
						    ->setCellValueExplicit('B'.$i, $colaborador["cod_ant"], PHPExcel_Cell_DataType::TYPE_STRING)
							->setCellValue("C".$i, $colaborador["producto"])
							->setCellValue("D".$i, $colaborador["caracte"])
							->setCellValue("E".$i, $colaborador["sublinea"])
							->setCellValue("F".$i, $colaborador["linea"])
							->setCellValue("G".$i, $colaborador["subgrupo"])
							->setCellValue("H".$i, $colaborador["grupo"])
							->setCellValue("I".$i, $fdo);
							$i++;
			}
		

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("Productos");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Productos - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) {
			//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
			$exportarReporte->save("tmp/REPORTE DE PRODUCTOS.xls");
		}else{
			$exportarReporte->save("php://output");
		}

	}else{

		
		require_once '../lib/fpdf/fpdf.php';


		class PDF extends FPDF{
			function Header(){
			
				$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "REPORTE DE PRODUCTOS", 0, 2, 'R');			
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado por " . $_SESSION['usuario'] . " a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
		
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
		$reportePdf->SetFont("Arial", "B", 11);
		$reportePdf->Ln();
		$reportePdf->SetFillColor(255, 255, 255);
		$reportePdf->SetTextColor(1);
		$reportePdf->SetFont("Arial", "B", 11);
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->Cell(20, 8, utf8_decode("Cód"), 1, 0, "C", 1);
		$reportePdf->Cell(30, 8, utf8_decode("Cód Anterior"), 1, 0, "C", 1);
		$reportePdf->Cell(70, 8, utf8_decode("Producto"), 1, 0, "C", 1);
		$reportePdf->Cell(50, 8, utf8_decode("Característica"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Sublínea"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Línea"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Subgrupo"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Grupo"), 1, 0, "C", 1);

		//$reportePdf->Cell(0, 5, "Notif. email", 1, 0, "C", 1);

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
			$reportePdf->Cell(20, 6.5, $array[$i]["codigo"], 1, 0, "R", 1);
			$reportePdf->Cell(30, 6.5, $array[$i]["cod_ant"], 1, 0, "R", 1);
			$reportePdf->Cell(70, 6.5, $array[$i]["producto"], 1, 0, "L", 1);
			$reportePdf->Cell(50, 6.5, ($array[$i]["caracte"]), 1, 0, "L", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["sublinea"], 1, 0, "L", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["linea"], 1, 0, "L", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["subgrupo"], 1, 0, "L", 1);
			$reportePdf->Cell(40, 6.5, $array[$i]["grupo"], 1, 0, "L", 1);
			
			
		}

		
		
		if ($_POST["envio"]==1) {
			//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
			$reportePdf->Output("tmp/Reporte de Puestos de Trabajo.pdf", "F");
		}else{
			$reportePdf->Output("Reporte de Puestos de Trabajo.pdf", "I");
		}
	}
	

  		
	
 ?>
<?php
//session_start();
include '../cnx_data.php';
$opc=$_GET['sw'];
/*if ($_REQUEST['dato']!="") { 
		$dato=$_REQUEST['dato'];
		$_SESSION['vrbrptsrvc']=$_REQUEST['dato'];
	}else{
}*/
$dato               = $_GET["dato"];
$tipo       = $_REQUEST["tipo"];
$fechaGenerado      = date("d-m-Y");
$horaGenerado       = date("h:i:s a");
$servicios      = array();

$sql = "SELECT vsc.sercodigo, vsc.sernombre, vsc.crsnombre, vsc.sblnombre, vsc.linnombre, vsc.sbgnombre, vsc.grunombre,s.serrequiereinsumos as sw 
		FROM bty_vw_servicios_categorias as vsc 
		natural join btyservicio as s 
		WHERE serstado = 1";

if(!empty($dato)){
	$sql = $sql." AND (vsc.sernombre LIKE '%".$dato."%')";
}
$sql = $sql." ORDER BY sernombre";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$servicios[] = 		array(
			"codigo"             => $row["sercodigo"],
			"nombre"          	 => $row["sernombre"],
			"crsnombre" 		 => $row["crsnombre"],
			"sblnombre"          => $row["sblnombre"],
			"linnombre"          => $row["linnombre"],
			"sbgnombre"          => $row["sbgnombre"],
			"grunombre"          => $row["grunombre"],
			"sw"				 => $row["sw"]
		);
	}
}
switch ($opc) {
	case 'on':
		
		if($tipo=='PDF'){
			require_once '../lib/fpdf/fpdf.php';

			class PDF extends FPDF{

				function Header(){

					$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
					$this->SetFont("Arial", "B", 14);
					$this->Cell(0, 10, "REPORTE DE SERVICIOS E INSUMOS", 0, 2, 'R');
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
			for($i = 0; $i < count($servicios); $i++){
				$reportePdf->SetFillColor(151, 130, 45);
				$reportePdf->SetTextColor(255);
				$reportePdf->SetFont("Arial", "B", 10);
				$reportePdf->Cell(15, 8, utf8_decode("Código"), 1, 0, "C", 1);
				$reportePdf->Cell(90, 8, utf8_encode("Nombre Servicio"), 1, 0, "C", 1);
				$reportePdf->Cell(45, 8, utf8_encode("Caracteristica"), 1, 0, "C", 1);
				$reportePdf->Cell(40, 8, utf8_decode("Sublínea"), 1, 0, "C", 1);
				$reportePdf->Cell(45, 8, utf8_decode("Línea"), 1, 0, "C", 1);
				$reportePdf->Cell(50, 8, utf8_decode("Subgrupo"), 1, 0, "C", 1);
				$reportePdf->Cell(40, 8, utf8_decode("Grupo"), 1, 1, "C", 1);
				//$reportePdf->Ln(12);
				$reportePdf->SetFillColor(255);
				$reportePdf->SetFont("Arial", "", 8);
				$reportePdf->SetTextColor(0);

				if(($i % 2) == 0){

					$reportePdf->SetFillColor(255, 246, 210);
				}
				else{

					$reportePdf->SetFillColor(255);
				}
				$reportePdf->Cell(15, 6.5, $servicios[$i]["codigo"], 1, 0, "C", 1);
				$reportePdf->Cell(90, 6.5, utf8_decode($servicios[$i]["nombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(45, 6.5, utf8_decode($servicios[$i]["crsnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(40, 6.5, utf8_encode($servicios[$i]["sblnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(45, 6.5, utf8_decode($servicios[$i]["linnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(50, 6.5, utf8_decode($servicios[$i]["sbgnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(40, 6.5, utf8_encode($servicios[$i]["grunombre"]), 1, 1, "L", 1);
				if($servicios[$i]["sw"]==1){
					//titulos columnas insumos
					$reportePdf->SetFillColor(151, 130, 45);
					$reportePdf->SetTextColor(255);
					$reportePdf->SetFont("Arial", "B", 10);
					$reportePdf->Cell(240, 6.5, "INSUMO", 1, 0, "C", 1);
					$reportePdf->Cell(35, 6.5, "CANTIDAD", 1, 0, "C", 1);
					$reportePdf->Cell(50, 6.5, "REQUIERE CANTIDAD", 1, 0, "C", 1);
					$reportePdf->Ln();
					//fin titulos insumos
					$sercod=$servicios[$i]["codigo"];
					$sqlins="SELECT sp.sercodigo,sp.procodigo, sv.sernombre,pd.pronombre,sp.spcantidad,sp.sprequierecantidad from btyservicio_producto sp
								join btyservicio sv on sp.sercodigo=sv.sercodigo
								join btyproducto pd on pd.procodigo=sp.procodigo
								where sp.sprstado=1 AND sp.sercodigo=$sercod";
					$resins=$conn->query($sqlins);
					$reportePdf->SetFont("Arial", "", 8);
					$reportePdf->SetTextColor(0);
					if(mysqli_num_rows($resins)>0){
						$i=0;
						while($rowins=$resins->fetch_array()){
							
							if(($i % 2) == 0){

								$reportePdf->SetFillColor(255, 246, 210);
							}
							else{

								$reportePdf->SetFillColor(255);
							}
							$reportePdf->Cell(240, 6.5, utf8_decode($rowins['pronombre']), 1, 0, "L", 1);
							$reportePdf->Cell(35, 6.5, $rowins['spcantidad'], 1, 0, "C", 1);
							if($rowins['sprequierecantidad']==1){
								$reportePdf->Cell(50, 6.5, "SI", 1, 0, "C", 1);
							}else{
								$reportePdf->Cell(50, 6.5, "NO", 1, 0, "C", 1);	
							}
							$reportePdf->Ln();
							$i++;
						}
					}else{
						$reportePdf->SetFillColor(255);
						$reportePdf->Cell(325, 6.5, "No hay insumos asignados", 1, 0, "C", 1);
					}

				}else{
					$reportePdf->SetFillColor(255);
					$reportePdf->Cell(325, 6.5, "Este servicio NO requiere de Insumos", 1, 0, "C", 1);
				}
				
				$reportePdf->Ln(12);
			}

			$reportePdf->Output("Reporte de Servicios.pdf", "I");
				
		}else if($tipo=='XLS'){
			echo $tipo;
			require_once '../lib/phpexcel/Classes/PHPExcel.php';

			$columnas = array("A", "B", "C", "D", "E", "F", "G");
			$reporteExcel = new PHPExcel();
			$reporteExcel->getProperties()
							->setCreator("Beauty ERP")
							->setLastModifiedBy("Beauty ERP")
							->setTitle("Reporte de Servicios")
							->setSubject("Reporte de Servicios")
							->setDescription("Reporte generado a través de Beauty ERP")
							->setKeywords("beauty ERP reporte Servicios")
							->setCategory("reportes");
			//$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
			$imagenCliente = new PHPExcel_Worksheet_Drawing();
			$imagenCliente->setName("Imagen corporativa");
			$imagenCliente->setDescription("Imagen corporativa");
			$imagenCliente->setCoordinates("A1");
			$imagenCliente->setPath("../contenidos/imagenes/logo_empresa.jpg");
			$imagenCliente->setHeight(45);
			$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));
			$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

			foreach($columnas as $columna){

				$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
			}
				$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

			$i = 9;
			foreach($servicios as $servicio){

				$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":G".$i)->getFont()->setBold(true);
				$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, "Código")
							->setCellValue("B".$i, "Nombre servicio")
							->setCellValue("C".$i, "Caracteristica")
							->setCellValue("D".$i, "Sublínea")
							->setCellValue("E".$i, "Línea")
							->setCellValue("F".$i, "Subgrupo")
							->setCellValue("G".$i, "Grupo");
							$i++;

				$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":G".$i)->getFont()->setBold(false);
				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, $servicio["codigo"])
								->setCellValue("B".$i, utf8_encode($servicio["nombre"]))
								->setCellValue("C".$i, utf8_encode($servicio["crsnombre"]))
								->setCellValue("D".$i, utf8_encode($servicio["sblnombre"]))
								->setCellValue("E".$i, utf8_encode($servicio["linnombre"]))
								->setCellValue("F".$i, utf8_encode($servicio["sbgnombre"]))
								->setCellValue("G".$i, utf8_encode($servicio["grunombre"]));
				$i++;
				if($servicio["sw"]==1){
					$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":G".$i)->getFont()->setBold(true);
					$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":C".$i);
					$reporteExcel->getActiveSheet(0)->mergeCells("D".$i.":E".$i);
					$reporteExcel->getActiveSheet(0)->mergeCells("F".$i.":G".$i);
					$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, "Insumo")
								->setCellValue("D".$i, "Cantidad")
								->setCellValue("F".$i, "Requiere cantidad");
					$i++;
					$sercod=$servicio["codigo"];
					$sqlins="SELECT sp.sercodigo,sp.procodigo, sv.sernombre,pd.pronombre,sp.spcantidad,sp.sprequierecantidad from btyservicio_producto sp
								join btyservicio sv on sp.sercodigo=sv.sercodigo
								join btyproducto pd on pd.procodigo=sp.procodigo
								where sp.sprstado=1 AND sp.sercodigo=$sercod";
					$resins=$conn->query($sqlins);
					if(mysqli_num_rows($resins)>0){
						while($rowins=$resins->fetch_array()){
							$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":C".$i);
							$reporteExcel->getActiveSheet(0)->mergeCells("D".$i.":E".$i);
							$reporteExcel->getActiveSheet(0)->mergeCells("F".$i.":G".$i);

							$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":G".$i)->getFont()->setBold(false);
							if($rowins[5]==1){
								$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, $rowins[3])
										->setCellValue("D".$i, $rowins[4])
										->setCellValue("F".$i, 'SI');
							}else{
								$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, $rowins[3])
										->setCellValue("D".$i, $rowins[4])
										->setCellValue("F".$i, 'NO');
							}
							$i++;
						}
					}else{
						$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":G".$i);
						$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, "No hay insumos asignados a este servicio");
						$i++;
					}
				}else{
					$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":G".$i);
						$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, "Este servicio NO requiere de Insumos");
						$i++;
				}
				$i++;
			}

			//$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

			//Nombrar a la hoja principal como 'Servicios'
			$reporteExcel->getActiveSheet(0)->setTitle("Servicios e Insumos");

			$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

			//Establecer la primera hoja (Servicios) como hoja principal
			$reporteExcel->setActiveSheetIndex(0);

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header('Content-Disposition: attachment; filename="Reporte de servicios e Insumos - Beauty ERP.xls');
			header('Cache-Control: max-age=0');
			ob_get_clean();
			$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
			if ($_POST["enviox"]==1) {
				//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
				$exportarReporte->save("tmp/Reporte de Servicios ".$_SESSION['user_session'].".xls");
			}else{
				$exportarReporte->save("php://output");
			}
		}
	break;
	case 'off':
		if ($tipo == "XLS") {
			require_once '../lib/phpexcel/Classes/PHPExcel.php';

			$columnas = array("A", "B", "C", "D", "E", "F", "G");
			$i = 9;
			$reporteExcel = new PHPExcel();
			$reporteExcel->getProperties()
							->setCreator("Beauty ERP")
							->setLastModifiedBy("Beauty ERP")
							->setTitle("Reporte de Servicios")
							->setSubject("Reporte de Servicios")
							->setDescription("Reporte generado a través de Beauty ERP")
							->setKeywords("beauty ERP reporte Servicios")
							->setCategory("reportes");
			$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
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
							->setCellValue("A8", "Código")
							->setCellValue("B8", "Nombre")
							->setCellValue("C8", "Caracteristica")
							->setCellValue("D8", "Sublínea")
							->setCellValue("E8", "Línea")
							->setCellValue("F8", "Subgrupo")
							->setCellValue("G8", "Grupo");

			foreach($columnas as $columna){

				$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
			}
			$reporteExcel->getActiveSheet(0)->getStyle("A8:G8")->getFont()->setBold(true);

			foreach($servicios as $servicio){

				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, $servicio["codigo"])
								->setCellValue("B".$i, utf8_encode($servicio["nombre"]))
								->setCellValue("C".$i, utf8_encode($servicio["crsnombre"]))
								->setCellValue("D".$i, utf8_encode($servicio["sblnombre"]))
								->setCellValue("E".$i, utf8_encode($servicio["linnombre"]))
								->setCellValue("F".$i, utf8_encode($servicio["sbgnombre"]))
								->setCellValue("G".$i, utf8_encode($servicio["grunombre"]));
				$i++;
			}

			$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");

			//Nombrar a la hoja principal como 'Servicios'
			$reporteExcel->getActiveSheet(0)->setTitle("Servicios");

			$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

			//Establecer la primera hoja (Servicios) como hoja principal
			$reporteExcel->setActiveSheetIndex(0);

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header('Content-Disposition: attachment; filename="Reporte de servicios - Beauty ERP.xls');
			header('Cache-Control: max-age=0');
			ob_get_clean();
			$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
			if ($_POST["enviox"]==1) {
				//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
				$exportarReporte->save("tmp/Reporte de Servicios ".$_SESSION['user_session'].".xls");
			}else{
			$exportarReporte->save("php://output");
				}
		
		} else if($tipo == "PDF") {
			require_once '../lib/fpdf/fpdf.php';

			class PDF extends FPDF{

				function Header(){

					$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
					$this->SetFont("Arial", "B", 14);
					$this->Cell(0, 10, "REPORTE DE SERVICIOS", 0, 2, 'R');
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
			$reportePdf->Cell(15, 8, utf8_decode("Código"), 1, 0, "C", 1);
			$reportePdf->Cell(90, 8, utf8_encode("Nombre"), 1, 0, "C", 1);
			$reportePdf->Cell(45, 8, utf8_encode("Caracteristica"), 1, 0, "C", 1);
			$reportePdf->Cell(40, 8, utf8_decode("Sublínea"), 1, 0, "C", 1);
			$reportePdf->Cell(45, 8, utf8_decode("Línea"), 1, 0, "C", 1);
			$reportePdf->Cell(50, 8, utf8_decode("Subgrupo"), 1, 0, "C", 1);
			$reportePdf->Cell(40, 8, utf8_decode("Grupo"), 1, 1, "C", 1);
			
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
				$reportePdf->Cell(15, 6.5, $servicios[$i]["codigo"], 1, 0, "C", 1);
				$reportePdf->Cell(90, 6.5, utf8_encode($servicios[$i]["nombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(45, 6.5, utf8_decode($servicios[$i]["crsnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(40, 6.5, utf8_encode($servicios[$i]["sblnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(45, 6.5, utf8_decode($servicios[$i]["linnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(50, 6.5, utf8_decode($servicios[$i]["sbgnombre"]), 1, 0, "L", 1);
				$reportePdf->Cell(40, 6.5, utf8_encode($servicios[$i]["grunombre"]), 1, 1, "L", 1);
			}
			if ($_POST["envio"]==1) {
				//echo" Archivo PDF generado satisfactoriamente con su nombre de usuario";
				$reportePdf->Output("tmp/Reporte de Servicios ".$_SESSION['user_session'].".pdf", "F");
			}else{
			$reportePdf->Output("Reporte de Servicios.pdf", "I");
			}
		}

	break;
}

	
?>
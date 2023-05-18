<?php 
require_once ('../../lib/fpdf/fpdf.php');
include("../../../cnx_data.php");

//print_r($_REQUEST);

$tipoReporte      = trim($_REQUEST["tipoReporte"]);
$diaSeleccionado  = trim($_REQUEST["diaSeleccionado"]);
$codSalon         = trim($_REQUEST["codSalon"]);

$f = mysqli_query($conn, "SELECT a.slncodigo, a.slnnombre FROM btysalon a WHERE a.slncodigo= $codSalon");
$v = mysqli_fetch_array($f);
$_SESSION['sl'] = $v['slnnombre'];

if($tipoReporte == "excel"){
	$queryCitas       = "SELECT * FROM bty_vw_citas_detallado WHERE slncodigo = '$codSalon' AND citfecha = '$diaSeleccionado' ORDER BY cithora";
	$resultQueryCitas = $conn->query($queryCitas);
	$citas            = array();
	$codCitas         = array();
	$novedades        = array();
	$fechaGenerado    = date("d-m-Y");
	$horaGenerado     = date("h:i:s a");
	$nombreSalon      = "";
	$whereCodCitas    = "(";

	while($registros = $resultQueryCitas->fetch_array()){
		$codCitas[]  = $registros["citcodigo"];
		$nombreSalon = $registros["slnnombre"];
		$citas[]     = array(
						"codCita"        => $registros["citcodigo"],
						"codColaborador" => $registros["clbcodigo"],
						"nomColaborador" => $registros["clbnombre"],
						"codSalon"       => $registros["slncodigo"],
						"nomSalon"       => $registros["slnnombre"],
						"dirSalon"       => $registros["slndireccion"],
						"codServicio"    => $registros["sercodigo"],
						"nomServicio"    => $registros["sernombre"],
						"durServicio"    => $registros["serduracion"],
						"codCliente"     => $registros["clicodigo"],
						"nombreCliente"  => $registros["clinombre"],
						"codUsuario"     => $registros["usucodigo"],
						"nomUsuario"     => $registros["usunombre"],
						"fecha"          => $registros["citfecha"],
						"hora"           => $registros["cithora"],
						"observaciones"  => $registros["citobservaciones"],
						"fechaRegistro"  => $registros["citfecharegistro"],
						"horaRegistro"   => $registros["cithoraregistro"]);
	}

	foreach($codCitas as $codCita){
		$whereCodCitas .= $codCita.",";
	}

	$whereCodCitas = trim($whereCodCitas, ",");
	$whereCodCitas .=")";

	$resultQueryNovedades = $conn->query("SELECT cita.citcodigo AS citcodigo, estado.escnombre AS escnombre, novedad.citfecha AS nvcfecha, novedad.cithora AS nvchora, novedad.nvcobservaciones AS nvcobservaciones, tercero.trcrazonsocial AS usuarioNovedad FROM bty_vw_citas_detallado cita INNER JOIN btynovedad_cita novedad ON cita.citcodigo = novedad.citcodigo INNER JOIN btyestado_cita estado ON novedad.esccodigo = estado.esccodigo INNER JOIN btyusuario usuario ON usuario.usucodigo = novedad.usucodigo INNER JOIN btytercero tercero ON usuario.trcdocumento = tercero.trcdocumento WHERE cita.citcodigo IN ".$whereCodCitas." ORDER BY cita.citcodigo,  novedad.cithora, novedad.citfecha");

	while($registros2 = $resultQueryNovedades->fetch_array()){

		$novedades[] = array(
						"codCita"       => $registros2["citcodigo"],
						"nomEstado"     => $registros2["escnombre"],
						"fechaNovedad"  => $registros2["nvcfecha"],
						"horaNovedad"   => $registros2["nvchora"],
						"observaciones" => $registros2["nvcobservaciones"],
						"nomUsuario"    => $registros2["usuarioNovedad"]);
	}

	require_once "../../lib/phpexcel/Classes/PHPExcel.php";

		$columnasCitas     = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M");
		$columnasNovedades = array("A", "B", "C", "D", "E", "F");
		$i                 = 9;
		$j                 = 5;
		$reporteExcel      = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de citas")
						->setSubject("Reporte de citas")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte citas")
						->setCategory("reportes");
		
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
		$reporteExcel->getActiveSheet(0)->mergeCells("A5:C5");

		$imagenCita = new PHPExcel_Worksheet_Drawing();
		$imagenCita->setName("Imagen corporativa");
		$imagenCita->setDescription("Imagen corporativa");
		$imagenCita->setCoordinates("A1");
		$imagenCita->setPath("./imagenes/logo_empresa.jpg");
		$imagenCita->setHeight(49);
		$imagenCita->setWorksheet($reporteExcel->getActiveSheet());

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);
		//Crear la hoja Novedades
		$nuevHoja = new PHPExcel_Worksheet($reporteExcel, "Novedades");
		
		//Agregar la hoja Novedades
		$reporteExcel->addSheet($nuevHoja);	

		//Escribir en la hoja Citas
		$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A8", "No. Cita ")
						->setCellValue("B8", "Salón")
						->setCellValue("C8", "Dirección salón")
						->setCellValue("D8", "Servicio")
						->setCellValue("E8", "Duración servicio (min)")
						->setCellValue("F8", "Cliente")
						->setCellValue("G8", "Colaborador asignado")
						->setCellValue("H8", "Fecha de cita")
						->setCellValue("I8", "Hora de cita")
						->setCellValue("J8", "Asignado por")
						->setCellValue("K8", "Observaciones")
						->setCellValue("L8", "Fecha de registro")
						->setCellValue("M8", "Hora de registro");


		//Redimensionar las columnas de la hoja Citas
		foreach($columnasCitas as $columnaCita){

			$reporteExcel->getActiveSheet(0)->getColumnDimension($columnaCita)->setAutoSize(true);
		}
		
		//Colocar en Negrita los títulos de las columnas
		$reporteExcel->getActiveSheet(0)->getStyle("A8:M8")->getFont()->setBold(true);

		//Escribir en la hoja Citas
		foreach($citas as $cita){

			$codCitas[] = $cita["codCita"];

			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A".$i, $cita["codCita"])
							->setCellValue("B".$i, utf8_encode($cita["nomSalon"]))
							->setCellValue("C".$i, utf8_encode($cita["dirSalon"]))
							->setCellValue("D".$i, utf8_encode($cita["nomServicio"]))
							->setCellValue("E".$i, $cita["durServicio"])
							->setCellValue("F".$i, utf8_encode($cita["nombreCliente"]))
							->setCellValue("G".$i, utf8_encode($cita["nomColaborador"]))
							->setCellValue("H".$i, $cita["fecha"])
							->setCellValue("I".$i, $cita["hora"])
							->setCellValue("J".$i, utf8_encode($cita["nomUsuario"]))
							->setCellValue("K".$i, utf8_encode($cita["observaciones"]))
							->setCellValue("L".$i, $cita["fechaRegistro"])
							->setCellValue("M".$i, $cita["horaRegistro"]);
			$i++;
		}

		//Nombrar a la hoja principal como 'Citas'
		$reporteExcel->getActiveSheet(0)->setTitle("Citas");

		//Escribir en la hoja Novedades
		$reporteExcel->setActiveSheetIndex(1)
						->setCellValue("A4", "Cita No.")
						->setCellValue("B4", "Estado")
						->setCellValue("C4", "Fecha")
						->setCellValue("D4", "Hora")
						->setCellValue("E4", "Autor de la novedad")
						->setCellValue("F4", "Observaciones");

		//Redimensionar las columnas de la hoja Novedades
		foreach($columnasNovedades as $columnaNovedad){

			$reporteExcel->getActiveSheet(1)->getColumnDimension($columnaNovedad)->setAutoSize(true);
		}

		//Colocar en Negrita los títulos de la hoja Novedades
		$reporteExcel->setActiveSheetIndex(1)->getStyle("A4:F4")->getFont()->setBold(true);	

		//Escribir en la hoja Novedades
		foreach($novedades as $novedad){

			$reporteExcel->setActiveSheetIndex(1)
							->setCellValue("A".$j, $novedad["codCita"])
							->setCellValue("B".$j, $novedad["nomEstado"])
							->setCellValue("C".$j, $novedad["fechaNovedad"])
							->setCellValue("D".$j, $novedad["horaNovedad"])
							->setCellValue("E".$j, $novedad["nomUsuario"])
							->setCellValue("F".$j, $novedad["observaciones"]);
			$j++;
		}

		//$reporteExcel->getActiveSheet(1)->mergeCells("A1:C4");
		$reporteExcel->getActiveSheet(1)->mergeCells("A1:C1");

		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);
		$reporteExcel->setActiveSheetIndex(1)->setCellValue("A1", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);
	
		//Establecer la primera hoja (Citas) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de citas ('.$diaSeleccionado.') - '.$nombreSalon.' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		$exportarReporte->save("php://output");

}else{

			class ReportPdf extends FPDF{

					function Header(){

						$this->Image('../../imagenes/logo_empresa.jpg', 10, 10, 60);
						$this->SetFont("Arial", "B", 8);
						$this->Cell(0, 10, "CITAS PARA EL SALON ".$_SESSION['sl']." | FECHA (".$_REQUEST["diaSeleccionado"].") ", 0, 2, 'R');
						$this->Ln();
						$this->SetFont("Arial", "B", 12);
						//$this->Cell(0, 5, "TURNO:  ".utf8_encode($_SESSION['nombre'])." ", 0, 2, 'L');	
						$this->SetFont("Arial", "", 9);
						//$this->Cell(0, 8, "Generado a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2, 'R');
					}

					function Footer(){

						$this->SetY(-12);
						$this->SetFont('Arial','',8);
						$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
						$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s"), 0, 2,'C');
					}

					function Tabla($header,$datos,$w,$al){

						$this->SetFillColor(151, 130, 45);
						$this->SetTextColor(255);
						$this->SetDrawColor(0,0,0);
						$this->SetLineWidth(.1);
						$this->SetFont('','',7);

						
						for($i=0;$i<count($header);$i++){
							$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
						}
						$this->Ln();

						$this->SetFillColor(255, 246, 210);
						$this->SetTextColor(0);

						$Relleno=0;
						$j=0;
						$k=36;
						$l=0;
					    while($row=mysqli_fetch_array($datos)){
					    	
						  
						  for($i=0;$i<count($header);$i++){						  
						    
						    $this->Cell($w[$i],6,utf8_decode($row[$i]),'LR',0,$al[$i],$Relleno);
								
						   }

						   $this->Ln();
						   $Relleno=!$Relleno;
						   	$j++;
							
							if($j==$k){	
								$l++;
								if($l==1){$k=36;}
								$j=-1;
								$this->Cell(array_sum($w),0,'','T');
								$this->AddPage();
								$this->SetY(25);
								$this->SetFillColor(40,22,111);
								$this->SetTextColor(255);
								//$this->SetDrawColor(0,0,0);
								$this->SetLineWidth(.3);
								$this->SetFont('','I');

							
								for($i=0;$i<count($header);$i++){
									$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
								}
								$this->Ln();

								$this->SetFillColor(224,235,255);
								$this->SetTextColor(0);
								$this->SetFont('');
								$Relleno=0;
							}	
						}
						
						$this->Cell(array_sum($w),0,'','T');
					}
			}

			$reportePdf = new ReportPdf();
			//$reportePdf->AddPage("L", "Letter");
			//$reportePdf->Output("Reporte de ".utf8_decode('Citas por día salón').".pdf", "I");	
}
mysqli_close($conn);
ob_end_flush();
?>
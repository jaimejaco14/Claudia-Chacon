<?php 
	session_start();
	require_once '../../../lib/fpdf/fpdf.php';
	include("../../../cnx_data.php");


    $codsalon 				    = $_GET['codsalon'];
    $_SESSION['salon'] 		    = $_GET['salon'];
	$programacion 				= array();
	$fechaGenerado  			= date("d-m-Y");
	$horaGenerado   			= date("h:i:s a");

	if ($_GET['opcion'] == "pdf") 
	{   


		class ReportPdf extends FPDF
		{

			function Header()
			{

				$this->Image('../../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
				$this->SetFont("Arial", "B", 8);
				$this->Cell(0, 10, "".utf8_decode('REPORTE DE HORARIOS SALÓN:')." ".$_SESSION['salon']."", 0, 2, 'R');
				$this->Ln();
				$this->SetFont("Arial", "B", 12);
				//$this->Cell(0, 5, "TURNO:  ".utf8_encode($_SESSION['nombre'])." ", 0, 2, 'L');	
				$this->SetFont("Arial", "", 9);
				//$this->Cell(0, 8, "Generado a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2, 'R');
			}

			function Footer()
			{

				$this->SetY(-12);
				$this->SetFont('Arial','',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s"), 0, 2,'C');
			}

			function Tabla($header,$datos,$w,$al)
			{

				$this->SetFillColor(151, 130, 45);
				$this->SetTextColor(255);
				$this->SetDrawColor(0,0,0);
				$this->SetLineWidth(.1);
				$this->SetFont('','',7);

				
				for($i=0;$i<count($header);$i++)
				{
					$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
				}

				$this->Ln();

				$this->SetFillColor(255, 246, 210);
				$this->SetTextColor(0);

				$Relleno=0;
				$j=0;
				$k=36;
				$l=0;
			    while($row=mysqli_fetch_array($datos))
			    {
			    	
				  
					for($i=0;$i<count($header);$i++)
					{				  
					    
					    $this->Cell($w[$i],6,utf8_decode($row[$i]),'LR',0,$al[$i],$Relleno);
							
					}
				   $this->Ln();
				   $Relleno=!$Relleno;
				   	$j++;
					
					if($j==$k)
					{	
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
		$reportePdf->AddPage("P", "letter");


		//mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );
		$reportePdf->SetFont('helvetica','B',7);
					

    	$EncabezadoColumnas=array(utf8_decode('Horarios'));

	    $AnchoColumnas=array(200);
		 
	    $AlineacionColumnas=array('L');

    	$sql = mysqli_query($conn,"SELECT concat(h.hordia,'  DE: ',DATE_FORMAT(h.hordesde, '%H:%i') , '  HASTA: ',DATE_FORMAT(h.horhasta, '%H:%i'))
									FROM btyhorario AS h 
									INNER JOIN btyhorario_salon AS hs ON hs.horcodigo = h.horcodigo AND hs.slncodigo = '$codsalon' 
									ORDER BY FIELD(h.hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')");
			

	    $reportePdf->Tabla($EncabezadoColumnas,$sql,$AnchoColumnas,$AlineacionColumnas);	
	    $reportePdf->Ln(7);
		$reportePdf->Output("Reporte de ".utf8_decode('horarios')." ".$_GET['salon'].".pdf", "I");

	}
	else
	{
		require_once '../../../lib/phpexcel/Classes/PHPExcel.php';

		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de Turnos")
						->setSubject("Reporte de Turnos")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte Turnos")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");

		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("../../../contenidos/imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(45);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);

		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado . " SALON " . $_SESSION['salon'] );
		$i=8;
    	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $col);
		$reporteExcel->getActiveSheet(0)->getColumnDimension("A")->setAutoSize(true);
		$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getFont()->setBold(true);
		$i++;
		$sql = "SELECT concat(h.hordia,'  DE: ', DATE_FORMAT(h.hordesde, '%H:%i') , '  HASTA: ', DATE_FORMAT(h.horhasta, '%H:%i')) as horario
				FROM btyhorario AS h 
				INNER JOIN btyhorario_salon AS hs ON hs.horcodigo = h.horcodigo AND hs.slncodigo = '$codsalon' 
				ORDER BY FIELD(h.hordia,'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO','FESTIVO')";
			$res2=$conn->query($sql);
		while ($data = $res2->fetch_assoc()) { 
			$imp=$data['horario'];
				$reporteExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $imp);
				$i++;
		}

				

		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");
		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("HORARIOS");
		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);
		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="REPORTE DE HORARIOS SALON '.$_SESSION['salon'].' - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/REPORTE DE HORARIOS SALON ".$_SESSION['salon'].".xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}
	}
	//mysqli_close($conn);
?>
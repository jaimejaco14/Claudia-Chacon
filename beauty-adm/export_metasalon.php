<?php
include '../cnx_data.php';
$mode=$_GET['mode'];//variable que define el reporte pedido. valores: "PDF" o "EXC".
//se verifica si al pedir el reporte se pidió algun filtro.******************************
$f1="";
$f2="";
$f3="";
$fechaGenerado  			= date("d-m-Y");
$horaGenerado   			= date("h:i:s a");
if( ($_GET['filtromes'] > 0 ) or ($_GET['filtrosln'] > 0) or ($_GET['filtrocrg'] > 0))
{
	$mes=$_GET['filtromes'];
	$sln=$_GET['filtrosln'];
	$crg=$_GET['filtrocrg'];
   
    if($mes>0){
        $f1=" AND mtames=".$mes;
    }
    if($sln>0){
        $f2=" WHERE slncodigo=".$sln;
    }
    if($crg>0){

        $f3=" AND crgcodigo=".$crg;
    }
}

$encab_sln = "SELECT distinct(slncodigo),sln.slnnombre AS salon FROM btymeta_salon_cargo Natural JOIN btysalon as sln ".$f2." order by sln.slnnombre";
$encab_mes="SELECT distinct(
CASE mtames
	    WHEN 1 THEN 'ENERO'
	    WHEN 2 THEN 'FEBRERO'
	    WHEN 3 THEN 'MARZO'
	    WHEN 4 THEN 'ABRIL'
	    WHEN 5 THEN 'MAYO'
	    WHEN 6 THEN 'JUNIO'
	    WHEN 7 THEN 'JULIO'
	    WHEN 8 THEN 'AGOSTO'
	    WHEN 9 THEN 'SEPTIEMBRE'
	    WHEN 10 THEN 'OCTUBRE'
	    WHEN 11 THEN 'NOVIEMBRE'
	    WHEN 12 THEN 'DICIEMBRE'
END) as nommes, mtames as nummes from btymeta_salon_cargo where slncodigo=";
$contenido="SELECT crgnombre,mtatipo,IF(mtapuntoreferencia=1,'SI','NO') AS mtapuntoreferencia,FORMAT(mtavalor, 0) AS mtavalor FROM btymeta_salon_cargo natural join btysalon natural join btycargo WHERE slncodigo=";

switch($mode){
	case "PDF":
		require_once '../lib/fpdf/fpdf.php';

		class ReportPdf extends FPDF
		{

			function Header()
			{

				$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
				$this->SetFont("Arial", "B", 8);
				$this->Cell(0, 10, "".utf8_decode('REPORTE DE METAS POR SALÓN Y MES'), 0, 2, 'R');
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
		$reportePdf->SetFont('helvetica','B',7);
        $res=$conn->query($encab_sln);//consulta de los salones**********************************************************************************************
        while ($data = $res->fetch_assoc()) { 
        	$salon=$data['salon'];
        	$EncabezadoColumnas=array(utf8_decode($salon));
		    $AnchoColumnas=array(200);
		    $AlineacionColumnas=array('C');
		    $reportePdf->Tabla($EncabezadoColumnas,null,$AnchoColumnas,$AlineacionColumnas);
		    $reportePdf->Ln(1);
		    $conmeses=$encab_mes.$data['slncodigo'].$f1;//consulta de los meses de ese salon********************************************************************
			$resmes=$conn->query($conmeses);
			
			while($rowmes=$resmes->fetch_assoc()){
				$EncabezadoColumnas=array(utf8_decode($rowmes['nommes']));
			    $AnchoColumnas=array(200);
			    $AlineacionColumnas=array('C');
			    $reportePdf->Tabla($EncabezadoColumnas,null,$AnchoColumnas,$AlineacionColumnas);
			    $reportePdf->Ln();
				$cont=$contenido.$data['slncodigo']." AND mtames=".$rowmes['nummes'].$f3." ORDER BY  crgnombre asc";//consulta contenido************************
				$rescont=$conn->query($cont);
				$AlineacionColumnas=array('C','C','C','R');
				$Encabezados=array('CARGO','TIPO DE META','REFERENCIA','VALOR');
				$Anchos=array(50,50,50,50);
			    $reportePdf->Tabla($Encabezados,$rescont,$Anchos,$AlineacionColumnas);	
			    $reportePdf->Ln();
			}
		    $reportePdf->Ln(10);
        }

		$reportePdf->Output("Reporte de metas por mes y salon.pdf", "I");
	break;
/*****************************************************************************************************************************/
	case "EXC":
		require_once '../lib/phpexcel/Classes/PHPExcel.php';

		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de Metas")
						->setSubject("Reporte de Metas")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte Metas")
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

		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "REPORTE GENERADO EL DIA ".$fechaGenerado." A LAS ".$horaGenerado);
		/*******************************************************************************************************************************/
		$i=7;
		$res=$conn->query($encab_sln);//consulta de los salones**********************************************************************************************
        while ($data = $res->fetch_assoc()) { 
        	$salon=$data['salon'];
        	$reporteExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $salon);//7
			//$reporteExcel->getActiveSheet(0)->getColumnDimension("A")->setAutoSize(true);
			$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getFont()->setBold(true);
			$reporteExcel->setActiveSheetIndex(0)->mergeCells("A".$i.":D".$i);
			$reporteExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '994C00')
		            )
		        )
		    );
		    $reporteExcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$i++;//8
		    $conmeses=$encab_mes.$data['slncodigo'].$f1;//consulta de los meses de ese salon********************************************************************
			$resmes=$conn->query($conmeses);
			while($rowmes=$resmes->fetch_assoc()){
				$cont=$contenido.$data['slncodigo']." AND mtames=".$rowmes['nummes'].$f3." ORDER BY  crgnombre asc";//consulta contenido************************
				$rescont=$conn->query($cont);
				$reporteExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $rowmes['nommes']);//8
				$reporteExcel->getActiveSheet(0)->getColumnDimension("A")->setAutoSize(true);
				$reporteExcel->getActiveSheet(0)->getColumnDimension("B")->setAutoSize(true);
				$reporteExcel->getActiveSheet(0)->getColumnDimension("C")->setAutoSize(true);
				$reporteExcel->getActiveSheet(0)->getColumnDimension("D")->setAutoSize(true);
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getFont()->setBold(true);
				$reporteExcel->setActiveSheetIndex(0)->mergeCells("A".$i.":D".$i);
				$reporteExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CC6600')
			            )
			        )
			    );
				$i++;//9
				$reporteExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFB266')
			            )
			        )
			    );
				$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A".$i, "CARGO")
						->setCellValue("B".$i, "TIPO DE META")
						->setCellValue("C".$i, "REFERENCIA")
						->setCellValue("D".$i, "VALOR");//9
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getFont()->setBold(true);
				$reporteExcel->getActiveSheet(0)->getStyle("B".$i)->getFont()->setBold(true);
				$reporteExcel->getActiveSheet(0)->getStyle("C".$i)->getFont()->setBold(true);
				$reporteExcel->getActiveSheet(0)->getStyle("D".$i)->getFont()->setBold(true);
						
				while($rowcont=$rescont->fetch_assoc()){
					$i++;//10
					$reporteExcel->getActiveSheet()->getStyle("A".$i.":D".$i)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FFCC99')
				            )
				        )
				    );
					$reporteExcel->setActiveSheetIndex(0)
						->setCellValue("A".$i, $rowcont['crgnombre'])
						->setCellValue("B".$i, $rowcont['mtatipo'])
						->setCellValue("C".$i, $rowcont['mtapuntoreferencia'])
						->setCellValue("D".$i, $rowcont['mtavalor']);
				}
				$i++;
			}
			$i++;
        }

		/*******************************************************************************************************************************/
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");
		//Nombrar a la hoja principal como 'Colaboradores'
		$reporteExcel->getActiveSheet(0)->setTitle("METAS");
		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);
		//Establecer la primera hoja (Colaboradores) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);

		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="REPORTE DE METAS" - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/REPORTE DE METAS.xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}
	break;
}
?>
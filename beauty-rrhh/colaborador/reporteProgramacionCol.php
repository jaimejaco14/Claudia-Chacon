<?php 
session_start();
	require_once '../../lib/fpdf/fpdf.php';
	include '../../cnx_data.php';
    
	$codcolaborador 	= $_REQUEST["codcolaborador"];
	$_SESSION['nombre']	= $_REQUEST['nombre'];
	$mes 				= $_REQUEST['mes'];


	$fechaGenerado    = date("d-m-Y");
	$horaGenerado     = date("h:i:s a");

	/*switch ($mes) {

		case '01':
			$mes = 'ENERO';
			break;

		case '02':
			$mes = 'FEBRERO';
			break;

		case '03':
			$mes = 'MARZO';
			break;

		case '04':
			$mes = 'ABRIL';
			break;

		case '05':
			$mes = 'MAYO';
			break;

		case '06':
			$mes = 'JUNIO';
			break;

		case '07':
			$mes = 'JULIO';
			break;

		case '08':
			$mes = 'AGOSTO';
			break;

		case '09':
			$mes = 'SEPTIEMBRE';
			break;
		
		case '10':
			$mes = 'OCTUBRE';
			break;

		case '11':
			$mes = 'NOVIEMBRE';
			break;

		case '12':
			$mes = 'DICIEMBRE';
			break;
		default:
			
			break;
	}*/
	

$sql2 = mysqli_query($conn, "SELECT b.slnnombre, car.crgnombre FROM btysalon_base_colaborador a JOIN btysalon b ON a.slncodigo=b.slncodigo JOIN btycolaborador col ON col.clbcodigo=a.clbcodigo JOIN btycargo car ON car.crgcodigo = col.crgcodigo WHERE a.clbcodigo = $codcolaborador AND a.slchasta IS NULL  ");

		$slnBase = mysqli_fetch_array($sql2);
		$_SESSION['salon_base'] = $slnBase[0];
		$_SESSION['cargo']      = $slnBase[1];

class ReportPdf extends FPDF
{

		function Header()
		{

			$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
			$this->SetFont("Arial", "B", 8);
			$this->Cell(0, 5, "PROGRAMACION MENSUAL PARA ".$_SESSION['nombre']." ", 0, 2, 'R');
			$this->Ln(0);
			$this->Cell(0, 5, "SALON BASE ACTUAL: ".$_SESSION['salon_base']." ", 0, 2, 'R');
			$this->Ln(0);
			$this->Cell(0, 5, "CARGO: ".$_SESSION['cargo']." ", 0, 2, 'R');
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
			    while($row=mysqli_fetch_array($datos))
			    {
			    	
				  
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
$reportePdf->AddPage("P", "letter");
//$reportePdf->Ln();

	mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );
	mysqli_set_charset($conn, "utf8");

		$sql = mysqli_query($conn, "SELECT DISTINCT CONCAT(UCASE(DATE_FORMAT(p.prgfecha,'%d de %M'))) AS fecha_inicio, UCASE(DAYNAME(p.prgfecha)), IF(tpr.tprnombre = 'LABORA', TIME_FORMAT(t.trndesde,'%H:%i %p'), NULL) AS hora_inicio, IF(tpr.tprnombre = 'LABORA', TIME_FORMAT(t.trninicioalmuerzo,'%h:%i %p'), NULL) AS inicio_almuerzo, IF(tpr.tprnombre = 'LABORA', TIME_FORMAT(t.trnfinalmuerzo,'%h:%i %p'), NULL) AS final_almuerzo, IF(tpr.tprnombre = 'LABORA', TIME_FORMAT(t.trnhasta,'%h:%i %p'), NULL) AS hora_salida, tpr.tprnombre, s.slnnombre, t.trnnombre AS turno, p.prgfecha FROM btyprogramacion_colaboradores p JOIN btyturno t ON t.trncodigo = p.trncodigo JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo JOIN btysalon s ON s.slncodigo = ts.slncodigo JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo AND c.clbcodigo = $codcolaborador JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento JOIN btytipo_programacion tpr ON p.tprcodigo=tpr.tprcodigo WHERE MONTH(p.prgfecha) = '".$mes."' ORDER BY p.prgfecha")or die(mysqli_error($conn));

switch ($mes) {

		case '01':
			$mes = 'ENERO';
			break;

		case '02':
			$mes = 'FEBRERO';
			break;

		case '03':
			$mes = 'MARZO';
			break;

		case '04':
			$mes = 'ABRIL';
			break;

		case '05':
			$mes = 'MAYO';
			break;

		case '06':
			$mes = 'JUNIO';
			break;

		case '07':
			$mes = 'JULIO';
			break;

		case '08':
			$mes = 'AGOSTO';
			break;

		case '09':
			$mes = 'SEPTIEMBRE';
			break;
		
		case '10':
			$mes = 'OCTUBRE';
			break;

		case '11':
			$mes = 'NOVIEMBRE';
			break;

		case '12':
			$mes = 'DICIEMBRE';
			break;
		default:
			
			break;
	}

	

			$reportePdf->SetFont('helvetica','B',11);
			$reportePdf->Cell(20,7,"" . $mes . " DE " . date('Y'));
			$reportePdf->Ln(9);

		   
		    $EncabezadoColumnas=array('Fecha', ''.utf8_decode('Día').'', 'Hora Entrada','Inicio Almuerzo','Fin Almuerzo','Hora Salida',''.utf8_decode('Programación'), ''.utf8_decode('Salón').'');

		  	$AnchoColumnas = array(30,20,20,20,20,20,30,40);
			 
		    $AlineacionColumnas=array('L','C','C','C','C','C','C', 'C');
		    $reportePdf->Tabla($EncabezadoColumnas,$sql,$AnchoColumnas,$AlineacionColumnas);
		    $reportePdf->SetFont('helvetica','B',11);
		    $reportePdf->Ln();
	    

$reportePdf->Output("".utf8_decode('PROGRAMACION MENSUAL DE '). $_SESSION['nombre'].".pdf", "I");


mysqli_close($conn);
?>
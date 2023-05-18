<?php 
session_start();
	require_once '../../../lib/fpdf/fpdf.php';
	include("../../../cnx_data.php");
    
		$salon 			= $_GET['salon'];
		$fecha 			= $_GET['fecha'];
		$programacion 	= array();
		$fechaGenerado  = date("d-m-Y");
		$horaGenerado   = date("h:i:s a");

		$f = mysqli_query($conn, "SELECT a.slncodigo, a.slnnombre FROM btysalon a WHERE a.slncodigo= $salon");
		$v = mysqli_fetch_array($f);
		$_SESSION['sl'] = $v['slnnombre'];



class ReportPdf extends FPDF{

			function Header(){

				$this->Image('../../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
				$this->SetFont("Arial", "B", 8);
				$this->Cell(0, 10, "PROGRAMACION SALON ".$_SESSION['sl']." PARA EL DIA ".strtoupper($_GET['fecha'])." ", 0, 2, 'R');
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
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s")." del ".$_SESSION['act'], 0, 2,'C');
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
$reportePdf->AddPage("P", "letter");
//$reportePdf->Ln();

	mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );

		$sql = mysqli_query($conn, "SELECT DISTINCT p.trncodigo, p.prgfecha, t.trnnombre, sln.slnnombre, TIME_FORMAT(t.trndesde, '%H:%i') as desde, TIME_FORMAT(t.trnhasta, '%H:%i') as hasta, DATE_FORMAT(p.prgfecha, '%d de %M de %Y')as fecha, DATE_FORMAT(CURDATE(), '%d de %M de %Y') as act, TIME_FORMAT(t.trninicioalmuerzo, '%H:%i') as inialmu, TIME_FORMAT(t.trnfinalmuerzo, '%H:%i') as finalmu FROM btyprogramacion_colaboradores p JOIN btyturno t ON t.trncodigo=p.trncodigo JOIN btysalon sln ON sln.slncodigo=p.slncodigo WHERE p.prgfecha = '$fecha' AND p.slncodigo = $salon order by t.trnnombre");


			while($vb = mysqli_fetch_array($sql)){
	

				$_SESSION['turno_'] = $vb['trncodigo'];
				$_SESSION['fecha_'] = $vb['prgfecha'];
				$_SESSION['nombre'] = $vb['trnnombre'];
				$_SESSION['salon']  = $vb['slnnombre'];
				$_SESSION['fechaw'] = $vb['fecha'];
				$_SESSION['act']    = $vb['act'];
				$_SESSION['inialmu']= $vb['inialmu'];
				$_SESSION['finalmu']= $vb['finalmu'];
				$_SESSION['desde']  = $vb['desde'];
				$_SESSION['hasta']  = $vb['hasta'];

			    //echo $_SESSION['turno_']. "<br>";
		

			$sql2 = mysqli_query($conn, "SELECT cargo.crgnombre, c.clbcodigo,  t.trcrazonsocial, cat.ctcnombre, tp.tprnombre, pt.ptrnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha,cat.ctcnombre, tipo.tdialias, turno.trnnombre,  CONCAT(tipo.tdialias, ': ', t.trcdocumento) AS Documento, cargo.crgnombre, turno.trndesde as desde, turno.trnhasta as hasta, turno.trninicioalmuerzo as inialmu, turno.trnfinalmuerzo as finalmu FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE p.prgfecha = '$fecha' AND p.slncodigo = $salon AND p.trncodigo = '".$_SESSION['turno_']."' ORDER BY cargo.crgnombre ,turno.trnnombre");		

		

	

			$reportePdf->SetFont('helvetica','B',7);
			$reportePdf->Cell(200,7,"TURNO: " . $vb['trnnombre'] . "  " . " HORARIO: " . $vb['desde'] . " a " . $vb['hasta'] . "  ALMUERZO: de " . $vb['inialmu'] . "  	a  " . $vb['finalmu'] ,0,0,'L'); 
			$reportePdf->Ln(9);

		   
		    $EncabezadoColumnas=array('Cargo', ''.utf8_decode('Código').'', 'Colaborador','Categoria','Tipo','Puesto');

	
		    $AnchoColumnas=array(25,10,80,25,20,15);
			 
		    $AlineacionColumnas=array('R','R','L','L','L','C');

		    $reportePdf->Tabla($EncabezadoColumnas,$sql2,$AnchoColumnas,$AlineacionColumnas);	
		    $reportePdf->Ln(7);

		
	    
	}

$reportePdf->Output("Reporte de ".utf8_decode('Programación por día salón')." ".$_GET['salon'].".pdf", "I");


mysqli_close($conn);
?>
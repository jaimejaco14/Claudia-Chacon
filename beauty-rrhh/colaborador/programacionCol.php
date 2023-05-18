<?php 
	session_start();
	require_once '../../lib/fpdf/fpdf.php';
	include("../../cnx_data.php");


    	$s = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.clbcodigo = '".$_GET['codigo']."' ");

    	$fe = mysqli_fetch_array($s);

    	$_SESSION['nombre'] = $fe[0];


	    
	class ReportPdf extends FPDF
	{

		function Header()
		{

			$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 40);
			$this->SetFont("Arial", "B", 7);

		$mes = explode("-", $_GET['fecha']);

		switch ($mes[1]) 
		{
			case '01':
				$_SESSION['mes'] = 'ENERO';

				break;
			case '02':
				$_SESSION['mes'] = 'FEBRERO';
				break;
			case '03':
				$_SESSION['mes'] = 'MARZO';
				break;
			case '04':
				$_SESSION['mes'] = 'ABRIL';
				break;
			case '05':
				$_SESSION['mes'] = 'MAYO';
				break;
			case '06':
				$_SESSION['mes'] = 'JUNIO';
				break;
			case '07':
				$_SESSION['mes'] = 'JULIO';
				break;
			case '08':
				$_SESSION['mes'] = 'AGOSTO';
				break;
			case '09':
				$_SESSION['mes'] = 'SEPTIEMBRE';
				break;
			case '10':
				$_SESSION['mes'] = 'OCTUBRE';
				break;
			case '11':
				$_SESSION['mes'] = 'NOVIEMBRE';
				break;
			case '12':
				$_SESSION['mes'] = 'DICIEMBRE';
				break;
			
			default:
				$_SESSION['mes']="";
				break;
		}
			$this->Cell(0, 10, "".utf8_decode('PROGRAMACIÓN') . " DE ".$_SESSION['nombre']. " MES DE [ ".$_SESSION['mes']." ] ", 0, 2, 'R');
			$this->Ln(2); 
			$this->SetFont("Arial", "B", 7);	
		
		}

		function Footer()
		{

			$this->SetY(-12);
			$this->SetFont('Arial','',7);
			$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
			$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s")." del ".date("Y-m-d"), 0, 2,'C');
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
				    
				    $this->Cell($w[$i],6,$row[$i],'LR',0,$al[$i],$Relleno);
						
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

				
					for($i=0;$i<count($header);$i++)
					{
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

mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );


		     



		//$sql2 = mysqli_query($conn, "SELECT cargo.crgnombre,  c.clbcodigo, t.trcrazonsocial, cat.ctcnombre, tp.tprnombre, pt.ptrnombre, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha,cat.ctcnombre, tipo.tdialias, turno.trnnombre, cargo.crgnombre, turno.trndesde as desde, turno.trnhasta as hasta, turno.trninicioalmuerzo as inialmu, turno.trnfinalmuerzo as finalmu, CONCAT(tipo.tdialias, ': ', t.trcdocumento) AS Documento FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE p.prgfecha = '".$RsFechas['prgfecha']."' AND p.slncodigo = '".$_GET['salon']."' AND p.trncodigo = '".$vb['trncodigo']."' ORDER BY turno.trnnombre");	


		$sql2 = mysqli_query($conn, "SELECT p.prgfecha, sal.slnnombre, CONCAT(turno.trnnombre, ' DE ', TIME_FORMAT(turno.trndesde, '%H:%i'), ' A ', TIME_FORMAT(turno.trnhasta, '%H:%i'))AS turno, tp.tprnombre, pt.ptrnombre, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha,cat.ctcnombre, tipo.tdialias, cargo.crgnombre, turno.trndesde AS desde, turno.trnhasta AS hasta, turno.trninicioalmuerzo AS inialmu, turno.trnfinalmuerzo AS finalmu, CONCAT(tipo.tdialias, ': ', t.trcdocumento) AS Documento FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN  btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btysalon sal ON sal.slncodigo=p.slncodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE MONTH(p.prgfecha) = MONTH('".$_GET['fecha']."') AND YEAR(p.prgfecha) = YEAR('".$_GET['fecha']."') AND p.clbcodigo = '".$_GET['codigo']."' ORDER BY p.prgfecha");	

			

			

		   
		    $EncabezadoColumnas=array('Fecha',utf8_decode('Salón'), 'Turno', utf8_decode('Tipo de Prgramación'),'Puesto');

	
		    $AnchoColumnas=array(20,50,45,25,20);
			 
		    $AlineacionColumnas=array('C','L','L','C','L');

		    $reportePdf->Tabla($EncabezadoColumnas,$sql2,$AnchoColumnas,$AlineacionColumnas);	
		    $reportePdf->Ln(2);
		
	

	$reportePdf->Output("Reporte de ".utf8_decode('Programación por día salón')." ".$_GET['salon'].".pdf", "I");


	mysqli_close($conn);
?>
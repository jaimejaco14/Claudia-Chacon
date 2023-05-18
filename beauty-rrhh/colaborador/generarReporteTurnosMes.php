<?php 
	session_start();
	require_once '../../lib/fpdf/fpdf.php';
	include("../../cnx_data.php");

    
	    
	class ReportPdf extends FPDF
	{

		function Header()
		{

			$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 40);
			$this->SetFont("Arial", "B", 7);

		$mes= date('m', strtotime($_GET['fecha']));
		

				switch ($mes) 
		{
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
				$mes="";
				break;
		}
			$this->Cell(0, 10, "".utf8_decode('PROGRAMACIÓN SALÓN')." ".$_GET['nomsalon']." PARA EL MES DE ".strtoupper($mes)." ", 0, 2, 'R');
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


		$QueryFechas = mysqli_query($conn, "SELECT DISTINCT DATE_FORMAT(s.prgfecha,'%d de %M de %Y')as fecha, s.prgfecha as prgfecha, CONCAT('HORARIO [',h.hordia,']: DE: ',date_format(h.hordesde,'%H:%i'),' A: ',date_format(h.horhasta,'%H:%i')) AS horario  FROM btyprogramacion_colaboradores s, btyhorario as h, btyhorario_salon as hs WHERE h.horcodigo=hs.horcodigo and hs.slncodigo=s.slncodigo and s.horcodigo=h.horcodigo and MONTH(s.prgfecha) = MONTH('".$_GET['fecha']."') AND s.slncodigo = '".$_GET['salon']."' ORDER BY fecha asc");







	while($RsFechas = mysqli_fetch_array($QueryFechas))
	{	
			
	        $reportePdf->SetFont('helvetica','BI',7);
			$reportePdf->Cell(200,7,"FECHA: " . strtoupper($RsFechas['fecha']).' '.$RsFechas['horario'],0,0,'L');
			$reportePdf->Ln(7);

			$sql = mysqli_query($conn, "SELECT DISTINCT(s.trncodigo) as trncodigo, CONCAT(t.trnnombre,' DE: ',DATE_FORMAT(t.trndesde,'%H:%i'),' A: ',DATE_FORMAT(t.trnhasta,'%H:%i'),' ALM: ',DATE_FORMAT(t.trninicioalmuerzo,'%H:%i'),' - ',DATE_FORMAT(t.trnfinalmuerzo,'%H:%i')) AS turno, sln.slnnombre as slnnom, t.trnnombre as trnnombre FROM btyprogramacion_colaboradores s JOIN btyturno t ON s.trncodigo=t.trncodigo JOIN btysalon sln ON s.slncodigo=sln.slncodigo WHERE s.prgfecha = '".$RsFechas['prgfecha']."' AND s.slncodigo = '".$_GET['salon']."' ORDER BY t.trnnombre");

			while($vb = mysqli_fetch_array($sql))
	{	

		    $reportePdf->SetFont('helvetica','B',7);
			$reportePdf->Cell(200,7,"TURNO: " . strtoupper($vb['turno']),0,0,'L');
			$reportePdf->Ln(5);


		$sql2 = mysqli_query($conn, "SELECT cargo.crgnombre,  c.clbcodigo, t.trcrazonsocial, cat.ctcnombre, tp.tprnombre, pt.ptrnombre, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha,cat.ctcnombre, tipo.tdialias, turno.trnnombre, cargo.crgnombre, turno.trndesde as desde, turno.trnhasta as hasta, turno.trninicioalmuerzo as inialmu, turno.trnfinalmuerzo as finalmu, CONCAT(tipo.tdialias, ': ', t.trcdocumento) AS Documento FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE p.prgfecha = '".$RsFechas['prgfecha']."' AND p.slncodigo = '".$_GET['salon']."' AND p.trncodigo = '".$vb['trncodigo']."' ORDER BY turno.trnnombre");		

			

			

		   
		    $EncabezadoColumnas=array('Cargo', 'Codigo','Colaborador','Perfil','Tipo','Puesto');

	
		    $AnchoColumnas=array(25,10,80,25,20,15);
			 
		    $AlineacionColumnas=array('R','R','L','L','L','C');

		    $reportePdf->Tabla($EncabezadoColumnas,$sql2,$AnchoColumnas,$AlineacionColumnas);	
		    $reportePdf->Ln(2);
		}
	}

	$reportePdf->Output("Reporte de ".utf8_decode('Programación por día salón')." ".$_GET['salon'].".pdf", "I");


	mysqli_close($conn);
?>
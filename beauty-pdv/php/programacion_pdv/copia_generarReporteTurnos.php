<?php 
	require_once '../../../beauty/lib/fpdf/fpdf.php';
	ob_start();
	include("../../../cnx_data.php");

		$salon 			= $_GET['salon'];
		$turno 			= $_GET['turno'];
		$fecha 			= $_GET['fecha'];
		$programacion 	= array();
		$fechaGenerado  = date("d-m-Y");
		$horaGenerado   = date("h:i:s a");

if ($_GET['tipo'] 	== 'dia') {

		mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );


		$query = mysqli_query($conn, "SELECT sln.slnnombre, DATE_FORMAT(pgr.prgfecha, '%d de %M de %Y')as fecha, DATE_FORMAT(CURDATE(), '%d de %M de %Y') as act,pgr.trncodigo, t.trnnombre, t.trndesde, t.trnhasta, TIME_FORMAT(t.trninicioalmuerzo, '%h:%i %p')as inialmu, TIME_FORMAT(t.trnfinalmuerzo, '%h:%i %p') as finalmu FROM btyprogramacion_colaboradores pgr JOIN btysalon sln ON pgr.slncodigo=sln.slncodigo JOIN btyturno t ON t.trncodigo=pgr.trncodigo WHERE sln.slncodigo= $salon AND pgr.prgfecha = '$fecha' AND t.trncodigo = $turno");

		
		$gy = mysqli_fetch_array($query);

		$_SESSION['fecha']       = $gy['fecha'];
		$_SESSION['fechaactual'] = $gy['act'];
		$_SESSION['salon']       = $gy['slnnombre'];
		$_SESSION['turno']       = $gy['trnnombre'];
		$_SESSION['desde']       = $gy['trndesde'];
		$_SESSION['hasta']       = $gy['trnhasta'];
		$_SESSION['inialmu']     = $gy['inialmu'];
		$_SESSION['finalmu']     = $gy['finalmu'];




		mysqli_query($conn, "SET @numero=0");

		$sql = mysqli_query($conn, "SELECT @numero:=@numero+1 AS posicion, t.trcdocumento, t.trcrazonsocial, tp.tprnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha, cat.ctcnombre, tipo.tdialias, turno.trnnombre, cargo.crgnombre, TIME_FORMAT(turno.trndesde, '%h:%i %p') as desde, TIME_FORMAT(turno.trnhasta, '%h:%i %p') as hasta, TIME_FORMAT(turno.trninicioalmuerzo, '%h:%i %p')as inialmu, TIME_FORMAT(turno.trnfinalmuerzo, '%h:%i %p') as finalmu FROM  btyprogramacion_colaboradores p INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE p.prgfecha = '$fecha' AND p.slncodigo = $salon AND p.trncodigo = $turno ORDER BY turno.trnnombre")or die(mysqli_error($conn));

		



		while($registros = mysqli_fetch_array($sql)){

		$programacion[] = array(
							"posicion"           => $registros["posicion"],
							"documento"          => $registros["trcdocumento"],
							"nombre"             => $registros["trcrazonsocial"],
							"tipo_pro"           => $registros["tprnombre"],
							"pto_tra"            => $registros["ptrnombre"],
							"cargo"              => $registros["crgnombre"],
							"cat"                => $registros["ctcnombre"],
							"tipodoc"            => $registros["tdialias"],
							"turno"              => $registros["trnnombre"],
							"almuerzo"           => $registros["almuerzo"],
							"desde"              => $registros["desde"],
							"hasta"              => $registros["hasta"],
							"inialmu"            => $registros["inialmu"],
							"finalmu"            => $registros["finalmu"],
		
						);
	    }


		class PDF extends FPDF{

				function Header(){

					$this->Image('../../../beauty/imagenes/logo_empresa.jpg', 10, 10, 70);
					$this->SetFont("Arial", "B", 14);
					$this->Cell(0, 10, "PROGRAMACION POR TURNOS ( SALON ".$_SESSION['salon']." ) ".$_SESSION['fecha'], 0, 2, 'R');
					$this->Ln();
					$this->SetFont("Arial", "B", 12);
					$this->Cell(0, 5, "Turno: ".$_SESSION['turno']." - Horario: ".$_SESSION['desde']." a ".$_SESSION['hasta']." - Almuerzo: De ".$_SESSION['inialmu']." a ".$_SESSION['finalmu']." ", 0, 2, 'L');
					$this->SetFont("Arial", "", 9);
				}

				function Footer(){

					$this->SetY(-12);
					$this->SetFont('Arial','',8);
					$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
					$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2,'C');
				}
		}


		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 10);
		$reportePdf->Cell(10, 8, utf8_decode("No°"), 1, 0, "C", 1);
		$reportePdf->Cell(35, 8, "No. Documento", 1, 0, "C", 1);
		//$reportePdf->Cell(70, 8, "Turno", 1, 0, "C", 1);
		$reportePdf->Cell(130, 8, "Nombre", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Cargo"), 1, 0, "C", 1);		
		$reportePdf->Cell(40, 8, utf8_decode("Categorìa"), 1, 0, "C", 1);
		//$reportePdf->Cell(35, 8, "Almuerzo", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Tipo Programación"), 1, 0, "C", 1);
		$reportePdf->Cell(30, 8, utf8_decode("Puesto"), 1, 0, "C", 1);

		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		for($i = 0; $i < count($programacion); $i++){

			$_SESSION['turno'] = $programacion[$i]["turno"];

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}

			$reportePdf->Ln();
			$reportePdf->Cell(10, 6.5, $programacion[$i]["posicion"], 1, 0, "R");
			$reportePdf->Cell(35, 6.5, $programacion[$i]["tipodoc"] . ": " . $programacion[$i]["documento"], 1, 0, "R", 1);
			//$reportePdf->Cell(70, 6.5, $programacion[$i]["turno"], 1, 0, "L");
			$reportePdf->Cell(130, 6.5, $programacion[$i]["nombre"], 1, 0, "L");
			$reportePdf->Cell(40, 6.5, $programacion[$i]["cargo"], 1, 0, "C");
			$reportePdf->Cell(40, 6.5, $programacion[$i]["cat"], 1, 0, "C");
			//$reportePdf->Cell(35, 6.5, $programacion[$i]["desde"] . " - " . $programacion[$i]["hasta"], 1, 0, "C");
			//$reportePdf->Cell(35, 6.5, $programacion[$i]["inialmu"] . " - " . $programacion[$i]["finalmu"], 1, 0, "C");
			$reportePdf->SetFillColor($bgcolor);
			if ($programacion[$i]["tipo_pro"] == 'LABORA')  {
				$reportePdf->SetFillColor(36,226,55);
			}else{
				if ($programacion[$i]["tipo_pro"] == 'PERMISO') {
					$reportePdf->SetFillColor(229, 63, 255);
				}else{
					if ($programacion[$i]["tipo_pro"] == 'INCAPACIDAD') {
						$reportePdf->SetFillColor(204, 202, 206);
					}else{
						if ($programacion[$i]["tipo_pro"] == 'META') {
							$reportePdf->SetFillColor(52, 125, 15);
						}else{
							if ($programacion[$i]["tipo_pro"] == 'CAPACITACION') {
								$reportePdf->SetFillColor(106, 209, 247);
							}else{
								if ($programacion[$i]["tipo_pro"] == 'DESCANSO') {
									$reportePdf->SetFillColor(255, 243, 15);
								}else{
									if ($programacion[$i]["tipo_pro"] == 'CITA MEDICA') {
										$reportePdf->SetFillColor(186, 242, 235);
									}
								}
							}
						}
					}
				}
			}
			$reportePdf->Cell(40, 6.5, $programacion[$i]["tipo_pro"], 1	, 0, "C",1);
			$reportePdf->Cell(30, 6.5, $programacion[$i]["pto_tra"], 1, 0, "C");		
			
		}
		$reportePdf->Output("Reporte de ".utf8_decode('Programación por turno salón')." ".$_SESSION['salon'].".pdf", "I");

}else{

		


		mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );

		$sql = mysqli_query($conn, "SELECT DISTINCT p.trncodigo, p.prgfecha, t.trnnombre, sln.slnnombre, t.trndesde, t.trnhasta, DATE_FORMAT(p.prgfecha, '%d de %M de %Y')as fecha,DATE_FORMAT(CURDATE(), '%d de %M de %Y') as act, TIME_FORMAT(t.trninicioalmuerzo, '%h:%i %p')as inialmu, TIME_FORMAT(t.trnfinalmuerzo, '%h:%i %p') as finalmu FROM btyprogramacion_colaboradores p JOIN btyturno t ON t.trncodigo=p.trncodigo JOIN btysalon sln ON sln.slncodigo=p.slncodigo WHERE p.prgfecha = '$fecha' AND p.slncodigo = $salon");


			while($vb = mysqli_fetch_array($sql)){
	

				$_SESSION['turno_'] = $vb['trncodigo'];
				$_SESSION['fecha_'] = $vb['prgfecha'];
				$_SESSION['nombre'] = $vb['trnnombre'];
				$_SESSION['salon']  = $vb['slnnombre'];
				$_SESSION['fecha']  = $vb['fecha'];
				$_SESSION['act']    = $vb['act'];
				$_SESSION['inialmu']= $vb['inialmu'];
				$_SESSION['finalmu']= $vb['finalmu'];

			    //echo $_SESSION['turno_']. "<br>";
		

			$sql2 = mysqli_query($conn, "SELECT  t.trcdocumento, t.trcrazonsocial, tp.tprnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, p.trncodigo, p.prgfecha,cat.ctcnombre, tipo.tdialias, turno.trnnombre, cargo.crgnombre, TIME_FORMAT(turno.trndesde, '%h:%i %p') as desde, TIME_FORMAT(turno.trnhasta, '%h:%i %p') as hasta, TIME_FORMAT(turno.trninicioalmuerzo, '%h:%i %p')as inialmu, TIME_FORMAT(turno.trnfinalmuerzo, '%h:%i %p') as finalmu FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btycargo cargo ON c.crgcodigo = cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo JOIN btytipodocumento tipo ON tipo.tdicodigo=t.tdicodigo JOIN btyturno turno ON p.trncodigo=turno.trncodigo WHERE p.prgfecha = '$fecha' AND p.slncodigo = $salon AND p.trncodigo = '".$_SESSION['turno_']."' ORDER BY turno.trnnombre");			
			
	    
	}
		class ReportPdf extends FPDF{

			function Header(){

				$this->Image('../../../beauty/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 14);
				$this->Cell(0, 10, "PROGRAMACION SALON ".$_SESSION['salon']." PARA EL DIA ".strtoupper($_SESSION['fecha'])." ", 0, 2, 'R');
				$this->Ln();
				$this->SetFont("Arial", "B", 12);
				$this->Cell(0, 5, "TURNO:  ".utf8_encode($_SESSION['nombre'])." ", 0, 2, 'L');	
				$this->SetFont("Arial", "", 9);
				//$this->Cell(0, 8, "Generado a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2, 'R');
			}

			function Footer(){

				$this->SetY(-12);
				$this->SetFont('Arial','',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2,'C');
			}
		}




	    $reportePdf = new ReportPdf();
		$reportePdf->AddPage("L", "legal");
		$reportePdf->Ln();
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 10);
		$reportePdf->Cell(35, 8, "No. Documento", 1, 0, "C", 1);
		$reportePdf->Cell(90, 8, "Nombre", 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Cargo"), 1, 0, "C", 1);		
		$reportePdf->Cell(40, 8, utf8_decode("Categoría"), 1, 0, "C", 1);
		$reportePdf->Cell(40, 8, utf8_decode("Tipo Programación"), 1, 0, "C", 1);
		$reportePdf->Cell(30, 8, utf8_decode("Puesto"), 1, 0, "C", 1);
		$reportePdf->SetFillColor(255);
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 8);

		while($registros = mysqli_fetch_array($sql2)){

			$programacion[] = array(
					"documento"          => $registros["trcdocumento"],
					"nombre"             => $registros["trcrazonsocial"],
					"tipo_pro"           => $registros["tprnombre"],
					"pto_tra"            => $registros["ptrnombre"],
					"cargo"              => $registros["crgnombre"],
					"cat"                => $registros["ctcnombre"],
					"tipodoc"            => $registros["tdialias"],
					"turno"              => $registros["trnnombre"],
					"almuerzo"           => $registros["almuerzo"],
					"desde"              => $registros["desde"],
					"hasta"              => $registros["hasta"],
					"inialmu"            => $registros["inialmu"],
					"finalmu"            => $registros["finalmu"],
					"cod"                => $registros["trncodigo"]


			);			
		}



		for($i = 0; $i < count($programacion); $i++){

			if(($i % 2) == 0){

				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{

				$reportePdf->SetFillColor(255);
			}

			$reportePdf->Ln();
			$reportePdf->Cell(35, 6.5, $programacion[$i]["tipodoc"] . ": " . $programacion[$i]["documento"], 1, 0, "R", 1);
			$reportePdf->Cell(90, 6.5, $programacion[$i]["nombre"], 1, 0, "L");
			$reportePdf->Cell(40, 6.5, $programacion[$i]["cargo"], 1, 0, "C");
			$reportePdf->Cell(40, 6.5, $programacion[$i]["cat"] . "***" . $programacion[$i]["cod"] , 1, 0, "C");
			$reportePdf->SetFillColor($bgcolor);

			switch ($programacion[$i]["tipo_pro"]) {
				case 'LABORA':
					$reportePdf->SetFillColor(36,226,55);
					break;

				case 'PERMISO':
					$reportePdf->SetFillColor(229, 63, 255);
					break;

				case 'INCAPACIDAD':
					$reportePdf->SetFillColor(204, 202, 206);
					break;

				case 'META':
					$reportePdf->SetFillColor(52, 125, 15);
					break;

				case 'CAPACITACION':
					$reportePdf->SetFillColor(106, 209, 247);
					break;

				case 'DESCANSO':
					$reportePdf->SetFillColor(255, 243, 15);
					break;

				case 'CITA MEDICA':
					$reportePdf->SetFillColor(186, 242, 235);
					break;				
				default:
					$programacion[$i]["tipo_pro"];
					break;
			}
			$reportePdf->Cell(40, 6.5, $programacion[$i]["tipo_pro"], 1	, 0, "C",1);
			$reportePdf->Cell(30, 6.5, $programacion[$i]["pto_tra"], 1, 0, "C");
			
					
		}//fin for
		$reportePdf->Output("Reporte de ".utf8_decode('Programación por día salón')." ".$_SESSION['salon'].".pdf", "I");
}
mysqli_close($conn);
ob_end_flush();
 ?>
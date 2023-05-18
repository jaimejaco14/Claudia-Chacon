<?php 

	require_once '../../../lib/fpdf/fpdf.php';
	include("../../../cnx_data.php");

	$sql="(SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
			TIME_FORMAT(j.trnhasta,'%H:%i'))  AS desde,
			bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, 
			a.abmcodigo, a.aptcodigo
			FROM btyasistencia_procesada a
			JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
			JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
			JOIN btytercero t ON t.trcdocumento=c.trcdocumento
			JOIN btysalon s ON s.slncodigo=a.slncodigo
			JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
			JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
			JOIN btyturno j ON j.trncodigo=a.trncodigo
			JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
			WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000'
			ORDER BY t.trcrazonsocial) 

	UNION 

 	(SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, 
		CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
		TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, 
		a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo
		FROM btyasistencia_procesada a
		JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
		JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento
		JOIN btysalon s ON s.slncodigo=a.slncodigo
		JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
		JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
		JOIN btyturno j ON j.trncodigo=a.trncodigo
		WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND a.abmcodigo IS NULL AND NOT a.aptcodigo=6 AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000'
		ORDER BY t.trcrazonsocial) 

	UNION 
	(
		SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, b.aptnombre, CASE WHEN IFNULL(NULL, IF((
		SELECT ab.abmnuevotipo
		FROM btyasistencia_procesada ap2
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
		WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo 
		AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) = 'SALIDA' THEN CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
		TIME_FORMAT(j.trnhasta,'%H:%i')) END AS desde, 
		IFNULL(NULL, IF((
		SELECT ab.abmnuevotipo
		FROM btyasistencia_procesada ap2
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
		WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) AS TIPO, NULL, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo
		FROM btyasistencia_procesada a
		JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
		JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento
		JOIN btysalon s ON s.slncodigo=a.slncodigo
		JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
		JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
		JOIN btyturno j ON j.trncodigo=a.trncodigo
		WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND a.abmcodigo IS NULL 
		AND a.aptcodigo=6 AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000')
		ORDER BY trcrazonsocial";


$res=$conn->query($sql);

$con = mysqli_num_rows($res);
$_SESSION['conteo'] = $con;

	 
	class PDF extends FPDF
	{

			function Header()
			{

				$this->Image('../../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 50);
				$this->SetFont("Arial", "B", 8);
				$this->Cell(0, 5, utf8_decode("REPORTE DE NOVEDADES SALÓN " . $_SESSION['PDVslnNombre'] . " [MES ACTUAL]"), 0, 2, 'R');
				$this->Cell(0, 5, utf8_decode("NOVEDADES ENCONTRADAS: " . $_SESSION['conteo']), 0, 2, 'R');
				$this->SetFont("Arial", "", 8);
				$this->Ln(9);
			}

			function Footer()
			{

				$this->SetY(-12);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado el " . date("d-m-Y"). " a las ". date("h:i:sA"). " mediante el sistema Beauty Soft ERP", 0, 2,'C');

			}
	}



$reportePdf = new PDF();

$reportePdf->AddPage("L", "legal");
$reportePdf->Ln();
$reportePdf->SetFillColor(151, 130, 45);
$reportePdf->SetTextColor(255);
$reportePdf->SetFont("Arial", "B", 8);
//ENCABEZADOS**************************************************
$reportePdf->Cell(70, 8, "COLABORADOR", 1, 0, "C", 1);
$reportePdf->Cell(25, 8, "CARGO", 1, 0, "C", 1);
$reportePdf->Cell(25, 8, "FECHA", 1, 0, "C", 1);
$reportePdf->Cell(25, 8, "NOVEDAD", 1, 0, "C", 1);
$reportePdf->Cell(50, 8, "TURNO", 1, 0, "C", 1);
$reportePdf->Cell(25, 8, "TIPO", 1, 0, "C", 1);
$reportePdf->Cell(35, 8, "HORA", 1, 0, "C", 1);
$reportePdf->Cell(70, 8, "OBSERVACIONES", 1, 0, "C", 1);
//FIN ENCABEZADOS**********************************************
$reportePdf->Ln(8);
//color, tipo y tamaño de letra
$reportePdf->SetTextColor(0);
$reportePdf->SetFont("Arial", "", 7);
//fin color, tipo y tamaño de letra


$sql="(SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
			TIME_FORMAT(j.trnhasta,'%H:%i'))  AS desde,
			bio.abmnuevotipo,bio.abmhora, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, 
			a.abmcodigo, a.aptcodigo
			FROM btyasistencia_procesada a
			JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
			JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
			JOIN btytercero t ON t.trcdocumento=c.trcdocumento
			JOIN btysalon s ON s.slncodigo=a.slncodigo
			JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
			JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
			JOIN btyturno j ON j.trncodigo=a.trncodigo
			JOIN btyasistencia_biometrico bio ON bio.abmcodigo=a.abmcodigo
			WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000'
			ORDER BY t.trcrazonsocial) 

	UNION 

 	(SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre,b.aptnombre, 
		CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
		TIME_FORMAT(j.trnhasta,'%H:%i')) AS aptnombre, '','', j.trncodigo, a.horcodigo, 
		a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo
		FROM btyasistencia_procesada a
		JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
		JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento
		JOIN btysalon s ON s.slncodigo=a.slncodigo
		JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
		JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
		JOIN btyturno j ON j.trncodigo=a.trncodigo
		WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND a.abmcodigo IS NULL AND NOT a.aptcodigo=6 AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000' 
		ORDER BY t.trcrazonsocial) 

	UNION 
	(
		SELECT a.clbcodigo, t.trcrazonsocial, crg.crgnombre, ctc.ctcnombre, b.aptnombre, CASE WHEN IFNULL(NULL, IF((
		SELECT ab.abmnuevotipo
		FROM btyasistencia_procesada ap2
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
		WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo 
		AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) = 'SALIDA' THEN CONCAT(TIME_FORMAT(j.trndesde, '%H:%i'), ' a ', 
		TIME_FORMAT(j.trnhasta,'%H:%i')) END AS desde, 
		IFNULL(NULL, IF((
		SELECT ab.abmnuevotipo
		FROM btyasistencia_procesada ap2
		JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap2.abmcodigo
		WHERE ap2.prgfecha = a.prgfecha AND ap2.clbcodigo=a.clbcodigo AND ap2.abmcodigo IS NOT NULL)='ENTRADA','SALIDA','ENTRADA')) AS TIPO, NULL, j.trncodigo, a.horcodigo, a.slncodigo, a.apcobservacion, a.prgfecha, a.abmcodigo, a.aptcodigo
		FROM btyasistencia_procesada a
		JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo
		JOIN btycolaborador c ON c.clbcodigo=a.clbcodigo
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento
		JOIN btysalon s ON s.slncodigo=a.slncodigo
		JOIN btycargo crg ON crg.crgcodigo=c.crgcodigo
		JOIN btycategoria_colaborador ctc ON ctc.ctccodigo=c.ctccodigo
		JOIN btyturno j ON j.trncodigo=a.trncodigo
		WHERE MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND a.abmcodigo IS NULL 
		AND a.aptcodigo=6 AND s.slncodigo = '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000')
		ORDER BY trcrazonsocial";


$res=$conn->query($sql);
$i=0;//variable de control color de fondo intercalado de filas
while($row=$res->fetch_array()){
	$i++;
	if(($i % 2) == 0){

		$reportePdf->SetFillColor(255, 246, 210);
	}
	else{

		$reportePdf->SetFillColor(255);
	}

	
	$_SESSION['trcrazonsocial'] 	= $row['trcrazonsocial'];
	$_SESSION['crgnombre']     		= $row['crgnombre'];
	$_SESSION['salctcnombreon']     = $row['ctcnombre'];
	$_SESSION['aptnombre']      	= $row['aptnombre'];
	$_SESSION['desde']  			= $row['desde'];
	$_SESSION['abmnuevotipo']   	= $row['abmnuevotipo'];
	$_SESSION['abmhora']  			= $row['abmhora'];
	$_SESSION['apcobservacion']     = $row['apcobservacion'];
	$reportePdf->SetFont("Arial", "", 7);
	$reportePdf->Cell(70, 8, $row['trcrazonsocial'], 1, 0, "L", 1);
	$reportePdf->Cell(25, 8, $row['crgnombre'], 1, 0, "L", 1);
	$reportePdf->Cell(25, 8, $row['prgfecha'], 1, 0, "L", 1);
	$reportePdf->Cell(25, 8, $row['aptnombre'], 1, 0, "L", 1);
	$reportePdf->Cell(50, 8, $row['desde'], 1, 0, "L", 1);
	$reportePdf->Cell(25, 8, $row['abmnuevotipo'], 1, 0, "L", 1);
	$reportePdf->Cell(35, 8, $row['abmhora'], 1, 0, "L", 1);
	$reportePdf->Cell(70, 8, $row['apcobservacion'], 1, 0, "L", 1);
	$reportePdf->Ln(8);


}


$reportePdf->Output("REPORTE DE NOVEDADES ". $_SESSION['PDVslnNombre'].".pdf", "I");

?>


<?php 
	//session_start();
	require_once '../lib/fpdf/fpdf.php';
	//include '../cnx_data.php';

	$sql="SELECT p.nvpcodigo, det.nvpfecharegistro, TIME_FORMAT(det.nvphoraregistro, '%H:%i') AS nvphoraregistro, DATE_FORMAT(det.nvpfecha, '%d %M de %Y')AS nvpfecha, det.nvpobservacion, p.clbcodigo, det.usucodigo, t2.trcrazonsocial AS usuadmin, t.trcrazonsocial AS col, TIME_FORMAT(det.nvphoradesde,'%H:%i')AS nvphoradesde, TIME_FORMAT(det.nvphorahasta, '%H:%i')AS nvphorahasta, sln.slnnombre,  crg.crgnombre, tipo.tnvnombre, perfil.ctcnombre FROM btynovedades_programacion_detalle AS p, btynovedades_programacion AS det, btycolaborador AS c, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon AS sln, btycargo AS crg, btytipo_novedad_programacion AS tipo, btycategoria_colaborador AS perfil WHERE p.nvpcodigo=det.nvpcodigo AND det.usucodigo=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND u1.usucodigo=det.usucodigo AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND tipo.tnvcodigo=det.tnvcodigo AND sln.slncodigo=det.slncodigo AND perfil.ctccodigo=c.ctccodigo  AND crg.crgcodigo=c.crgcodigo AND p.nvpcodigo = '".$_GET['idnovedad']."' ORDER BY p.nvpcodigo DESC, col ASC";


	$res=$conn->query($sql);

	while($row=$res->fetch_array())
	{
		$_SESSION['idnovedad'] = $row[0];
		$_SESSION['desde']     = $row['nvphoradesde'];
		$_SESSION['hasta']     = $row['nvphorahasta'];
		$_SESSION['salon']     = $row['slnnombre'];
		$_SESSION['tipo']      = $row['tnvnombre'];
		$_SESSION['usuadmin']  = $row['usuadmin'];
		$_SESSION['horareg']   = $row['nvphoraregistro'];
		$_SESSION['fechareg']  = $row['nvpfecharegistro'];
		$_SESSION['observacion']  = $row['nvpobservacion'];
		$_SESSION['perfil']       = $row['ctcnombre'];
	}
    
	class PDF extends FPDF{

	function Header(){

		$this->Image('../contenidos/imagenes/logo_empresa.jpg', 10, 10, 50);
		$this->SetFont("Arial", "B", 8);
		$this->Cell(0, 5, utf8_decode("REPORTE DE NOVEDAD N° " . $_SESSION['idnovedad']), 0, 2, 'R');
		$this->Cell(0, 5, "TIPO: ".$_SESSION['tipo'], 0, 2, 'R');
		$this->Cell(0, 5, "DE ".$_SESSION['desde']." A ".$_SESSION['hasta'] . " HS", 0, 2, 'R');
		$this->Cell(0, 5,  "SALON: " . $_SESSION['salon'], 0, 2, 'R');
		$this->Cell(0, 5,  "REGISTRADO POR: " . $_SESSION['usuadmin'] . " EL " . $_SESSION['fechareg'] . " A LAS " . $_SESSION['horareg'], 0, 2, 'R');
		$this->SetFont("Arial", "", 8);
	}

	function Footer(){

		$this->SetY(-12);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
		$this->Cell(0,5,"Generado el " . date("d-m-Y"). " a las ". date("h:i:sA"). " mediante el sistema Beauty Soft ERP", 0, 2,'C');
	}
}
$reportePdf = new PDF();

$reportePdf->AddPage("P", "legal");
$reportePdf->Ln();
$reportePdf->SetFillColor(151, 130, 45);
$reportePdf->SetTextColor(255);
$reportePdf->SetFont("Arial", "B", 8);
//ENCABEZADOS**************************************************
$reportePdf->Cell(15, 8, "CODIGO", 1, 0, "C", 1);
$reportePdf->Cell(90, 8, "COLABORADOR", 1, 0, "C", 1);
$reportePdf->Cell(42, 8, "CARGO", 1, 0, "C", 1);
$reportePdf->Cell(42, 8, "PERFIL", 1, 0, "C", 1);
//FIN ENCABEZADOS**********************************************
$reportePdf->Ln(8);
//color, tipo y tamaño de letra
$reportePdf->SetTextColor(0);
$reportePdf->SetFont("Arial", "", 7);
//fin color, tipo y tamaño de letra


$sql="SELECT p.nvpcodigo, det.nvpfecharegistro, TIME_FORMAT(det.nvphoraregistro, '%H:%i') AS nvphoraregistro, DATE_FORMAT(det.nvpfecha, '%d %M de %Y')AS nvpfecha, det.nvpobservacion, p.clbcodigo, det.usucodigo, t2.trcrazonsocial AS usuadmin, t.trcrazonsocial AS col, TIME_FORMAT(det.nvphoradesde,'%H:%i')AS nvphoradesde, TIME_FORMAT(det.nvphorahasta, '%H:%i')AS nvphorahasta, sln.slnnombre,  crg.crgnombre, tipo.tnvnombre, perfil.ctcnombre FROM btynovedades_programacion_detalle AS p, btynovedades_programacion AS det, btycolaborador AS c, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon AS sln, btycargo AS crg, btytipo_novedad_programacion AS tipo, btycategoria_colaborador AS perfil WHERE p.nvpcodigo=det.nvpcodigo AND det.usucodigo=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND u1.usucodigo=det.usucodigo AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND tipo.tnvcodigo=det.tnvcodigo AND sln.slncodigo=det.slncodigo AND perfil.ctccodigo=c.ctccodigo  AND crg.crgcodigo=c.crgcodigo AND p.nvpcodigo = '".$_GET['idnovedad']."' ORDER BY p.nvpcodigo DESC, col ASC";
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

	$_SESSION['idnovedad'] = $row[0];
	$_SESSION['desde']     = $row['nvphoradesde'];
	$_SESSION['hasta']     = $row['nvphorahasta'];
	$_SESSION['salon']     = $row['slnnombre'];
	$_SESSION['tipo']      = $row['tnvnombre'];
	$_SESSION['usuadmin']  = $row['usuadmin'];
	$_SESSION['horareg']   = $row['nvphoraregistro'];
	$_SESSION['fechareg']  = $row['nvpfecharegistro'];
	$_SESSION['observacion']  = $row['nvpobservacion'];
	$_SESSION['perfil']       = $row['ctcnombre'];

	$reportePdf->Cell(15, 8, $row['clbcodigo'], 1, 0, "R", 1);
	$reportePdf->Cell(90, 8, $row['col'], 1, 0, "L", 1);
	$reportePdf->Cell(42, 8, $row['crgnombre'], 1, 0, "C", 1);
	$reportePdf->Cell(42, 8, $row['ctcnombre'], 1, 0, "C", 1);
	$reportePdf->Ln(8);
}


$reportePdf->Output("Reporte individual de asistencia.pdf", "I");


?>


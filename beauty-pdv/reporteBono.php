<?php 

	$fechaGenerado = date("d-m-Y");
	$horaGenerado = date("h:i:s a");
    $codigoBono = $_GET['codigo_bono'];
    $salon = $_GET['salon'];
    $valor = $_GET['valor'];
	$ordenServicio = $_GET['orden_servicio'];

	if(isset($_GET['fecha_transaccion']) && !empty($_GET['fecha_transaccion'])){

		$fechaGenerado = date('d-m-Y', strtotime($_GET['fecha_transaccion']));
		$horaGenerado = date('h:i:s a', strtotime($_GET['fecha_transaccion']));
	}

	require_once '../lib/fpdf/fpdf.php';

	$reportePdf = new FPDF();

	$reportePdf->AddPage("P", [150, 100]);
	$reportePdf->SetFont("Arial", "", 10);
	$reportePdf->Cell(0, 10, utf8_decode('REDENCIÓN DEL BONO VIRTUAL'));
	$reportePdf->Ln();
	$reportePdf->Cell(0, 10, utf8_decode('SALÓN: ' . strtoupper($salon)));
	$reportePdf->Ln();
	$reportePdf->Cell(0, 10, 'ORDEN DE SERVICIO # ' . $ordenServicio);
	$reportePdf->Ln();
	$reportePdf->Cell(0, 10, utf8_decode('FECHA REDENCIÓN: ') . $fechaGenerado . ' ' . $horaGenerado);
	$reportePdf->Ln();
	$reportePdf->Cell(0, 10, utf8_decode('CÓDIGO BONO: ') . strtoupper($codigoBono));
	$reportePdf->Ln();
	$reportePdf->Cell(0, 10, 'VALOR: $' . number_format($valor, 0, ',', '.'));
	
	if(isset($_GET['usuario']) && !empty($_GET['usuario'])){
		$reportePdf->SetY(-60);
		$reportePdf->MultiCell(0, 10, utf8_decode('Redimido por: ' . $_GET['usuario']));
	}
	else{
		$reportePdf->SetY(-35);
		$reportePdf->Cell(0, 10, utf8_decode('Redimido por: _________________________'));
	}
	$reportePdf->Output();
?>
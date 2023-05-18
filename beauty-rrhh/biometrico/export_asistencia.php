<?php
include '../../cnx_data.php';
$opc=$_GET['opc'];
$sln=$_GET['salon'];
$mes=$_GET['mes'];
$salones=explode(',',$sln);
switch($opc){
	case "PDF":
		require_once '../../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 12);
				$this->Cell(0, 9, "REPORTE DE NOVEDADES ASISTENCIA POR SALONES- ".$_GET['mestxt']." ", 0, 2, 'R');
				$this->SetFont("Arial", "", 9);
				$this->Cell(0, 8, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y"), 0, 2, 'R');
			}

			function Footer(){

				$this->SetY(-12);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP", 0, 2,'C');
			}
		}
		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		
		foreach ($salones as $salon){
			$sqlns="SELECT sln.slnnombre FROM btysalon sln WHERE sln.slncodigo=$salon";
			$resns=$conn->query($sqlns);
			$slnnom=$resns->fetch_array();
			$reportePdf->Ln();
			$reportePdf->SetFillColor(151, 130, 45);
			$reportePdf->SetTextColor(255);
			$reportePdf->SetFont("Arial", "B", 9);
			$reportePdf->Cell(330, 8, $slnnom[0], 1, 0, "C", 1);
			$reportePdf->Ln(8);
			$reportePdf->Cell(90, 8, "COLABORADOR", 1, 0, "C", 1);
			$reportePdf->Cell(40, 8, "LLEGADA TARDE", 1, 0, "C", 1);
			$reportePdf->Cell(40, 8, "SALIDA TEMPRANO", 1, 0, "C", 1);
			$reportePdf->Cell(35, 8, "AUSENCIA", 1, 0, "C", 1);
			$reportePdf->Cell(35, 8, "INCOMPLETO", 1, 0, "C", 1);
			$reportePdf->Cell(55, 8, "PRESENCIA NO PROGRAMADA", 1, 0, "C", 1);
			$reportePdf->Cell(35, 8, "ERROR", 1, 0, "C", 1);
			//FIN ENCABEZADOS**********************************************
			$reportePdf->Ln(8);
			//color, tipo y tamaño de letra
			$reportePdf->SetTextColor(0);
			$reportePdf->SetFont("Arial", "", 8);
			//fin color, tipo y tamaño de letra

			$sql0="SELECT distinct(ab.clbcodigo), t.trcrazonsocial
					from btyasistencia_procesada ab
					join btycolaborador c on c.clbcodigo=ab.clbcodigo
					join btytercero t on t.trcdocumento=c.trcdocumento
					where month(ab.prgfecha)='$mes' and year(ab.prgfecha)=year(curdate()) and ab.slncodigo='$salon'
					order by t.trcrazonsocial asc";
			$res=$conn->query($sql0);
			$i=0;//variable de control color de fondo intercalado de filas
			while($row=$res->fetch_array()){
				$i++;
				if(($i % 2) == 0){

					$reportePdf->SetFillColor(255, 246, 210);
				}
				else{

					$reportePdf->SetFillColor(255);
				}
				$sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
					from btyasistencia_procesada ap 
					join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
					where ap.clbcodigo=".$row['clbcodigo']." 
					and ap.aptcodigo = 2
					and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
					union
					select apt.aptnombre,count(ap.aptcodigo) as cantidad
					from btyasistencia_procesada ap 
					join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
					where ap.clbcodigo=".$row['clbcodigo']." 
					and ap.aptcodigo = 3
					and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
					union
					select apt.aptnombre,count(ap.aptcodigo) as cantidad
					from btyasistencia_procesada ap 
					join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
					where ap.clbcodigo=".$row['clbcodigo']."
					and ap.aptcodigo = 4
					and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
					union
					select apt.aptnombre,count(ap.aptcodigo) as cantidad
					from btyasistencia_procesada ap 
					join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
					where ap.clbcodigo=".$row['clbcodigo']."
					and ap.aptcodigo = 6
					and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
					union
					select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
					from btyasistencia_procesada ap 
					join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
					where ap.clbcodigo=".$row['clbcodigo']."
					and ap.aptcodigo = 5
					and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
					union
					select null,count(*) from btyasistencia_biometrico ab 
					where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
					AND MONTH(ab.abmfecha)=".$mes." and year(ab.abmfecha)=year(curdate())";

				$res3=$conn->query($sql3);
				$detalle="";
				while($deta=$res3->fetch_array()){
					$detalle.=$deta[1].",";
				}
				$det=explode(',',$detalle);
				$reportePdf->Cell(90, 8, $row['trcrazonsocial'], 1, 0, "C", 1);
				$reportePdf->Cell(40, 8, $det[0], 1, 0, "C", 1);
				$reportePdf->Cell(40, 8, $det[1], 1, 0, "C", 1);
				$reportePdf->Cell(35, 8, $det[2], 1, 0, "C", 1);
				$reportePdf->Cell(35, 8, $det[3], 1, 0, "C", 1);
				$reportePdf->Cell(55, 8, $det[4], 1, 0, "C", 1);
				$reportePdf->Cell(35, 8, $det[5], 1, 0, "C", 1);
				$reportePdf->Ln(8);
			}
		}
		//ENCABEZADOS**************************************************

		$reportePdf->Output("Reporte de novedades asistencia.pdf", "I");

	break;
	case "EXCEL":
		require_once '../../lib/phpexcel/Classes/PHPExcel.php';

		$columnas = array("A", "B", "C", "D", "E", "F");
		$i        = 9;
		$reporteExcel = new PHPExcel();
		$reporteExcel->getProperties()
						->setCreator("Beauty ERP")
						->setLastModifiedBy("Beauty ERP")
						->setTitle("Reporte de novedades asistencia")
						->setSubject("Reporte de novedades asistencia")
						->setDescription("Reporte generado a través de Beauty ERP")
						->setKeywords("beauty ERP reporte novedades asistencia")
						->setCategory("reportes");
		$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");

		//Creacion de imagen de cabecera
		$imagenCliente = new PHPExcel_Worksheet_Drawing();
		$imagenCliente->setName("Imagen corporativa");
		$imagenCliente->setDescription("Imagen corporativa");
		$imagenCliente->setCoordinates("A1");
		$imagenCliente->setPath("../../contenidos/imagenes/logo_empresa.jpg");
		$imagenCliente->setHeight(45);
		$imagenCliente->setWorksheet($reporteExcel->getActiveSheet(0));

		$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
		$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte Generado a las ".date("h:i:sA")." del ".date("d-m-Y"));
		foreach($columnas as $columna){
					$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
				}
		foreach ($salones as $salon){
				$sqlns="SELECT sln.slnnombre FROM btysalon sln WHERE sln.slncodigo=$salon";
				$resns=$conn->query($sqlns);
				$slnnom=$resns->fetch_array();
				//Escribir en la hoja Clientes
				$reporteExcel->setActiveSheetIndex(0)->setCellValue("A".$i, utf8_encode($slnnom[0]));
				$i++;
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":F".$i)->getFont()->setBold(true);
				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, "Colaborador")
								->setCellValue("B".$i, "Llegadas Tarde")
								->setCellValue("C".$i, "Salidas Temprano")
								->setCellValue("D".$i, "Ausencias")
								->setCellValue("E".$i, "NO Marcados")
								->setCellValue("F".$i, "Errores");
				$i++;
				$sql0="SELECT distinct(ab.clbcodigo), t.trcrazonsocial
						from btyasistencia_procesada ab
						join btycolaborador c on c.clbcodigo=ab.clbcodigo
						join btytercero t on t.trcdocumento=c.trcdocumento
						where month(ab.prgfecha)='$mes' and year(ab.prgfecha)=year(curdate()) and ab.slncodigo='$salon'
						order by t.trcrazonsocial asc";
				$res=$conn->query($sql0);
				while($row=$res->fetch_array()){
					
					$sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 2
						and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 3
						and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 4
						and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 6
						and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
						union
						select null,count(*) from btyasistencia_biometrico ab 
						where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
						AND MONTH(ab.abmfecha)=".$mes." and year(ab.abmfecha)=year(curdate())";

					$res3=$conn->query($sql3);
					$detalle="";
					while($deta=$res3->fetch_array()){
						$detalle.=$deta[1].",";
					}
					$det=explode(',',$detalle);

					$reporteExcel->setActiveSheetIndex(0)
									->setCellValue("A".$i, utf8_encode($row['trcrazonsocial']))
									->setCellValue("B".$i, $det[0])
									->setCellValue("C".$i, $det[1])
									->setCellValue("D".$i, $det[2])
									->setCellValue("E".$i, $det[3])
									->setCellValue("F".$i, $det[4]);
					$i++;
				}
				$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");
				//FIN ESCRITURA
		$i++;
		}
		//
		//Nombrar a la hoja principal como 'Clientes'
		$reporteExcel->getActiveSheet(0)->setTitle("Novedades");
		$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);
		//Establecer la primera hoja (Clientes) como hoja principal
		$reporteExcel->setActiveSheetIndex(0);
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header('Content-Disposition: attachment; filename="Reporte de Novedades Asistencia - Beauty ERP.xls');
		header('Cache-Control: max-age=0');
		ob_get_clean();
		$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
		if ($_POST["enviox"]==1) 
		{
			$exportarReporte->save("tmp/REPORTE DE ASISTENCIA .xls");
		}
		else
		{
			$exportarReporte->save("php://output");
		}
	break;
	$conn->mysqli_close();
}
?>
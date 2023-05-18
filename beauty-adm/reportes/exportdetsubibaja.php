<?php
include '../../cnx_data.php';
$opc=$_GET['opc'];
$desde=$_GET['f1'];
$hasta=$_GET['f2'];
if($_GET['sln']!='null'){
	$salon=$_GET['sln'];
}else{
	$consln0="SELECT group_concat(slncodigo order by slnnombre) from btysalon";
	$res0=$conn->query($consln0);
	$row0=$res0->fetch_array();
	$salon=$row0[0];
}
$sln=explode(',',$salon);
switch($opc){
	case 'PDF':
		require_once '../../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 10);
				$this->Cell(0, 10, "REPORTE DE USO DE SUBE Y BAJA", 0, 2, 'R');
				$this->Cell(0, 4, "Del ".$_GET['f1']." al ".$_GET['f2'], 0, 2, 'R');
				$this->SetFont("Arial", "", 8);
				$this->Ln(12);
				
			}

			function Footer(){
				$this->SetTextColor(0,0,0);
				$this->SetY(-15);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0, 5, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y")." mediante Beauty Soft ERP", 0, 2, 'C');
			}
		}
		$reportePdf = new PDF();

		$reportePdf->AddPage("P", "legal");
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 9);
		//ENCABEZADOS**************************************************
		foreach ($sln as $sal) {
			$sql1="SELECT sln.slnnombre from btysalon sln where sln.slncodigo=$sal";
			$res1=$conn->query($sql1);
			$row1=$res1->fetch_array();
			$reportePdf->SetFillColor(151, 130, 45);
			$reportePdf->SetTextColor(255);
			$reportePdf->SetFont("Arial", "B", 9);
			$reportePdf->Cell(196, 8, $row1[0], 1, 0, "C", 1);
			$reportePdf->Ln(8);
			$reportePdf->Cell(20, 10, "FECHA", 1, 0, "C", 1);
			$reportePdf->Cell(76, 5, "INICIO", 1, 0, "C", 1);
			$reportePdf->Cell(76, 5, "CIERRE", 1, 0, "C", 1);
			$reportePdf->SetFont("Arial", "B", 6);
			$reportePdf->Cell(24, 10, "COLABORADORES", 1, 0, "C", 1);
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 9);
			$reportePdf->Cell(20, 0, "", 0, 0, "L", 0);
			$reportePdf->Cell(15, 5, "Hora", 1, 0, "C", 1);
			$reportePdf->Cell(61, 5, "Usuario", 1, 0, "C", 1);
			$reportePdf->Cell(15, 5, "Hora", 1, 0, "C", 1);
			$reportePdf->Cell(61, 5, "Usuario", 1, 0, "C", 1);
	
			$reportePdf->Ln(5);
			$reportePdf->SetFont("Arial", "B", 7);
			$sql2="SELECT ca.tuafechai, ta.tuahorai AS horai, ter.trcrazonsocial, 
					(CASE WHEN ta.tuahorai <> ta.tuahoraf THEN ta.tuahoraf END) horaf,
					(CASE WHEN ta.tuahorai <> ta.tuahoraf THEN ter2.trcrazonsocial ELSE 'NO CERRADO'  end) usucierre,
					COUNT(ca.clbcodigo)
					FROM btycola_atencion ca
					JOIN btyturnos_atencion ta ON ta.slncodigo=ca.slncodigo AND ta.tuafechai=ca.tuafechai
					JOIN btyusuario us ON us.usucodigo=ta.usucodigoi
					JOIN btytercero ter ON ter.trcdocumento=us.trcdocumento
					JOIN btyusuario us2 ON us2.usucodigo=ta.usucodigof
					JOIN btytercero ter2 ON ter2.trcdocumento=us2.trcdocumento
					WHERE ca.slncodigo=$sal AND ca.tuafechai BETWEEN '$desde' AND '$hasta'
					GROUP BY ca.tuafechai,ter.trcrazonsocial,ter2.trcrazonsocial";
			$res2=$conn->query($sql2);
			$nr=mysqli_num_rows($res2);
			if($nr>0){
				while($row2=$res2->fetch_array()){
					$i++;
					if(($i % 2) == 0){

						$reportePdf->SetFillColor(255, 246, 210);
					}
					else{

						$reportePdf->SetFillColor(255);
					}
					$reportePdf->SetTextColor(0,0,0);
					$reportePdf->Cell(20, 5, $row2[0], 1, 0, "C", 1);
					$reportePdf->Cell(15, 5, $row2[1], 1, 0, "C", 1);
					$reportePdf->Cell(61, 5, $row2[2], 1, 0, "L", 1);
					$reportePdf->Cell(15, 5, $row2[3], 1, 0, "C", 1);
					$reportePdf->Cell(61, 5, $row2[4], 1, 0, "L", 1);
					$reportePdf->Cell(24, 5, $row2[5], 1, 0, "C", 1);
					$reportePdf->Ln(5);
				}
				/*
					|$sqltotal="SELECT 
							sum(case when nc.esccodigo = 1 then 1 else 0 end) agenfunc,
							sum(case when nc.esccodigo = 2 then 1 else 0 end) agenusu,
							sum(case when nc.esccodigo = 4 then 1 else 0 end) sms,
							sum(case when nc.esccodigo = 5 then 1 else 0 end) email,
							sum(case when nc.esccodigo = 6 then 1 else 0 end) tel,
							sum(case when nc.esccodigo = 7 then 1 else 0 end) reprog,
							sum(case when nc.esccodigo = 9 then 1 else 0 end) inas,
							sum(case when nc.esccodigo = 3 then 1 else 0 end) cancel,
							sum(case when nc.esccodigo = 8 then 1 else 0 end) atend
							FROM btycita ct
							JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo
							JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo
							WHERE ct.slncodigo=$sal
							AND ct.citfecha BETWEEN '$desde' AND '$hasta'";
					$restot=$conn->query($sqltotal);
					$rowtot=$restot->fetch_array();
					$i++;
					if(($i % 2) == 0){

							$reportePdf->SetFillColor(255, 246, 210);
						}
						else{

							$reportePdf->SetFillColor(255);
						}
						$reportePdf->Cell(80, 5, "TOTAL", 1, 0, "R", 1);
						$reportePdf->Cell(25, 5, $rowtot[0], 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, $rowtot[1], 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, $rowtot[2], 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, $rowtot[3], 1, 0, "C", 1);
						$reportePdf->Cell(25, 5, $rowtot[4], 1, 0, "C", 1);
						$reportePdf->Cell(34, 5, $rowtot[5], 1, 0, "C", 1);
						$reportePdf->Cell(30, 5, $rowtot[6], 1, 0, "C", 1);
						$reportePdf->Cell(30, 5, $rowtot[7], 1, 0, "C", 1);
						$reportePdf->Cell(35, 5, $rowtot[8], 1, 0, "C", 1);
*/
			}else{
				$reportePdf->SetFillColor(255);
				$reportePdf->SetTextColor(0,0,0);
				$reportePdf->Cell(334, 5, "No hay datos", 1, 0, "C", 1);
			}
			$i=0;
			
			$reportePdf->Ln(15);
		}
		$reportePdf->Output("Reporte de sube y baja.pdf", "I");
	break;
	case 'XLS':
		require_once '../../lib/phpexcel/Classes/PHPExcel.php';

			$fechaGenerado           = date("d-m-Y");
			$horaGenerado            = date("h:i:s a");

			$columnas = array("A", "B", "C", "D", "E", "F");

			$reporteExcel = new PHPExcel();
			$reporteExcel->getProperties()
							->setCreator("Beauty ERP")
							->setLastModifiedBy("Beauty ERP")
							->setTitle("Reporte de Servicios agendados por salon")
							->setSubject("Reporte de Servicios agendados por salon")
							->setDescription("Reporte generado a través de Beauty ERP")
							->setKeywords("beauty ERP reporte Servicios agendados por salon")
							->setCategory("reportes");
			//Creacion de imagen de cabecera
			$imagenSalon = new PHPExcel_Worksheet_Drawing();
			$imagenSalon->setName("Imagen corporativa");
			$imagenSalon->setDescription("Imagen corporativa");
			$imagenSalon->setCoordinates("A1");
			$imagenSalon->setPath("../../contenidos/imagenes/logo_empresa.jpg");
			$imagenSalon->setHeight(70);
			$imagenSalon->setWorksheet($reporteExcel->getActiveSheet(0));

			$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

			//Escribir en la hoja 
			$i=8;
			foreach ($sln as $sal) {
				$sql1="SELECT sln.slnnombre from btysalon sln where sln.slncodigo=$sal";
				$res1=$conn->query($sql1);
				$row1=$res1->fetch_array();
				$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":F".$i);
				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, $row1[0]);
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getFont()->setBold(true);
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$i++;
				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, "Fecha")
								->setCellValue("B".$i, "Hora Inicio")
								->setCellValue("C".$i, "Usuario Inicio")
								->setCellValue("D".$i, "Hora Cierre")
								->setCellValue("E".$i, "Usuario Cierre")
								->setCellValue("F".$i, "Colaboradores");
				$reporteExcel->getActiveSheet(0)->getStyle("A".$i.":F".$i)->getFont()->setBold(true);
				$i++;
				$sql2="SELECT ca.tuafechai, ta.tuahorai AS horai, ter.trcrazonsocial, 
					(CASE WHEN ta.tuahorai <> ta.tuahoraf THEN ta.tuahoraf END) horaf,
					(CASE WHEN ta.tuahorai <> ta.tuahoraf THEN ter2.trcrazonsocial ELSE 'NO CERRADO'  end) usucierre,
					COUNT(ca.clbcodigo)
					FROM btycola_atencion ca
					JOIN btyturnos_atencion ta ON ta.slncodigo=ca.slncodigo AND ta.tuafechai=ca.tuafechai
					JOIN btyusuario us ON us.usucodigo=ta.usucodigoi
					JOIN btytercero ter ON ter.trcdocumento=us.trcdocumento
					JOIN btyusuario us2 ON us2.usucodigo=ta.usucodigof
					JOIN btytercero ter2 ON ter2.trcdocumento=us2.trcdocumento
					WHERE ca.slncodigo=$sal AND ca.tuafechai BETWEEN '$desde' AND '$hasta'
					GROUP BY ca.tuafechai,ter.trcrazonsocial,ter2.trcrazonsocial";
				$res2=$conn->query($sql2);
				$numrow=mysqli_num_rows($res2);
				if($numrow>0){
					while($row2=$res2->fetch_array()){		
						$reporteExcel->setActiveSheetIndex(0)
										->setCellValue("A".$i, $row2[0])
										->setCellValue("B".$i, $row2[1])
										->setCellValue("C".$i, utf8_encode($row2[2]))
										->setCellValue("D".$i, $row2[3])
										->setCellValue("E".$i, utf8_encode($row2[4]))
										->setCellValue("F".$i, $row2[5]);
						$i++;
					}
					$i=$i+2;		
				}else{
					$reporteExcel->getActiveSheet(0)->mergeCells("A".$i.":F".$i);
					$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, "********** NO HAY DATOS **********");	
					$reporteExcel->getActiveSheet(0)->getStyle("A".$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$i=$i+2;
				}
			}

			foreach($columnas as $columna){

				$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
			}
			
			$reporteExcel->getActiveSheet()->getStyle('B8:J2000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$reporteExcel->getActiveSheet(0)->setTitle("Uso Sube y baja");

			$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

			$reporteExcel->setActiveSheetIndex(0);

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header('Content-Disposition: attachment; filename="Reporte de uso de sube y baja  - Beauty ERP.xls');
			header('Cache-Control: max-age=0');
			ob_get_clean();
			$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
			if ($_POST["enviox"]==1) {
				$exportarReporte->save("tmp/Reporte de uso de sube y baja ".$_SESSION['user_session'].".xls");
			}else{
			$exportarReporte->save("php://output");
			}

	break;
}
?>
<?php

//////////////////////////////////////*
$fecha1=$_GET['f1'];
$fecha2=$_GET['f2'];
$cg=$_GET['cg'];
$opc=$_GET['opc'];
if($cg!=0){
	$cargo=" and cg.crgcodigo IN ($cg)";
}else{
	$cargo="";
}

$sln='';
if(isset($_GET['sln'])){
    $sln=" and ab.slncodigo=".$_GET['sln'];
    $txtsl=$_GET['txtsl'];
}
include '../../cnx_data.php';


switch($opc){
	case 'PDF':

		require_once '../../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 10);
				$this->Cell(0, 10, "REPORTE DE ASISTENCIA ".$_GET['txtsl']." Del ".$_GET['f1']." al ".$_GET['f2'], 0, 2, 'R');
				$this->SetFont("Arial", "", 8);
				$this->Ln(12);
				
			}

			function Footer(){

				$this->SetY(-13);
				$this->SetFont('Arial','I',8);
				$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
				$this->Cell(0, 5, "Generado a las ".date("h:i:sA")." del ".date("d-m-Y")." mediante Beauty Soft ERP", 0, 2, 'C');
			}
		}
		$reportePdf = new PDF();

		$reportePdf->AddPage("L", "legal");
		$reportePdf->SetFillColor(151, 130, 45);
		$reportePdf->SetTextColor(255);
		$reportePdf->SetFont("Arial", "B", 8);
		//ENCABEZADOS**************************************************
		$reportePdf->Cell(75, 6, "COLABORADOR", 1, 0, "C", 1);
		$reportePdf->Cell(35, 6, "SALON BASE", 1, 0, "C", 1);
		$reportePdf->Cell(30, 6, "LLEGADA TARDE", 1, 0, "C", 1);
		$reportePdf->Cell(30, 6, "SALIDA TEMPRANO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "AUSENCIA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "INCOMPLETO", 1, 0, "C", 1);
		$reportePdf->Cell(50, 6, "PRESENCIA NO PROGRAMADA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "ERROR", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "NOVEDADES", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "PERMISOS", 1, 0, "C", 1);
		$reportePdf->Cell(15, 6, "VALOR", 1, 0, "C", 1);
		//color, tipo y tamaño de letra
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 7);
		//fin color, tipo y tamaño de letra
		//FIN ENCABEZADOS**********************************************
		$reportePdf->Ln(6);

		$sql="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre,sl.slnnombre
			from btyasistencia_procesada ab
			join btycolaborador c on c.clbcodigo=ab.clbcodigo
			join btytercero t on t.trcdocumento=c.trcdocumento
			join btycargo cg on cg.crgcodigo=c.crgcodigo
			join btysalon_base_colaborador sbc on sbc.clbcodigo=c.clbcodigo
			join btysalon sl on sl.slncodigo=sbc.slncodigo
			where ab.prgfecha between '$fecha1' and '$fecha2' and sbc.slchasta is null".$sln.$cargo."
			order by t.trcrazonsocial asc";
		$res=$conn->query($sql);
		$numrow=mysqli_num_rows($res);
		$i=0;
		$it=0;$st=0;$au=0;$pnp=0;$err=0;$inc=0;$nov=0;$per=0;
		if($numrow>0){
			while($row=$res->fetch_array()){
			$sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 2
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 3
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 4
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 6
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 5
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select null,count(*) from btyasistencia_biometrico ab 
						where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
						AND ab.abmfecha between '$fecha1' and '$fecha2'
						union
	                    SELECT 'VALOR',concat('$',format(sum(ap.apcvalorizacion),0))
	                    FROM btyasistencia_procesada ap
	                    WHERE ap.clbcodigo=".$row['clbcodigo']." AND ap.prgfecha BETWEEN '$fecha1' and '$fecha2'
						union
						select 'NOVEDADES',count(*) 
						from btynovedades_programacion_detalle pd
						natural join btynovedades_programacion np
						where pd.clbcodigo=".$row['clbcodigo']." and np.nvpfechadesde between '$fecha1' and '$fecha2'
						union
						select 'PERMISOS',ifnull(count(*),0) as cper
						from btypermisos_colaboradores pc 
						where pc.clbcodigo=".$row['clbcodigo']." AND ((pc.perfecha_desde between '$fecha1' and '$fecha2') or (pc.perfecha_hasta between '$fecha1' and '$fecha2'))  and pc.perestado='AUTORIZADO'";
				$res3=$conn->query($sql3);
				$detalle="";
				while($deta=$res3->fetch_array()){
					$detalle.=$deta[1]."•";
				}
				$det=explode('•',$detalle);
				$i++;
				if(($i % 2) == 0){
					$reportePdf->SetFillColor(255, 246, 210);
				}
				else{
					$reportePdf->SetFillColor(255);
				}
				$reportePdf->Cell(75, 5, $row[1]."  (".$row[2].")", 1, 0, "L", 1);
				$reportePdf->Cell(35, 5, $row[3], 1, 0, "C", 1);
				$reportePdf->Cell(30, 5, $det[0], 1, 0, "C", 1);$it+= $det[0];
				$reportePdf->Cell(30, 5, $det[1], 1, 0, "C", 1);$st+= $det[1];
				$reportePdf->Cell(20, 5, $det[2], 1, 0, "C", 1);$au+= $det[2];
				$reportePdf->Cell(20, 5, $det[3], 1, 0, "C", 1);$inc+=$det[3];
				$reportePdf->Cell(50, 5, $det[4], 1, 0, "C", 1);$pnp+=$det[4];
				$reportePdf->Cell(20, 5, $det[5], 1, 0, "C", 1);$err+=$det[5];
				$reportePdf->Cell(20, 5, $det[7], 1, 0, "C", 1);$nov+=$det[7];
				$reportePdf->Cell(20, 5, $det[8], 1, 0, "C", 1);$per+=$det[8];
				$reportePdf->Cell(15, 5, $det[6], 1, 0, "R", 1);
				$reportePdf->Ln(5);
			}	
				$i++;
				if(($i % 2) == 0){
					$reportePdf->SetFillColor(255, 246, 210);
				}
				else{
					$reportePdf->SetFillColor(255);
				}
					$reportePdf->SetFont("Arial", "B", 10);
					$reportePdf->Cell(110, 5, "TOTALES", 1, 0, "C", 1);
					$reportePdf->Cell(30, 5, $it, 1, 0, "C", 1);
					$reportePdf->Cell(30, 5, $st, 1, 0, "C", 1);
					$reportePdf->Cell(20, 5, $au, 1, 0, "C", 1);
					$reportePdf->Cell(20, 5, $inc, 1, 0, "C", 1);
					$reportePdf->Cell(50, 5, $pnp, 1, 0, "C", 1);
					$reportePdf->Cell(20, 5, $err, 1, 0, "C", 1);
					$reportePdf->Cell(20, 5, $nov, 1, 0, "C", 1);
					$reportePdf->Cell(20, 5, $per, 1, 0, "C", 1);
					$reportePdf->Cell(15, 5,"" , 1, 0, "R", 1);
					$reportePdf->Ln(5);
			$i++;
			if(($i % 2) == 0){
				$reportePdf->SetFillColor(255, 246, 210);
			}
			else{
				$reportePdf->SetFillColor(255);
			}
			$sqltotal="SELECT concat('$',format(SUM(ab.apcvalorizacion),0))
						FROM btyasistencia_procesada ab
						JOIN btycolaborador c ON c.clbcodigo=ab.clbcodigo
						JOIN btytercero t ON t.trcdocumento=c.trcdocumento
						JOIN btycargo cg ON cg.crgcodigo=c.crgcodigo
						WHERE ab.prgfecha BETWEEN '$fecha1' AND '$fecha2'".$sln.$cargo;
			$restotal=$conn->query($sqltotal);
			$rowtotal=$restotal->fetch_array();
			$reportePdf->SetFont("Arial", "B", 10);
			$reportePdf->Cell(300, 5, "TOTAL VALORIZACION", 1, 0, "R", 1);
			$reportePdf->Cell(35, 5, $rowtotal[0], 1, 0, "R", 1);
		}
		$reportePdf->Output("Reporte general de asistencia.pdf", "I");

	break;

	case 'XLS':

			require_once '../../lib/phpexcel/Classes/PHPExcel.php';

			$fechaGenerado           = date("d-m-Y");
			$horaGenerado            = date("h:i:s a");

			$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I");
			$i        = 9;

			$reporteExcel = new PHPExcel();
			$reporteExcel->getProperties()
							->setCreator("Beauty ERP")
							->setLastModifiedBy("Beauty ERP")
							->setTitle("Reporte de salones")
							->setSubject("Reporte de asistencia")
							->setDescription("Reporte generado a través de Beauty ERP")
							->setKeywords("beauty ERP reporte asistencia")
							->setCategory("reportes");
			$reporteExcel->getActiveSheet(0)->mergeCells("A1:C4");
			//Creacion de imagen de cabecera
			$imagenSalon = new PHPExcel_Worksheet_Drawing();
			$imagenSalon->setName("Imagen corporativa");
			$imagenSalon->setDescription("Imagen corporativa");
			$imagenSalon->setCoordinates("A1");
			$imagenSalon->setPath("../../contenidos/imagenes/logo_empresa.jpg");
			$imagenSalon->setHeight(35);
			$imagenSalon->setWorksheet($reporteExcel->getActiveSheet(0));

			$reporteExcel->getActiveSheet(0)->getStyle("A5")->getFont()->setBold(true);
			$reporteExcel->setActiveSheetIndex(0)->setCellValue("A5", "Reporte generado el día ".$fechaGenerado." a las ".$horaGenerado);

			//Escribir en la hoja Salones
			$reporteExcel->setActiveSheetIndex(0)
							->setCellValue("A8", "Colaborador")
							->setCellValue("B8", "Salon")
							->setCellValue("C8", "Llegada tarde")
							->setCellValue("D8", "Salida temprano")
							->setCellValue("E8", "Ausencia")
							->setCellValue("F8", "Incompleto")
							->setCellValue("G8", "Presencia No programada")
							->setCellValue("H8", "Errores")
							->setCellValue("I8", "Novedades")
							->setCellValue("J8", "Permisos")
							->setCellValue("K8", "Valor");

			foreach($columnas as $columna){

				$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
			}

			$reporteExcel->getActiveSheet(0)->getStyle("A8:K8")->getFont()->setBold(true);

			$sql="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre,sl.slnnombre
				from btyasistencia_procesada ab
				join btycolaborador c on c.clbcodigo=ab.clbcodigo
				join btytercero t on t.trcdocumento=c.trcdocumento
				join btycargo cg on cg.crgcodigo=c.crgcodigo
				join btysalon_base_colaborador sbc on sbc.clbcodigo=c.clbcodigo
				join btysalon sl on sl.slncodigo=sbc.slncodigo
				where ab.prgfecha between '$fecha1' and '$fecha2' and sbc.slchasta is null".$sln.$cargo."
				order by t.trcrazonsocial asc";
				echo $sql;
			$res=$conn->query($sql);
			$numrow=mysqli_num_rows($res);
			$i=9;
			if($numrow>0){
				while($row=$res->fetch_array()){
				$sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 2
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']." 
						and ap.aptcodigo = 3
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 4
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(ap.aptcodigo) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 6
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
						from btyasistencia_procesada ap 
						join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
						where ap.clbcodigo=".$row['clbcodigo']."
						and ap.aptcodigo = 5
						AND ap.prgfecha between '$fecha1' and '$fecha2'
						union
						select null,count(*) from btyasistencia_biometrico ab 
						where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
						AND ab.abmfecha between '$fecha1' and '$fecha2'
						union
	                    SELECT 'VALOR',concat('$',format(sum(ap.apcvalorizacion),0))
	                    FROM btyasistencia_procesada ap
	                    WHERE ap.clbcodigo=".$row['clbcodigo']." AND ap.prgfecha BETWEEN '$fecha1' and '$fecha2'
	                    union
						select 'NOVEDADES',count(*) 
						from btynovedades_programacion_detalle pd
						natural join btynovedades_programacion np
						where pd.clbcodigo=".$row['clbcodigo']." and np.nvpfechadesde between '$fecha1' and '$fecha2'
						union
						select 'PERMISOS',ifnull(count(*),0) as cper
						from btypermisos_colaboradores pc 
						where pc.clbcodigo=".$row['clbcodigo']." AND ((pc.perfecha_desde between '$fecha1' and '$fecha2') or (pc.perfecha_hasta between '$fecha1' and '$fecha2'))  and pc.perestado='AUTORIZADO'";

				$res3=$conn->query($sql3);
				$detalle="";
				while($deta=$res3->fetch_array()){
					$detalle.=$deta[1]."•";
				}
				$det=explode('•',$detalle);

				
				$reporteExcel->setActiveSheetIndex(0)
								->setCellValue("A".$i, utf8_encode($row[1]."  (".$row[2].")"))
								->setCellValue("B".$i, $row[3])
								->setCellValue("C".$i, $det[0])
								->setCellValue("D".$i, $det[1])
								->setCellValue("E".$i, $det[2])
								->setCellValue("F".$i, $det[3])
								->setCellValue("G".$i, $det[4])
								->setCellValue("H".$i, $det[5])
								->setCellValue("I".$i, $det[7])
								->setCellValue("J".$i, $det[8])
								->setCellValue("K".$i, $det[6]);
				$i++;

		
				}		
			}
			$reporteExcel->getActiveSheet()->getStyle('I9:I1000')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$reporteExcel->getActiveSheet(0)->mergeCells("A1:C1");


			$reporteExcel->getActiveSheet(0)->setTitle("Asistencia");

			$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

			//Establecer la primera hoja (Salones) como hoja principal
			$reporteExcel->setActiveSheetIndex(0);

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header('Content-Disposition: attachment; filename="Reporte de Asistencia general - Beauty ERP.xls');
			header('Cache-Control: max-age=0');
			ob_get_clean();
			$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
			if ($_POST["enviox"]==1) {
				//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
				$exportarReporte->save("tmp/Reporte de Salones ".$_SESSION['user_session'].".xls");
			}else{
			$exportarReporte->save("php://output");
			}

	break;
}

          


?>
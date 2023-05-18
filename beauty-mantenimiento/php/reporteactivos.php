<?php
$opc=$_GET['opc'];

include '../../cnx_data.php';

switch($opc){
	case 'PDF':

		require_once '../../lib/fpdf/fpdf.php';

		class PDF extends FPDF{

			function Header(){

				$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 70);
				$this->SetFont("Arial", "B", 10);
				$this->Cell(0, 10, "REPORTE GENERAL DE ACTIVOS", 0, 2, 'R');
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
		$reportePdf->SetFont("Arial", "B", 5);
		//ENCABEZADOS**************************************************
		$reportePdf->Cell(8, 6, "COD", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "NOMBRE", 1, 0, "C", 1);
		$reportePdf->Cell(15, 6, "MARCA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "MODELO", 1, 0, "C", 1);
		$reportePdf->Cell(22, 6, "ESPECIFICACIONES", 1, 0, "C", 1);
		$reportePdf->Cell(15, 6, "GENERICO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "SERIAL", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "DESCRIPCION", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "FECHA COMPRA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "USADO DESDE", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "PROVEEDOR", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "FABRICANTE", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "PAIS", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "CODIGO EXT", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "COSTO BASE", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "IMPUESTOS", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "TIPO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "SUBTIPO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "GRUPO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "SUBGRUPO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "ETIQUETADO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "UBICACION", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "AREA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "MANTENIMIENTO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "FRECUENCIA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "REVISION", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "FRECUENCIA", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "PRIORIDAD", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "GARANTIA TIEMPO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "CANT", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "UNIDAD", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "GARANTIA USO", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "CANT", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "UNIDAD", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "INSUMOS", 1, 0, "C", 1);
		$reportePdf->Cell(20, 6, "REPUESTOS", 1, 0, "C", 1);
		//color, tipo y tamaño de letra
		$reportePdf->SetTextColor(0);
		$reportePdf->SetFont("Arial", "", 7);
		//fin color, tipo y tamaño de letra
		//FIN ENCABEZADOS**********************************************
		$reportePdf->Ln(6);

		/*$sql="";
		$res=$conn->query($sql);
		$numrow=mysqli_num_rows($res);
		$i=0;
		if($numrow>0){
			while($row=$res->fetch_array()){
			
				$i++;
				if(($i % 2) == 0){
					$reportePdf->SetFillColor(255, 246, 210);
				}
				else{
					$reportePdf->SetFillColor(255);
				}
				$reportePdf->Cell(75, 5, $row[0], 1, 0, "L", 1);
				$reportePdf->Cell(35, 5, $row[3], 1, 0, "C", 1);
				$reportePdf->Cell(30, 5, $row[0], 1, 0, "C", 1);
				$reportePdf->Cell(30, 5, $row[1], 1, 0, "C", 1);
				$reportePdf->Cell(20, 5, $row[2], 1, 0, "C", 1);
				$reportePdf->Cell(20, 5, $row[3], 1, 0, "C", 1);
				$reportePdf->Cell(50, 5, $row[4], 1, 0, "C", 1);
				$reportePdf->Cell(20, 5, $row[5], 1, 0, "C", 1);
				$reportePdf->Cell(20, 5, $row[7], 1, 0, "C", 1);
				$reportePdf->Cell(20, 5, $row[8], 1, 0, "C", 1);
				$reportePdf->Cell(15, 5, $row[6], 1, 0, "R", 1);
				$reportePdf->Ln(5);
			}	
		}*/
		$reportePdf->Output("Reporte general de Activos.pdf", "I");

	break;

	case 'XLS':

			require_once '../../lib/phpexcel/Classes/PHPExcel.php';

			$fechaGenerado           = date("d-m-Y");
			$horaGenerado            = date("h:i:s a");

			$columnas = array("A", "B", "C", "D", "E", "F", "G", "H", "I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ");
			$i        = 9;

			$reporteExcel = new PHPExcel();
			$reporteExcel->getProperties()
							->setCreator("Beauty ERP")
							->setLastModifiedBy("Beauty ERP")
							->setTitle("Reporte de activos")
							->setSubject("Reporte de activos")
							->setDescription("Reporte generado a través de Beauty ERP")
							->setKeywords("beauty ERP reporte activos")
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

			//Escribir en la hoja Activos
			$reporteExcel->setActiveSheetIndex(0)
							->setCellvalue("A8", "COD")
							->setCellvalue("B8", "NOMBRE")
							->setCellvalue("C8", "MARCA")
							->setCellvalue("D8", "MODELO")
							->setCellvalue("E8", "ESPECIFICACIONES")
							->setCellvalue("F8", "GENERICO")
							->setCellvalue("G8", "SERIAL")
							->setCellvalue("H8", "DESCRIPCION")
							->setCellvalue("I8", "FECHA COMPRA")
							->setCellvalue("J8", "USADO DESDE")
							->setCellvalue("K8", "PROVEEDOR")
							->setCellvalue("L8", "FABRICANTE")
							->setCellvalue("M8", "PAIS")
							->setCellvalue("N8", "CODIGO EXT")
							->setCellvalue("O8", "COSTO BASE")
							->setCellvalue("P8", "IMPUESTOS")
							->setCellvalue("Q8", "TIPO")
							->setCellvalue("R8", "SUBTIPO")
							->setCellvalue("S8", "GRUPO")
							->setCellvalue("T8", "SUBGRUPO")
							->setCellvalue("U8", "ETIQUETADO")
							->setCellvalue("V8", "UBICACION")
							->setCellvalue("W8", "AREA")
							->setCellvalue("X8", "MANTENIMIENTO")
							->setCellvalue("Y8", "FRECUENCIA")
							->setCellvalue("Z8", "REVISION")
							->setCellvalue("AA8", "FRECUENCIA")
							->setCellvalue("AB8", "PRIORIDAD")
							->setCellvalue("AC8", "GARANTIA TIEMPO")
							->setCellvalue("AD8", "CANT")
							->setCellvalue("AE8", "UNIDAD")
							->setCellvalue("AF8", "GARANTIA USO")
							->setCellvalue("AG8", "CANT")
							->setCellvalue("AH8", "UNIDAD")
							->setCellvalue("AI8", "INSUMOS")
							->setCellvalue("AJ8", "REPUESTOS");

			foreach($columnas as $columna){

				$reporteExcel->getActiveSheet(0)->getColumnDimension($columna)->setAutoSize(true);
			}

			$reporteExcel->getActiveSheet(0)->getStyle("A8:AJ8")->getFont()->setBold(true);
			$sql="SELECT a.actcodigo,a.actnombre,m.marnombre,a.actmodelo,a.actespecificaciones, IF(a.actgenerico=1,'SI','NO') AS gen, IFNULL(a.actserial,'N/D') AS serial,a.actdescripcion, IFNULL(a.actfechacompra,'N/A') AS fecom, IFNULL(a.actfechainicio,'N/A') AS feiniuso,t.trcrazonsocial,f.fabnombre,pa.painombre, IFNULL(a.actcodigoexterno,'N/D') AS codext,a.actcosto_base,a.actcosto_impuesto,tp.tianombre,st.sbtnombre,g.granombre,sg.sbganombre,sg.sbgubicacionetiqueta,lg.lugnombre,ar.arenombre, IF(a.actreq_mant_prd=1,'SI','NO') AS rqmtto,if(a.actfreq_mant=0,'N/A',concat(a.actfreq_mant,' dias')) as freqm, IF(a.actreq_rev_prd=1,'SI','NO') AS rqrev,if(a.actfreq_rev=0,'N/A',concat(a.actfreq_rev,' dias')) as freqr,pri.pranombre, IF(a.actgtia_tiempo=1,'SI','NO') AS garant, IF(a.actgtia_tiempo_valor=0,'N/A',a.actgtia_tiempo_valor) AS time_gar, IF(a.unacodigo_tiempo=0,'N/A',un1.unanombre) AS unigarti, IF(a.actgtia_uso=1,'SI','NO') AS garanu, IF(a.actgtia_uso_valor=0,'N/A',a.actgtia_uso_valor) AS uso_gar, IF(a.unacodigo_uso=0,'N/A',un2.unanombre) AS unigaruso, IF(a.actreq_insumos=1,'SI','NO') AS ins, IF(a.actreq_repuestos=1,'SI','NO') AS rep
				FROM btyactivo a
				JOIN btyactivo_marca m ON m.marcodigo=a.marcodigo
				JOIN btyproveedor p ON p.prvcodigo=a.prvcodigo
				JOIN btytercero t ON t.trcdocumento=p.trcdocumento
				JOIN btyactivo_fabricante f ON f.fabcodigo=a.fabcodigo
				JOIN btypais pa ON pa.paicodigo=a.paicodigo
				JOIN btyactivo_subgrupo sg ON sg.sbgcodigo=a.sbgcodigo
				JOIN btyactivo_grupo g ON g.gracodigo=sg.gracodigo
				JOIN btyactivo_subtipo st ON st.sbtcodigo=g.sbtcodigo
				JOIN btyactivo_tipo tp ON tp.tiacodigo=st.tiacodigo
				JOIN btyactivo_ubicacion u ON u.actcodigo=a.actcodigo AND u.ubchasta IS NULL
				JOIN btyactivo_area ar ON ar.arecodigo=u.arecodigo
				JOIN btyactivo_lugar lg ON lg.lugcodigo=ar.lugcodigo
				JOIN btyactivo_prioridad pri ON pri.pracodigo=a.pracodigo
				JOIN btyactivo_unidad un1 ON un1.unacodigo=a.unacodigo_tiempo
				JOIN btyactivo_unidad un2 ON un2.unacodigo=a.unacodigo_uso
				WHERE a.actestado=1 order by a.actcodigo";
			$res=$conn->query($sql);
			$i=9;
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
				
				   $reporteExcel->setActiveSheetIndex(0)
								->setCellvalue("A".$i,$row[0])
								->setCellvalue("B".$i,$row[1])
								->setCellvalue("C".$i,$row[2])
								->setCellvalue("D".$i,$row[3])
								->setCellvalue("E".$i,$row[4])
								->setCellvalue("F".$i,$row[5])
								->setCellvalue("G".$i,$row[6])
								->setCellvalue("H".$i,$row[7])
								->setCellvalue("I".$i,$row[8])
								->setCellvalue("J".$i,$row[9])
								->setCellvalue("K".$i,$row[10])
								->setCellvalue("L".$i,$row[11])
								->setCellvalue("M".$i,$row[12])
								->setCellvalue("N".$i,$row[13])
								->setCellvalue("O".$i,$row[14])
								->setCellvalue("P".$i,$row[15])
								->setCellvalue("Q".$i,$row[16])
								->setCellvalue("R".$i,$row[17])
								->setCellvalue("S".$i,$row[18])
								->setCellvalue("T".$i,$row[19])
								->setCellvalue("U".$i,$row[20])
								->setCellvalue("V".$i,$row[21])
								->setCellvalue("W".$i,$row[22])
								->setCellvalue("X".$i,$row[23])
								->setCellvalue("Y".$i,$row[24])
								->setCellvalue("Z".$i,$row[25])
								->setCellvalue("AA".$i,$row[26])
								->setCellvalue("AB".$i,$row[27])
								->setCellvalue("AC".$i,$row[28])
								->setCellvalue("AD".$i,$row[29])
								->setCellvalue("AE".$i,$row[30])
								->setCellvalue("AF".$i,$row[31])
								->setCellvalue("AG".$i,$row[32])
								->setCellvalue("AH".$i,$row[33])
								->setCellvalue("AI".$i,$row[34])
								->setCellvalue("AJ".$i,$row[35]);
						$i++;
				}		
			}
			


			$reporteExcel->getActiveSheet(0)->setTitle("Activos");

			$reporteExcel->getActiveSheet(0)->getStyle("A1")->getFont()->setBold(true);

			//Establecer la primera hoja (Salones) como hoja principal
			$reporteExcel->setActiveSheetIndex(0);

			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header('Content-Disposition: attachment; filename="Reporte general de activos - Beauty ERP.xls');
			header('Cache-Control: max-age=0');
			ob_get_clean();
			$exportarReporte = PHPExcel_IOFactory::createWriter($reporteExcel, "Excel5");
			if ($_POST["enviox"]==1) {
				//echo "Se ha generado exitosamente su archivo de Excel con su nombre de usuario";
				$exportarReporte->save("tmp/Reporte general de activos ".$_SESSION['user_session'].".xls");
			}else{
			$exportarReporte->save("php://output");
			}

	break;
}




?>
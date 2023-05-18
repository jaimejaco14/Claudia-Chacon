<?php
	require_once '../../lib/fpdf/fpdf.php';
	include '../../cnx_data.php';

	$fechaGenerado    = date("d-m-Y");
	$horaGenerado     = date("h:i:s a");

	

		class ReportPdf extends FPDF
		{

				function Header()
				{

					$this->Image('../../contenidos/imagenes/logo_empresa.jpg', 10, 10, 60);
					$this->SetFont("Arial", "B", 8);
					$this->Cell(0, 5, "REPORTE DE PERMISOS", 0, 2, 'C');
					$this->Ln(0);
					//$this->Cell(0, 5, "COLABORADOR: ".$_SESSION['colaborador']." ", 0, 2, 'R');
					//$this->Cell(0, 8, "Generado a las ".date("h:i:s A")." del ".$_SESSION['fechaactual'], 0, 2, 'R');
				}

				function Footer()
				{

					$this->SetY(-12);
					$this->SetFont('Arial','',8);
					$this->Cell(0,5,utf8_decode('Página ').$this->PageNo(), 0, 2,'C');
					$this->Cell(0,5,"Generado mediante el sistema Beauty Soft ERP a las ".date("H:i:s"), 0, 2,'C');
				}

				function Tabla($header,$datos,$w,$al)
				{

					$this->SetFillColor(151, 130, 45);
					$this->SetTextColor(255);
					$this->SetDrawColor(0,0,0);
					$this->SetLineWidth(.1);
					$this->SetFont('','',7);

					
					for($i=0;$i<count($header);$i++){
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
					    	
						  
						  for($i=0;$i<count($header);$i++){
						  
						    
						    $this->Cell($w[$i],6,utf8_decode($row[$i]),'LR',0,$al[$i],$Relleno);
								
						   }
						   $this->Ln();
						   $Relleno=!$Relleno;
						   	$j++;
							
							if($j==$k){	
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

							
								for($i=0;$i<count($header);$i++){
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
		$reportePdf->AddPage("L", "legal");
		mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );
		mysqli_set_charset($conn, "utf8");

		$estado = $_GET['estado'];
		$f1 = $_GET['fechaini'];
		$f2 = $_GET['fechafin'];
		$col = $_GET['colaborador'];

		
		if ($_GET['estado'] == "REGISTRADO" || $_GET['estado'] == "AUTORIZADO" || $_GET['estado'] == "NO AUTORIZADO" AND $_GET['fechaini'] == "") 
		{			

			$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.perestado_tramite = '$estado'";


			
		}
		else
		{
			if ($_GET['estado'] == 0  AND $_GET['fechaini'] != "" AND $_GET['fechafin'] != "") 
			{
					$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.perfecha_desde >= '".$_GET['fechaini']."' AND p.perfecha_hasta <= '".$_GET['fechafin']."' ";

					
			}
			else
			{
				if ($_GET['colaborador'] == 0  AND $_GET['fechaini'] == "" AND $_GET['fechafin'] == "" AND $_GET['colaborador'] != "") 
				{
					$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND t.trcrazonsocial LIKE '%$col%' ";
				}
				else
				{
					if ($_GET['colaborador'] == 0  AND $_GET['fechaini'] == "" AND $_GET['fechafin'] == "" AND $_GET['colaborador'] == "")
					{
						$sql = "SELECT p.percodigo, CONCAT(t.trcnombres, ' ', t.trcapellidos) AS col, CONCAT(p.perfecha_desde, ' - ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' - ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, t2.trcrazonsocial AS usu_aut, p.perobservacion_registro, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, ' ', p.perhora_autorizacion) END AS fecha_autori, p.perestado_tramite AS estado_tramite, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) END AS fecha_autori, p.clbcodigo, p.perobservacion_registro FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 ";
					}
				}
				
			}
		}



			$query = mysqli_query($conn, $sql);

		
			$reportePdf->SetFont('helvetica','B',10);
			$reportePdf->Ln(9);

		   
		    $EncabezadoColumnas=array(utf8_decode('Cód'), 'Colaborador', 'Permiso Desde','Permiso Hasta','Usuario Registro', 'Usuario Autoriza', 'Observaciones Registro', 'Fecha Autoriza', 'Estado');

		  	$AnchoColumnas = array(7,50,26,26,50,50,75,25,26);
			 
		    $AlineacionColumnas=array('R','L','L','L','L','L','L', 'L', 'C', 'L');
		    $reportePdf->Tabla($EncabezadoColumnas,$query,$AnchoColumnas,$AlineacionColumnas);
		    $reportePdf->SetFont('helvetica','B',11);

		    function utf8_converter($array)
			{
				array_walk_recursive($array, function(&$item, $key){
					if(!mb_detect_encoding($item, 'utf-8', true)){
						$item = utf8_encode($item);
					}
				});

				return $array;
			}

			$sql= utf8_converter($query);

			$reportePdf->Output("REPORTE DE PERMISOS.pdf", "I");


			mysqli_close($conn);

?>
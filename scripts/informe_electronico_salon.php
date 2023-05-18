<?php 

	require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
	
	include(dirname(__FILE__).'/../cnx_data.php');

	$ruta='http://beauty.claudiachacon.com/beauty/scripts';

	$sqlSalon = mysqli_query($conn, "SELECT distinct(ap.slncodigo), sl.slnnombre, sl.slnemail
									FROM btyprogramacion_colaboradores ap 
									natural join btysalon sl
									where  sl.slncodigo=9 and ap.prgfecha  BETWEEN (curdate() - INTERVAL DAYOFMONTH(curdate()) - 1 DAY) AND (curdate() - INTERVAL  1 DAY) 
									ORDER BY sl.slnnombre");


	while ($filasSalon = mysqli_fetch_array($sqlSalon)) 
	{
		
	    $SqlFecha=mysqli_query($conn, "SET lc_time_names = 'es_CO'");

	    $SqlFecha=mysqli_query($conn, "SELECT UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%M')) AS Mes, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%Y') AS Ano, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%d') AS DiaNumero, UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%W')) AS DiaNombre, MONTH(DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AS MES, DATE_ADD(CURDATE(), INTERVAL -1 DAY)AS FECHA");
    		
		$RsFecha = mysqli_fetch_array($SqlFecha);

		$codsalon=$filasSalon['slncodigo'];
		$message = '<html><style>th{font-size: .9em;}</style>
			<head>
			
		    <meta charset="utf-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="http://beauty.claudiachacon.com/beauty/lib/vendor/fontawesome/css/font-awesome.css" />

			</head>
			<body>';

		//INICIO TABLA CITAS
		$sqlcit="SELECT 
					SUM(CASE WHEN cta.esccodigo IN (1,2) THEN 1 ELSE 0 END) AS ag, 
					SUM(CASE WHEN cta.esccodigo IN (3,9) THEN 1 ELSE 0 END) AS can, 
					SUM(CASE WHEN cta.esccodigo =8 THEN 1 ELSE 0 END) AS ate,
															(
					SELECT COUNT(DISTINCT(nc.citcodigo))
					FROM btynovedad_cita nc
					JOIN btycita c ON c.citcodigo=nc.citcodigo
					WHERE c.slncodigo=$codsalon AND nc.citcodigo NOT IN 
															(
					SELECT nc2.citcodigo
					FROM btynovedad_cita nc2
					WHERE nc2.esccodigo IN (3,4,5,6,7,8,9) AND nc2.citfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)) AND nc.citfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)) AS ng
					FROM btynovedad_cita cta
					JOIN btycita ct ON ct.citcodigo=cta.citcodigo
					WHERE ct.slncodigo=$codsalon AND cta.citfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY) AND ct.citfecharegistro BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)";
		$rescit=mysqli_query($conn,$sqlcit);
		$rowcit=mysqli_fetch_array($rescit);
		$tot=$rowcit['ag'];
		$pcan=round(($rowcit['can']*100)/ $tot, 1);if($pcan<30){$sty4='color:green;';}else if($pcan>30 && $pcan<60){$sty4='color:orange;';}else{$sty4='color:red;';}
		$pate=round(($rowcit['ate']*100)/ $tot, 1);if($pate<30){$sty6='color:red;';}else if($pate>30 && $pate<60){$sty6='color:orange;';}else{$sty6='color:green;';}
		$png=round(($rowcit['ng']*100)/ $tot, 1);if($png<30){$sty8='color:green;';}else if($png>30 && $png<60){$sty8='color:orange;';}else{$sty8='color:red;';}





		$message.='<table cellpadding="5" cellspacing="5" border="1" style="width: 65%;">
							<thead>
								<tr style="background-color: #d2e3fc">
								  	<th colspan="7"><center>ACUMULADO CITAS SALON '.$filasSalon['slnnombre'].' '.$RsFecha['Mes'].' - '.$RsFecha['Ano'].'</center></th>
								</tr>
								<tr>
									<th style="text_align:center;">Agendadas</th>
									<th colspan="2" style="text-align:center;">No Atendidas</th>
									<th colspan="2" style="text-align:center;">Atendidas</th>
									<th colspan="2" style="text-align:center;">No gestionadas</th>
								</tr>
								<tr>
									<td style="text-align:center;">'.$rowcit['ag'].'</td>

									<td style="text-align:center;'.$sty4.'"">'.$rowcit['can'].'</td>
									<td style="text-align:center;'.$sty4.'"">'.$pcan.'%</td>
      
									<td style="text-align:center;'.$sty6.'"">'.$rowcit['ate'].'</td>
									<td style="text-align:center;'.$sty6.'"">'.$pate.'%</td>

									<td style="text-align:center;'.$sty8.'"">'.$rowcit['ng'].'</td>
									<td style="text-align:center;'.$sty8.'"">'.$png.'%</td>
								</tr>
							</thead>
							<tbody>';

			$message.='</table><br>';
		//FIN TABLA CITAS
		//
		//
		


		//INICIO TABLA NOVEDADES
	
			$message .= '<table cellpadding="5" cellspacing="5" border="1" style="width: 65%;">
					<thead>
						<tr style="background-color: #d2e3fc">
						  <th colspan="24"><center>NOVEDADES SALON '.$filasSalon['slnnombre'].' '.$RsFecha['DiaNombre'].' '.$RsFecha['DiaNumero'].' de '.$RsFecha['Mes'].' - '.$RsFecha['Ano'].'</center></th>
						</tr>
						<tr>
							<th colspan="4">IT</th>
							<th colspan="4">ST</th>
							<th colspan="4">A</th>
							<th colspan="4">RI</th>	
							<th colspan="4">PNP</th>	
							<th colspan="4">E</th>					
						</tr>
						<tr>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
							<th colspan="2">Dia</th>
							<th colspan="2">Mes</th>
						</tr>
					</thead>
					<tbody>';
			//INICIO CONSULTAS DE NOVEDADES DE ASISTENCIA
				//consulta numerica para el dia***********************************************************************
				$sqldia="SELECT 
							sum(case when ap.aptcodigo=2 then 1 else  0 end) IT,
							sum(case when ap.aptcodigo=3 then 1 else  0 end) ST,
							sum(case when ap.aptcodigo=4 then 1 else  0 end) AU,
							sum(case when ap.aptcodigo=6 then 1 else  0 end) INC,
							SUM(CASE WHEN ap.aptcodigo=5 THEN 1 ELSE 0 END) PNP,
							(SELECT COUNT(distinct(ab.clbcodigo))
							FROM btyasistencia_biometrico ab
							WHERE ab.slncodigo=$codsalon AND ab.abmfecha = (CURDATE() - INTERVAL 1 DAY) AND ab.abmerroneo=1 ) ERR
							FROM btyasistencia_procesada ap
							WHERE ap.slncodigo=$codsalon AND ap.prgfecha = (curdate() - INTERVAL  1 DAY)";
				$resdia=mysqli_query($conn,$sqldia);
				$rowdia = mysqli_fetch_array($resdia);
				
				$itdia=$rowdia['IT'];
				$stdia=$rowdia['ST'];
				$audia=$rowdia['AU'];
				$india=$rowdia['INC'];
				$pnpdia=$rowdia['PNP'];
				$edia=$rowdia['ERR'];
				
				//calculo porcentaje dia
				$sqlcol="SELECT count(distinct(ap.clbcodigo)) numcoldia
						from btyasistencia_procesada ap
						where ap.slncodigo=$codsalon and ap.prgfecha = (curdate() - INTERVAL  1 DAY)";
				$rescol=mysqli_query($conn,$sqlcol);
				$rowcol=mysqli_fetch_array($rescol);
				$ncd=$rowcol['numcoldia'];

				$pitdia=round(($itdia*100)/ $ncd, 1);if($pitdia<=30){$sty1='color:green;';}else if($pitdia>30 && $pitdia<60){$sty1='color:orange;';}else{$sty1='color:red;';}
				$pstdia=round(($stdia*100)/ $ncd, 1);if($pstdia<=30){$sty3='color:green;';}else if($pstdia>30 && $pstdia<60){$sty3='color:orange;';}else{$sty3='color:red;';}
				$paudia=round(($audia*100)/ $ncd, 1);if($paudia<=30){$sty5='color:green;';}else if($paudia>30 && $paudia<60){$sty5='color:orange;';}else{$sty5='color:red;';}
				$pindia=round(($india*100)/ $ncd, 1);if($pindia<=30){$sty7='color:green;';}else if($pindia>30 && $pindia<60){$sty7='color:orange;';}else{$sty7='color:red;';}
				$ppnpdia=round(($pnpdia*100)/ $ncd, 1);
				$pedia=round(($edia*100)/ $ncd, 1);if($pedia<30){$sty9='color:green;';}else if($pedia>30 && $pedia<60){$sty9='color:orange;';}else{$sty9='color:red;';}

				//consulta numerica para el mes***********************************************************************
				$sqlmes="SELECT 
							SUM(CASE WHEN ap.aptcodigo=2 THEN 1 ELSE 0 END) IT, 
							SUM(CASE WHEN ap.aptcodigo=3 THEN 1 ELSE 0 END) ST, 
							SUM(CASE WHEN ap.aptcodigo=4 THEN 1 ELSE 0 END) AU, 
							SUM(CASE WHEN ap.aptcodigo=6 THEN 1 ELSE 0 END) INC, 
							SUM(CASE WHEN ap.aptcodigo=5 THEN 1 ELSE 0 END) PNP,
														(
							SELECT COUNT(DISTINCT(ab.clbcodigo))
							FROM btyasistencia_biometrico ab
							WHERE ab.slncodigo=$codsalon AND ab.abmerroneo=1 AND ab.abmfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)) ERR
							FROM btyasistencia_procesada ap
							WHERE ap.slncodigo=$codsalon AND ap.prgfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)";
				$resmes=mysqli_query($conn,$sqlmes);
				$rowmes = mysqli_fetch_array($resmes);
				
				$itmes=$rowmes['IT'];
				$stmes=$rowmes['ST'];
				$aumes=$rowmes['AU'];
				$inmes=$rowmes['INC'];
				$pnpmes=$rowmes['PNP'];
				$emes=$rowmes['ERR'];

				//calculo porcentaje mes
				$sqlcmes="SELECT ROUND(AVG(x.prom)) * DAYOFMONTH(curdate() - INTERVAL  1 DAY) AS promcol
							from (select count(distinct(ap.clbcodigo)) prom
							FROM btyasistencia_procesada ap
							WHERE ap.slncodigo=$codsalon AND ap.prgfecha BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) AND (CURDATE() - INTERVAL 1 DAY)
							group by ap.prgfecha) x";
				$rescmes=mysqli_query($conn,$sqlcmes);
				$rowcmes=mysqli_fetch_array($rescmes);
				$pcm=$rowcmes['promcol'];

				$pitmes=round(($itmes*100)/ $pcm, 1);if($pitmes<=30){$sty2='color:green;';}else if($pitmes>30 && $pitmes<60){$sty2='color:orange;';}else{$sty2='color:red;';}
				$pstmes=round(($stmes*100)/ $pcm, 1);if($pstmes<=30){$sty4='color:green;';}else if($pstmes>30 && $pstmes<60){$sty4='color:orange;';}else{$sty4='color:red;';}
				$paumes=round(($aumes*100)/ $pcm, 1);if($paumes<=30){$sty6='color:green;';}else if($paumes>30 && $paumes<60){$sty6='color:orange;';}else{$sty6='color:red;';}
				$pinmes=round(($inmes*100)/ $pcm, 1);if($pinmes<=30){$sty8='color:green;';}else if($pinmes>30 && $pinmes<60){$sty8='color:orange;';}else{$sty8='color:red;';}
				$ppnpmes=round(($pnpmes*100)/ $pcm, 1);
				$pemes=round(($emes*100)/ $pcm, 1);if($pemes<30){$sty10='color:green;';}else if($pemes>30 && $pemes<60){$sty10='color:orange;';}else{$sty10='color:red;';}
			//FIN CONSULTAS DE NOVEDADES
			//
			//cuerpo de tabla novedades
			$message.='<tr>
						<td style="text-align:center;'.$sty1.'">'.$itdia.'</td>
						<td style="text-align:center;'.$sty1.'">'.$pitdia.'%</td>
						<td style="text-align:center;'.$sty2.'">'.$itmes.'</td>
						<td style="text-align:center;'.$sty2.'">'.$pitmes.'%</td>

						<td style="text-align:center;'.$sty3.'">'.$stdia.'</td>
						<td style="text-align:center;'.$sty3.'">'.$pstdia.'%</td>
						<td style="text-align:center;'.$sty4.'">'.$stmes.'</td>
						<td style="text-align:center;'.$sty4.'">'.$pstmes.'%</td>

						<td style="text-align:center;'.$sty5.'">'.$audia.'</td>
						<td style="text-align:center;'.$sty5.'">'.$paudia.'%</td>
						<td style="text-align:center;'.$sty6.'">'.$aumes.'</td>
						<td style="text-align:center;'.$sty6.'">'.$paumes.'%</td>

						<td style="text-align:center;'.$sty7.'">'.$india.'</td>
						<td style="text-align:center;'.$sty7.'">'.$pindia.'%</td>
						<td style="text-align:center;'.$sty8.'">'.$inmes.'</td>
						<td style="text-align:center;'.$sty8.'">'.$pinmes.'%</td>

						<td style="text-align:center;">'.$pnpdia.'</td>
						<td style="text-align:center;">'.$ppnpdia.'%</td>
						<td style="text-align:center;">'.$pnpmes.'</td>
						<td style="text-align:center;">'.$ppnpmes.'%</td>

						<td style="text-align:center;'.$sty9.'">'.$edia.'</td>
						<td style="text-align:center;'.$sty9.'">'.$pedia.'%</td>
						<td style="text-align:center;'.$sty10.'">'.$emes.'</td>
						<td style="text-align:center;'.$sty10.'">'.$pemes.'%</td>
						</tr>';
			
			//pie de tabla novedades					
			$message .= '
			    <tr style="background-color: #d2e3fc">
				  <td colspan="24"><center>IT: Ingreso Tarde  ST: Salida Temprano  A: Ausencia RI: Registro Incompleto<br>  PNP: Presencia no Programada  E: Erroneo</center></td>
				</tr>';
			$message.='</tbody></table><br><br><br>';
			
			$message .= '</body></html>';
		//FIN TABLA NOVEDADES
	
		

		echo $message;
		/*
			$mail = new PHPMailer;

			$mail->isSMTP();

			$mail->SMTPDebug = 0;

			$mail->Debugoutput = 'html';

			$mail->Host = "smtpout.secureserver.net";

			$mail->Port = 25;

			$mail->SMTPAuth = true;

			$mail->Username = "app@claudiachacon.com";
			$mail->Password = "AppBTY.18";
			$mail->setFrom('app@claudiachacon.com', 'Beauty Soft');
		      $mail->addReplyTo('app@claudiachacon.com', 'Beauty Soft');


			//$mail->addAddress('jvelasco@claudiachacon.com');
			//$mail->addAddress('cchacon@claudiachacon.com');
			//$mail->addAddress('direccion.operaciones@claudiachacon.com');
			//$mail->addAddress('gestionhumana@claudiachacon.com');
			//$mail->addAddress('direccion.administrativa@claudiachacon.com');
		    //$mail->addAddress('app@claudiachacon.com');

		
			$mail->addAddress($filasSalon['slnemail']);
		       //$mail->addAddress('jhonfb2@fundacionlabanda.tk');
		       //$mail->addAddress('silmasur@gmail.com');
			//$mail->addAddress('soporte@mipc-soluciones.com');
		    
		    $mail->Subject = utf8_decode('Beauty Soft: Informe diario');

		    $mail->msgHTML($message, dirname(__FILE__));
			
			$mail->AltBody = '';

		    if (!$mail->send()) 
		    {
		    	if($mail->send()){
		    		echo 'enviado en 2do intento';
		    	}else{
		    		$mail->send();echo 'enviado al 3er intento';
		    	}
		      	echo "Error: " . $mail->ErrorInfo."\n";
			} 
			else 
			{
			    echo "Enviado a: "."\n";
			    echo $filasSalon['slnemail'];
			    echo "====";
			}
		*/

	}

 ?>
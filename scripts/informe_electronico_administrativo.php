<?php 

	require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
	
	include(dirname(__FILE__).'/../cnx_data.php');

	$ruta='http://beauty.claudiachacon.com/beauty/scripts';
	
    
    $SqlFecha=mysqli_query($conn, "SET lc_time_names = 'es_CO'");
    $SqlFecha=mysqli_query($conn, "SELECT 
									UCASE(DATE_FORMAT(CURDATE()- INTERVAL 1 DAY, '%M')) AS Mes, 
									DATE_FORMAT(CURDATE()- INTERVAL 1 DAY, '%Y') AS Ano, 
									DATE_FORMAT(CURDATE()- INTERVAL 1 DAY, '%d') AS DiaNumero, 
									UCASE(DATE_FORMAT(CURDATE()- INTERVAL 1 DAY, '%W')) AS DiaNombre, 
									MONTH(CURDATE()- INTERVAL 1 DAY) AS MES, 
									CURDATE()- INTERVAL 1 DAY AS FECHA");
    $RsFecha = mysqli_fetch_array($SqlFecha);


	$message = '<html><style>th{font-size: .9em;}</style>
	<head>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://beauty.claudiachacon.com/beauty/lib/vendor/fontawesome/css/font-awesome.css" />

	</head>
	<body>';

	$cliente=mysqli_fetch_array(mysqli_query($conn,"SELECT (SELECT COUNT(*) FROM btycliente WHERE clitiporegistro='INTERNO') AS sesc,
													(SELECT COUNT(*) FROM btycliente WHERE clitiporegistro='INTERNO-PDF417') AS cesc,
													(SELECT COUNT(*) FROM btycliente) AS total"));
		$message.='
		<table cellpadding="5" cellspacing="5" border="1">
		<thead>
			<tr style="background-color: #d2e3fc">
				<th colspan="3" style="white-space: nowrap; text-align: center;">ACUMULADO DE REGISTRO DE CLIENTES*</th>
			</tr>
			<tr>
				<th style="white-space: nowrap; text-align: center;">Sin escaner</th>
				<th style="white-space: nowrap; text-align: center;">Con escaner</th>
				<th style="white-space: nowrap; text-align: center;">TOTAL CLIENTES</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="white-space: nowrap; text-align: center;">'.$cliente[0].'</td>
				<td style="white-space: nowrap; text-align: center;">'.$cliente[1].'</td>
				<td style="white-space: nowrap; text-align: center;"><b>'.$cliente[2].'</b></td>
			</tr>
		</tbody>
	</table>*Acumulado hasta este momento<br><br>';


	$acumcli=mysqli_query($conn,"SELECT 
							IF(s.slncodigo=0,'NO DEFINIDO*',s.slnnombre) AS salon, 
							SUM(IF(c.clitiporegistro='INTERNO',1,0)) AS sinescaner, 
							SUM(IF(c.clitiporegistro='INTERNO-PDF417',1,0)) AS conescaner, 
							SUM(IF(c.clitiporegistro IN ('INTERNO','INTERNO-PDF417'),1,0)) AS total
							FROM btysalon s
							LEFT JOIN btycliente c ON s.slncodigo=c.slncodigo
							GROUP BY s.slnnombre
							ORDER BY s.slncodigo");
	$message.='<table cellpadding="5" cellspacing="5" border="1">
	<thead>
	<tr style="background-color: #d2e3fc"><th colspan="4">Registro de clientes por Sal&oacute;n</th></tr>
	<tr>
	<th style="white-space: nowrap; text-align: center;">Sal&oacute;n</th>
	<th style="white-space: nowrap; text-align: center;">Sin Escaner</th>
	<th style="white-space: nowrap; text-align: center;">Con escaner</th>
	<th style="white-space: nowrap; text-align: center;">Total</th>
	</tr>
	</thead>
	<tbody>';
	while($rowacli=$acumcli->fetch_array()){
		$message.='<tr><td style="white-space: nowrap;">'.$rowacli["salon"].'</td><td style="white-space: nowrap; text-align: center;">'.$rowacli["sinescaner"].'</td><td style="white-space: nowrap; text-align: center;">'.$rowacli["conescaner"].'</td><td style="white-space: nowrap; text-align: center;">'.$rowacli["total"].'</td></tr>';
	}
	$message.='</tbody>
	</table><br><br>';

	$inco=mysqli_fetch_array(mysqli_query($conn,"SELECT IFNULL(SUM(IF(c.usucodigo NOT IN (0,1) AND ((LENGTH(SUBSTRING_INDEX(c.cliemail,'@',1))<=3 OR c.cliemail LIKE '%correo%' OR c.cliemail LIKE 'NO%') OR (LENGTH(t.trctelefonomovil)<10 OR SUBSTRING(t.trctelefonomovil,1,1) <> 3 OR SUBSTRING(t.trctelefonomovil,2,1) NOT IN (0,1,2,5))),1,0)),0) AS tsalon
			FROM btycliente c 
			JOIN btytercero t ON t.trcdocumento=c.trcdocumento
			WHERE c.slncodigo <> 0 and c.clifecharegistro=(curdate()-interval 1 day)"));

	$message.='<table cellpadding="5" cellspacing="5" border="1">
	<thead>
	<tr style="background-color: #d2e3fc"><th colspan="3">Registro de clientes con Inconsistencias (de ayer)</th></tr>
	<tr>
	<th style="white-space: nowrap;"><b>TOTAL<b></th>
	<th style="white-space: nowrap; text-align: center;">'.$inco[0].'</th>
	<th style="white-space: nowrap; text-align: center;"><a href="http://beauty.claudiachacon.com/beauty/scripts/informe_registro_clientes.php?fecha='.$RsFecha['FECHA'].'">Ver Detalles</a></th>
	</tr>
	</thead>
	</table><br><br>';

	$message .= '<table cellpadding="5" cellspacing="5" border="1">
		<thead>
			<tr style="background-color: #d2e3fc">
			  <th colspan="10"><center>INFORME DE AGENDAMIENTO DE CITAS</center></th>
			</tr>
			<tr>
				<th rowspan="2">Sal&oacute;n</th>
				<th colspan="3">D&iacute;a: '.$RsFecha['DiaNombre'].' '.$RsFecha['DiaNumero'].'</th>
				<th colspan="3">Mes: '.$RsFecha['Mes'].'</th>
				<th colspan="3">A&ntilde;o: '.$RsFecha['Ano'].'</th>
			</tr>
			<tr>
				<th>Funcionario</th>
				<th>Cliente</th>
				<th>Suma</th>
				<th>Funcionario</th>
				<th>Cliente</th>
				<th>Suma</th>
				<th>Funcionario</th>
				<th>Cliente</th>
				<th>Suma</th>
			</tr>
		</thead>
		<tbody>';


	$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

	
	while ($row = mysqli_fetch_array($sql)) 
	{

		/*----------  Dia  ----------*/
		
		$query = mysqli_query($conn, "SELECT IFNULL(sum(case when nc.esccodigo = 1 then 1 else 0 end),'0') agenfunc, IFNULL(sum(case when nc.esccodigo = 2 then 1 else 0 end),0) agenusu FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.slncodigo= '".$row['slncodigo']."' AND ct.citfecharegistro = (curdate()-interval 1 day)");

		$filas = mysqli_fetch_array($query);
		$SumaDia=$filas[0]+$filas[1];

		$message.='<tr><td align="left"><b>'.$row[1].'</b></td><td align="right">'.$filas[0].'</td><td align="right">'.$filas[1].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo='.$row['slncodigo'].'&rango=dia&valor='.$RsFecha['DiaNumero'].'&fecha='.$RsFecha['FECHA'].' " title="Ver mas detalles">'.$SumaDia.'</a></td>';



		/*----------  Mes  ----------*/

		$query2 = mysqli_query($conn, "SELECT IFNULL(SUM(CASE WHEN nc.esccodigo = 1 THEN 1 ELSE 0 END),'0') agenfunc, IFNULL(SUM(CASE WHEN nc.esccodigo = 2 THEN 1 ELSE 0 END),0) agenusu FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.slncodigo= '".$row['slncodigo']."' AND ct.citfecharegistro BETWEEN (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY)");

		$filas2 = mysqli_fetch_array($query2);
		$SumaMes=$filas2[0]+$filas2[1];

		$message.='<td align="right">'.$filas2[0].'</td><td align="right">'.$filas2[1].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo='.$row['slncodigo'].'&rango=mes&valor='.$RsFecha['MES'].'&fecha='.$RsFecha['FECHA'].'" title="Ver mas detalles">'.$SumaMes.'</a></td>';

		/*----------  Año  ----------*/

		$query3 = mysqli_query($conn, "SELECT IFNULL(SUM(CASE WHEN nc.esccodigo = 1 THEN 1 ELSE 0 END),'0') agenfunc, IFNULL(SUM(CASE WHEN nc.esccodigo = 2 THEN 1 ELSE 0 END),0) agenusu FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.slncodigo= '".$row['slncodigo']."' AND ct.citfecharegistro BETWEEN  MAKEDATE(YEAR(CURDATE()),1) AND DATE_ADD(CURDATE(), INTERVAL -1 DAY)");

		$filas3 = mysqli_fetch_array($query3);
		$SumaAno=$filas3[0]+$filas3[1];

		$message.='<td align="right">'.$filas3[0].'</td><td align="right">'.$filas3[1].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo='.$row['slncodigo'].'&rango=ano&valor='.$RsFecha['Ano'].'&fecha='.$RsFecha['FECHA'].'" title="Ver mas detalles">'.$SumaAno.'</a></td></tr>';

	}


    /*----------  Total día  ----------*/
    
    $QuTotalDia = mysqli_query($conn, "SELECT IFNULL(SUM(CASE WHEN nc.esccodigo = 1 THEN 1 ELSE 0 END),'0') Funcionario, IFNULL(SUM(CASE WHEN nc.esccodigo = 2 THEN 1 ELSE 0 END),0) Usuario FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.citfecharegistro = (curdate()-interval 1 day)");

	$RsTotalDia = mysqli_fetch_array($QuTotalDia); 
	$SumaTotalDia=$RsTotalDia['Funcionario']+$RsTotalDia['Usuario'];

	 /*----------  Total Mes  ----------*/
    
    $QuTotalMes = mysqli_query($conn, "SELECT IFNULL(SUM(CASE WHEN nc.esccodigo = 1 THEN 1 ELSE 0 END),'0') Funcionario, IFNULL(SUM(CASE WHEN nc.esccodigo = 2 THEN 1 ELSE 0 END),0) Usuario FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.citfecharegistro BETWEEN  (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY)");

	$RsTotalMes = mysqli_fetch_array($QuTotalMes); 
	$SumaTotalMes=$RsTotalMes['Funcionario']+$RsTotalMes['Usuario'];

	/*----------  Total Año  ----------*/
    
    $QuTotalAno = mysqli_query($conn, "SELECT IFNULL(SUM(CASE WHEN nc.esccodigo = 1 THEN 1 ELSE 0 END),'0') Funcionario, IFNULL(SUM(CASE WHEN nc.esccodigo = 2 THEN 1 ELSE 0 END),0) Usuario FROM btycita ct JOIN btyservicio sv ON ct.sercodigo=sv.sercodigo JOIN btynovedad_cita nc ON ct.citcodigo=nc.citcodigo WHERE ct.citfecharegistro BETWEEN MAKEDATE(YEAR(CURDATE()),1) AND DATE_ADD(CURDATE(), INTERVAL -1 DAY)");

	$RsTotalAno = mysqli_fetch_array($QuTotalAno); 
	$SumaTotalAno=$RsTotalAno['Funcionario']+$RsTotalAno['Usuario'];


	$message.='<tr style="background-color: #febcbc">
				<td align="left"><b>TOTALES</b></td><td align="right">'.$RsTotalDia['Funcionario'].'</td><td align="right">'.$RsTotalDia['Usuario'].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo=0&rango=dia&valor='.$RsFecha['DiaNumero'].'&fecha='.$RsFecha['FECHA'].' ">'.$SumaTotalDia.'</a></td>
				<td align="right">'.$RsTotalMes['Funcionario'].'</td><td align="right">'.$RsTotalMes['Usuario'].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo=0&rango=mes&valor='.$RsFecha['MES'].'&fecha='.$RsFecha['FECHA'].' ">'.$SumaTotalMes.'</a></td>
				<td align="right">'.$RsTotalAno['Funcionario'].'</td><td align="right">'.$RsTotalAno['Usuario'].'</td><td align="right"><a href="'.$ruta.'/informe_electronico_detallado.php?slncodigo='.$row['slncodigo'].'&rango=ano&valor='.$RsFecha['Ano'].'&fecha='.$RsFecha['FECHA'].'" title="Ver mas detalles">'.$SumaTotalAno.'</a></td>
				</tr>';

	$message .='</tbody>
	</table><br><br>';

	$sqlFecha2=mysqli_query($conn, "SET lc_time_names = 'es_CO'");
    $sqlFecha2=mysqli_query($conn, "SELECT UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%M')) AS Mes, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%Y')AS Ano, DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%d')AS DiaNumero, UCASE(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 DAY), '%W'))AS DiaNombre");
    $RsFecha2 = mysqli_fetch_array($sqlFecha2);

	$message .= '

		<table cellpadding="5" cellspacing="5" border="1">
			<thead>
				<tr style="background-color: #d2e3fc">
			  		<th colspan="15"><center>NOVEDADES '.$RsFecha2['DiaNombre'].' '.$RsFecha2['DiaNumero'].' '.$RsFecha2['Mes'].' '.$RsFecha2['Ano'].' </center></th>
				</tr>
				<tr>
					<th rowspan="2">Sal&oacute;n</th>
					<th colspan="2" style="white-space: nowrap; text-align: center;">IT</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">ST</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">A</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">RI</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">PNP</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">E</th>
					<th colspan="2" style="white-space: nowrap; text-align: center">Total</th>
				</tr>
				<tr>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
					<th style="white-space: nowrap; text-align: center; background-color: #b3f6a0">DIA</th>
					<th style="white-space: nowrap; text-align: center; background-color: #f6f5a0">MES</th>
				</tr>
			
			</thead>
		<tbody>';

	$salones = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

	while ($row2 = mysqli_fetch_array($salones)) 
	{

		$message.='<tr><td style="white-space: nowrap"><b>'.$row2[1].'</b></td>';

		/**
		 *
		 * QUERY TIPOS DE ESTADO BIOMETRICO DIA - MES
		 *
		 */

			$QueryTarde = mysqli_query($conn, "SELECT COUNT(ap.aptcodigo) AS 'LLEGADA TARDE DIA', (SELECT COUNT(ap.aptcodigo) AS salidatemprano FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 2 AND MONTH(ap.prgfecha) = MONTH(CURDATE()) AND ap.slncodigo = '".$row2[0]."')AS 'LLEGADA TARDE MES', 
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 3 AND ap.prgfecha = (curdate()-interval 1 day) AND ap.slncodigo = '".$row2[0]."') AS 'SALIDA TEMPRANO DIA', 
				(
					SELECT COUNT(ap.aptcodigo) AS salidatemprano FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 3 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."')AS 'SALIDA TEMPRANO MES',
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 4 AND ap.prgfecha = (curdate()-interval 1 day) AND ap.slncodigo = '".$row2[0]."')AS 'AUSENCIA DIA', 
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 4 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."')AS 'AUSENCIA MES', 
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 6 AND ap.prgfecha = (curdate()-interval 1 day) AND ap.slncodigo = '".$row2[0]."')AS 'REGISTRO INCOMPLETO DIA',
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 6 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."')AS 'REGISTRO INCOMPLETO MES', 
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 5 AND ap.prgfecha = (curdate()-interval 1 day) AND ap.slncodigo = '".$row2[0]."')AS 'PRESENCIA NO PROGRAMADA DIA',
				(
					SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 5 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) day) and(CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."')AS 'PRESENCIA NO PROGRAMADA MES',

				(
					SELECT COUNT(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 and ab.slncodigo = '".$row2[0]."' AND ab.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS 'ERRORES DIA',
 
				(
					SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 and ab.slncodigo = '".$row2[0]."' AND ab.abmfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY) )AS 'ERRORES MES' FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 2 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND ap.slncodigo ='".$row2[0]."'");

			$filas4 = mysqli_fetch_array($QueryTarde);	


$message.='<td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=it&valor=2&fecha='.$RsFecha['FECHA'].'">'.$filas4[0].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=it&valor=2&fecha='.$RsFecha['FECHA'].'">'.$filas4[1].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=st&valor=3&fecha='.$RsFecha['FECHA'].'">'.$filas4[2].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=st&valor=3&fecha='.$RsFecha['FECHA'].'">'.$filas4[3].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=a&valor=4&fecha='.$RsFecha['FECHA'].'">'.$filas4[4].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=a&valor=4&fecha='.$RsFecha['FECHA'].'">'.$filas4[5].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=inc&valor=6&fecha='.$RsFecha['FECHA'].'">'.$filas4[6].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=inc&valor=6&fecha='.$RsFecha['FECHA'].'">'.$filas4[7].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=pnp&valor=5&fecha='.$RsFecha['FECHA'].'">'.$filas4[8].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=pnp&valor=5&fecha='.$RsFecha['FECHA'].'">'.$filas4[9].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=e&fecha='.$RsFecha['FECHA'].'">'.$filas4[10].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalleErrores.php?slncodigo='.$row2[0].'&tipo=e&fecha='.$RsFecha['FECHA'].'">'.$filas4[11].'</a></td>';

		/**
		 *
		 * TOTAL DIA
		 *
		 */
			$QueryTotd= mysqli_query($conn, "SELECT SUM(CASE WHEN ap.aptcodigo = 2 THEN 1 ELSE 0 END )AS a, SUM(CASE WHEN ap.aptcodigo = 3 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 4 THEN 1 ELSE 0 END )AS b2, SUM(CASE WHEN ap.aptcodigo = 5 THEN 1 ELSE 0 END )AS c, SUM(CASE WHEN ap.aptcodigo = 6 THEN 1 ELSE 0 END )AS d, (SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 and ab.slncodigo = '".$row2[0]."' AND ab.abmfecha = (curdate()-interval 1 day)) AS HYT FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.prgfecha = (CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."'");

			/*ab.abmfecha =  DATE_ADD(CURDATE(), INTERVAL -1 DAY))*/

			$filas18 = mysqli_fetch_array($QueryTotd);

			$totalD = $filas18[0] + $filas18[1] + $filas18[2] + $filas18[3] + $filas18[4] + $filas18[5];	


			$message.='<td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedades.php?slncodigo='.$row2[0].'&tipo=alls&fecha='.$RsFecha['FECHA'].'">'.$totalD.'</a></td>';

		/**
		 *
		 * TOTAL MES
		 *
		 */

			$QueryErrMe= mysqli_query($conn, "SELECT SUM(CASE WHEN ap.aptcodigo = 2 THEN 1 ELSE 0 END )AS a, SUM(CASE WHEN ap.aptcodigo = 3 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 4 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 5 THEN 1 ELSE 0 END )AS c, SUM(CASE WHEN ap.aptcodigo = 6 THEN 1 ELSE 0 END )AS d, (SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 and ab.slncodigo = '".$row2[0]."' AND MONTH(ab.abmfecha) = MONTH(CURDATE()) AND YEAR(ab.abmfecha) = YEAR(CURDATE()) and ab.abmfecha<curdate()) AS HYT FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY) AND ap.slncodigo = '".$row2[0]."'");

			$filas17 = mysqli_fetch_array($QueryErrMe);	

			$total = $filas17[0] + $filas17[1] + $filas17[2] + $filas17[3] + $filas17[4] + $filas17[5];

			$message.='<td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoNovedadesMes.php?slncodigo='.$row2[0].'&tipo=alls&val=mes&fecha='.$RsFecha['FECHA'].'">'.$total.'</a></td>';
	
		
	}


		$QueryTotales = mysqli_query($conn, "SELECT COUNT(ap.aptcodigo) AS 'TOTAL INGRESO TARDE DIA', 
		(
			SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 2 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY)) AS 'TOTAL INGRESO TARDE MES', 

		( 
			SELECT COUNT(ap.aptcodigo) AS 'TOTAL INGRESO TARDE DIA'  FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 3 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS 'TOTAL SALIDA TEMPRANO DIA',

		(
			SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 3 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY))AS 'TOTAL SALIDA TEMPRANO MES',

		(
			SELECT COUNT(ap.aptcodigo) AS 'TOTAL INGRESO TARDE DIA' FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 4 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS 'TOTAL AUSENCIA DIA',

		(
			SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 4 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY))AS 'TOTAL AUSENCIA MES', 
		
		(
			SELECT COUNT(ap.aptcodigo) AS 'TOTAL INGRESO TARDE DIA' FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 6 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS 'TOTAL REGISTRO INCOMPLETO DIA',

		(
			SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 6 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY))AS 'TOTAL REGISTRO INCOMPLETO MES',

		(
			SELECT COUNT(ap.aptcodigo) AS 'TOTAL INGRESO TARDE DIA' FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 5 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS 'TOTAL PRESENCIA NO PROGRAMADA DIA',

		(
			SELECT COUNT(ap.aptcodigo) AS cantidad FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 5 AND ap.prgfecha between (CURDATE() - INTERVAL DAYOFMONTH(CURDATE() - INTERVAL 1 DAY) DAY) AND(CURDATE() - INTERVAL 1 DAY))AS 'TOTAL PRESENCIA NO PROGRAMADA MES',

		(
			SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 AND ab.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AS 'TOTAL ERRORES DIA', 

		(
			SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 AND year(ab.abmfecha) = year(CURDATE()) and  MONTH(ab.abmfecha) = MONTH(CURDATE()) and ab.abmfecha<curdate() )AS 'TOTAL ERRORES MES'FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.aptcodigo = 2 AND ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)");

				$sumTotal = mysqli_fetch_array($QueryTotales);


	


		$QueryTotalDia = mysqli_query($conn, "SELECT SUM(CASE WHEN ap.aptcodigo = 2 THEN 1 ELSE 0 END )AS a, SUM(CASE WHEN ap.aptcodigo = 3 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 4 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 5 THEN 1 ELSE 0 END )AS c, SUM(CASE WHEN ap.aptcodigo = 6 THEN 1 ELSE 0 END )AS d, (SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 AND ab.abmfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY))AS HYT FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE ap.prgfecha = DATE_ADD(CURDATE(), INTERVAL -1 DAY)");

			$sumTotal13 = mysqli_fetch_array($QueryTotalDia);

			$SumaTotal = $sumTotal13[0] + $sumTotal13[1] + $sumTotal13[2] + $sumTotal13[3] + $sumTotal13[4] + $sumTotal13[5];


			$QueryTotalMes = mysqli_query($conn, "SELECT SUM(CASE WHEN ap.aptcodigo = 2 THEN 1 ELSE 0 END )AS a, SUM(CASE WHEN ap.aptcodigo = 3 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 4 THEN 1 ELSE 0 END )AS b, SUM(CASE WHEN ap.aptcodigo = 5 THEN 1 ELSE 0 END )AS c, SUM(CASE WHEN ap.aptcodigo = 6 THEN 1 ELSE 0 END )AS d, (SELECT count(*)AS cantidad from btyasistencia_biometrico ab WHERE ab.abmerroneo=1 AND MONTH(ab.abmfecha) = MONTH(CURDATE()) AND YEAR(ab.abmfecha) = YEAR(CURDATE()) and ab.abmfecha<curdate()) AS HYT FROM btyasistencia_procesada ap JOIN btyasistencia_procesada_tipo apt ON ap.aptcodigo=apt.aptcodigo WHERE MONTH(ap.prgfecha) = MONTH(CURDATE()) and year(ap.prgfecha) = year(CURDATE()) ");

			$sumTotal14 = mysqli_fetch_array($QueryTotalMes);


    		$SumaTotalMes = $sumTotal14[0] + $sumTotal14[1] + $sumTotal14[2] + $sumTotal14[3] + $sumTotal14[4] + $sumTotal14[5];



			$message.='<tr style="background-color: #febcbc"><th>TOTALES</th><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=it&valor=2&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[0].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=it&valor=2&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[1].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=st&valor=3&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[2].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=st&valor=3&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[3].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=a&valor=4&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[4].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=a&valor=4&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[5].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=inc&valor=6&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[6].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=inc&valor=6&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[7].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=pnp&valor=5&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[8].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=pnp&valor=5&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[9].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=e&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[10].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonMes.php?tipo=e&fecha='.$RsFecha['FECHA'].'">'.$sumTotal[11].'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalon.php?tipo=alls&fecha='.$RsFecha['FECHA'].'">'.$SumaTotal.'</a></td><td style="white-space: nowrap; text-align: right"><a href="'.$ruta.'/reporteDetalladoTotalesSalonTotal.php?tipo=alls&fecha='.$RsFecha['FECHA'].'">'.$SumaTotalMes.'</a></td></tr>';

		$message .= '

		    <tr style="background-color: #d2e3fc">
			  <td colspan="15"><center>IT: Ingreso Tarde  ST: Salida Temprano  A: Ausencia RI: Registro Incompleto<br>  PNP: Presencia no Programada  E: Erroneo</center></td>
			</tr>';

		

		
		$message.='</tbody></table>';



	$message .= '</body></html>';


//echo $message;
	$mail = new PHPMailer;

	$mail->isSMTP();

	$mail->SMTPDebug = 4;

	$mail->Debugoutput = 'html';

	$mail->Host = "smtpout.secureserver.net";

	$mail->Port = 25;

	$mail->SMTPAuth = true;

	$mail->Username = "app@claudiachacon.com";
	$mail->Password = "AppBTY.18";
	$mail->setFrom('app@claudiachacon.com', 'Beauty Soft');
	$mail->addReplyTo('app@claudiachacon.com', 'Beauty Soft');

	$mail->addAddress('jvelasco@claudiachacon.com');
	$mail->addAddress('cchacon@claudiachacon.com');
	$mail->addAddress('direccion.operaciones@claudiachacon.com');
	$mail->addAddress('direccion.comercial@claudiachacon.com');
	$mail->addAddress('gestionhumana@claudiachacon.com');
	$mail->addAddress('asistente.gestionhumana@claudiachacon.com');
	$mail->addAddress('asistente.mercadeo@claudiachacon.com');
	$mail->addAddress('direccion.administrativa@claudiachacon.com');
	$mail->addAddress('app@claudiachacon.com');


    
    $mail->Subject = utf8_decode('Beauty Soft: Informe diario');

    $mail->msgHTML($message, dirname(__FILE__));
	
	$mail->AltBody = '';

	if (!$mail->send()) 
	{
	  echo "Error: " . $mail->ErrorInfo."\n";
	} 
	else 
	{
	    echo "Mensaje Enviado"."\n";
	}



 ?>
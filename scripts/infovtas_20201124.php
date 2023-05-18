<?php 
include(dirname(__FILE__).'/../cnx_data.php');
require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
setlocale(LC_ALL,"es_ES");

//fecha HOY
$string=date("d/m/Y");
$date = DateTime::createFromFormat("d/m/Y", $string);
$fecha = strftime("24 de %B de %Y [%A]",$date->getTimestamp());
//fecha año pasado
$date2 = DateTime::createFromFormat("d/m/Y", $string);
date_sub($date2, date_interval_create_from_date_string('1 year'));
$fecha2 = strftime("24 de %B de %Y [%A]",$date2->getTimestamp());


$message='<html><style>th{font-size: .9em;}</style><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><h4>Informe Diario de Ventas.</h4>';
$message.='<table cellpadding="5" cellspacing="0" border="1">
			<tr bgcolor="#FABA7C">
				<th rowspan="2">SALON</th>
				<th colspan="9">'.$fecha.'</th>
				<th colspan="7">'.$fecha2.'</th>
				<th rowspan="2">[%] Crecimiento Serv</th>
				<th rowspan="2">[%] Crecimiento Prod</th>
				<th rowspan="2">Acumulado mes actual</th>
				<th rowspan="2">Acumulado mes a&ntilde;o anterior</th>
				<th rowspan="2">[%] Crecimiento Acumulado mes</th>
			</tr>

			<tr bgcolor="#FABA7C">
				<th># clientes</th>
				<th># servicios</th>
				<th>VR TQTE</th>
				<th>B.L SERV</th>
				<th>VR QUIMIC</th>
				<th>VR INSUM</th>
				<th>TOTAL SERV</th>
				<th>VR PRODUC</th>
				<th>TOTAL VTA</th>
				<th>VR TQTE</th>
				<th>B.L SERV</th>
				<th>VR QUIMIC</th>
				<th>VR INSUM</th>
				<th>TOTAL SERV</th>
				<th>VR PRODUC</th>
				<th>TOTAL VTA</th>
			</tr>';
$sqls="SELECT s.slncodigo FROM btysalon s WHERE s.slncodigo NOT IN (0,2,13) ORDER BY s.slnnombre";
$ress=$conn->query($sqls);
	$cancli1=0;
	$cansrv1=0;
	$tkt1=0;
	$tkt2=0;
	$ins1=0;
	$ins2=0;
	$srv1=0;
	$srv2=0;
	$prd1=0;
	$prd2=0;
	$tot1=0;
	$tot2=0;
	$mesac=0;
	$mesap=0;
	$nf=0;
while($rows=$ress->fetch_array()){
	$salon=$rows[0];
	//2020			
	$sql1="SELECT m.nomsln, ROUND(m.sumtkt/m.divi) AS tkt, ROUND(m.sumins/m.divi) AS ins, ROUND(m.tosrv/m.divi) AS srv, ROUND(m.toqui/m.divi) AS qui, ROUND(m.tosrv2/m.divi) AS srv2, ROUND(m.topro/m.divi) AS pro, ROUND(m.total/m.divi) AS total, m.mesac as mesac, cantcliadmi($salon,'2020-11-24') as cantcli, m.cantsrv as cantsrv FROM 
		(SELECT z.nomsln, z.sumtkt, z.sumins,(z.sumsrv-z.sumtkt-z.sumins-z.sumqui) AS tosrv, z.sumsrv AS tosrv2, z.sumqui AS toqui, z.sumpro AS topro, (z.sumsrv+z.sumpro) AS total, z.fact AS factura, (z.sumsrv+z.sumpro)/z.fact AS divi, z.mesac as mesac, z.cantsrv as cantsrv
		FROM (
		SELECT 
		s.slnnombre AS nomsln,
		SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumsrv,
		SUM(CASE WHEN a.linea='01' THEN 1 ELSE 0 END ) AS cantsrv,
		SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumtkt,
		SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumins,
		SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumpro,
		SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumqui,
		bty_factadmi('2020-11-24',s.slnadmi) AS fact,
		bty_factadmi_mesacum('2020-11-24',s.slnadmi) AS mesac
		FROM btyfromadmi a 
		JOIN btysalon s ON s.slnadmi=a.salon
		WHERE a.fecha='2020-11-24' AND a.td='FS' AND a.estado='A' AND s.slncodigo = $salon) AS z ) AS m";
	$res1=$conn->query($sql1);

	//2019
	$sql2="SELECT ROUND(m.sumtkt/m.divi) AS tkt, ROUND(m.sumins/m.divi) AS ins, ROUND(m.tosrv/m.divi) AS srv, ROUND(m.toqui/m.divi) AS qui, ROUND(m.tosrv2/m.divi) AS srv2, ROUND(m.topro/m.divi) AS pro, ROUND(m.total/m.divi) AS total, m.mesap as mesap FROM 
		(SELECT z.nomsln, z.sumtkt, z.sumins,(z.sumsrv-z.sumtkt-z.sumins-z.sumqui) AS tosrv, z.sumsrv AS tosrv2, z.sumqui AS toqui, z.sumpro AS topro, (z.sumsrv+z.sumpro) AS total, z.fact AS factura, (z.sumsrv+z.sumpro)/z.fact AS divi, z.mesap as mesap
		FROM (
		SELECT 
		s.slnnombre AS nomsln,
		SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumsrv,
		SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumtkt,
		SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumins,
		SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumpro,
		SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumqui,
		bty_factadmi(DATE_SUB('2020-11-24', INTERVAL 1 YEAR),s.slnadmi) AS fact,
		bty_factadmi_mesacum(DATE_SUB('2020-11-24', INTERVAL 1 YEAR),s.slnadmi) AS mesap
		FROM btyfromadmi a 
		JOIN btysalon s ON s.slnadmi=a.salon
		WHERE a.fecha=DATE_SUB('2020-11-24', INTERVAL 1 YEAR) AND a.td='FS' AND a.estado='A'  AND s.slncodigo = $salon) AS z ) AS m";
	$res2=$conn->query($sql2);

	while(($row1=$res1->fetch_array()) && ($row2=$res2->fetch_array()) ){
		if((($row1['pro']==0) || ($row1['pro']==null)) && (($row2['pro']==0) || ($row2['pro']==null))){
			$pro=0;
		}else{
			$pro=round((($row1['pro'] / $row2['pro']) -1) * 100 , 2);
		}
		if(($row1['srv']==0) && ($row2['srv']==0)){
			$srv=0;
		}else{
			$srv=round((($row1['srv'] / $row2['srv']) -1)* 100 , 2);
		}
		if(($row1['mesac']==0) && ($row2['mesap']==0)){
			$cmes=0;
		}else{
			$cmes=round((($row1['mesac'] / $row2['mesap']) -1)* 100 , 2);
		}
		//color fila
		$nf++;
		$cfila=$nf%2==0?'#FFCFA9':'';
		$clrp=$pro>0?"green":"red";
		$clrs=$srv>0?"green":"red";
		$clms=$cmes>0?"green":"red";
		$message.='<tr bgcolor="'.$cfila.'"><td align="right">'.$row1['nomsln'].'</td>
					<td align="center">'.$row1['cantcli'].'</td>
					<td align="center">'.$row1['cantsrv'].'</td>
					<td align="right">'.number_format($row1['tkt'],0).'</td>
					<td align="right">'.number_format($row1['srv'],0).'</td>
					<td align="right">'.number_format($row1['qui'],0).'</td>
					<td align="right">'.number_format($row1['ins'],0).'</td>
					<td align="right">'.number_format($row1['srv2'],0).'</td>
					<td align="right">'.number_format($row1['pro'],0).'</td>
					<th align="right">'.number_format($row1['total'],0).'</th>
					<td align="right">'.number_format($row2['tkt'],0).'</td>
					<td align="right">'.number_format($row2['srv'],0).'</td>
					<td align="right">'.number_format($row2['qui'],0).'</td>
					<td align="right">'.number_format($row2['ins'],0).'</td>
					<td align="right">'.number_format($row2['srv2'],0).'</td>
					<td align="right">'.number_format($row2['pro'],0).'</td>
					<th align="right">'.number_format($row2['total'],0).'</th>
					<th align="center" style="color:'.$clrs.'">'.$srv.'</th>
					<th align="center" style="color:'.$clrp.'">'.$pro.'</th>
					<th align="right">'.number_format($row1['mesac'],0).'</th>
					<th align="right">'.number_format($row2['mesap'],0).'</th>
					<th align="center" style="color:'.$clms.'">'.$cmes.'</th></tr>';
		$cancli1+=$row1['cantcli'];
		$cansrv1+=$row1['cantsrv'];
		$tkt1+=$row1['tkt'];
		$tkt2+=$row2['tkt'];
		$srv1+=$row1['srv'];
		$srv2+=$row2['srv'];
		$qui1+=$row1['qui'];
		$qui2+=$row2['qui'];
		$ins1+=$row1['ins'];
		$ins2+=$row2['ins'];
		$srv21+=$row1['srv2'];
		$srv22+=$row2['srv2'];
		$prd1+=$row1['pro'];
		$prd2+=$row2['pro'];
		$tot1+=$row1['total'];
		$tot2+=$row2['total'];
		$mesac+=$row1['mesac'];
		$mesap+=$row2['mesap'];
	}
}

$tpro=round((($prd1 / $prd2) -1) * 100 , 2);
$tsrv=round((($srv1 / $srv2) -1) * 100 , 2);
$tmes=round((($mesac / $mesap) -1) * 100 , 2);
$clrts=$tsrv>0?"green":"red";
$clrtp=$tpro>0?"green":"red";
$cltmes=$tmes>0?"green":"red";
$message.='<tr bgcolor="#FABA7C"><th>TOTAL SIN MallPlaza</th>
				<th>'.$cancli1.'</th>
				<th>'.$cansrv1.'</th>
				<th>'.number_format($tkt1,0).'</th>
				<th>'.number_format($srv1,0).'</th>
				<th>'.number_format($qui1,0).'</th>
				<th>'.number_format($ins1,0).'</th>
				<th>'.number_format($srv21,0).'</th>
				<th>'.number_format($prd1,0).'</th>
				<th>'.number_format($tot1,0).'</th>
				<th>'.number_format($tkt2,0).'</th>
				<th>'.number_format($srv2,0).'</th>
				<th>'.number_format($qui2,0).'</th>
				<th>'.number_format($ins2,0).'</th>
				<th>'.number_format($srv22,0).'</th>
				<th>'.number_format($prd2,0).'</th>
				<th>'.number_format($tot2,0).'</th>
				<th align="center" style="color:'.$clrts.'">'.$tsrv.'</th>
				<th align="center" style="color:'.$clrtp.'">'.$tpro.'</th>
				<th>'.number_format($mesac,0).'</th>
				<th>'.number_format($mesap,0).'</th>
				<th align="center" style="color:'.$cltmes.'">'.$tmes.'</th></tr>';
//Mall Plaza
$sql3="SELECT m.nomsln, ROUND(m.sumtkt/m.divi) AS tkt, ROUND(m.sumins/m.divi) AS ins, ROUND(m.tosrv/m.divi) AS srv, ROUND(m.toqui/m.divi) AS qui, ROUND(m.tosrv2/m.divi) AS srv2, ROUND(m.topro/m.divi) AS pro, ROUND(m.total/m.divi) AS total, m.mesac as mesac ,cantcliadmi(13,'2020-11-24') as cantcli, m.cantsrv as cantsrv FROM 
	(SELECT z.nomsln, z.sumtkt, z.sumins,(z.sumsrv-z.sumtkt-z.sumins-z.sumqui) AS tosrv, z.sumsrv AS tosrv2, z.sumqui AS toqui, z.sumpro AS topro, (z.sumsrv+z.sumpro) AS total, z.fact AS factura, (z.sumsrv+z.sumpro)/z.fact AS divi, z.mesac as mesac, z.cantsrv as cantsrv
	FROM (
	SELECT 
	s.slnnombre AS nomsln,
	SUM(CASE WHEN a.linea='01' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumsrv,
	SUM(CASE WHEN a.linea='01' THEN 1 ELSE 0 END ) AS cantsrv,
	SUM(CASE WHEN a.linea='04' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumtkt,
	SUM(CASE WHEN a.linea='05' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumins,
	SUM(CASE WHEN a.linea='02' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumpro,
	SUM(CASE WHEN a.linea='03' THEN (a.pmasiva*a.cantidad)*((100-a.pordes)/100) ELSE 0 END ) AS sumqui,
	bty_factadmi('2020-11-24',s.slnadmi) AS fact,
	bty_factadmi_mesacum('2020-11-24',s.slnadmi) AS mesac
	FROM btyfromadmi a 
	JOIN btysalon s ON s.slnadmi=a.salon
	WHERE a.fecha='2020-11-24' AND a.td='FS' AND a.estado='A' AND s.slncodigo =13) AS z ) AS m";
$res3=$conn->query($sql3);
while($row3=$res3->fetch_array()){
	$message.='<tr><td align="right">'.$row3['nomsln'].'</td>
				<td align="center">'.$row3['cantcli'].'</td>
				<td align="center">'.$row3['cantsrv'].'</td>
				<td align="right">'.number_format($row3['tkt'],0).'</td>
				<td align="right">'.number_format($row3['srv'],0).'</td>
				<td align="right">'.number_format($row3['qui'],0).'</td>
				<td align="right">'.number_format($row3['ins'],0).'</td>
				<td align="right">'.number_format($row3['srv2'],0).'</td>
				<td align="right">'.number_format($row3['pro'],0).'</td>
				<th align="right">'.number_format($row3['total'],0).'</th>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="right">0</td>
				<td align="center">N/A</td>
				<td align="center">N/A</td>
				<th align="right">'.number_format($row3['mesac'],0).'</th>
				<td align="right">0</td>
				<td align="center">N/A</td></tr>';
$cancli1+=$row3['cantcli'];
$cansrv1+=$row3['cantsrv'];
$tkt1+=$row3['tkt'];
$srv1+=$row3['srv'];
$qui1+=$row3['qui'];
$ins1+=$row3['ins'];
$srv21+=$row3['srv2'];
$prd1+=$row3['pro'];
$tot1+=$row3['total'];
$mesac+=$row3['mesac'];
}

$gtpro=round((($prd1 / $prd2) -1) * 100 , 2);
$gtsrv=round((($srv1 / $srv2) -1) * 100 , 2);
$gtmes=round((($mesac / $mesap) -1) * 100 , 2);
$clrgts=$gtsrv>0?"green":"red";
$clrgtp=$gtpro>0?"green":"red";
$clgtmes=$gtmes>0?"green":"red";
$message.='<tr bgcolor="#FABA7C"><th>GRAN TOTAL</th>
				<th>'.$cancli1.'</th>
				<th>'.$cansrv1.'</th>
				<th>'.number_format($tkt1,0).'</th>
				<th>'.number_format($srv1,0).'</th>
				<th>'.number_format($qui1,0).'</th>
				<th>'.number_format($ins1,0).'</th>
				<th>'.number_format($srv21,0).'</th>
				<th>'.number_format($prd1,0).'</th>
				<th>'.number_format($tot1,0).'</th>
				<th>'.number_format($tkt2,0).'</th>
				<th>'.number_format($srv2,0).'</th>
				<th>'.number_format($qui2,0).'</th>
				<th>'.number_format($ins2,0).'</th>
				<th>'.number_format($srv22,0).'</th>
				<th>'.number_format($prd2,0).'</th>
				<th>'.number_format($tot2,0).'</th>
				<th align="center" style="color:'.$clrgts.'">'.$gtsrv.'</th>
				<th align="center" style="color:'.$clrgtp.'">'.$gtpro.'</th>
				<th>'.number_format($mesac,0).'</th>
				<th>'.number_format($mesap,0).'</th>
				<th align="center" style="color:'.$clgtmes.'">'.$gtmes.'</th></tr>';




$message.='</table><br>';
//echo $message;
$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = "smtpout.secureserver.net";
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = "info@claudiachacon.com";
	$mail->Password = "Cchacon2018";
	$mail->setFrom('info@claudiachacon.com', 'Beauty Soft');
	$mail->addReplyTo('info@claudiachacon.com', 'Beauty Soft');
	$mail->Subject = utf8_decode('INFORME DIARIO DE VENTAS');
	$mail->msgHTML($message, dirname(__FILE__));

	$mail->addAddress('sistemas@claudiachacon.com');
	/*$mail->addAddress('jvelasco@claudiachacon.com');
	$mail->AddCC('sistemas@claudiachacon.com');
	$mail->AddCC('direccion.comercial@claudiachacon.com');
	$mail->AddCC('direccion.operaciones@claudiachacon.com');
	$mail->AddCC('direccion.administrativa@claudiachacon.com');
	$mail->AddCC('asistente.mercadeo@claudiachacon.com');*/
	if($mail->send()){
		echo 'Sent '.date("Y-m-d").PHP_EOL;
	}else{
		echo '**ERROR**'.date("Y-m-d").PHP_EOL;
	}
?>
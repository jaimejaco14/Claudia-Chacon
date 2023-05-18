<?php 

include(dirname(__FILE__).'/../cnx_data.php');
require dirname(__FILE__).'/../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
setlocale(LC_ALL,"es_ES");
$string=date("d/m/Y",strtotime("-1 days"));
$date = DateTime::createFromFormat("d/m/Y", $string);
$fecha = strftime("%d de %B del %Y",$date->getTimestamp());
#Registros App dia anterior y acumulada
	$sql="SELECT(
			SELECT COUNT(a.cacodigo)
			FROM btyclienteApp a
			WHERE a.cafechareg>='2019-10-29 18:00:00' and DATE(a.cafechareg)<CURDATE()) AS total, (
			SELECT COUNT(b.cacodigo)
			FROM btyclienteApp b
			WHERE DATE(b.cafechareg)= DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AS ayer";
	$res=$conn->query($sql);
	$row=$res->fetch_array();
	$treg=$row[0];
	$yreg=$row[1];
	
	$message='<html><style>th{font-size: .9em;}</style><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><h4>Informe registros y redenciones APP.</h4>';
	$message.='<table cellpadding="5" cellspacing="0" border="1">
			<tr><th colspan="3">Registros</th></tr>
			<tr>
				<td colspan="2">'.$fecha.'</td>
				<td>'.$yreg.'</td>
			</tr>
			<tr>
				<td colspan="2">Total</td>
				<td>'.$treg.'</td>
			</tr>
			</table><br>';
/************************************************************/


#TOTAL CITAS APP POR SALON
	$message.= '<table cellpadding="5" cellspacing="0" border="1">
					<tr><th colspan="2">Total Citas App por Salon*</th></tr>
					<tr>
						<th>Salon</th>
						<th>Cant</th>
					</tr>';
	$sql="SELECT s.slnnombre, COUNT(a.dacodigo) as cant
			FROM btydomicitaApp a
			JOIN btysalon s ON s.slncodigo=a.dcsalon
			WHERE DATE(a.dcfhreg)<CURDATE() AND s.slnextestado=1
			GROUP BY s.slnnombre order by cant desc";
	$res=$conn->query($sql);
	$total=0;
	while($row=$res->fetch_array()){
		$message.='<tr><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
		$total+=$row[1];
	}
	$message.='<tr><th>TOTAL*</th><th>'.$total.'</th></tr></table>*Acumulado con corte '.$fecha.'<br><br>';

/************************************************************/

	$message.='<table cellpadding="5" cellspacing="0" border="1">
					<tr><th colspan="2">Redencion Puntos Chacon*</th></tr>
					<tr><th>Salon</th><th>Redenciones</th></tr>';
		$sqlr="SELECT s.slnnombre AS sln, COUNT(r.cacedula) AS cant FROM btysalon s
				LEFT JOIN btyredencionpuntos r ON r.slncodigo=s.slncodigo AND DATE(r.pcfeho)<CURDATE()
				WHERE s.slnextestado=1 
				GROUP BY s.slncodigo";
		$resr=$conn->query($sqlr);
		$tsln=0;
		while($rowr=$resr->fetch_array()){
			$message.='<tr><td>'.$rowr['sln'].'</td><td align="center">'.$rowr['cant'].'</td></tr>';
			$tsln+=$rowr['cant'];
		}
		$message.='<tr><th>TOTAL*</th><th align="center">'.$tsln.'</th></tr>';
	$message.='</table>*Acumulado con corte '.$fecha;

/************************************************************/
#ENVIO DE CORREO
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
	$mail->Subject = utf8_decode('INFORME APP');
	$mail->msgHTML($message, dirname(__FILE__));

	$mail->addAddress('jvelasco@claudiachacon.com');
	$mail->AddCC('direccion.comercial@claudiachacon.com');
	$mail->AddCC('direccion.operaciones@claudiachacon.com');
	$mail->AddCC('direccion.administrativa@claudiachacon.com');
	$mail->AddCC('sistemas@claudiachacon.com');
	$mail->AddCC('asistente.mercadeo@claudiachacon.com');
	
	//echo $message;
	if($mail->send()){
		echo 'Sent '.date("Y-m-d").PHP_EOL;
	}else{
		echo 'error';
	}
?>
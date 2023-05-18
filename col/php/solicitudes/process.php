<?php
include '../../../cnx_data.php';
require '../../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadsol':
		$clb=$_POST['clb'];
		$sql="SELECT s.solcodigo,st.soltinombre,sr.solresnombre,se.solesnombre,sl.solescod,sl.sollogcomentarios,s.soldescripcion,sl.sollogfecha,
			(SELECT l.sollogfecha FROM btysolicitudes_log l WHERE l.solescod=1 AND l.solcodigo=sl.solcodigo) AS fecharad
			FROM btysolicitudes s
			join btysolicitudes_tipo st on st.solticod=s.solticod
			join btysolicitudes_responsable sr on sr.solrescod=s.solrescod
			join btysolicitudes_log sl on sl.solcodigo=s.solcodigo
			join btysolicitudes_estado se on se.solescod=sl.solescod
			WHERE s.clbcodigo=$clb and sl.sollogestado=1 order by solescod desc,fecharad desc";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('scod'=>$row['solcodigo'], 'stpo'=>$row['soltinombre'], 'srep'=>$row['solresnombre'], 'sest'=>$row['solesnombre'], 'sdte'=>$row['fecharad'], 'secd'=>$row['solescod'], 'scom'=>$row['sollogcomentarios'], 'sfres'=>$row['sollogfecha'], 'sdes'=>$row['soldescripcion']);
		}
		echo json_encode($array);
	break;
	case 'loadtisol':
		$sql="SELECT solticod, soltinombre, solrescod FROM btysolicitudes_tipo WHERE soltiestado=1 ORDER BY soltinombre";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['solticod'], 'nom'=>$row['soltinombre'], 'res'=>$row['solrescod']);
		}
		echo json_encode($array);
	break;
	case 'loadressol':
		$sql="SELECT solrescod, solresnombre FROM btysolicitudes_responsable WHERE solresestado=1 and usucodigo is not null";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['solrescod'], 'nom'=>$row['solresnombre']);
		}
		echo json_encode($array);
	break;
	case 'savesol':
		$clb=$_POST['clb'];
		$tisol=$_POST['tisol'];
		$rsol=$_POST['rsol'];
		$detsol=utf8_decode($_POST['detsol']);
		$sql="INSERT INTO btysolicitudes (solticod,clbcodigo,solrescod,soldescripcion) VALUES ($tisol,$clb,$rsol,'$detsol')";
		if($conn->query($sql)){
			$idsol = mysqli_insert_id($conn);
			$sqlog="INSERT INTO btysolicitudes_log (solcodigo,solrescod,solescod,sollogcomentarios,sollogfecha,sollogestado) VALUES ($idsol,$rsol,1,'Nueva solicitud',now(),1)";
			if($conn->query($sqlog)){
				$sqldt="SELECT st.soltinombre AS tipo,sl.sollogfecha AS ferad,s.soldescripcion AS sdes,t.trcrazonsocial AS col,u.usuemail AS mail
						FROM btysolicitudes s
						JOIN btysolicitudes_tipo st ON st.solticod=s.solticod
						JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
						JOIN btycolaborador c ON c.clbcodigo=s.clbcodigo
						JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
						JOIN btysolicitudes_responsable sr ON sr.solrescod=s.solrescod
						JOIN btyusuario u ON u.usucodigo=sr.usucodigo
						WHERE s.clbcodigo=$clb AND sl.sollogestado=1 AND sl.solcodigo=$idsol";
				mysqli_set_charset('utf8');
				$resdt=$conn->query($sqldt);
				$rowdt=$resdt->fetch_array();
				$destino=$rowdt['mail'];
				$col=$rowdt['col'];
				$tipo=$rowdt['tipo'];
				$ferad=$rowdt['ferad'];
				$desc=$rowdt['sdes'];
				//echo $destino;
				echo (SendMail($destino,$tipo,$ferad,$col,$desc))?1:4;
			}else{
				echo 2;
			}
		}else{
			echo 3;
		}
	break;
}
function SendMail($destino,$tipo,$ferad,$col,$desc){
	$message='<html><style>th{font-size: .9em;}</style><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><h4>Usted ha recibido una solicitud de parte de un colaborador.<br> A continuacion encontrara los detalles:</h4>';
	$message .= '<table cellpadding="5" cellspacing="5" border="1">
		<tbody>
			<tr style="background-color: #d2e3fc">
			  <th colspan="3"><center>NUEVA SOLICITUD</center></th>
			</tr>
			<tr><th colspan="1">TIPO</th><td colspan="2">'.$tipo.'</td></tr>
			<tr><th colspan="1">RADICADO</th><td colspan="2">'.$ferad.'</td></tr>
			<tr><th colspan="1">SOLICITANTE</th><td colspan="2">'.$col.'</td></tr>
			<tr><th colspan="1">DESCRIPCION</th><td colspan="2">'.$desc.'</td></tr>
		</tbody></table><h4>Para dar tramite a esta solicitud ingrese a<br> BeautySoft, modulo de GGHH -> Colaboradores -> Solicitudes. O haciendo click <a href="http://beauty.claudiachacon.com/beauty/beauty-rrhh/solicitudes/solicitudes.php">aqui</a></h4></body></html>';
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
	$mail->Subject = utf8_decode('Ha recibido una NUEVA SOLICITUD');
	$mail->msgHTML($message, dirname(__FILE__));
	//$mail->addAddress('app@claudiachacon.com');
	$mail->addAddress($destino);
	if($mail->send()){
		return true;
	}else{
		return false;
	}
}
?>
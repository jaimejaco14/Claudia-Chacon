<?php
include '../../cnx_data.php';
require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
$opc=$_POST['opc'];
switch($opc){
	case 'countsolpend':
		$usu=$_POST['usu'];
		$sql="SELECT COUNT(*) FROM btysolicitudes s
				JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
				JOIN btysolicitudes_responsable sr ON sl.solrescod=sr.solrescod
				WHERE sr.usucodigo=$usu AND sl.sollogestado=1 AND sl.solescod <> 3";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo $row[0];
	break;
	case 'loadsol':
		$usucod=$_POST['usucod'];
		$sql="SELECT s.solcodigo as scod,st.soltinombre AS tipo,t.trcrazonsocial AS col,se.solesnombre as est, sl.solescod as cest,sl.solrescod as rsol,s.soldescripcion as sdesc,sl.sollogcomentarios as comm,
				(SELECT l.sollogfecha FROM btysolicitudes_log l WHERE l.solescod=1 AND l.solcodigo=sl.solcodigo) AS actu
				FROM btysolicitudes s
				JOIN btysolicitudes_tipo st ON st.solticod=s.solticod
				JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
				JOIN btysolicitudes_estado se on se.solescod=sl.solescod
				JOIN btycolaborador c ON c.clbcodigo=s.clbcodigo
				JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
				JOIN btysolicitudes_responsable sr on s.solrescod=sr.solrescod
				JOIN btyusuario u on u.usucodigo=sr.usucodigo
				WHERE u.usucodigo=$usucod and sl.sollogestado=1";
		mysqli_set_charset($conn,'utf8');
		$res=$conn->query($sql);
		if($res->num_rows>0){
			while($data = mysqli_fetch_assoc($res)){
				$array['data'][] = $data;
			}
		}else{
			$array=array('data'=>'');
		}
		echo json_encode($array);
	break;
	case 'loadreasign':
		$codsol=$_POST['codsol'];
		$usu=$_POST['usu'];
		$sql="SELECT sr.solrescod,sr.solresnombre FROM btysolicitudes_responsable sr WHERE sr.solresestado=1 and sr.usucodigo <> $usu";
		mysqli_set_charset($conn,'utf8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['solrescod'],'nom'=>$row['solresnombre']));
		}
		echo json_encode($array);
	break;
	case 'reassign':
		$codsol=$_POST['codsol'];
		$usu=$_POST['usu'];
		$sql="UPDATE btysolicitudes_log sl, btysolicitudes s SET sl.sollogestado=0,s.solrescod=$usu WHERE sl.solcodigo=$codsol and s.solcodigo=$codsol";
		if($conn->query($sql)){
			$sql2="INSERT INTO btysolicitudes_log (solcodigo,solrescod,solescod,sollogcomentarios,sollogfecha,sollogestado) VALUES ($codsol,$usu,4,'REASIGNADA',NOW(),1)";
			if($conn->query($sql2)){
				$sqldt="SELECT st.soltinombre AS tipo,sl.sollogfecha AS ferad,s.soldescripcion AS sdes,t.trcrazonsocial AS col,u.usuemail AS mail,
						(SELECT sre.solresnombre
						FROM btysolicitudes_log slo
						JOIN btysolicitudes_responsable sre on sre.solrescod=slo.solrescod
						WHERE slo.solcodigo=sl.solcodigo AND slo.sollogestado=0
						ORDER BY slo.sollogfecha DESC
						LIMIT 1) as antes
						FROM btysolicitudes s
						JOIN btysolicitudes_tipo st ON st.solticod=s.solticod
						JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
						JOIN btycolaborador c ON c.clbcodigo=s.clbcodigo
						JOIN btytercero t ON t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento
						JOIN btysolicitudes_responsable sr ON sr.solrescod=s.solrescod
						JOIN btyusuario u ON u.usucodigo=sr.usucodigo
						WHERE sl.sollogestado=1 AND sl.solcodigo=$codsol";
				mysqli_set_charset('utf8');
				$resdt=$conn->query($sqldt);
				$rowdt=$resdt->fetch_array();
				$destino=$rowdt['mail'];
				$col=$rowdt['col'];
				$tipo=$rowdt['tipo'];
				$ferad=$rowdt['ferad'];
				$desc=$rowdt['sdes'];
				$antes=$rowdt['antes'];
				echo (SendMail($destino,$tipo,$ferad,$col,$desc,$antes))?1:0;
			}else{
				echo $sql2;
			}
		}else{
			echo $sql;
		}
	break;
	case 'entram':
		$codsol=$_POST['codsol'];
		$rsol=$_POST['rsol'];
		$sql="UPDATE btysolicitudes_log SET sollogestado=0 WHERE solcodigo=$codsol";
		if($conn->query($sql)){
			$sql="INSERT INTO btysolicitudes_log (solcodigo,solrescod,solescod,sollogcomentarios,sollogfecha,sollogestado) 
					VALUES ($codsol,$rsol,2,'En Tramite',NOW(),1)";
			echo $conn->query($sql)?1:0;
		}else{
			echo 0;
		}
	break;
	case 'answer':
		$codsol=$_POST['codsol'];
		$ans=utf8_decode($_POST['ans']);
		$usu=$_POST['usu'];
		$sql="UPDATE btysolicitudes_log SET sollogestado=0 WHERE solcodigo=$codsol";
		if($conn->query($sql)){
			$usr="SELECT sr.solrescod FROM btysolicitudes_responsable sr WHERE sr.usucodigo=$usu AND sr.solresestado=1";
			$rusr=$conn->query($usr);
			$rowusr=$rusr->fetch_array();
			$sres=$rowusr[0];
			$ins="INSERT INTO btysolicitudes_log (solcodigo,solrescod,solescod,sollogcomentarios,sollogfecha,sollogestado) VALUES ($codsol,$sres,3,'$ans',NOW(),1)";
			echo ($conn->query($ins))?1:0;
		}
	break;
	case 'selfiltro':
		$sql="SELECT se.solescod,se.solesnombre FROM btysolicitudes_estado se WHERE se.selesestado=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['solescod'],'nom'=>$row['solesnombre']);
		}
		echo json_encode($array);
	break;
}
function SendMail($destino,$tipo,$ferad,$col,$desc,$antes){
	$message='<html><style>th{font-size: .9em;}</style><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body><h4>'.$antes.' le ha asignado una solicitud.<br> A continuacion encontrara los detalles:</h4>';
	$message .= '<table cellpadding="5" cellspacing="5" border="1">
		<tbody>
			<tr style="background-color: #d2e3fc">
			  <th colspan="3"><center>RE-ASIGNACION DE SOLICITUD</center></th>
			</tr>
			<tr><th colspan="1">RE-ASIGNADA POR:</th><td colspan="2">'.$antes.'</td></tr>
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
	$mail->Subject = utf8_decode('SOLICITUD RE-ASIGNADA');
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
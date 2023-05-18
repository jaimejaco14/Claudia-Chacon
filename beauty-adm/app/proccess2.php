<?php 
header("Access-Control-Allow-Origin: *");
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
include '../../cnx_data.php';
require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
$opc=$_POST['opc'];
switch($opc){
	case 'slsalon':
		$sql="SELECT slncodigo as cod, slnnombre as nom FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['cod'],'nom'=>$row['nom']);
		}
		echo json_encode($array);
	break;
	case 'valcli':
		$ced=$_POST['ced'];
		$nom=$_POST['nom'];
		$ape=$_POST['ape'];
		$cel=$_POST['cel'];
		$ema=$_POST['ema'];
		if($_POST['dir']){
			$dir=$_POST['dir'];
		}else{
			$dir='';
		}
		$nomape=$nom.' '.$ape;
		$clicod='0';
		$sqlt="INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trctelefonomovil, brrcodigo, trcestado) VALUES (2,$ced,0,'$nom','$ape','$nomape','$cel',0,1) ON DUPLICATE KEY UPDATE trctelefonomovil='$cel', trcdireccion=(if('$dir'='',trcdireccion,'$dir'))";
		if($conn->query($sqlt)){
			$sqlc="SELECT c.clicodigo FROM btycliente c WHERE c.trcdocumento=$ced";
			$res=$conn->query($sqlc);
			if($res->num_rows>0){
				$row=$res->fetch_array();
				$clicod=$row[0];
				mysqli_query($conn,"UPDATE btycliente SET clitiporegistro='APP', cliemail='$ema' WHERE clicodigo=$clicod");
				$err='NO';
			}else{
				$clicod=mysqli_fetch_array(mysqli_query($conn,"SELECT max(clicodigo)+1 FROM btycliente"))[0];
				$sqlic="INSERT INTO btycliente (clicodigo,trcdocumento,tdicodigo,slncodigo,cliemail,clifecharegistro,clitiporegistro,cliestado,usucodigo) VALUES ($clicod,$ced,2,0,'$ema',curdate(),'APP',1,0)";
				if(!$conn->query($sqlic)){
					$err='ERRCLI';
				}else{
					$err='NO';
				}
			}
		}else{
			$err='ERRTER';
		}
		echo json_encode(array('ERR'=>$err,'clicod'=>$clicod));
	break;
	case 'loadcol':
		$crg	=	$_POST['crg'];
		$sln	=	$_POST['sln'];
		$date	=	$_POST['date'];
		$time	=	$_POST['time'];
		$dur	=	$_POST['dur'];
		$eki	=	$_POST['eki'];

		$sql="SELECT distinct(c.clbcodigo),concat(SUBSTRING_INDEX(t.trcnombres, ' ', 1),' ',SUBSTRING_INDEX(t.trcapellidos, ' ', 1)) AS nombre, cc.ctcnombre AS ctg
				FROM btyprogramacion_colaboradores p
				JOIN btycolaborador c ON p.clbcodigo=c.clbcodigo
				JOIN btytercero t ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo
				JOIN btycargo g ON g.crgcodigo=c.crgcodigo
				JOIN btyturno n ON p.trncodigo=n.trncodigo
				JOIN btycategoria_colaborador cc ON cc.ctccodigo=c.ctccodigo
				JOIN btyservicio_colaborador sc ON sc.clbcodigo=c.clbcodigo
				WHERE p.tprcodigo IN (1,9) AND g.crgcodigo=$crg AND p.slncodigo=$sln AND p.prgfecha='$date' 
				AND ('$time' BETWEEN n.trndesde AND n.trnhasta) 
				AND c.clbcodigo NOT IN (SELECT c.clbcodigo
				FROM btycita c
				JOIN btyservicio s ON c.sercodigo=s.sercodigo
				WHERE c.slncodigo=$sln AND c.citfecha= p.prgfecha AND bty_fnc_estadocita(c.citcodigo) in (1,2,10)
				AND (TIME_FORMAT('$time','%H:%i') BETWEEN TIME_FORMAT(c.cithora,'%H:%i') AND TIME_FORMAT(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60)), '%H:%i')
				OR (IF(MINUTE(TIME_FORMAT(ADDTIME('$time',SEC_TO_TIME(($dur-1)*60)),'%H:%i')) BETWEEN 1 AND 30,TIME_FORMAT(ADDTIME('$time',SEC_TO_TIME(($dur-1)*60)),'%H:30'),TIME_FORMAT(ADDTIME('$time', SEC_TO_TIME(($dur-1)*60)), '%H:00'))  BETWEEN TIME_FORMAT(c.cithora,'%H:%i') AND TIME_FORMAT(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60)), '%H:%i')))) AND bty_fnc_permisocolaborador('$date',c.clbcodigo)=0 AND bty_fnc_novedadcolaborador('$date',c.clbcodigo)=0 AND sc.sercodigo=$eki ORDER BY nombre";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['clbcodigo'],'nom'=>$row['nombre'],'ctg'=>$row['ctg']);
		}
		echo json_encode($array);
	break;
	case 'sercar':
		$ser=utf8_decode($_POST['ser']);
		$sql="SELECT c.crgcodigo,c.crgnombre, a.serequi, if(s.serduracion=0,60,s.serduracion) as serduracion FROM appservicio a
				JOIN btycargo c ON c.crgcodigo=a.sercargo
				JOIN btyservicio s ON a.serequi=s.sercodigo
				WHERE a.sernombre = '$ser'";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		echo json_encode(array('cod'=>$row[0],'nom'=>$row[1],'eki'=>$row[2],'dur'=>$row[3]));
	break;
	case 'incita':
		$dac=$_POST['dac'];
		$sln=$_POST['sln'];
		$cli=$_POST['cli'];
		$tel=$_POST['tel'];
		$cfe=$_POST['cfe'];
		$cho=$_POST['cho'];
		$col=explode(',' , $_POST['col']);
		$ser=explode(',' , $_POST['ser']);
		$dur=explode(',' , $_POST['dur']);
		$ins=0;
		$codct=array();
		for($i=0;$i<count($col);$i++){
			if($i==0){
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col[$i],$sln,$ser[$i],$cli,0,'$cfe','$cho',curdate(),curtime(),'')";
				if($conn->query($sql)){
					$sql2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (2, $codcita, curdate(), curtime(), 0, '')";
					$conn->query($sql2);
					$ins++;
				}
			}else{
				$sqls="SELECT hour(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60))) hh, MINUTE(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60))) mh
						FROM btycita c
						JOIN btynovedad_cita n ON c.citcodigo=n.citcodigo
						JOIN btyservicio s ON s.sercodigo=c.sercodigo
						WHERE c.citfecha = '$cfe' AND c.cithora='$cho' AND c.slncodigo=$sln AND c.clbcodigo=$col[$i] AND n.esccodigo IN (1,2,4,5,6)";
				$res=$conn->query($sqls);
				if($res->num_rows>0){
					$row=$res->fetch_array();
					if(($row['mh']>0) && ($row['mh']<=30)){
						$cho2=$row['hh'].':30:00';
					}else{
						$cho2=($row['hh']+1).':00:00';
					}
				}else{
					$cho2=$cho;
				}
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col[$i],$sln,$ser[$i],$cli,0,'$cfe','$cho2',curdate(),curtime(),'')";
				if($conn->query($sql)){
					$sql2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (2, $codcita, curdate(), curtime(), 0, '')";
					$conn->query($sql2);
					$ins++;
				}
			}
			array_push($codct, $codcita);
		}
		$cct=implode( ", ", $codct);
		if($ins==count($col)){
			$sql="";
			$upd="UPDATE btydomicitaApp a JOIN btycliente c ON c.trcdocumento = a.dccliced 
			SET a.daestado = 1, a.citcodigo='$cct', a.dcsalon=$sln
			WHERE c.clicodigo = $cli AND a.daestado = 0 AND a.dctipo='CITA' AND a.dacodigo=$dac";
			$conn->query($upd);
			/******************************************************************************************************/
			//send mail
			$email=mysqli_fetch_array(mysqli_query($conn,"SELECT cliemail FROM btycliente WHERE clicodigo=$cli"))[0];
			$nomsln=mysqli_fetch_array(mysqli_query($conn,"SELECT slnnombre FROM btysalon WHERE slncodigo=$sln"))[0];
			$fecha = strtotime($cfe);
			$fdate = SpanishDate($fecha);
			$hora = strtotime($cho);
			$fhora = date('h:i A', $hora);
			sendMailC($email,$nomsln,$fdate,$fhora);
			/******************************************************************************************************/
			//send SMS
			$cons=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(smsid)+1 FROM btyregistro_sms"))[0];
			$msj="CLAUDIA CHACON. Su cita fue agendada exitosamente para ".$cfe." a las ".$fhora.". Recuerde asistir con 10 minutos de anticipacion para garantizar su cupo.";
			if(sendSMS($tel,$msj,$cons)){
				mysqli_query($conn,"INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$cli,NOW(),'$tel')");
			}
			echo json_encode(array('res'=>'OK','sql'=>$upd));
		}else if($ins==0){
			echo json_encode(array('res'=>'ERR'));
		}else{
			echo json_encode(array('res'=>'ERP'));
		}
	break;
	case 'insdom':
		$dac=$_POST['dac'];
		$sln=$_POST['sln'];
		$cli=$_POST['cli'];
		$tel=$_POST['tel'];
		$cfe=$_POST['cfe'];
		$cho=$_POST['cho'];
		$col=explode(',' , $_POST['col']);
		$ser=explode(',' , $_POST['ser']);
		$dur=explode(',' , $_POST['dur']);
		$vsrv=$_POST['vsrv'];
		$vrec=$_POST['vrec'];
		$vtri=$_POST['vtri'];
		$vtrv=$_POST['vtrv'];
		$tdom=$_POST['tdom'];
		$ins=0;
		$codct=array();
		for($i=0;$i<count($col);$i++){
			if($i==0){
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col[$i],$sln,$ser[$i],$cli,0,'$cfe','$cho',curdate(),curtime(),'')";
				if($conn->query($sql)){
					$sql2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (10, $codcita, curdate(), curtime(), 0, '')";
					if($conn->query($sql2)){
						$conn->query("INSERT INTO btydomicilio (citcodigo,dmvalser,dmvalrec,dmvaltrai,dmvaltrar,dmtotal) VALUES ($codcita, $vsrv, $vrec, $vtri, $vtrv, $tdom)");
						$ins++;
					}
				}
			}else{
				$sqls="SELECT hour(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60))) hh, MINUTE(ADDTIME(c.cithora, SEC_TO_TIME((s.serduracion-1)*60))) mh
						FROM btycita c
						JOIN btynovedad_cita n ON c.citcodigo=n.citcodigo
						JOIN btyservicio s ON s.sercodigo=c.sercodigo
						WHERE c.citfecha = '$cfe' AND c.cithora='$cho' AND c.slncodigo=$sln AND c.clbcodigo=$col[$i] AND n.esccodigo IN (1,2,4,5,6)";
				$res=$conn->query($sqls);
				if($res->num_rows>0){
					$row=$res->fetch_array();
					if(($row['mh']>0) && ($row['mh']<=30)){
						$cho2=$row['hh'].':30:00';
					}else{
						$cho2=($row['hh']+1).':00:00';
					}
				}else{
					$cho2=$cho;
				}
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col[$i],$sln,$ser[$i],$cli,0,'$cfe','$cho2',curdate(),curtime(),'')";
				if($conn->query($sql)){
					$sql2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (10, $codcita, curdate(), curtime(), 0, '')";
					if($conn->query($sql2)){
						$conn->query("INSERT INTO btydomicilio (citcodigo,dmvalser,dmvalrec,dmvaltrai,dmvaltrar,dmtotal) VALUES ($codcita, $vsrv, $vrec, $vtri, $vtrv, $tdom)");
						$ins++;
					}
				}
			}
			array_push($codct, $codcita);
		}
		$cct=implode( ", ", $codct);
		if($ins==count($col)){
			$upd="UPDATE btydomicitaApp a 
					JOIN btycliente c ON c.trcdocumento = a.dccliced 
					SET a.daestado = 1, a.citcodigo='$cct'
					WHERE c.clicodigo = $cli AND a.daestado = 0 AND a.dctipo='DOMICILIO' AND a.dacodigo=$dac";
			$conn->query($upd);
			/******************************************************************************************************/
			//send mail
			$cdata=mysqli_fetch_array(mysqli_query($conn,"SELECT c.cliemail,t.trcdireccion FROM btytercero t JOIN btycliente c ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo WHERE c.clicodigo=$cli"));
			$email=$cdata[0];
			$clidir=$cdata[1];
			$fecha = strtotime($cfe);
			$fdate = SpanishDate($fecha);
			$hora = strtotime($cho);
			$fhora = date('h:i A', $hora);
			sendMailD($email,$clidir,$fdate,$fhora);
			/******************************************************************************************************/
			//send SMS
			$cons=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(smsid)+1 FROM btyregistro_sms"))[0];
			$msj="[CLAUDIA CHACON] Su Servicio en Casa fue agendado exitosamente para ".$cfe." a las ".$fhora.".";
			if(sendSMS($tel,$msj,$cons)){
				mysqli_query($conn,"INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$cli,NOW(),'$tel')");
			}
			echo json_encode(array('res'=>'OK','sql'=>$upd));
			/***************************************************************************************************************/
		}else if($ins==0){
			echo json_encode(array('res'=>'ERR'));
		}else{
			echo json_encode(array('res'=>'ERP'));
		}
	break;
	case 'lsln':
		$sql="SELECT slncodigo as cod, slnnombre as nom FROM btysalon WHERE slnextestado=1 order by slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['cod'],'nom'=>$row['nom']);
		}
		echo json_encode($array);
	break;
}
function sendSMS($teldest,$msj,$cons){
	ini_set("soap.wsdl_cache_enabled", 0);
	ini_set('soap.wsdl_cache_ttl',0);
    //Credenciales
    $user="w478";
    $pass="1nvv3l4sc0";
     //Parámetros
    $destino = "57".$teldest;
    $sender = "890223";
    $requestID = $cons;
    $recreq = "0";
    $dataCoding = "0";
    $message = $msj;
    $wsdl="https://www.gestormensajeriaadmin.com/RA/tggDataSoap?wsdl";

    $options = array(
     'login' => $user,
     'password' => $pass,
    );

    $client = new SoapClient($wsdl, $options);
    $client->__setLocation('https://www.gestormensajeriaadmin.com/RA/tggDataSoap?wsdl');
    $param=array("subscriber"=>$destino, "sender"=>$sender, "requestId"=>$requestID, "receiptRequest"=>$recreq, "dataCoding"=>$dataCoding, "message"=>$message);

    try
    {
        $response = $client->sendMessage($param);
        $array = json_decode(json_encode($response),true);
        $cres= $array['resultCode'];
        if($cres==0)
        {
            return true;
        }
        else
        {
            return false;
        }
    } 
    catch (Exception $e) 
    { 
        return false;
    }
}
function sendMailC($email,$nomsln,$cfe,$cho){
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = "smtpout.secureserver.net";
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = "info@claudiachacon.com";
	$mail->Password = "Cchacon2018";
	$mail->setFrom('info@claudiachacon.com', utf8_decode('Claudia Chacón Belleza y Estética'));

	$mail->IsHTML(true);

	$content = str_replace(array('%fecha%', '%hora%', '%sede%'),array($cfe, $cho, $nomsln), file_get_contents('mail/cita.html'));
	$mail->Body = $content;
	$mail->Subject = 'Su cita se ha programado correctamente';
	$mail->AltBody = 'Su cita se ha programado correctamente para la fecha: '.$cfe.' a las'.$cho.'';

	$mail->addAddress($email);
	//$mail->addAddress('sistemas@claudiachacon.com');
	if($mail->send()){
		return true;
	}else{
		return false;
	}
}
function sendMailD($email,$dir,$cfe,$cho){
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = "smtpout.secureserver.net";
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = "info@claudiachacon.com";
	$mail->Password = "Cchacon2018";
	$mail->setFrom('info@claudiachacon.com', utf8_decode('Claudia Chacón Belleza y Estética'));

	$mail->IsHTML(true);
	$content = str_replace(array('%fecha%', '%hora%', '%domicilio%'),array($cfe, $cho, $dir), file_get_contents('mail/domi.html'));
	$mail->Body = $content;
	$mail->Subject = 'Su servicio en casa se ha programado correctamente';
	$mail->AltBody = 'Su servicio en casa se ha programado correctamente para la fecha: '.$cfe.' a las'.$cho.'';

	$mail->addAddress($email);
	//$mail->addAddress('sistemas@claudiachacon.com');
	if($mail->send()){
		return true;
	}else{
		return false;
	}
}
function SpanishDate($FechaStamp){
   $ano = date('Y',$FechaStamp);
   $mes = date('n',$FechaStamp);
   $dia = date('d',$FechaStamp);
   $diasemana = date('w',$FechaStamp);
   $diassemanaN= array("Domingo","Lunes","Martes","Miercoles",
                  "Jueves","Viernes","Sabado");
   $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
             "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
   return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
}  
?>
<?php 
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

header("Access-Control-Allow-Origin: *");
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
include '../../cnx_data.php';
require '../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

require_once('../../lib/pubnubAPI/autoloader.php');
use Pubnub\Pubnub;
$pubnub = new Pubnub(array(
    'subscribe_key' => 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d',
    'publish_key' => 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d',
    'uuid' => '',
    'ssl' => false
));

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
	case 'slnfull':
		$sql="SELECT s.slncodigo, s.slnnombre,  
			CONCAT( TIME_FORMAT(h.hordesde, '%l:%i%p'),' a ', TIME_FORMAT(h.horhasta, '%l:%i%p')) AS hlv,
			CONCAT( TIME_FORMAT(h2.hordesde, '%l:%i%p'),' a ', TIME_FORMAT(h2.horhasta, '%l:%i%p')) AS hsb,
			CONCAT( TIME_FORMAT(h3.hordesde, '%l:%i%p'),' a ', TIME_FORMAT(h3.horhasta, '%l:%i%p')) AS hdom
			FROM btysalon s
			JOIN btyhorario_salon hs ON hs.slncodigo=s.slncodigo
			JOIN btyhorario_salon hs2 ON hs2.slncodigo=s.slncodigo
			JOIN btyhorario_salon hs3 ON hs3.slncodigo=s.slncodigo
			JOIN btyhorario h ON h.horcodigo=hs.horcodigo AND h.hordia IN ('LUNES','MARTES','MIERCOLES','JUEVES','VIERNES')
			JOIN btyhorario h2 ON h2.horcodigo=hs2.horcodigo AND h2.hordia = 'SABADO'
			JOIN btyhorario h3 ON h3.horcodigo=hs3.horcodigo AND h3.hordia = 'DOMINGO'
			WHERE s.slnextestado=1 AND h.horestado=1 AND h2.horestado=1 AND h3.horestado=1
			GROUP BY s.slncodigo order by s.slnnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['slncodigo'],
							'nom'=>$row['slnnombre'], 
							'hlv'=>$row['hlv'],
							'hsb'=>$row['hsb'],
							'hdm'=>$row['hdom'],
							'tmc'=>$row['slntmc']);
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
				WHERE p.tprcodigo IN (1,9,10) AND g.crgcodigo=$crg AND p.slncodigo=$sln AND p.prgfecha='$date' 
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
		//$ser=utf8_decode($_POST['ser']);
		$ser=trim($_POST['ser'],' ');
		$sql="SELECT c.crgcodigo,c.crgnombre, a.serequi, if(s.serduracion=0,60,s.serduracion) as serduracion FROM appservicio a
				JOIN btycargo c ON c.crgcodigo=a.sercargo
				JOIN btyservicio s ON a.serequi=s.sercodigo
				WHERE a.sernombre = '$ser'";
		//echo $sql;
		mysqli_set_charset($conn,'UTF8');
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
			$upd="UPDATE btydomicitaApp a JOIN btycliente c ON c.trcdocumento = a.dccliced SET a.daestado = 1, a.citcodigo='$cct' WHERE c.clicodigo = $cli AND a.daestado = 0 AND a.dctipo='CITA' AND a.dacodigo=$dac";
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
			$msj="CLAUDIA CHACON. Tu cita fue agendada exitosamente para ".$cfe." a las ".$fhora.". Recuerda asistir con 10 minutos de anticipacion para garantizar tu cupo.";
			if(sendSMS($tel,$msj,$cons)){
				mysqli_query($conn,"INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$cli,NOW(),'$tel')");
			}else{
				echo 'err SMS';
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
		if($_POST['cov']!=0){
			$cov='COVID_PRO ';
		}else{
			$cov='';
		}
		//$cov=$_POST['cov'];
		$ins=0;
		$codct=array();
		for($i=0;$i<count($col);$i++){
			if($i==0){
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col[$i],$sln,$ser[$i],$cli,0,'$cfe','$cho',curdate(),curtime(),'$cov')";
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
					SET a.daestado = 1, a.citcodigo='$cct', a.dcsalon=$sln
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
	case 'loadbarrio':
		$sql="SELECT b.brrcodigo, b.brrnombre FROM btybarrio b WHERE b.brrstado=1 ORDER BY b.brrnombre";
		mysqli_set_charset($conn,'UTF8');
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['brrcodigo'],'nom'=>$row['brrnombre']);
		}
		echo json_encode($array);
	break;
	case 'loadcli':
		$txt=utf8_decode($_POST['txt']);
		$sql="SELECT a.clicodigo, b.trcrazonsocial, b.trcdocumento, b.trcdireccion, b.brrcodigo, b.trctelefonomovil FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE b.trcrazonsocial like '%".$txt."%' or b.trcdocumento like '%".$txt."%'";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clicodigo'], 
				'nom'=>utf8_encode($row['trcrazonsocial']), 
				'ced'=>$row['trcdocumento'], 
				'address'=>utf8_encode($row['trcdireccion']), 
				'brr'=>$row['brrcodigo'], 
				'phone'=>$row['trctelefonomovil']));
		}
		echo json_encode($array);
	break;
	case 'loadser':
		$sql="SELECT a.sercodigo, a.sernombre, a.serduracion FROM btyservicio a WHERE a.serstado=1 order by sernombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['sercodigo'], 'nom'=>utf8_encode($row['sernombre']), 'dur'=>$row['serduracion']));
		}
		echo json_encode($array);
	break;
	case 'loadcolage':
		if($_POST['tp']=='C'){
			$tp="1,9";
		}else{
			$tp="10";
		}
		$sln  = $_POST['sln'];
		$feho = explode(' ',$_POST['feho']);
		$eki  = $_POST['srv'];
		$fe   = $feho[0];
		$ho   = $feho[1];
		$array=[];
		$sql="SELECT c.clbcodigo,CONCAT(SUBSTRING_INDEX(t.trcnombres,' ',1),' ', SUBSTRING_INDEX(t.trcapellidos,' ',1)) AS nomcol,pt.ptrnombre FROM btyprogramacion_colaboradores pc JOIN btycolaborador c ON c.clbcodigo=pc.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND c.tdicodigo=t.tdicodigo JOIN btyservicio_colaborador sc ON sc.clbcodigo=c.clbcodigo JOIN btyservicio s ON s.sercodigo=sc.sercodigo JOIN btyturno n ON n.trncodigo=pc.trncodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo=pc.ptrcodigo WHERE pc.slncodigo=$sln AND pc.prgfecha='$fe' AND sc.sercodigo=$eki 	AND pc.tprcodigo IN ($tp) AND (('$ho' BETWEEN n.trndesde AND n.trnhasta) AND (ADDTIME('$ho',SEC_TO_TIME(s.serduracion*60)) BETWEEN n.trndesde AND n.trnhasta)) AND bty_fnc_permisocolaborador('$fe',c.clbcodigo)=0 AND bty_fnc_novedadcolaborador('$fe',c.clbcodigo)=0 AND c.clbcodigo NOT IN (SELECT ct.clbcodigo FROM btycita ct JOIN btyservicio s2 ON s2.sercodigo=ct.sercodigo WHERE ct.citfecha='$fe' AND ct.slncodigo=$sln AND bty_fnc_estadocita(ct.citcodigo) in (1,2,10) AND (('$ho' BETWEEN ct.cithora AND ADDTIME(ct.cithora,SEC_TO_TIME((s2.serduracion-1)*60))) or (ADDTIME('$ho',SEC_TO_TIME((s.serduracion-1)*60)) BETWEEN ct.cithora AND ADDTIME(ct.cithora, SEC_TO_TIME(s2.serduracion*60)))))  AND c.clbcodigo NOT IN (SELECT z.clbcod FROM app_blockcol z WHERE z.feho=CONCAT('$fe',' ','$ho'))  order by nomcol,ptrnombre";
		mysqli_set_charset($conn,'UTF8');
		$res = $conn->query($sql);
		if($res->num_rows > 0){
			while($row=$res->fetch_array()){
				$array[]=array('cod'=>$row['clbcodigo'], 'nom'=>$row['nomcol'],'pt'=>$row['ptrnombre']);
			}
		}else{
			$array[]=array('cod'=>'ND', 'nom'=>'No hay Profesionales Disponibles', 'pt'=>'N/A');
		}
		echo json_encode($array);
	break;
	case 'agenda_c':
		$cli  = $_POST['cli'];
		$sln  = $_POST['sln'];
		$feh  = $_POST['feho'];
		$feho = explode(' ', $feh);
		$cfe  = $feho[0];
		$cho  = $feho[1];
		$seco = $_POST['seco'];
		$ins  = 0;
		$txtsrv = '';

		$atsrv = array();
		$codct = array();

		for($i=0;$i<count($seco);$i++){
			$col	= $seco[$i]['col'];
			$svc	= $seco[$i]['srv'];
			if($i==0){
				$codcita=mysqli_fetch_array(mysqli_query($conn,"SELECT MAX(citcodigo)+1 FROM btycita"))[0];
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col,$sln,$svc,$cli,0,'$cfe','$cho',curdate(),curtime(),'')";
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
						WHERE c.citfecha = '$cfe' AND c.cithora='$cho' AND c.slncodigo=$sln AND c.clbcodigo=$col AND n.esccodigo IN (1,2,4,5,6)";
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
				$sql="INSERT INTO btycita (citcodigo, meccodigo, clbcodigo, slncodigo, sercodigo, clicodigo, usucodigo, citfecha, cithora, citfecharegistro, cithoraregistro, citobservaciones) VALUES ($codcita,5,$col,$sln,$svc,$cli,0,'$cfe','$cho2',curdate(),curtime(),'')";
				if($conn->query($sql)){
					$sql2="INSERT INTO btynovedad_cita (esccodigo, citcodigo, citfecha, cithora, usucodigo, nvcobservaciones) VALUES (2, $codcita, curdate(), curtime(), 0, '')";
					$conn->query($sql2);
					$ins++;
				}
			}
			$nsrv = mysqli_fetch_array(mysqli_query($conn,"SELECT sernombre FROM btyservicio WHERE sercodigo=$svc"))[0];
			array_push($atsrv, $nsrv);
			array_push($codct, $codcita);
		}
		$strsrv = implode("," , $atsrv);
		$strcta = implode("," , $codct);
		$sqldc="INSERT INTO btydomicitaApp (dccliced, dcclinom, dccliape, dcclicel, dcfhdom, dcfhreg, dcservicio, dcobser, dctipo, dcsalon,citcodigo) 
		VALUES ('$ced', '$nom', '$ape', '$cel', '$feh', NOW(), '$strsrv', '','CITA', $sln, 0, '$strcta')";
		//$conn->query($sqldc);
		$pubnub->publish('cita'.$sln, $cfe);
		echo $ins;
	break;
	case 'kcovid':
		$sql="SELECT p.serprecio FROM appservicio_precio p WHERE p.sercodigo=91";
		$pre=mysqli_fetch_array(mysqli_query($conn,$sql))[0];
		echo $pre;
	break;
	case 'agenda_d':
		$cli  = $_POST['cli'];
		//obtener $ced, $nom, $ape, $cel a partir de $cli (codigo cliente)
		$dir  = $_POST['dir'];
		$brr  = $_POST['brr'];
		$sln  = $_POST['sln'];
		$feh  = $_POST['feho'];
		$feho = explode(' ', $feh);
		$cfe  = $feho[0];
		$cho  = $feho[1];
		$seco = $_POST['seco'];
		$kcov = $_POST['kcov'];
		$ins  = 0;
		$tp   = 'DOMICILIO';
		$sql="INSERT INTO btydomicitaApp (dccliced, dcclinom, dccliape, dcclidir, dcclicel, dcfhdom, dcfhreg, dcservicio, dcobser, dctipo, dcsalon,dccovid) VALUES ('$ced', '$nom', '$ape', '$dir', '$cel', '$feh', NOW(), '$tsrv', '$obs','$tp', $sln, $cov)";
	break;
	case 'valced':
		$ced = $_POST['ced'];
		$sql="SELECT t.trcnombres AS nom, t.trcapellidos AS ape, t.trctelefonomovil AS cel, c.cliemail AS mail
				FROM btycliente c
				natural JOIN btytercero t 
				WHERE c.trcdocumento=$ced";
		$res = $conn->query($sql);
		if($res->num_rows>0){
			$sw=1;
			$row = $res->fetch_array();
			$data=array('nom'=>$row['nom'], 'ape'=>$row['ape'], 'cel'=>$row['cel'], 'mail'=>$row['mail']);
		}else{
			$sw=0;
			$data='';
		}
		echo json_encode(array('sw'=>$sw, 'data'=>$data));
	break;
	case 'savecli':
		$ced  = $_POST['ced'];
		$nom  = $_POST['nom'];
		$ape  = $_POST['ape'];
		$rz   = $nom.' '.$ape;
		$mail = $_POST['mail'];
		$cel  = $_POST['cel'];
		$sqlsw  = "SELECT count(*) FROM btytercero WHERE trcdocumento=$ced";
		$sw     = mysqli_fetch_array(mysqli_query($conn,$sqlsw))[0];
		if($sw==0){
			$cod  = mysqli_fetch_array(mysqli_query($conn, "SELECT max(clicodigo)+1 FROM btycliente"))[0]; 
			$sql  = "INSERT INTO btytercero (tdicodigo,trcdocumento,trcnombres,trcapellidos,trcrazonsocial,trctelefonomovil) VALUES (2,$ced,'$nom','$ape','$rz','$cel')";
			$sql2 = "INSERT INTO btycliente (clicodigo,trcdocumento,tdicodigo,slncodigo,cliemail,clifecharegistro,clitiporegistro,ocucodigo,cliestado) VALUES ($cod,$ced,2,0,'$mail', CURDATE(),'INTERNO',0,1)";
		}else{
			$sql  = "UPDATE btytercero SET trcnombres='$nom', trcapellidos='$ape', trcrazonsocial='$rz', trctelefonomovil='$cel' WHERE trcdocumento=$ced";
			$sql2 = "UPDATE btycliente SET cliemail='$mail' WHERE trcdocumento=$ced";
		}
		if($conn->query($sql)){
			if($conn->query($sql2)){
				$rpt=1;
			}else{
				$rpt=$sql2;
			}
		}else{
			$rpt=$sql;
		}
		echo $rpt;
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
	$mail->Subject = 'Tu cita se ha programado correctamente';
	$mail->AltBody = 'Tu cita se ha programado correctamente para la fecha: '.$cfe.' a las'.$cho.'';

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
	$mail->Subject = 'Tu servicio en casa se ha programado correctamente';
	$mail->AltBody = 'Tu servicio en casa se ha programado correctamente para la fecha: '.$cfe.' a las'.$cho.'';

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
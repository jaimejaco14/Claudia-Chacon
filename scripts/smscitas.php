<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$today=date('d-m-Y');

function sendSMS($teldest,$nomdest,$cithora,$citsln,$citcrg,$cons){
	ini_set("soap.wsdl_cache_enabled", 0);
	ini_set('soap.wsdl_cache_ttl',0);
    //Credenciales
    $user="w478";
    $pass="1nvv3l4sc0";
     //Parámetros
    $destino = "57".$teldest;
    //$destino = "573005736906";
    $sender = "890223";
    $requestID =$cons;
    $recreq = "0";
    $dataCoding = "0";
    $message = "Hola ".$nomdest.". Claudia Chacon Belleza y estetica te recuerda tu cita con ".$citcrg." hoy a las ".$cithora." en ".$citsln;
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

$sql="SELECT cl.clicodigo, REPLACE(UPPER(t.trcrazonsocial),'Ñ','N') as clinom, DATE_FORMAT(c.cithora, '%h:%i %p') as cithora, s.slnnombre, t.trctelefonomovil, cg.crgnombre
		FROM btycita c
		JOIN btynovedad_cita nc ON nc.citcodigo=c.citcodigo
		JOIN btyestado_cita ec ON ec.esccodigo=nc.esccodigo
		JOIN btysalon s ON s.slncodigo=c.slncodigo
		JOIN btycliente cl ON cl.clicodigo=c.clicodigo
		JOIN btytercero t ON t.trcdocumento=cl.trcdocumento
		JOIN btycolaborador col ON col.clbcodigo=c.clbcodigo
		JOIN btycargo cg ON cg.crgcodigo=col.crgcodigo
		WHERE c.citfecha = CURDATE() AND (ec.esccodigo=bty_fnc_estadocita(c.citcodigo) AND ec.esccodigo IN (1,2,7,10)) and c.cithora > CURTIME()
		ORDER BY c.cithora";


$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res->num_rows > 0){

	$oldclicod  = '';
	$oldclinom  = '';
	$oldcithora = '';
	$oldcitsln  = '';
	$oldcittel  = '';
	$oldcitcrg  = '';

	$sql="SELECT ifnull(MAX(smsid),1) FROM btyregistro_sms";
	$max=mysqli_fetch_array(mysqli_query($conn,$sql));
	$cons=$max[0]+1;
	$sent=0;$errSQL=0;$nosent=0;$nophone=0;$rpt=0;
	
	while($row=mysqli_fetch_array($res)){

		$clicod  =$row['clicodigo'];
		$clinom  =utf8_encode($row['clinom']);
		$cithora =$row['cithora'];
		$citsln  =$row['slnnombre'];
		$cittel  =$row['trctelefonomovil'];
		$citcrg  =$row['crgnombre'];

		if(($clicod!=$oldclicod) || ($citcrg!=$oldcitcrg) || ($cithora!=$oldcithora)){
			if(strlen($cittel)==10){
				if(sendSMS($cittel,$clinom,$cithora,$citsln,$citcrg,$cons)){
					$sql="INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$clicod,NOW(),$cittel)";
					if($conn->query($sql)){
						$cons++;
						$sent++;
					}else{
						$errSQL++;
					}
				}else{
					$nosent++;
				}
			}else{
				$nophone++;
			}
		}else{
			$rpt++;
		}
		$oldclicod  =$clicod;
		$oldclinom  =$clinom;
		$oldcithora =$cithora;
		$oldcitsln  =$citsln;
		$oldcittel  =$cittel;
		$oldcitcrg  =$citcrg;
	}
	echo $today.' Enviados: '.$sent." No enviados: ".$nosent." Rept: ".$rpt." NoTel: ".$nophone." ErrorSQL: ".$errSQL. PHP_EOL;
}else{
	echo $today.' No hay citas'. PHP_EOL;
}

?>
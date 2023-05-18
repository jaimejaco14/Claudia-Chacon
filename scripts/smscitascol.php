<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$today=date('d-m-Y');
function sendSMS($teldest,$nomdest,$cithora,$clinom,$serv,$cons){
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
    $message = "Hola ".$nomdest.". Hoy a las ".$cithora." tienes ".$serv." con ".$clinom;
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
$sql="SELECT col.clbcodigo AS codcol, SUBSTRING_INDEX(t2.trcnombres,' ',1) AS nomcol, t2.trctelefonomovil AS telcol,c.clicodigo AS clicod, REPLACE(UPPER(t.trcrazonsocial),'Ñ','N') AS clinom, TIME_FORMAT(ct.cithora,'%h:%i%p') AS hora, s.sercodigo AS sercod, REPLACE(UPPER(s.sernombre),'Ñ','N') AS ser
	FROM btycliente c
	JOIN btytercero t ON c.trcdocumento=t.trcdocumento
	JOIN btycita ct ON ct.clicodigo=c.clicodigo
	JOIN btycolaborador col ON col.clbcodigo=ct.clbcodigo
	JOIN btytercero t2 ON col.trcdocumento=t2.trcdocumento
	JOIN btyservicio s ON s.sercodigo=ct.sercodigo
	JOIN btyusuario u ON u.usucodigo=ct.usucodigo
	JOIN btytercero t3 ON t3.trcdocumento=u.trcdocumento
	WHERE ct.citfecha= CURDATE() AND bty_fnc_estadocita(ct.citcodigo) IN (1,2,7,10) and ct.cithora > CURTIME()
	ORDER BY ct.cithora";
//echo $sql.'<br><br>';
$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res->num_rows > 0){
	$oldcodcol='';
	$oldnomcol='';
	$oldtelcol='';
	$oldclicod='';
	$oldcli='';
	$oldcithora='';
	$oldsercod='';
	$oldser='';

	$sql="SELECT ifnull(MAX(smsid),1) FROM btyregistro_sms";
	$max=mysqli_fetch_array(mysqli_query($conn,$sql));
	$cons=$max[0]+1;
	$sent=0;$errSQL=0;$nosent=0;$nophone=0;$rpt=0;
	while($row=mysqli_fetch_array($res)){

		$codcol=$row['codcol'];
		$nomcol=utf8_encode($row['nomcol']);
		$telcol=($row['telcol']);
		$clicod=$row['clicod'];
		$cli=utf8_encode($row['clinom']);
		$cithora=$row['hora'];
		$sercod=$row['sercod'];
		$ser=utf8_encode($row['ser']);


		if(($codcol!=$oldcodcol) || ($ser!=$oldser) || ($cithora!=$oldcithora)){
			if(strlen($telcol)==10){
				if(sendSMS($telcol,$nomcol,$cithora,$cli,$ser,$cons)){
					$sql="INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$clicod,NOW(),$telcol)";
					//$sql="select curdate()";
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
		$oldcodcol=$codcol;
		$oldnomcol=$nomcol;
		$oldtelcol=$telcol;
		$oldclicod=$clicod;
		$oldcli=$cli;
		$oldcithora=$cithora;
		$oldsercod=$sercod;
		$oldser=$ser;
	}
	echo $today.' Enviados: '.$sent." /No enviados: ".$nosent." /Rept: ".$rpt." /NoTel: ".$nophone." /ErrorSQL: ".$errSQL. PHP_EOL;
}else{
	echo $today.' No hay citas'. PHP_EOL;
}

?>
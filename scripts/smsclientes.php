<?php 
setlocale(LC_CTYPE, 'es_ES');
include(dirname(__FILE__).'/../cnx_data.php');
function sendSMS($teldest,$nomdest,$cons){
	ini_set("soap.wsdl_cache_enabled", 0);
	ini_set('soap.wsdl_cache_ttl',0);
    //Credenciales
    $user="w478";
    $pass="1nvv3l4sc0";
     //Parámetros
    $destino = "57".$teldest;
    //$destino = "573012542547";
    $sender = "890223";
    $requestID =$cons;
    $recreq = "0";
    $dataCoding = "0";
    //******************************************
    if((strlen($nomdest)<=2) || ($nomdest=='DE') || ($nomdest=='DEL')){
    	$nomdest='';
    }
    $message = "[CLAUDIA CHACON] ".$nomdest." ACUMULA MILLAS LIFEMILES con cada servicio y conoce tu destino favorito. #somosmasbelleza claudiachacon.com";
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
        echo $e;
    }
}
/*$sql="SELECT c.clbcodigo, SUBSTRING_INDEX(t.trcnombres,' ',1) AS trcrazonsocial, t.trctelefonomovil
        FROM btycolaborador c
        JOIN btytercero t ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo
        WHERE c.clbestado=1 AND bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO' and length(t.trctelefonomovil)=10";*/
$sql="SELECT c.clicodigo, CONVERT(CAST(substring_index(REPLACE(UPPER(t.trcnombres),'Ñ','N'),' ',1) AS BINARY) USING utf8) as trcrazonsocial, t.trctelefonomovil
		FROM btycliente c
		JOIN btytercero t ON t.trcdocumento=c.trcdocumento and t.tdicodigo=c.tdicodigo
		WHERE t.trcestado=1 and LENGTH(t.trctelefonomovil)=10 and t.trctelefonomovil NOT IN (select smsdestino from btyregistro_sms  where date(smsfecha)=curdate() and time(smsfecha)<'14:45:00')";
//echo $sql.'<br><br>';

/*$sql="SELECT pr.clicodigo, CONVERT(CAST(t.trcnombres AS BINARY) USING utf8) as trcrazonsocial, t.trctelefonomovil
FROM btypromoregistro pr
JOIN btycliente c ON c.clicodigo=pr.clicodigo
JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
WHERE pr.clicodigo NOT IN (
SELECT rp.clicodigo
FROM btyredencion_promo rp) AND pr.proestado=1";*/
$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res->num_rows > 0){
	$sql2="SELECT ifnull(MAX(smsid),1) FROM btyregistro_sms";
	$max=mysqli_fetch_array(mysqli_query($conn,$sql2));
	$cons=$max[0]+1;
	$sent=0;$errSQL=0;$nosent=0;$nophone=0;$rpt=0;
	while($row=mysqli_fetch_array($res)){
		$clicod=$row['clicodigo'];
		$clinom=utf8_encode($row['trcrazonsocial']);
		$cittel=$row['trctelefonomovil'];
        $nombre = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $clinom));
		if(sendSMS($cittel,$nombre,$cons)){
			$sql3="INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,$clicod,NOW(),$cittel)";
			if($conn->query($sql3)){
				$cons++;
				$sent++;
			}else{
				$errSQL++;
			}
		}else{
			$nosent++;
		}
        //echo $nombre.'<br>';
	}
	echo $today.' Enviados: '.$sent." No enviados: ".$nosent." Rept: ".$rpt." NoTel: ".$nophone." ErrorSQL: ".$errSQL. PHP_EOL;
}else{
    echo 'No hay citas';
}
  // echo $nombre;
?>
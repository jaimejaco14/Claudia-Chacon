<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$today=date('d-m-Y');
function sendSMS($teldest,$nomdest,$cons){
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
    $message = "Felicidades ".$nomdest."! En la semana de tu cumpleanos(de domingo a domingo), CLAUDIA CHACON te regala 20% dcto en todos nuestros servicios. Solo Presenta tu cedula y disfruta!";
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
$sql="SELECT SUBSTRING_INDEX(UPPER(t.trcnombres),' ',1) as clinom,t.trctelefonomovil,c.clicodigo
		FROM btycliente c
		JOIN btytercero t ON c.trcdocumento=t.trcdocumento
		WHERE MONTH(c.clifechanacimiento)= MONTH(CURDATE()) AND DAY(c.clifechanacimiento)= DAY(CURDATE())";
//echo $sql.'<br><br>';
$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res->num_rows > 0){
	$oldclicod='';
	$oldclinom='';
	$oldcittel='';
	$sql="SELECT ifnull(MAX(smsid),1) FROM btyregistro_sms";
	$max=mysqli_fetch_array(mysqli_query($conn,$sql));
	$cons=$max[0]+1;
	$sent=0;$errSQL=0;$nosent=0;$nophone=0;$rpt=0;
	while($row=mysqli_fetch_array($res)){
		$clicod=$row['clicodigo'];
		$clinom=utf8_encode($row['clinom']);
		$cittel=$row['trctelefonomovil'];
		if($clicod!=$oldclicod){
			if(strlen($cittel)==10){
				if(sendSMS($cittel,$clinom,$cons)){
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
		$oldclicod=$clicod;
		$oldclinom=$clinom;
		$oldcittel=$cittel;
	}
	echo $today.' Enviados: '.$sent." No enviados: ".$nosent." Rept: ".$rpt." NoTel: ".$nophone." ErrorSQL: ".$errSQL. PHP_EOL;
}else{
	echo $today.' No hay cumple'. PHP_EOL;
}

?>
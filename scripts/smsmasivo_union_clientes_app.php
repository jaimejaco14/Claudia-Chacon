<?php 
include(dirname(__FILE__).'/../cnx_data.php');
$today=date("Y-m-d H:i:s");

function sendSMS($teldest,$cons){
    ini_set("soap.wsdl_cache_enabled", 0);
    ini_set('soap.wsdl_cache_ttl',0);
    //Credenciales
    $user="w478";
    $pass="1nvv3l4sc0";
     //Parametros
    $destino = "57".$teldest;
    //$destino = "573012542547";
    $sender = "890223";
    $requestID =$cons;
    $recreq = "0";
    $dataCoding = "0";
    //******************************************
    $message = "Últimos 2 días para tu CAMBIO DE LOOK con 25% de descuento (color y keratinas). Agenda tu cita en CLAUDIA CHACON al 3103428912";
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
//Todos los clientes tanto de beuaty como de la app
$sql="SELECT DISTINCT(t.trctelefonomovil) AS trctelefonomovil FROM btytercero t WHERE t.trcdocumento IN (SELECT trcdocumento FROM btycliente WHERE slncodigo IN (8, 11, 3, 9, 4, 12, 10)) AND t.trcestado=1 AND LENGTH(t.trctelefonomovil)=10 
AND t.trctelefonomovil NOT LIKE '%00000%'
AND t.trctelefonomovil NOT LIKE '%11111%'
AND t.trctelefonomovil NOT LIKE '%22222%'
AND t.trctelefonomovil NOT LIKE '%33333%'
AND t.trctelefonomovil NOT LIKE '%44444%'
AND t.trctelefonomovil NOT LIKE '%55555%'
AND t.trctelefonomovil NOT LIKE '%66666%'
AND t.trctelefonomovil NOT LIKE '%77777%'
AND t.trctelefonomovil NOT LIKE '%88888%'
AND t.trctelefonomovil NOT LIKE '%99999%' 
AND SUBSTRING(t.trctelefonomovil,1,1)='3' AND SUBSTRING(t.trctelefonomovil,2,1) <= '5'
UNION SELECT DISTINCT(a.cacelular) AS trctelefonomovil FROM btyclienteApp a WHERE a.cacelular NOT IN  (SELECT t.trctelefonomovil FROM btytercero t WHERE t.trcdocumento IN (SELECT trcdocumento FROM btycliente) AND t.trcestado=1 AND LENGTH(t.trctelefonomovil)=10 
AND t.trctelefonomovil NOT LIKE '%00000%'
AND t.trctelefonomovil NOT LIKE '%11111%'
AND t.trctelefonomovil NOT LIKE '%22222%'
AND t.trctelefonomovil NOT LIKE '%33333%'
AND t.trctelefonomovil NOT LIKE '%44444%'
AND t.trctelefonomovil NOT LIKE '%55555%'
AND t.trctelefonomovil NOT LIKE '%66666%'
AND t.trctelefonomovil NOT LIKE '%77777%'
AND t.trctelefonomovil NOT LIKE '%88888%'
AND t.trctelefonomovil NOT LIKE '%99999%' 
AND SUBSTRING(t.trctelefonomovil,1,1)='3' AND SUBSTRING(t.trctelefonomovil,2,1) <= '5'
ORDER BY `t`.`trctelefonomovil`  DESC) AND LENGTH(a.cacelular)=10 AND 
a.cacelular NOT LIKE '%00000%' AND
 a.cacelular NOT LIKE '%11111%' AND 
 a.cacelular NOT LIKE '%22222%' AND 
 a.cacelular NOT LIKE '%33333%' AND 
 a.cacelular NOT LIKE '%44444%' AND 
 a.cacelular NOT LIKE '%55555%' AND 
 a.cacelular NOT LIKE '%66666%' AND 
 a.cacelular NOT LIKE '%77777%' AND 
 a.cacelular NOT LIKE '%88888%' AND 
 a.cacelular NOT LIKE '%99999%' AND SUBSTRING(a.cacelular,1,1)='3' AND SUBSTRING(a.cacelular,2,1) <= '5'";

$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res->num_rows > 0){
    $sent=0;$errSQL=0;$nosent=0;$nophone=0;$rpt=0;
    while($row=mysqli_fetch_array($res)){
        $sql2="SELECT ifnull(MAX(smsid)+1 ,1)  FROM btyregistro_sms";
        $cons=mysqli_fetch_array(mysqli_query($conn,$sql2))[0];
        $cittel=$row['trctelefonomovil'];
        if(sendSMS($cittel,$cons)){
            $sql3="INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,0,NOW(),$cittel)";
            if($conn->query($sql3)){
                $sent++;
            }else{
                $errSQL++;
            }
        }else{
            $nosent++;
        }
    }
    echo $today.'| Enviados: '.$sent." | No enviados: ".$nosent." | Rept: ".$rpt." | NoTel: ".$nophone." | ErrorSQL: ".$errSQL. PHP_EOL;
}else{
    echo 'No hay citas';
}
?>
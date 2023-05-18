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
    $message = "CLAUDIA CHACON - Debido al Toque de queda, nuestros salones estaran cerrados hasta el martes. Reagenda tu cita en el 3103428912 o en la APP. Nos vemos pronto!";
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
//Todos los clientes
$tel=array(3215111353,
    3058171808,
    3014162863,
    3002501416,
    3004726354,
    3138708170,
    3017995000,
    3002472335,
    3214639379,
    3216966495,
    3164745326,
    3208075948,
    3007599461,
    3215812594,
    3015641031,
    3013361099,
    3212055498,
    3015204785,
    3004586425,
    3124526269,
    3017601536,
    3005124689,
    3053404310,
    3157480826,
    3205429129,
    3166195451,
    3135764336,
    3124319585,
    3008027309,
    3157226013,
    3174011846,
    3212087263,
    3107175098,
    3106565305,
    3106079582,
    3157269149,
    3014581218,
    3174365091,
    3006665057,
    3157266031,
    3014566916,
    3157344577,
    3006048229,
    3014595200,
    3157357947,
    3157521365,
    3132849079,
    3003883349,
    3126246993,
    3008082229,
    3013416367,
    3003128384,
    3008144382,
    3142968704,
    3174314313,
    3167446936,
    3008891690,
    3013796315,
    3205631450,
    3158753476,
    3043694832,
    3018596666,
    3008030212,
    3007192281,
    3135719844,
    3106107156,
    3106118712,
    3046520268,
    3008117966,
    3157787973,
    3006524190,
    3008333302,
    3154722280,
    3218158636,
    3016989632,
    3118473470,
    3008149994,
    3143592088,
    3106357832,
    3176792335,
    3003360675,
    3176427687,
    3216516747,
    3043537642,
    3157188142,
    3168740115,
    3206856051,
    3184161153,
    3004188160);

    //$tel=array(3012542547,3003336223);
    foreach ($tel as $key) {
        $sql2="SELECT MAX(smsid)+1 FROM btyregistro_sms";
        $cons=mysqli_fetch_array(mysqli_query($conn,$sql2))[0];
        if(sendSMS($key,$cons)){
            $sql3="INSERT INTO btyregistro_sms (smsid,clicodigo,smsfecha,smsdestino) VALUES ($cons,0,NOW(),$key)";
            if($conn->query($sql3)){
                $sent++;
            }else{
                $errSQL++;
            }
        }else{
            $nosent++;
        }
    }
    echo $sent;
?>
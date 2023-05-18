<?php 
include '../../cnx_data.php'; 
function get_real_ip(){

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}
//$ipaddress = get_real_ip();
$ipaddress = '190.29.30.177';
$sql="SELECT slncodigo,slnnombre,slntelefonofijo,slnextensiontelefonofijo,slntelefonomovil FROM btysalon where slnipaddress='$ipaddress'";
$res=$conn->query($sql);
if($res->num_rows>0){
    $row=$res->fetch_array();
    $slncod=$row['slncodigo'];
    $slnnombre=$row['slnnombre'];
    $slntel=$row['slntelefonofijo'];
    $slnext=$row['slnextensiontelefonofijo'];
    $slncel=$row['slntelefonomovil'];
    //carga de datos de eventos 
    $sql="SELECT ipeenlace as link, TIME_FORMAT(ipehoraini, '%H:%i') as hini , TIME_FORMAT(ipehorafin, '%H:%i') as hfin, ipetipo as tipo FROM btyimg_pantalla_evento WHERE ipeestado=1";
    $res=$conn->query($sql);
    if($res->num_rows>0){
        $row=$res->fetch_array();
        $link=$row['link'];
        $hini=$row['hini'];
        $hfin=$row['hfin'];
        $swc=$row['tipo'];
    }else{
        $sql="SELECT ipeenlace as link, TIME_FORMAT(ipehoraini, '%H:%i') as hini , TIME_FORMAT(ipehorafin, '%H:%i') as hfin, ipetipo as tipo FROM btyimg_pantalla_evento WHERE ipedefault=1";
        $res=$conn->query($sql);
        if($res->num_rows>0){
            $row=$res->fetch_array();
            $link=$row['link'];
            $hini=$row['hini'];
            $hfin=$row['hfin'];
            $swc=$row['tipo'];
        }
    }
}else{
	exit;  
}

?>

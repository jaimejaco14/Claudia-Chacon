<?php
session_start();
unset($_SESSION['clbcodigo']);
unset($_SESSION['trcdocumento']);
unset($_SESSION['nombre']);           
unset($_SESSION['apellido']);              
unset($_SESSION['incluturno']);      
unset($_SESSION['cargo']);                   
unset($_SESSION['email']);           
unset($_SESSION['categoria']);
session_destroy();
if(isset($_COOKIE['datacookie'])){
    $jsoncookie->codcol     = "";
    $jsoncookie->idnum      = "";
    $jsoncookie->nombre     = "";
    $jsoncookie->apellido   = "";
    $jsoncookie->sb         = "";
    $jsoncookie->cargo      = "";
    $jsoncookie->email      = "";
    $jsoncookie->categoria  = "";
    $jsoncookie->logstatus = 0;
    setcookie("datacookie", json_encode($jsoncookie), time()+31556926 ,'/');
    unset($_COOKIE['datacookie']);
}
header("Location: index.php");
?>

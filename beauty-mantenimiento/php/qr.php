<?php
include "../../lib/phpqrcode/qrlib.php";
$QRurl="http://beautysoft.claudiachacon.com/beauty/externo/activos.php?idact=".$_GET['codact'];

QRcode::png($QRurl,null,'L',6,1);
?>
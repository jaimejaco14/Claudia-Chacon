<?php

include '../cnx_data.php';

$sql = "SELECT `usulogin`, `usuclave` FROM `btyusuario` WHERE usulogin = '".$_POST['usuario']."' LIMIT 1";
$clave = md5($_POST['pass']);
$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
	while ($row = $result->fetch_assoc()) {
		if ($row['usuclave'] == $clave) {
        	$_SESSION['user_session'] = $row['usulogin'];	
			echo "TRUE";
		}else{
			echo 'false';
		}
	}
}
?>
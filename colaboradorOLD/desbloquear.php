<?php
session_start();

 include '../cnx_data.php';

$sql = "SELECT a.trcdocumento, a.clbclave FROM btycolaborador a WHERE a.trcdocumento = '".$_POST['usuario']."' ";



$clave = md5($_POST['pass']);

$result = $conn->query($sql);

if ($result->num_rows == 1) 
{
	$row = $result->fetch_assoc();
	
	if ($row['clbclave'] == $clave) 
	{
  		$_SESSION['user_session'] = $row['trcdocumento'];	
		echo "TRUE";
	}
	else
	{
		echo "FALSE";
	}

	
}

?>
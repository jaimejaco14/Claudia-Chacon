<?php 
	include '../../cnx_data.php';
    	include("../funciones.php");

    	$clave = md5($_POST['pass']);

    	$Query = mysqli_query($conn, "SELECT * FROM btycliente WHERE trcdocumento = '".$_POST['usuario']."' ");

    	if (mysqli_num_rows($Query) > 0) 
    	{
    		$QueryPass = mysqli_query($conn, "SELECT a.clicodigo, a.trcdocumento, b.trcrazonsocial FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['usuario']."' AND a.cliclave = '".$clave."' ");

    		if (mysqli_num_rows($QueryPass) > 0) 
    		{
    			$row = mysqli_fetch_array($QueryPass);
    			$_SESSION['codicliente'] = $row['clicodigo'];
    			$_SESSION['documento']   = $row['trcdocumento'];
    			$_SESSION['nombres']     = $row['trcrazonsocial'];

    			echo 1; //ok
    		}
    		else
    		{
    			echo 2;
    		}
    	}
    	else
    	{
    		echo 3;
    	}

    	mysqli_close($conn);
?>
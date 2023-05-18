<?php 
	include"../../cnx_data.php";
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{
		case 'changeState':

			$sql = mysqli_query($conn, "SELECT clbacceso FROM btycolaborador WHERE clbcodigo = '".$_POST['codcol']."' ");

			$row = mysqli_fetch_array($sql);

			if ($row['clbacceso'] == 0 || $row['clbacceso'] == NULL ) 
			{
				$QueryEstado = mysqli_query($conn, "UPDATE btycolaborador SET clbacceso = 1 WHERE clbcodigo = '".$_POST['codcol']."' ");

				if ($QueryEstado) 
				{
					echo 1;
				}				
			}
			else
			{
				$QueryEstado = mysqli_query($conn, "UPDATE btycolaborador SET clbacceso = 0 WHERE clbcodigo = '".$_POST['codcol']."' ");

				if ($QueryEstado) 
				{
					echo 2;
				}
			}		

			break;

		case 'loadSwitch':
			
			$sql = mysqli_query($conn, "SELECT clbacceso FROM btycolaborador WHERE clbcodigo = '".$_POST['codcol']."' ");

			$row = mysqli_fetch_array($sql);

			if ($row['clbacceso'] == 0 || $row['clbacceso'] == NULL ) 
			{
				echo 1;
			}
			else
			{
				echo 2;
			}

			break;

		case 'genPass':

			function generaPass()
			{

				$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
				$longitudCadena=strlen($cadena);

				$pass = "";
				$longitudPass=8;

				for($i=1 ; $i<=$longitudPass ; $i++)
				{

				$pos=rand(0,$longitudCadena-1);

				$pass .= substr($cadena,$pos,1);
				}

				return $pass;
			}

			$clave = generaPass();
    		$password = md5($clave);

    		$Sql = mysqli_query($conn, "UPDATE btycolaborador SET clbclave = '".$password."' WHERE clbcodigo = '".$_POST['codcol']."' ");

    		if ($Sql) 
    		{
    			echo json_encode(array("des" => $clave, "cif" => $password));    			
    		}

			
			break;
		
		default:
			# code...
			break;
	}

?>
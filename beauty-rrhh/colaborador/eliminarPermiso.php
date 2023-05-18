<?php 
	include '../../cnx_data.php';


	switch ($_POST['opcion']) 
	{
		case 'eliminar':
			
			$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET perestado = 0 WHERE percodigo = '".$_POST['cod']."' ");

			if ($sql) 
			{
				echo 1;
			}


			break;

		case 'anular':

			$sql = mysqli_query($conn, "UPDATE btypermisos_colaboradores SET perestado_tramite = 'ANULADO' WHERE percodigo = '".$_POST['cod']."' ");

			if ($sql) 
			{
				echo 1;
			}
			
			break;
		
		default:
			# code...
			break;
	}


	
?>
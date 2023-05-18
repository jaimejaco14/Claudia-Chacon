<?php 
	session_start();
	include("../../cnx_data.php");
	include("../funciones.php");

	switch ($_POST['opcion']) 
	{

		case 'listado':

			$QueryPQRF = mysqli_query($conn, "SELECT a.pgrfcodigo, a.pqrftipo, a.pqrffecha, a.pqrfhora, b.slnnombre, a.pgrfnombre_contacto, a.pgrfestado FROM btypqrf AS a, btysalon AS b WHERE a.slncodigo=b.slncodigo");

				if(mysqli_num_rows($QueryPQRF) > 0)
				{
			 		while($data = mysqli_fetch_assoc($QueryPQRF))
			 		{
			        	$array['data'][] = $data;
			     	} 

			     	$array= utf8_converter($array); 
			     	echo json_encode($array); 
			    
			  	}
			  	else
			  	{
			    	echo json_encode(array("res" =>"vacio"));
			  	}

			
			break;

		case 'detalles':


			$QueryDetalles = mysqli_query($conn, "SELECT a.pgrfcodigo, d.trcrazonsocial, a.pgrdescripcion, a.pgrftelefonofijo_contacto, a.pgrfemail_contacto, a.pqrftipo, a.pqrffecha, a.pqrfhora, b.slnnombre, a.pgrfnombre_contacto, a.pgrftelefonomovil_contacto, a.pgrfestado, a.usucodigo, a.pgrrespuesta_descripcion, a.pqrfrespuesta_fecha, a.pqrfrespuesta_hora FROM btypqrf AS a, btysalon AS b, btyusuario AS c, btytercero AS d WHERE a.slncodigo=b.slncodigo AND c.usucodigo=a.usucodigo AND d.trcdocumento=c.trcdocumento AND a.pgrfcodigo = '".$_POST['cod']."' ");

				$jsondetalle = array();

				$row = mysqli_fetch_array($QueryDetalles); 
				
					$jsondetalle[] = array(
						'id'	 	=> $row['pgrfcodigo'],
						'desc'	 	=> $row['pgrdescripcion'],
						'nombre' 	=> $row['pgrfnombre_contacto'],
						'fijo'	 	=> $row['pgrftelefonofijo_contacto'],
						'email'	 	=> $row['pgrfemail_contacto'],
						'salon'	 	=> $row['slnnombre'],
						'fecha'	 	=> $row['pqrffecha'],
						'hora'	 	=> $row['pqrfhora'],
						'tipo'	 	=> $row['pqrftipo'],
						'movil'	 	=> $row['pgrftelefonomovil_contacto'],
						'estado' 	=> $row['pgrfestado'],
						'respuesta' => $row['pgrrespuesta_descripcion'],
						'fechares'  => $row['pqrfrespuesta_fecha'],
						'horares'   => $row['pqrfrespuesta_hora'],
						'usuario'   => $row['trcrazonsocial']

					);
				
					$array= utf8_converter($jsondetalle); 
			     	echo json_encode(array("res" => "full", "json" => $array)); 
		
			break;

		case 'guardarRes':
			
			$QueryGuardar = mysqli_query($conn, "UPDATE btypqrf SET pgrrespuesta_descripcion = '".utf8_decode($_POST['res'])."', pgrfestado = 'ATENDIDO', pqrfrespuesta_fecha = CURDATE(), pqrfrespuesta_hora = CURTIME(), usucodigo = '".$_SESSION['codigoUsuario']."' WHERE pgrfcodigo = '".$_POST['cod']."' ");

			if ($QueryGuardar) 
			{
				echo 1;
			}

			break;
		
		default:
			# code...
			break;
	}


	mysqli_close($conn);
?>
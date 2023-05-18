<?php 	
	header( 'Content-Type: application/json' );
	 include '../../cnx_data.php';
	include("../funciones.php");


	$QueryServicio = mysqli_query($conn, "SELECT a.sercodigo, a.sernombre FROM btyservicio a WHERE a.sernombre  LIKE '%".$_GET['q']."%' ORDER BY a.sernombre ");


			if (mysqli_num_rows($QueryServicio) > 0) 
			{
					$data = array();
					while ( $row = $QueryServicio->fetch_assoc())
					{
						$data[] = $row;
					}

					$array= utf8_converter($data);

						
					echo json_encode($array);

			}
			else
			{
				echo json_encode(array("res" => "empty"));
			}
 ?>
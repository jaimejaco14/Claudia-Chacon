 <?php 

 	    include("../../../cnx_data.php");
    	include("../funciones.php");

    	switch ($_POST['opcion']) 
    	{
    		case 'loadTD':
    			
				$tipDoc = mysqli_query($conn,"SELECT a.tdicodigo, a.tdinombre FROM btytipodocumento a WHERE a.tdiestado = 1 ORDER BY a.tdinombre");

				while ($row = mysqli_fetch_array($tipDoc)) 
				{  
				echo '<option value="'.$row['tdicodigo'].'">'.utf8_encode($row['tdinombre']).'</option>';

				}
    			break;

    		case 'loadOcu':
    			
				$sql = mysqli_query($conn,"SELECT ocucodigo, ocunombre FROM btyocupacion WHERE ocuestado = 1");

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    echo '<option value="'.$row['ocucodigo'].'">'.utf8_encode($row['ocunombre']).'</option>';

                }
    			break;

            case 'loadDepart':
                
                $sql = mysqli_query($conn,"SELECT a.depcodigo, a.depombre FROM btydepartamento a WHERE a.depstado = 1");

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    echo '<option value="'.$row['depcodigo'].'">'.utf8_encode($row['depombre']).'</option>';

                }
                break;

            case 'loadCliente':
                
                $sql = mysqli_query($conn,"SELECT cliente.trcdocumento AS documento, cliente.clicodigo AS codigo, CONCAT(tercero.trcnombres,' ',tercero.trcapellidos) AS nombreCompleto FROM btycliente AS cliente INNER JOIN btytercero AS tercero ON cliente.trcdocumento = tercero.trcdocumento");

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    echo '<option value="'.$row['codigo'].'">'.utf8_encode($row['nombreCompleto']). ' (' .$row['documento'].')' . '</option>';

                }
                break;

            case 'loadServicios':

                $f = "SELECT a.sercodigo, a.sernombre, CONCAT(a.serduracion, ' MIN APROX')AS serduracion FROM btyservicio a WHERE a.sernombre LIKE '%".$_POST['datoServicio']."%'";
                
                $sql = mysqli_query($conn,$f);



                $array = array();

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    $array[] = array('idservicio' => $row['sercodigo'], 'servicio' => $row['sernombre'], 'duracion' => $row['serduracion']);
                }

                    $array = utf8_converter($array);
                    echo json_encode(array("res" => "full", "json" => $array));
                break;
    		
    		default:
    			# code...
    			break;
    	}


?>
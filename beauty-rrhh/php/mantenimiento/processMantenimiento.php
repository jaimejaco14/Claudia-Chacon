<?php 
    include("../../../cnx_data.php");
    include("../funciones.php");


    switch ($_POST['opcion']) 
    {
    	case 'permantenimiento':
    		
    		$sql = mysqli_query($conn, "SELECT a.prmcodigo, a.trcdocumento, a.prmestado, a.prm_email, b.trcrazonsocial, b.trcdireccion, b.trctelefonofijo, b.trctelefonomovil, a.prmfecha_nacimiento FROM btypersona_mantenimiento a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento");

    		if(mysqli_num_rows($sql) > 0)
    		{ 
       		while($data = mysqli_fetch_assoc($sql))
       		{
        			$array['data'][] = $data;

      		}        
      

      		$array= utf8_converter($array);
    
      		echo json_encode($array);
      
  		}
  		else
  		{
    			$array[] = array('info', 'No hay Permisos');
    			echo json_encode($array);
  		}

 

    		break;

    	case 'cargarUsuarioEdicion':
    		
    			$sql = mysqli_query($conn, "SELECT a.prmcodigo, a.trcdocumento, a.prm_email, b.trcnombres, b.trcapellidos, b.trcdireccion, b.trctelefonofijo, b.trctelefonomovil, a.prmfecha_nacimiento FROM btypersona_mantenimiento a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.prmcodigo = '".$_POST['prmcodigo']."' ");

    			$array = array();

    			while ($row = mysqli_fetch_array($sql)) 
    			{
    				$array[] = array(
    					'prmcodigo' 		=> $row['prmcodigo'],
    					'trcdocumento' 		=> $row['trcdocumento'],
    					'prm_email' 		=> $row['prm_email'],
    					'trcnombres' 		=> $row['trcnombres'],
    					'trcapellidos' 		=> $row['trcapellidos'],
    					'trcdireccion' 		=> $row['trcdireccion'],
    					'trctelefonofijo' 	=> $row['trctelefonofijo'],
    					'trctelefonomovil' 	=> $row['trctelefonomovil'],
    					'prmfecha_nacimiento' 	=> $row['prmfecha_nacimiento']
    				);
    			}

    			$array = utf8_converter($array);

    			echo json_encode(array("res" => "full", "json" => $array));

    		break;


    	case 'guardarCambios':

    			$query = mysqli_query($conn, "SELECT trcdocumento FROM btypersona_mantenimiento WHERE prmcodigo = '".$_POST['codigo']."' ");

    			$fetch = mysqli_fetch_array($query);

    			$trcdocumento = $fetch['trcdocumento'];
    		
    			$sql = mysqli_query($conn, "UPDATE btytercero SET trcnombres = '".utf8_decode($_POST['nombre'])."', trcapellidos = '".utf8_decode($_POST['apellido'])."', trcrazonsocial = '".utf8_decode($_POST['nombre'] . ' '.$_POST['apellido'])."', trcdireccion = '".$_POST['direccion']."', trctelefonofijo = '".$_POST['fijo']."', trctelefonomovil = '".$_POST['movil']."' WHERE trcdocumento = '$trcdocumento'");

    			if ($sql) 
    			{
    				$queryMant = mysqli_query($conn, "UPDATE btypersona_mantenimiento SET prmfecha_nacimiento = '".$_POST['fecha']."', prm_email = '".$_POST['email']."' WHERE prmcodigo =  '".$_POST['codigo']."' ");

    				if ($queryMant) 
    				{
    					echo 1;
    				}
    			}
    			

    		break;


    	case 'eliminar':
    		
    			$queryMant = mysqli_query($conn, "UPDATE btypersona_mantenimiento SET prmestado = 0 WHERE prmcodigo =  '".$_POST['codigo']."' ");

			if ($queryMant) 
			{
				echo 1;
			}
    			
    			

    		break;


    	case 'activar_des':

    			$query = mysqli_query($conn, "SELECT prmestado FROM btypersona_mantenimiento WHERE prmcodigo = '".$_POST['codigo']."' ");

    			$fetch = mysqli_fetch_array($query);

    			$estado = $fetch['prmestado'];


    			if ($estado == 1) 
    			{
	    			$queryMant = mysqli_query($conn, "UPDATE btypersona_mantenimiento SET prmestado = 0 WHERE prmcodigo =  '".$_POST['codigo']."' ");

				if ($queryMant) 
				{
					echo 0;
				}    				
    			}
    			else
    			{
    				$queryMant = mysqli_query($conn, "UPDATE btypersona_mantenimiento SET prmestado = 1 WHERE prmcodigo =  '".$_POST['codigo']."' ");

				if ($queryMant) 
				{
					echo 1;
				}
    			}    			

    		break;

    	case 'validarDoc':
            
                $valDoc = mysqli_query($conn, "SELECT trcdocumento FROM btytercero WHERE trcdocumento =  '".$_POST['documento']."' ");

                if (mysqli_num_rows($valDoc) > 0) 
                {
                    $checkPerMan = mysqli_query($conn, "SELECT trcdocumento FROM btypersona_mantenimiento WHERE trcdocumento = '".$_POST['documento']."' ");

                    if (mysqli_num_rows($checkPerMan) > 0) 
                    {

                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a JOIN btytipodocumento  b ON a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }
                    else
                    {
                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a JOIN btytipodocumento  b ON a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'tdicodigo'         => $row['tdicodigo'],
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                            'trcdireccion'      => $row['trcdireccion'],
                            'trctelefonofijo'   => $row['trctelefonofijo'],
                            'trctelefonomovil'  => $row['trctelefonomovil'],
                            'fecha_nacimiento'  => $row['prmfecha_nacimiento'],
                            'tdinombre'         => $row['tdinombre']
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'full', 'json' => $array));
                    }
                }
                else
                {
                    echo json_encode(array("res" => "No tiene ningun registro", "desc" => 0));
                }

            break;

      case 'nuevaPersona':


                    $cedula = $_POST['documento'];
                    $primos =  array(3, 7, 13,17,19,23,29,37,41,43);
                    $sum = 0;
                    $j = strlen($cedula) - 1;

                    for($i=0;$i<strlen($cedula);$i++)
                    { 
                        $sum = $sum+ ($primos[$j]*$cedula[$i]);
                        $j = $j - 1;
                    } 

                    $dv = $sum % 11;

                    if ($dv != 1 and $dv !=0)
                        $dv = 11 - $dv;
                                         
            
            $checkTrc = mysqli_query($conn, "SELECT trcdocumento FROM btytercero WHERE trcdocumento = '".$_POST['documento']."' ");

            if (mysqli_num_rows($checkTrc) > 0) 
            {
                $checkPerMan = mysqli_query($conn, "SELECT trcdocumento FROM btypersona_mantenimiento WHERE trcdocumento = '".$_POST['documento']."' ");

                if (mysqli_num_rows($checkPerMan) > 0) 
                {
                    echo 3;
                } 
                else
                {
                    $sqlmax = mysqli_query($conn, "SELECT MAX(prmcodigo) FROM btypersona_mantenimiento");

                    $maxPer = mysqli_fetch_array($sqlmax);

                    $maxid = $maxPer[0] + 1;

                    $r = "INSERT INTO btypersona_mantenimiento (prmcodigo, tdicodigo, trcdocumento, prmfecha_nacimiento, prm_email, prmfecha_registro, prmhora_registro, usucodigo) VALUES('".$maxid."', '".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$_POST['fecha']."', '".$_POST['email']."', CURDATE(), CURTIME(), '".$_SESSION['codigoUsuario']."' )";

                    $insert_perman = mysqli_query($conn, $r)or die(mysqli_error($conn));

                    if ($insert_perman) 
                    {
                         $sql = mysqli_query($conn, "SELECT * FROM btytercero a WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }
                }  
            }
            else
            {
                $sqlMax = mysqli_query($conn, "SELECT MAX(prmcodigo) FROM btypersona_mantenimiento");

                $maxPer = mysqli_fetch_array($sqlMax);

                $maxid = $maxPer[0] + 1;

                $t = "INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, trcestado) VALUES('".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$dv."', '".utf8_encode(strtoupper($_POST['nombres']))."', '".utf8_encode(strtoupper($_POST['apellidos']))."', '".utf8_converter(strtoupper($_POST['nombres']. ' ' . $_POST['apellidos'])) . "', '".$_POST['direccion']."', '".$_POST['fijo']."', '".$_POST['movil']."', 1)";

                //echo $t;

                $insert_trc = mysqli_query($conn, $t)or die(mysqli_error($conn));

                if ($insert_trc) 
                {
                    $insert_perman = mysqli_query($conn, "INSERT INTO btypersona_mantenimiento (prmcodigo, tdicodigo, trcdocumento, prmfecha_nacimiento, prm_email, prmfecha_registro, prmhora_registro, usucodigo) VALUES('".$maxid."', '".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$_POST['fecha']."', '".$_POST['email']."', CURDATE(), CURTIME(), '".$_SESSION['codigoUsuario']."' )")or die(mysqli_error($conn)); 

                    if ($insert_perman) 
                    {
                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }                   
                }

            }

            break;
    	
    	default:
    		# code...
    		break;
    }

?>
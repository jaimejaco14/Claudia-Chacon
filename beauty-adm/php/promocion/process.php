<?php 
	include("../../../cnx_data.php");


	switch ($_POST['opcion']) 
	{
		case 'ultimoTipo':
			
			$max = mysqli_query($conn, "SELECT MAX(a.tpmcodigo) AS max FROM btypromocion_tipo a ORDER BY a.tpmnombre");

			$maxId = mysqli_fetch_array($max);

			$ultimo = $maxId[0];

			$sql = mysqli_query($conn, "SELECT * FROM btypromocion_tipo a WHERE a.tpmestado = 1 ORDER BY a.tpmnombre");

			while($fetch = mysqli_fetch_array($sql))
			{
				if ($fetch[0] == $ultimo) 
				{
					echo "<option value='".$fetch['tpmcodigo']."' selected>".utf8_encode($fetch['tpmnombre'])."</option>";
				}
				else
				{
					echo "<option value='".$fetch['tpmcodigo']."'>".utf8_encode($fetch['tpmnombre'])."</option>";
				}
			}
		break;

		case 'nuevoTipo':

				$max = mysqli_query($conn, "SELECT MAX(a.tpmcodigo) AS max FROM btypromocion_tipo a");

				$maxId = mysqli_fetch_array($max);

				$ultimo = $maxId[0]+1;

				$sql = mysqli_query($conn, "INSERT INTO btypromocion_tipo (tpmcodigo, tpmnombre, tpmdescripcion, tpmestado) VALUES($ultimo, '".utf8_decode(strtoupper($_POST['tipo']))."', '".utf8_decode(strtoupper($_POST['descripcion']))."', 1) ")or die(mysqli_error($conn));

				if ($sql) 
				{
					echo 1;
				}		
		break;

		case 'nuevaPromocion':

			//print_r($_POST);
			
			$max = mysqli_query($conn, "SELECT MAX(a.pmocodigo) FROM btypromocion a");

			$maxId = mysqli_fetch_array($max);

			$ultimo = $maxId[0]+1;

			
			if($_POST['reqreg']=='true'){
				$reqreg=1;
			}else{
				$reqreg=0;
			}

			if ($_POST['fechafin'] == null) 
			{
				$sql = mysqli_query($conn, "INSERT INTO btypromocion (pmocodigo, tpmcodigo, pmonombre, pmocondyrestric, pmodescripcion, lgbfechainicio, lgbfechafin, pmoestado, pmreqregistro) VALUES('".$ultimo."', '".$_POST['tipoPromo']."', '".utf8_decode(strtoupper($_POST['promocion']))."', '".utf8_decode(strtoupper($_POST['condiciones']))."', '".utf8_decode(strtoupper($_POST['descripcion']))."', '".$_POST['fechainicio']."', NULL, 1, $reqreg) ")or die(mysqli_error($conn));

					if ($sql) 
					{
						echo 1;
					}
			}
			else
			{
				$sql = mysqli_query($conn, "INSERT INTO btypromocion (pmocodigo, tpmcodigo, pmonombre, pmocondyrestric, pmodescripcion, lgbfechainicio, lgbfechafin, pmoestado, pmreqregistro) VALUES('".$ultimo."', '".$_POST['tipoPromo']."', '".utf8_decode(strtoupper($_POST['promocion']))."', '".utf8_decode(strtoupper($_POST['condiciones']))."', '".utf8_decode(strtoupper($_POST['descripcion']))."', '".$_POST['fechainicio']."', '".$_POST['fechafin']."', 1, $reqreg) ")or die(mysqli_error($conn));

					if ($sql) 
					{
						echo 1;
					}
			}

			


			break;

		case 'listado':
			
			$sql = mysqli_query($conn, "SELECT a.pmocodigo, b.tpmnombre, a.pmonombre, a.pmodescripcion, a.pmocondyrestric, a.lgbfechainicio, a.lgbfechafin FROM btypromocion a JOIN btypromocion_tipo b ON a.tpmcodigo=b.tpmcodigo WHERE a.pmoestado = 1");

  				$array = array();

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
			      $info[] = array('info' => 'No hay registros');
			      echo json_encode($info);
			}

			break;

		case 'asignar':
			
			$sql = mysqli_query($conn, "SELECT a.pmocodigo, a.slncodigo, a.pmddia, b.slnnombre, c.lgbfechainicio, c.lgbfechafin FROM btypromocion_detalle a JOIN btysalon b ON a.slncodigo=b.slncodigo JOIN btypromocion c ON c.pmocodigo=a.pmocodigo JOIN btypromocion_tipo d ON d.tpmcodigo=c.tpmcodigo WHERE a.pmocodigo = '".$_POST['cod']."' ORDER BY b.slnnombre,FIELD(a.pmddia, 'LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO','DOMINGO') ");

				while($data = mysqli_fetch_assoc($sql))
				{
				      $array['data'][] = $data;

				}        
		     
		     		$array= utf8_converter($array);
		    
		      	echo json_encode($array);

			break;

		case 'nuevoPromoSln':

                        $salon ='';
                        $dias  ='';                

                                       
                        $salon.=$_POST['salon'].',';
                        $dias.=$_POST['dias'].',';                                

                      	$vectorDia      = explode(',',$dias);
                      	$vectorSalon    = explode(',',$salon);

                       

                      

                       for ($i=0; $i < count($vectorDia)-1; $i++) 
                       {  

                       		for ($j=0; $j <count($vectorSalon)-1 ; $j++) 
                       		{ 
                       		                      	   	
                      	    		$sql = mysqli_query($conn, "INSERT IGNORE INTO btypromocion_detalle (pmocodigo, slncodigo, pmddia) VALUES('".$_POST['cod']."', '".$vectorSalon[$j]."', '".$vectorDia[$i]."' )")or die(mysqli_error($conn));
                       		}                    	   

                      	    
                       }
		break;

		case 'eliminar':
			
			$sql = mysqli_query($conn, "DELETE FROM btypromocion_detalle WHERE pmocodigo = '".$_POST['cod']."' AND slncodigo = '".$_POST['sln']."' AND pmddia = '".$_POST['dia']."' ");

			if ($sql) 
			{
				echo 1;
			}

			break;

		
		default:
			# code...
		break;
	}

	function utf8_converter($array)
  	{
    		array_walk_recursive($array, function(&$item, $key)
    		{
      		if(!mb_detect_encoding($item, 'utf-8', true))
      		{
          			$item = utf8_encode($item);
        		}
      	});

      	return $array;
  	}


	mysqli_close($conn);
?>
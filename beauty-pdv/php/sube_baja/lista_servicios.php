<?php 
	header('Content-Type: application/json');
	include("../../../cnx_data.php");


	$sql = mysqli_query($conn, "SELECT DISTINCT servicio.sercodigo, servicio.sernombre,  CONCAT(servicio.serduracion, ' MIN')AS serduracion, colaborador.clbcodigo FROM btyservicio_colaborador JOIN btycolaborador colaborador ON btyservicio_colaborador.clbcodigo = colaborador.clbcodigo JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento JOIN btyservicio servicio ON btyservicio_colaborador.sercodigo = servicio.sercodigo JOIN btycaracteristica caracteristica ON servicio.crscodigo = caracteristica.crscodigo JOIN btycargo cargo ON colaborador.crgcodigo=cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=colaborador.ctccodigo JOIN btysalon_base_colaborador slb ON slb.clbcodigo=colaborador.clbcodigo JOIN btysalon sln ON sln.slncodigo=slb.slncodigo WHERE colaborador.clbcodigo = '".$_POST['cod']."' AND servicio.serstado = 1 AND slb.slchasta IS NULL ORDER BY servicio.sernombre");






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

	function utf8_converter($array){
	    array_walk_recursive($array, function(&$item, $key){
	      if(!mb_detect_encoding($item, 'utf-8', true)){
	          $item = utf8_encode($item);
	        }
	      });

	      return $array;
	}



  	mysqli_free_result($sql);
  	mysqli_close($conn);

?>
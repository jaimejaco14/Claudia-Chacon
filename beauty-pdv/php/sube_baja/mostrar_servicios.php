<?php 
	include("../../../cnx_data.php");

	$codColaborador = $_POST["cod_col"];

        $d = "SELECT DISTINCT servicio.sercodigo, servicio.sernombre, servicio.seralias, CONCAT(servicio.serduracion, ' MIN')AS serduracion, servicio.serpreciofijo, caracteristica.crscodigo, caracteristica.crsnombre, colaborador.clbcodigo, tercero.trcrazonsocial, colaborador.cblimagen, cargo.crgnombre, cat.ctcnombre, sln.slnnombre FROM btyservicio_colaborador JOIN btycolaborador colaborador ON  btyservicio_colaborador.clbcodigo = colaborador.clbcodigo JOIN btytercero tercero ON colaborador.trcdocumento = tercero.trcdocumento JOIN btyservicio servicio ON btyservicio_colaborador.sercodigo = servicio.sercodigo JOIN btycaracteristica caracteristica ON servicio.crscodigo = caracteristica.crscodigo JOIN btycargo cargo ON colaborador.crgcodigo=cargo.crgcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=colaborador.ctccodigo JOIN btysalon_base_colaborador slb ON slb.clbcodigo=colaborador.clbcodigo JOIN btysalon sln ON sln.slncodigo=slb.slncodigo WHERE colaborador.clbcodigo = $codColaborador AND servicio.serstado = 1 AND slb.slchasta is NULL ORDER BY servicio.sernombre";

        //echo $d;

		$query = mysqli_query($conn,$d);


					
			 $array = array();



             if (mysqli_num_rows($query) > 0) 
             {
                    while ($row = mysqli_fetch_array($query)) 
                    {
                    	$array[] = array(
                    		'cod_servicio' => $row['sercodigo'],
                    		'nom_servicio' => $row['sernombre'],
                    		'ali_servicio' => $row['seralias'],
                    		'dur_servicio' => $row['serduracion'],
                    		'pre_fijo_ser' => $row['serpreciofijo'],
                    		'codcarac_ser' => $row['crscodigo'],
                    		'nomb_caract'  => $row['crsnombre'],
                    		'cod_colabor'  => $row['clbcodigo'],
                    		'nom_colabor'  => $row['trcrazonsocial'],
                    		'img_servici'  => $row['cblimagen'],
                    		'cargo_colab'  => $row['crgnombre'],
                            'salon_base'   => $row['slnnombre'],
                            'categoria'    => $row['ctcnombre']
                    	); 
                    }


         	              $array= utf8_converter($array);

                          echo json_encode(array("res" => "full", "json" => $array));
                   
             }
             else
             {

                $d = "SELECT b.trcrazonsocial, c.crgnombre, f.slnnombre, d.ctcnombre, a.cblimagen FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo= a.crgcodigo JOIN btycategoria_colaborador d ON d.ctccodigo=a.ctccodigo JOIN btysalon_base_colaborador e ON e.clbcodigo=a.clbcodigo JOIN btysalon f ON f.slncodigo=e.slncodigo WHERE a.clbcodigo = '".$_POST["cod_col"]."' ";

        //echo $d;

                    $query = mysqli_query($conn,$d);
                    while ($row = mysqli_fetch_array($query)) 
                    {
                        $array[] = array(
                            'nom_colabor'  => $row['trcrazonsocial'],
                            'img_servici'  => $row['cblimagen'],
                            'cargo_colab'  => $row['crgnombre'],
                            'salon_base'   => $row['slnnombre'],
                            'categoria'    => $row['ctcnombre']
                        ); 
                    }
                    $array= utf8_converter($array);
                    echo json_encode(array("res" => "empty", "json" => $array));
             }
    
    

            function utf8_converter($array){
                array_walk_recursive($array, function(&$item, $key){
                    if(!mb_detect_encoding($item, 'utf-8', true)){
                        $item = utf8_encode($item);
                    }
                });

                return $array;
            }


          	


	       mysqli_close($conn);
 ?>
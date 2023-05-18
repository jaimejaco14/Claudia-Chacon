<?php 
  header('Content-Type: application/json');
  include '../cnx_data.php';

    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $listado = array();

 	  $sql=mysqli_query($conn,"SELECT p.percodigo, t.trcrazonsocial, CASE WHEN p.perestado_tramite = 'AUTORIZADO' THEN t2.trcrazonsocial WHEN p.perestado_tramite = ' NO AUTORIZADO' THEN t2.trcrazonsocial WHEN p.perestado_tramite = 'REGISTRADO' THEN '' ELSE p.perestado_tramite END AS usu_aut, CONCAT(p.perfecha_registo, ' ', p.perhora_registro) AS fecha, CONCAT(p.perfecha_desde, ' ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE p.perfecha_autorizacion END AS fecha_autori, p.perestado_tramite AS estado_tramite, sln.slnnombre FROM btypermisos_colaboradores p, btysalon as sln, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2 WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND perfecha_desde >= '$desde' AND perfecha_hasta <= '$hasta' AND sln.slncodigo=p.slncodigo ORDER BY p.perestado_tramite DESC");

    if (mysqli_num_rows($sql) > 0) 
    {
      
        while ($row = mysqli_fetch_object($sql)) 
       	{
       		$listado[] = array(
       			'id'     			   => $row->percodigo,
       			'colaborador'    => $row->trcrazonsocial,
       			'fecha'     		 => $row->fecha,
       			'desde'     		 => $row->fecha_desde,
       			'hasta'     		 => $row->fecha_hasta,
       			'usu_reg'     	 => $row->usu_reg,
       			'usu_aut'     	 => $row->usu_aut,
       			'fecha_aut'      => $row->fecha_autori,
       			'estado'     		 => $row->estado_tramite,
            'salon'          => $row->slnnombre
       		);
       	}

   			function utf8_converter($array)
  			{
  				array_walk_recursive($array, function(&$item, $key){
  					if(!mb_detect_encoding($item, 'utf-8', true)){
  						$item = utf8_encode($item);
  					}
  				});

  				return $array;
  			}

  				$array= utf8_converter($listado);

  				echo json_encode($array);
  }
  else
  {
    echo 1;
  }

 ?>
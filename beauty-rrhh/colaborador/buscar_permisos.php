<?php 
  header('Content-Type: application/json');
  include '../../cnx_data.php';

  $output='';
  $sql=mysqli_query($conn,"SELECT p.percodigo, sln.slnnombre, t.trcrazonsocial, CONCAT(p.perfecha_registo, ' ', p.perhora_registro) AS fecha, CONCAT(p.perfecha_desde, ' ', p.perhora_desde) AS fecha_desde, CONCAT(p.perfecha_hasta, ' ', p.perhora_hasta) AS fecha_hasta, t1.trcrazonsocial AS usu_reg, CASE WHEN p.perestado_tramite = 'AUTORIZADO' THEN t2.trcrazonsocial WHEN p.perestado_tramite = 'NO AUTORIZADO' THEN t2.trcrazonsocial WHEN p.perestado_tramite = 'REGISTRADO' THEN '' ELSE p.perestado_tramite END AS usu_aut, CASE WHEN CONCAT(p.perfecha_autorizacion, p.perhora_autorizacion) IS NULL THEN '' ELSE p.perfecha_autorizacion END AS fecha_autori, p.perestado_tramite AS estado_tramite FROM btypermisos_colaboradores p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon as sln WHERE p.usucodigo_registro=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo_autorizacion=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND p.perestado = 1 AND p.perestado_tramite = 'REGISTRADO' AND sln.slncodigo = p.slncodigo ORDER BY p.perestado_tramite DESC");

  if(mysqli_num_rows($sql) > 0){
 
       while($data = mysqli_fetch_assoc($sql)){
        $array['data'][] = $data;

      }        
      $array= utf8_converter($array);
    
      echo json_encode($array);
      
  }else{
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

 
 ?>
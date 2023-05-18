<?php 
  header('Content-Type: application/json');
include '../cnx_data.php';

  $output='';
  $sql=mysqli_query($conn,"SELECT c.clbcodigo, b.trcrazonsocial, c.clefecha, c.cleobservaciones, c.cletipo, if(c.cleestado = 1, 'Activo', 'Inctivo') as estado FROM  btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento JOIN btyestado_colaborador c ON a.clbcodigo=c.clbcodigo ORDER BY c.clefecha DESC ");

  if(mysqli_num_rows($sql) > 0){
 
       while($data = mysqli_fetch_assoc($sql)){
        $array['data'][] = $data;

      }        
    
  }else{
    echo json_encode("No hay datos");
  }

function utf8_converter($array){
  array_walk_recursive($array, function(&$item, $key){
    if(!mb_detect_encoding($item, 'utf-8', true)){
        $item = utf8_encode($item);
      }
    });

    return $array;
}

$array= utf8_converter($array);

  echo json_encode($array);

    mysqli_free_result($sql);
    mysqli_close($conn);

 
 ?>
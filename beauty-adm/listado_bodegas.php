<?php 
  header('Content-Type: application/json');
include '../cnx_data.php';

  $output='';
  $sql=mysqli_query($conn,"SELECT bodcodigo, bodnombre, bodalias, if(bodestado = 1, 'Activo', 'Inactivo') as estado FROM btybodega where bodestado = 1");

  if(mysqli_num_rows($sql) > 0){
 
       while($data = mysqli_fetch_assoc($sql)){
        $array['data'][] = $data;

      }        
      $array= utf8_converter($array);
    
      echo json_encode($array);
      
  }else{
    $array[] = array('info', 'No hay bodegas');
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
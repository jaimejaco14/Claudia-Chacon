<?php 
  header('Content-Type: application/json');
include '../../cnx_data.php';

  $cod_usuario              = $_POST['id'];
  $_SESSION['cod_usuario']  = $cod_usuario;
  //print_r($_POST);

  mysqli_query( $conn, "SET lc_time_names = 'es_CO'" ); 

  $sql=mysqli_query($conn,"SELECT a.usucodigo, a.slncodigo, b.slnnombre, date_format(a.ussdesde, '%d de %M de %Y') as fec_des, date_format(a.usshasta, '%d de %M de %Y') as fec_has, a.ussestado FROM btyusuario_salon a JOIN btysalon b ON a.slncodigo=b.slncodigo WHERE a.usucodigo = $cod_usuario AND a.ussestado = 1 ORDER BY a.ussdesde DESC");

  $result = mysqli_query($conn, $sql); 


  if(mysqli_num_rows($sql) > 0){
 
        while($data = mysqli_fetch_assoc($sql)){
          $array['data'][] = $data;

        }       
         echo json_encode($array);
  }else{
       $array[] = array('info' => 'No hay datos disponibles');
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

  $array= utf8_converter($array);


    mysqli_free_result($sql);
    mysqli_close($conn);
 
 ?>
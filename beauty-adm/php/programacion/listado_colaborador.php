<?php 
  header("Content-Type: Application/Json");
  include("../../../cnx_data.php");

  //mysqli_query( $conn, "SET lc_time_names = 'es_CO'" ); 
  $info = array();
  //print_r($_POST);




  $salon = $_POST['salon'];

  $sql = mysqli_query($conn, "SELECT cr.crgnombre, c.clbcodigo, CONCAT(t.trcapellidos, ' ', t.trcnombres) AS nombres FROM btycargo AS cr, btycolaborador AS c, btysalon_base_colaborador AS sb, btysalon AS s, btytercero AS t WHERE (SELECT bty_fnc_estado_colaborador(c.clbcodigo)) ='VINCULADO' AND s.slnnombre='$salon' AND c.crgcodigo=cr.crgcodigo AND t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento AND s.slncodigo=sb.slncodigo AND c.clbcodigo=sb.clbcodigo AND c.clbestado='1' AND sb.slchasta IS NULL ORDER BY s.slnnombre, cr.crgnombre, t.trcapellidos, t.trcnombres")or die(mysqli_error($conn));


  if(mysqli_num_rows($sql) > 0)
  {
 
      while($row = mysqli_fetch_object($sql))
      {
         $info[] = array(
            'id'      => $row->clbcodigo,
            'nombre'  => $row->nombres,
            'cargo'   => $row->crgnombre,
            'salon'   => $salon
         );
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

          $array = utf8_converter($info);

          echo json_encode($array);
  }
  else
  {
      $info[] = array('info' => 'No hay registros');
      echo json_encode($info);
  }
?>
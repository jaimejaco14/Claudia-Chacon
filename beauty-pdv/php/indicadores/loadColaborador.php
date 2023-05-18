<?php 
  include("../../../cnx_data.php");
  include("../funciones.php");

  $info = array();



  $sql = mysqli_query($conn, "SELECT c.clbcodigo, ter.trcrazonsocial, cr.crgnombre, t.trnnombre, cat.ctcnombre FROM btyprogramacion_colaboradores AS p, btytipo_programacion AS tp, btyturno AS t, btycolaborador AS c, btycargo AS cr, btytercero AS ter, btycategoria_colaborador cat WHERE c.clbcodigo=p.clbcodigo AND c.crgcodigo=cr.crgcodigo AND cr.crgincluircolaturnos='1' AND t.trncodigo=p.trncodigo AND tp.tprcodigo=p.tprcodigo AND tp.tprlabora='1' AND ter.trcdocumento=c.trcdocumento AND cat.ctccodigo=c.ctccodigo AND p.slncodigo=".$_SESSION['PDVslncodigo']." AND p.prgfecha= CURDATE() AND (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trndesde AND t.trnhasta) AND NOT (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trninicioalmuerzo AND t.trnfinalmuerzo) ORDER BY ter.trcrazonsocial");

  $array = array();

  if(mysqli_num_rows($sql) > 0)
  {
    
      while($data = mysqli_fetch_array($sql))
      {
          $valSyB = mysqli_query($conn, "SELECT a.clbcodigo as colaborador, a.coldisponible as disponible FROM btycola_atencion a WHERE a.tuafechai = CURDATE() AND a.slncodigo = ".$_SESSION['PDVslncodigo']." AND a.clbcodigo = '".$data['clbcodigo']."' ORDER BY disponible ");

          if (mysqli_num_rows($valSyB) > 0) 
          {
                while ($filas = mysqli_fetch_assoc($valSyB)) 
                {
                  if ($filas['disponible'] == 1) 
                  {
                    $disponible = "DISPONIBLE";
                  }
                  else
                  {
                    $disponible = "OCUPADO";
                  }
                }

          }
          else
          {
            $disponible = "SIN INCLUIR";
          }

          $data['disponible'] = $disponible;


           $array[] = array(
                $data['trcrazonsocial'],
                $data['crgnombre'],
                $data['trnnombre'],
                $data['trcrazonsocial'],
                $data['ctcnombre'],
                $data['disponible']
            );
            $array['data'][] = $data;

         }        
  
        $array = utf8_converter($array);

        echo json_encode($array);
  }
  else
  {
      $info[] = array('info' => 'No hay registros');
      echo json_encode($info);
  }
?>
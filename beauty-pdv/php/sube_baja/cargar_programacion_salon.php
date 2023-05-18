<?php 
	session_start();
	header("content-type: application/json");
	include("../../../cnx_data.php");
    
    $usuario  = $_SESSION['PDVcodigoUsuario'];
    $array    = array();

    $consulta = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, d.trnnombre, cargo.crgnombre, tp.tprlabora, CONCAT(d.trnnombre, ' DE: ', DATE_FORMAT(d.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(d.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(d.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(d.trnfinalmuerzo, '%H:%i')) AS turno FROM btyprogramacion_colaboradores a JOIN  btycolaborador b on a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btycargo cargo ON b.crgcodigo=cargo.crgcodigo JOIN btytipo_programacion tp ON tp.tprcodigo=a.tprcodigo WHERE a.prgfecha = curdate() AND a.slncodigo = '".$_POST['salon']."' AND cargo.crgincluircolaturnos = 1 AND tp.tprlabora= 1 order by d.trnnombre, cargo.crgnombre");

    while ($row = mysqli_fetch_array($consulta)) 
    {

        $consulta2 = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, d.trnnombre, cargo.crgnombre, tp.tprlabora,CONCAT(d.trnnombre, ' DE: ', DATE_FORMAT(d.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(d.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(d.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(d.trnfinalmuerzo, '%H:%i')) AS turno, (SELECT coldisponible FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_POST['salon']."' AND tuafechai = CURDATE()) AS disponible, (SELECT colhorasalida FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_POST['salon']."' AND tuafechai = CURDATE()) AS horasalida, (SELECT colhoraingreso FROM btycola_atencion WHERE clbcodigo = '".$row['clbcodigo']."' AND slncodigo = '".$_POST['salon']."' AND tuafechai = CURDATE()) AS hraingreso FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btycargo cargo ON b.crgcodigo=cargo.crgcodigo JOIN btytipo_programacion tp ON tp.tprcodigo=a.tprcodigo WHERE a.prgfecha = CURDATE() AND a.slncodigo = '".$_POST['salon']."' AND cargo.crgincluircolaturnos = 1 AND tp.tprlabora= 1 AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY d.trnnombre, cargo.crgnombre");

        $fec = mysqli_fetch_array($consulta2);



    	 $array[] = array(
    	 	 'doc'     => $fec['trcdocumento'],
             'cod_col' => $fec['clbcodigo'],
             'nombre'  => $fec['trcrazonsocial'],
             'turno'   => $fec['turno'],
             'cargo'   => $fec['crgnombre'],
             'salon'   => $_SESSION['PDVslncodigo'],
             'disp'    => $fec['disponible'],
             'hsalida' => $fec['horasalida'],
             'hingreso' => $fec['hraingreso'],

    	 );
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

 	mysqli_close($conn);

 ?>
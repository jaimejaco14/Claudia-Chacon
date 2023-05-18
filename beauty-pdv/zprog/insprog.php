<?php 
include'../../cnx_data.php';
$array   = $_POST['filas'];
$error = array();
foreach($array as $obj){
	$col          = $obj['colab'];
	$turno        = $obj['turno'];
	$horario      = $obj['horario'];
	$salon        = $obj['salon'];
	$puesto       = $obj['puesto'];
	$fecha        = $obj['fecha'];
	$tipo         = $obj['tipo'];


	$sql="SELECT t.trcrazonsocial, concat(tn.trnnombre,' ', h.hordesde,'-', h.horhasta) as turno, sl.slnnombre, pt.ptrnombre, p.prgfecha, tp.tprnombre 
	FROM btyprogramacion_colaboradores p 
	JOIN btycolaborador c ON c.clbcodigo=p.clbcodigo 
	JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo 
	join btyturno tn on tn.trncodigo=p.trncodigo 
	join btyhorario h on h.horcodigo=p.horcodigo 
	join btysalon sl on sl.slncodigo=p.slncodigo 
	join btypuesto_trabajo pt on pt.ptrcodigo=p.ptrcodigo 
	join btytipo_programacion tp on tp.tprcodigo=p.tprcodigo 
	WHERE p.clbcodigo=$col AND p.prgfecha='$fecha'";
 
    $res=$conn->query($sql); 

    if ($res->num_rows == 0){

   		mysqli_query($conn, "INSERT INTO btyprogramacion_colaboradores (clbcodigo,trncodigo,horcodigo,slncodigo,ptrcodigo,prgfecha,tprcodigo) VALUES ($col, $turno, $horario, $salon, $puesto, '".$fecha."', $tipo)");
    }else{

		$row=$res->fetch_array();
		$error[] = array('colaborador' => $row['trcrazonsocial'], 'turno' => $row['turno'], 'salon' => $row['slnnombre'], 'puesto'=>$row['ptrnombre'],'fecha' => $row['prgfecha'],'tipolab' => $row['tprnombre']);
    }                     
          	
}

/*$error=utf8_converter($error);
$error = array_filter($error, 'removeEmptyElements');
echo json_encode(array("resp" => $error));*/
echo json_encode(array("resp" => $error));

?>
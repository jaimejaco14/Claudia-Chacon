<?php 
	include '../cnx_data.php';


	$id_prod = $_POST['id_prod'];
	//$idgrupo = $_POST['idgrupo'];
	$consulta = mysqli_query($conn, "SELECT *, car.crsnombre, car.crscodigo, sli.sblnombre, lin.linnombre, sgr.sbgnombre, gru.grunombre, gru.grucodigo FROM btyproducto pro JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sli ON car.sblcodigo=sli.sblcodigo JOIN btylinea lin ON sli.lincodigo=lin.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo WHERE procodigo = $id_prod AND proestado = 1");

	$id_linea = $_POST['id_linea'];

	$fr = mysqli_fetch_array($consulta);

	$html='';
	$sql = mysqli_query($conn, "SELECT b.lincodigo, b.linnombre FROM btylinea b JOIN btysubgrupo a ON b.sbgcodigo=a.sbgcodigo JOIN btygrupo c
ON a.grucodigo=c.grucodigo WHERE b.lincodigo = $id_linea ")or die(mysqli_error($conn));

	if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_array($sql)) {

        if ($fr['lincodigo'] == $row['lincodigo']) {
                	
        	$html.='
				<option value='.$row['lincodigo'].' selected>'.utf8_decode($row['linnombre']).'</option>
        	';
        }else{
        	$html.='
				<option value='.$row['lincodigo'].'>'.utf8_decode($row['linnombre']).'</option>
        	';
        }        	
        		
        	
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    //mysqli_close($conn);
 ?>
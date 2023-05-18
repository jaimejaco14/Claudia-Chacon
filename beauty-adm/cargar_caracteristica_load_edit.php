<?php 
	include '../cnx_data.php';


	$id_prod = $_POST['id_prod'];
	//$idgrupo = $_POST['idgrupo'];
	$consulta = mysqli_query($conn, "SELECT *, car.crsnombre, car.crscodigo, sli.sblnombre, lin.linnombre, sgr.sbgnombre, gru.grunombre, gru.grucodigo FROM btyproducto pro JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sli ON car.sblcodigo=sli.sblcodigo JOIN btylinea lin ON sli.lincodigo=lin.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo WHERE procodigo = $id_prod AND proestado = 1");

	$id_categoria = $_POST['id_categoria'];

	$fr = mysqli_fetch_array($consulta);

	$html='';
	$sql = mysqli_query($conn, "SELECT b.crscodigo, b.crsnombre FROM btycaracteristica b JOIN btysublinea a ON a.sblcodigo=b.sblcodigo WHERE b.crscodigo = $id_categoria")or die(mysqli_error($conn));

	if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_array($sql)) {

        if ($fr['crscodigo'] == $row['crscodigo']) {
                	
        	$html.='
				<option value='.$row['crscodigo'].' selected>'.utf8_decode($row['crsnombre']).'</option>
        	';
        }else{
        	$html.='
				<option value='.$row['crscodigo'].'>'.utf8_decode($row['crsnombre']).'</option>
        	';
        }        	
        		
        	
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    
 ?>
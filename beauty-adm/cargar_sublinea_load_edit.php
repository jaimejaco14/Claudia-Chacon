<?php 
	include '../cnx_data.php';


	$id_prod = $_POST['id_prod'];
	//$idgrupo = $_POST['idgrupo'];
	$consulta = mysqli_query($conn, "SELECT *, car.crsnombre, car.crscodigo, sli.sblnombre, lin.linnombre, sgr.sbgnombre, gru.grunombre, gru.grucodigo FROM btyproducto pro JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sli ON car.sblcodigo=sli.sblcodigo JOIN btylinea lin ON sli.lincodigo=lin.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo WHERE procodigo = $id_prod AND proestado = 1");

	$id_sublinea = $_POST['id_sublinea'];

	$fr = mysqli_fetch_array($consulta);
print_r($_POST);
	$html='';
	$sql = mysqli_query($conn, "SELECT b.sblcodigo, b.sblnombre FROM btysublinea b JOIN btylinea a ON a.lincodigo=b.lincodigo WHERE b.sblcodigo = $id_sublinea ")or die(mysqli_error($conn));

	if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_array($sql)) {

        if ($fr['sblcodigo'] == $row['sblcodigo']) {
                	
        	$html.='
				<option value='.$row['sblcodigo'].' selected>'.utf8_decode($row['sblnombre']).'</option>
        	';
        }else{
        	$html.='
				<option value='.$row['sblcodigo'].'>'.utf8_decode($row['sblnombre']).'</option>
        	';
        }        	
        		
        	
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    mysqli_close($conn);
 ?>
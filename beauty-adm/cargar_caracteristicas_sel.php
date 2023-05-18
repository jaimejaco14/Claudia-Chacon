<?php 
	include '../cnx_data.php';


	$id = $_POST['sublinea'];
	$html='';

	$sql = mysqli_query($conn, "SELECT crscodigo, crsnombre FROM btycaracteristica WHERE sblcodigo = $id");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Característica</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['crscodigo'].'>'.utf8_decode($row['crsnombre']).'</option>
        	';
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    
 ?>
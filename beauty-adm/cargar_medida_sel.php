<?php 
	include '../cnx_data.php';

	$html='';

	$sql = mysqli_query($conn, "SELECT umecodigo, umenombre FROM btyunidad_medida");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Unidad Medida</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['umecodigo'].'>'.utf8_decode($row['umenombre']).'</option>
        	';
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    //mysqli_close($conn);
 ?>
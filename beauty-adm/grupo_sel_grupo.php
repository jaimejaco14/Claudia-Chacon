<?php 
	include '../cnx_data.php';

	$html='';
	$sql = mysqli_query($conn, "SELECT grucodigo, grunombre FROM btygrupo WHERE tpocodigo = 1");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Grupo</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['grucodigo'].'>'.utf8_decode($row['grunombre']).'</option>
        	';
        }

	}else{
		$html.='
				<option>No hay registros disponibles</option>
        	';
	}
        echo $html;

    mysqli_close($conn);
 ?>
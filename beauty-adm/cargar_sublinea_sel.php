<?php 
	include '../cnx_data.php';


	$id = $_POST['linea'];
	$html='';

	$sql = mysqli_query($conn, "SELECT sblcodigo, sblnombre FROM btysublinea WHERE lincodigo = $id");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Sub-línea</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['sblcodigo'].'>'.utf8_decode($row['sblnombre']).'</option>
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
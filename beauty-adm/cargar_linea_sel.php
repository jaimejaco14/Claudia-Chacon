<?php 
	include '../cnx_data.php';


	$id = $_POST['subgrupo'];
	$html='';

	$sql = mysqli_query($conn, "SELECT lincodigo, linnombre FROM btylinea WHERE sbgcodigo = $id");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Línea</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['lincodigo'].'>'.utf8_decode($row['linnombre']).'</option>
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
 
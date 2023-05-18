<?php 
	include '../cnx_data.php';

	$html='';

	$sql = mysqli_query($conn, "SELECT imvcodigo, imvnombre FROM btyimpuesto_ventas");

	if (mysqli_num_rows($sql) > 0) {
        $html.='
			<option value="0" selected>Seleccione Tipo Impuesto</option>
        ';

        while ($row = mysqli_fetch_array($sql)) {
        	$html.='
				<option value='.$row['imvcodigo'].'>'.utf8_decode($row['imvnombre']).'</option>
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
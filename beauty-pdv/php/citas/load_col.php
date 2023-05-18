<?php 
	include("../../../cnx_data.php");

	$html="";
	$query = mysqli_query($conn, "SELECT col.clbcodigo as codigoColaborador, CONCAT(ter.trcnombres,' ',ter.trcapellidos) AS nombreColaborador  FROM btycolaborador col JOIN btytercero ter ON col.trcdocumento=ter.trcdocumento");



		if(mysqli_num_rows($query) > 0){
			
			$colaboradores = array();

			while($registros = mysqli_fetch_array($query)){

				$html.='
					<option value="'.$registros['codigoColaborador'].'"> '.utf8_decode($registros['nombreColaborador']).'</option>
				';
			}

			echo $html;
		}

	mysqli_close($conn);
?>
<?php 
	include '../cnx_data.php';

	$html="";
	$cod_prod = $_POST['cod_prod'];
	print_r($_POST);

$consulta = mysqli_query($conn, "SELECT *, unime.umenombre FROM btyproducto a JOIN btyunidad_medida unime ON a.umecodigo=unime.umecodigo WHERE a.procodigo = $cod_prod ");
	$fetch = mysqli_fetch_array($consulta);
	$cod_uni = $fetch['umecodigo'];
	$nom_uni = $fetch['umenombre'];



		$sql = mysqli_query($conn, "SELECT umecodigo, umenombre FROM btyunidad_medida");

		while ($row = mysqli_fetch_array($sql)) {

			if ($row['umecodigo'] == $cod_uni) {
				$html.='
					<option value="'.$row['umecodigo'].'" selected> '.$row['umenombre'].' </option>
				';				
			}else{
				$html.='
					<option value="'.$row['umecodigo'].'"> '.$row['umenombre'].' </option>
				';
			}
		}

		echo $html;

 ?>
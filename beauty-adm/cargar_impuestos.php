<?php 
	include '../cnx_data.php';

	$html="";
	$cod_prod = $_POST['cod_prod'];

$consulta = mysqli_query($conn, "SELECT *, b.imvnombre FROM btyproducto a JOIN btyimpuesto_ventas b ON a.imvcodigo=b.imvcodigo WHERE a.procodigo = $cod_prod");
	$fetch = mysqli_fetch_array($consulta);
	$cod_imp = $fetch['imvcodigo'];
	$nom_imp = $fetch['imvnombre'];



		$sql = mysqli_query($conn, "SELECT imvcodigo, imvnombre FROM btyimpuesto_ventas");

		while ($row = mysqli_fetch_array($sql)) {

			if ($row['imvcodigo'] == $cod_imp) {
				$html.='
					<option value="'.$row['imvcodigo'].'" selected> '.$row['imvnombre'].' </option>
				';				
			}else{
				$html.='
					<option value="'.$row['imvcodigo'].'"> '.$row['imvnombre'].' </option>
				';
			}
		}

		echo $html;

 ?>
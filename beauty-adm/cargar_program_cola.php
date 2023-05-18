<?php 
	include '../cnx_data.php';

	$salon_turno = $_POST['salon_turno'];

	$sql = mysqli_query($conn, "SELECT *, b.trcdocumento, c.trcrazonsocial, d.trnnombre FROM btyprogramacion_colaboradores a JOIN  btycolaborador b on a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo WHERE prgfecha = curdate() AND slncodigo = $salon_turno AND tprcodigo = 1");

	if (mysqli_num_rows($sql) > 0) {
		$array = array();

		while ($row = mysqli_fetch_object($sql)) {
			$array[] = array(
				'cod_col' 	=>$row->clbcodigo,
				'razon_soc' =>$row->trcrazonsocial,
				'turno' =>$row->trnnombre
			);
		}

		echo json_encode($array);
	}

//mysqli_close($conn);
 ?>
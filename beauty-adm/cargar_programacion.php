<?php 
	include '../cnx_data.php';

	$salon_turno = $_POST['salon_turno'];
	$html="";
	$cons = mysqli_query($conn, "SELECT * FROM btycola_atencion");
    $i=1;
	if (mysqli_num_rows($cons) > 0) {

	$sql = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, d.trnnombre FROM btyprogramacion_colaboradores a JOIN  btycolaborador b on a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo WHERE prgfecha = curdate() AND slncodigo = $salon_turno AND tprcodigo = 1 order by d.trnnombre asc");

	while ($row = mysqli_fetch_array($sql)) {
		
		$html.='
			<tr>
				<td> '.$row['clbcodigo'].' </td>
				<td> '.$row['trcrazonsocial'].' </td>
				<td> '.$row['trnnombre'].' </td>
				<td> <button class="btn btn-info btn-xs" id="btn_add_col" data-id="'.$row['clbcodigo'].'" data-pos="'.$i.'"><i class="fa fa-plus"></i></button> </td>
				<td> <button class="btn btn-primary btn-xs" id="btn_quitar_col" data-id=" '.$row['clbcodigo'].' "><i class="fa fa-times"></i></button> </td>
			</tr>
		';
	$i++;
	}
	echo $html;

		
		
	}else{
		$consulta = mysqli_query($conn, "SELECT b.clbcodigo, b.trcdocumento, c.trcrazonsocial, d.trnnombre FROM btyprogramacion_colaboradores a JOIN  btycolaborador b on a.clbcodigo=b.clbcodigo JOIN btytercero c ON b.trcdocumento=c.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo WHERE prgfecha = curdate() AND slncodigo = $salon_turno AND tprcodigo = 1 order by d.trnnombre asc");

		while ($row = mysqli_fetch_array($consulta)) {
		
		$html.='
			<tr>
				<td> '.$row['clbcodigo'].' </td>
				<td> '.$row['trcrazonsocial'].' </td>
				<td> '.$row['trnnombre'].' </td>
				<td> <button class="btn btn-info btn-xs" id="btn_add_col" data-id="'.$row['clbcodigo'].'" data-pos="'.$i.'"><i class="fa fa-plus"></i></button> </td>
				<td> <button class="btn btn-primary btn-xs" id="btn_quitar_col" data-id=" '.$row['clbcodigo'].' "><i class="fa fa-times"></i></button> </td>
			</tr>
		';
		$i++;
	}
	echo $html;
	}	

	//mysqli_close($conn);
 ?>
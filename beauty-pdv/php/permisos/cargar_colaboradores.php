<?php 
	include("../../../cnx_data.php");

	$colaborador = $_POST["colaborador"];

	$query = mysqli_query($conn,"SELECT c.clbcodigo, CONCAT(t.trcapellidos,' ',t.trcnombres) as trcrazonsocial FROM btycolaborador as c, btytercero as t where c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo and c.clbestado='1' AND CONCAT(t.trcapellidos,' ',t.trcnombres) LIKE '%$colaborador%' order by trcrazonsocial");

	while ($row = mysqli_fetch_array($query)) 
	{
		echo '<option value"'.$row['clbcodigo'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
	}


?>
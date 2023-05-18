<?php
include '../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'seek':
		$colaborador = $_POST["texto"];
		$query = "SELECT c.clbcodigo, c.trcdocumento, t.trcrazonsocial, crg.crgnombre FROM btycolaborador c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btycargo crg ON c.crgcodigo = crg.crgcodigo WHERE c.clbestado = 1 AND  t.trcrazonsocial LIKE '%$colaborador%' ORDER BY t.trcrazonsocial";
		$resultadoQuery = $conn->query($query);
		while($registros = $resultadoQuery->fetch_array()){
			$array[]=(array("codigo"=>$registros["clbcodigo"], "nombrecol"=>utf8_encode($registros["trcrazonsocial"])));
		}
		echo json_encode($array);
	break;
	case 'proc':
		$sln=$_POST['sln'];
		$clb=$_POST['clb'];
		$sql="DELETE FROM btycola_atencion WHERE slncodigo=$sln and clbcodigo=$clb and tuafechai=curdate() and colhorasalida <> ''";
		$res=$conn->query($sql);
		$af=mysqli_affected_rows($conn);
		echo $af;
	break;
}

?>
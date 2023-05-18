<?php
include("../../../cnx_data.php");


if ($_GET['p']== "salon") {
	$cod = $_GET['codigo'];
	// $sql = "SELECT DISTINCT  t.trncodigo id, CONCAT(t.hordia,' de ', t.trndesde, ' a ', t.trnhasta) title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno_salon t ON t.trncodigo = p.trncodigo and t.slncodigo = $cod INNER JOIN  btycolaborador c ON c.clbcodigo = p.clbcodigo INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento";
	$sql = "SELECT DISTINCT p.trncodigo AS id, t.trnnombre AS title, CONCAT(p.prgfecha,' ',t.trndesde) AS start, CONCAT(p.prgfecha,' ',t.trnhasta) AS end, t.trncolor AS backgroundColor FROM btyprogramacion_colaboradores p INNER JOIN btyturno t ON t.trncodigo = p.trncodigo WHERE p.slncodigo = $cod ";

} if ($_GET['p']== "clb") {
	//$g = mysqli_query($conn, "SELECT a.clbcodigo FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE a.trcdocumento = '".$_GET['codigo']."' ");
	//$fila = mysqli_fetch_array($g);
	$sln = $_GET['sln'];
	$codigo = $_GET['codigo'];

	// $sql = "SELECT s.slnnombre title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno_salon t ON t.trncodigo = p.trncodigo INNER JOIN btysalon s on s.slncodigo = t.slncodigo INNER JOIN  btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $cod INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento";

	$sql = "SELECT DISTINCT  CONCAT (s.slnnombre,' ', t.trnnombre) title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno t ON t.trncodigo = p.trncodigo INNER JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo INNER JOIN btysalon s on s.slncodigo = ts.slncodigo INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $codigo INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento WHERE s.slncodigo = $sln";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        # code...
        $a[] = $row;
    }
    echo json_encode($a);
} 
?>
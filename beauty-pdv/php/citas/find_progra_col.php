<?php
	session_start();
	include("../../../cnx_data.php");

$sql = "SELECT CONCAT('[',tp.tprnombre,'] ',s.slnnombre,': ',t.trnnombre) as turno, CONCAT(p.prgfecha,' ',t.trndesde) as start, CONCAT(p.prgfecha,' ',t.trndesde) as end, t.trncolor as backgroundColor FROM btyprogramacion_colaboradores as p, btytipo_programacion as tp, btyturno as t, btysalon as s  where s.slncodigo=p.slncodigo and   t.trncodigo=p.trncodigo and  tp.tprcodigo=p.tprcodigo  and  p.slncodigo='".$_SESSION['PDVslncodigo']."' and p.clbcodigo='".$_GET['col']."'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        # code...
        $a[] = $row;
    }
    echo json_encode($a);
} 
?>
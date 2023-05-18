<?php 
include'../../cnx_data.php';
$clb=$_GET['clb'];
$start=$_GET['start'];
$end=$_GET['end'];
$sql="SELECT DISTINCT 
		CONCAT(p.prgfecha,' ',t.trndesde) as start, 
		CONCAT(p.prgfecha,' ',t.trnhasta) as end, 
		CASE 
		WHEN tpr.tprnombre = 'DESCANSO' THEN 'DESCANSO' 
		WHEN tpr.tprnombre = 'PERMISO' THEN 'PERMISO'
		WHEN tpr.tprnombre = 'CAPACITACION' THEN 'CAPACITACION' 
		WHEN tpr.tprnombre = 'LABORA' THEN 'LABORA' 
		WHEN tpr.tprnombre = 'META' THEN 'META' 
		WHEN tpr.tprnombre = 'INCAPACIDAD' THEN 'INCAPACIDAD' 
		WHEN tpr.tprnombre = 'VACACIONES' THEN 'VACACIONES' 
		END as title, 
		s.slnnombre as salon,
		if(tpr.tprcodigo <> 1,'#606060',t.trncolor) as backgroundColor, 
		t.trnnombre as turno 
		FROM btyprogramacion_colaboradores p 
		INNER JOIN btyturno t ON t.trncodigo = p.trncodigo 
		INNER JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo 
		INNER JOIN btysalon s on s.slncodigo = ts.slncodigo 
		INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $clb
		INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento 
		JOIN btytipo_programacion tpr ON p.tprcodigo=tpr.tprcodigo	
		WHERE p.prgfecha BETWEEN '$start' AND '$end'";

$result = $conn->query($sql);
if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc()) 
    {
        $a[] = $row;
    }

    echo json_encode($a);
} 
 ?>
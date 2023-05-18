<?php
include '../cnx_data.php';
//print_r($_GET);

if ($_GET['p']== "salon") {
    $cod = $_GET['codigo'];
    // $sql = "SELECT DISTINCT  t.trncodigo id, CONCAT(t.hordia,' de ', t.trndesde, ' a ', t.trnhasta) title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno_salon t ON t.trncodigo = p.trncodigo and t.slncodigo = $cod INNER JOIN  btycolaborador c ON c.clbcodigo = p.clbcodigo INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento";
    $sql = "SELECT DISTINCT p.trncodigo AS id, t.trnnombre AS title, CONCAT(p.prgfecha,' ',t.trndesde) AS start, CONCAT(p.prgfecha,' ',t.trnhasta) AS end, t.trncolor AS backgroundColor FROM btyprogramacion_colaboradores p INNER JOIN btyturno t ON t.trncodigo = p.trncodigo WHERE p.slncodigo = $cod ";

} if ($_GET['p']== "clb") {

    $g = mysqli_query($conn, "SELECT a.clbcodigo FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE a.trcdocumento = '".$_GET['codigo']."' ");
    $fila = mysqli_fetch_array($g);
    $codigo = $fila[0];


    // $sql = "SELECT s.slnnombre title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno_salon t ON t.trncodigo = p.trncodigo INNER JOIN btysalon s on s.slncodigo = t.slncodigo INNER JOIN  btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $cod INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento";

    $sql = "SELECT DISTINCT CONCAT(p.prgfecha,' ',t.trndesde) start, t.trndesde as desde, t.trnhasta as hasta, CONCAT(p.prgfecha,' ',t.trnhasta) end, CASE WHEN tpr.tprnombre = 'DESCANSO' THEN 'DESCANSO' WHEN tpr.tprnombre = 'PERMISO' THEN 'PERMISO' WHEN tpr.tprnombre = 'CAPACITACION' THEN 'CAPACITACION' WHEN tpr.tprnombre = 'LABORA' THEN 'LABORA' WHEN tpr.tprnombre = 'META' THEN 'META' WHEN tpr.tprnombre = 'INCAPACIDAD' THEN 'INCAPACIDAD' END as res, s.slnnombre as salon, t.trncolor as backgroundColor, t.trnnombre as turno FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno t ON t.trncodigo = p.trncodigo INNER JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo INNER JOIN btysalon s on s.slncodigo = ts.slncodigo INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $codigo INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento JOIN btytipo_programacion tpr ON p.tprcodigo=tpr.tprcodigo";

}else{
    if ($_GET['p']== "clbs") {

    $g = mysqli_query($conn, "SELECT a.clbcodigo FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE a.trcdocumento = '".$_GET['codigo']."' ");
    $fila = mysqli_fetch_array($g);
    $codigo = $_GET['codigo'];


    // $sql = "SELECT s.slnnombre title, CONCAT(p.prgfecha,' ',t.trndesde) start, CONCAT(p.prgfecha,' ',t.trnhasta) end, t.trncolor backgroundColor FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno_salon t ON t.trncodigo = p.trncodigo INNER JOIN btysalon s on s.slncodigo = t.slncodigo INNER JOIN  btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $cod INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento";

    $sql = "SELECT DISTINCT CONCAT(p.prgfecha,' ',t.trndesde) start, t.trndesde as desde, t.trnhasta as hasta, CONCAT(p.prgfecha,' ',t.trnhasta) end, CASE WHEN tpr.tprnombre = 'DESCANSO' THEN 'DESCANSO' WHEN tpr.tprnombre = 'PERMISO' THEN 'PERMISO' WHEN tpr.tprnombre = 'CAPACITACION' THEN 'CAPACITACION' WHEN tpr.tprnombre = 'LABORA' THEN 'LABORA' WHEN tpr.tprnombre = 'META' THEN 'META' WHEN tpr.tprnombre = 'INCAPACIDAD' THEN 'INCAPACIDAD' END as res, s.slnnombre as salon, t.trncolor as backgroundColor, t.trnnombre as turno FROM `btyprogramacion_colaboradores` p INNER JOIN btyturno t ON t.trncodigo = p.trncodigo INNER JOIN btyturno_salon ts ON ts.trncodigo = t.trncodigo AND p.slncodigo = ts.slncodigo INNER JOIN btysalon s on s.slncodigo = ts.slncodigo INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo and c.clbcodigo = $codigo INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento JOIN btytipo_programacion tpr ON p.tprcodigo=tpr.tprcodigo";

}
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $a[] = $row;
    }
    echo json_encode($a);
} 
?>
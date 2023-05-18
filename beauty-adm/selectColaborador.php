<?php
include "../cnx_data.php";
$sql = "SELECT c.`clbcodigo`, c.`trcdocumento`, t.trcrazonsocial, crg.crgnombre FROM `btycolaborador` c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btycargo crg ON c.crgcodigo = crg.crgcodigo WHERE c.clbestado = 1 ORDER BY t.trcrazonsocial";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while ($row=$result->fetch_assoc()) {
        echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])." (".$row['crgnombre'].")</option>";
    }
} else {
    echo "<option value=''>--No hay resultados--</option>";
}
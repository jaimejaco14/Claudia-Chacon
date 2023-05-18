<?php
include '../cnx_data.php';
$sql = "SELECT a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento ORDER BY b.trcrazonsocial";
$result = $conn->query($sql);
if ($result->num_rows > 0){
    while ($row=$result->fetch_assoc()) {
        echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
    }
} else {
    echo "<option value=''>--No hay resultados--</option>";
}

?>
<?php
include "../cnx_data.php";
$cod = $_POST['col_cod'];
$sql = "SELECT `clbcodigo`, t.trcrazonsocial FROM `btycolaborador` c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento WHERE clbestado = 1 and t.trcrazonsocial like '%$cod%'";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      # code...
      echo "<option value='".$row['clbcodigo']."'>".$row['trcrazonsocial']."</option>";
  }
 } else {

 }
?>
<?php
include '../cnx_data.php';
$planta = $_POST["planta"];
$sln = $_POST['sln_cod'];
//$sql = "SELECT brrnombre FROM btybarrio";
if($planta != NULL) {
$sql = "SELECT `slnplantas`, slnnombre FROM `btysalon` WHERE slncodigo = $sln AND slnplantas < $planta";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$salon = $row['slnnombre'];
      	$num = $row['slnplantas'];
    }
      echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">El salon '.$salon.' solo tiene '.$num.' plantas</font></div>';
} else {
}
$conn->close();
}
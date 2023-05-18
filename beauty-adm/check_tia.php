<?php
include 'conexion.php';
$nom = $_POST["tianame"];

$sql = "SELECT tianombre FROM  btytipo_activo where tianombre = '$nom'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

        echo '<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activos</font></div>'; 
}

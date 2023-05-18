<?php
//include '../cnx_data.php';
$cod =  $_POST['cod_marca'];
$sql = "SELECT `marcodigo`, `marnombre` FROM `btymarca_activo` WHERE marcodigo = $cod";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['marcodigo'].",";
		echo $row['marnombre'].",";

	}
}
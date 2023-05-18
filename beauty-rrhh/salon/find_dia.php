<?php
include '../../cnx_data.php';
$cod = $_POST['codi'];
$sql = "SELECT `hordia` FROM `btyhorario_salon` WHERE slncodigo = $cod";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		# code...
		echo "<option value ='".$row['hordia']."'>".$row['hordia']."</option>";
	}
} else {
	echo "<option>--No hay resultados--</option>";
}
?>
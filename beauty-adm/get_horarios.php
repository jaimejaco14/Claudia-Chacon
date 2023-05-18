<?php
include '../cnx_data.php';
$cod = $_POST['horario_cod'];
$sql = "SELECT `horcodigo`, `hordia`, `hordesde`, `horhasta`, `horestado` FROM `btyhorario` WHERE hordia IN (SELECT h.hordia FROM btyhorario_salon hs INNER JOIN btyhorario h ON h.horcodigo = hs.horcodigo AND h.horcodigo = $cod) and horestado=1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		 echo "<option value=".$row['horcodigo'].">".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
	}
}
?>
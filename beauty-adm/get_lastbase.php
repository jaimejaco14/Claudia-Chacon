<?php 
include '../cnx_data.php';
$cod = $_POST['codigo'];

$sql = "SELECT base.slncodigo, base.slcdesde, base.slchasta, s.slnnombre FROM btysalon_base_colaborador base INNER JOIN btysalon s ON s.slncodigo = base.slncodigo WHERE base.slcdesde IN (SELECT MAX(slcdesde) FROM `btysalon_base_colaborador` where clbcodigo = $cod) AND base.clbcodigo = $cod and base.slchasta IS NULL";	
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['slncodigo'].",";
		echo $row['slcdesde'].",";
		echo $row['slnnombre'].",";
	}
}
?>
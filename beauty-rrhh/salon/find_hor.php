<?php
include '../../cnx_data.php';
$sql = "SELECT hs.`horcodigo`, h.hordia, h.hordesde, h.horhasta FROM `btyhorario_salon` hs INNER JOIN btyhorario h ON hs.horcodigo = h.horcodigo WHERE hs.slncodigo =".$_POST['salon']." ORDER BY hordia";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
     echo "<option value='".$row['horcodigo']."'>".$row['hordia']." de ".substr($row['hordesde'], 0, -3)." a ".substr($row['horhasta'], 0, -3)."</option>";
}    
} else {
	echo "<option value=''>--No hay resultados--</option>";
}
?>
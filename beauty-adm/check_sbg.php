<?php
include '../cnx_data.php';
$sql = "select * from btysubgrupo where sbgnombre ='".$_POST['cod']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "ups";
}
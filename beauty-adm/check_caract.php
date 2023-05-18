<?php
include '../cnx_data.php';
$sql = "select * from btycaracteristica where crsnombre ='".$_POST['cod']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "ups";
}
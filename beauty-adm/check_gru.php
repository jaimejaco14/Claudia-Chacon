<?php
include '../cnx_data.php';
$sql = "select * from btygrupo where grunombre ='".$_POST['cod']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "ups";
}
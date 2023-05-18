<?php
include '../cnx_data.php';
$sql = "select * from btylinea where linnombre ='".$_POST['cod']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "ups";
}
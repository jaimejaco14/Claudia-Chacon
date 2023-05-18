<?php
include '../cnx_data.php';
$sql = "select * from btysublinea where sblnombre ='".$_POST['cod']."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "ups";
}
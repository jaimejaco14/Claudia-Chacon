<?php 
include '../cnx_data.php';
$color = $_POST['color'];
$sql = "SELECT trncolor FROM  btyturno_salon where trncolor = '$color'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	echo "TRUE";
} else {
	echo "FALSE";
}
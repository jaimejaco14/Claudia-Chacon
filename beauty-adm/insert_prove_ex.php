<?php 
include '../cnx_data.php';
$crr=$_POST['correo'];
$dct=$_POST['docu'];
$tpy=$_POST['typo'];
$sqll= "SELECT * FROM `btyproveedor`";
                                  if ($conn->query($sqll)){
                                  $sqlmax = "SELECT MAX(`prvcodigo`) as m FROM `btyproveedor`";
                                  $max = $conn->query($sqlmax);
                                  if ($max->num_rows > 0) {
                                    while ($row = $max->fetch_assoc()) {
                                      $cod = $row['m']+1;
                                    } 
                                  } else {
                                    $cod = 0;
                                    
                                  }
                                }

$sql="INSERT INTO `btyproveedor`(`prvcodigo`, `trcdocumento`, `tdicodigo`, `prvemail`, `prvestado`) VALUES ($cod,'$dct','$tpy','$crr',1)";
if (mysqli_query($conn, $sql)) {
 	echo "TRUE";
    $conn->close();
 
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
 ?>
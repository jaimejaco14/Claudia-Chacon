<?php 
include '../cnx_data.php';
$correo=strtoupper($_POST['crr']);
$mvl=$_POST['movil'];
$tfj=$_POST['fijo'];
$document=$_POST['docu'];
$sql="UPDATE btyproveedor SET prvemail='$correo' WHERE trcdocumento = $document";
if ($conn->query($sql)) {
              //echo "Record updated successfully";
                echo "TRUE";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }
 $sqlb= "UPDATE `btytercero` SET trctelefonofijo= $tfj, trctelefonomovil=$mvl WHERE trcdocumento = $document";
 if ($conn->query($sqlb)) {
              //echo "Record updated successfully";
                echo "TRUE";
                } else {
                    echo "Error updating record: " . $conn->error;
                    
                    }

 ?>
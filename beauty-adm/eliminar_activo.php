<?php 
    
    //require('conexion.php');
    
    $codigo2 = $_POST['codigo'];
    

    $query= "UPDATE  btygrupo_activo SET graestado='0' WHERE gracodigo='$codigo2'";
    if (mysqli_query($conn, $query)) {
            $conn->close();


      } 
    



?>



<?php 
    
    //include '../cnx_data.php';
    
    $cod3 = $_POST['codigos'];
    

    $query= "UPDATE  btytipo_activo SET tiaestado='0' WHERE tiacodigo='$cod3'";
    if ($conn->query($query)==TRUE) {

    	echo "true";
            $conn->close();


      } 
    



?>
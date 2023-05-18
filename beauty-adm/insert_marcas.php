<?php
include 'conexion.php';
$nommarca = $_POST["marname"];  

$maxi ="SELECT MAX(marcodigo) as m FROM btymarca_activo";    
    $resultado = $conn->query($maxi);
    if ($resultado->num_rows > 0) 
    {
         while($row = $resultado->fetch_assoc()) 
        {
        
            $codigo_marca= $row["m"];
        }
    
    } 
    else 
    {
            $codigo_marca = 0;
    }
        $codigo_marca = $codigo_marca + 1;
    $query="INSERT INTO  btymarca_activo (marcodigo, marnombre, marestado) VALUES ('$codigo_marca', '$nommarca', '1')";
    
        if ($conn->query($query)) 
        {
            echo'TRUE';
        } 
        else 
        {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

?>
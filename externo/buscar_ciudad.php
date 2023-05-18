<?php
 include '../cnx_data.php';
 
 $ciudadcodigo = $_POST["ciudad"];
 
 
   $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $ciudadcodigo");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
        }
    } else {
        echo "<option value=''>--No hay resultados--</option>";
    }




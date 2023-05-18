<?php
include '../../cnx_data.php';
 $ciudadcodigo = $_POST["barrio"];
 
 
 
   $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciudadcodigo order by brrnombre");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {                
            echo '<option value="'.$row['brrcodigo'].'">'.utf8_encode($row['brrnombre']).'</option>';
        }
    } else {
        echo "<option value=''>--No hay resultados--</option>";
    }
    $conn->close();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


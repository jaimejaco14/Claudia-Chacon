<?php
//include '../cnx_data.php';
// Recibimos por POST los datos procedentes del formulario  

$nomtypo = $_POST["nombrtypo"];  




$maxi ="SELECT MAX(tiacodigo) as m FROM btytipo_activo";    
    $resultado = $conn->query($maxi);
    if ($resultado->num_rows > 0) {
         while($row = $resultado->fetch_assoc()) {
        
      $codigo_typo= $row["m"];
        //echo "<H3>HOLAAAAAAAAAAAAAAAAAAAAAA".$codigo."</H3>";
        //$v6 = $row["tdicodigo"];
    }
    
         }
        $codigo_typo = $codigo_typo + 1;




$query="INSERT INTO  btytipo_activo (tiacodigo, tianombre, tiaestado) VALUES ('$codigo_typo', '$nomtypo', '1')";



        
        if (mysqli_query($conn, $query)) {
            //echo "New record created successfully";
            $conn->close();


                    echo'<div class="alert alert-success" role="alert">se han guardados sus datos</div>';
                    //sleep(6);

                    header ("Refresh: 5; url= marca_activo.php");


        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        
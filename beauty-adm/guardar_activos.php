
<?php
//include 'conexion.php';
//include 'head.php';

if($nombre = $_POST['nombre']){

$sqlmax ="SELECT MAX(gracodigo) as m FROM btygrupo_activo ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        
        $codigo = $row["m"];

    }
    
         }
        $codigo = $codigo + 1;



    $cod_tipo = $_POST['tipo'];

$query="INSERT INTO  btygrupo_activo (gracodigo,tiacodigo,granombre,graestado) VALUES ('$codigo','$cod_tipo','$nombre',1)";
      if (mysqli_query($conn, $query)) {
            $conn->close();

                    echo'<div class="alert alert-success" role="alert">se han guardados sus datos</div>';

                    header ("Refresh: 5; url= index_de_activos.php");


      } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
      }



} 
// aqui se agrega un tipo de activo dentro del modal

else if( $nombres = $_POST['nombres']) {



$sqlmax ="SELECT MAX(tiacodigo) as m FROM  btytipo_activo ";    
$result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        
        $codigo = $row["m"];
        //echo "<H3>HOLAAAAAAAAAAAAAAAAAAAAAA".$codigo."</H3>";
        //$v6 = $row["tdicodigo"];
    }
    
         }
        $codigo = $codigo + 1;

        $query="INSERT INTO  btytipo_activo (tiacodigo,tianombre,tiaestado) VALUES ('$codigo','$nombres',1)";

        
        if (mysqli_query($conn, $query)) {
            //echo "New record created successfully";
            $conn->close();


                    echo'<div class="alert alert-success" role="alert">se han guardados sus datos</div>';
                    //sleep(6);

                    header ("Refresh: 5; url= index_de_activos.php");


        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        

}


?>

















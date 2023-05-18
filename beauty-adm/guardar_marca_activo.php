<?php
//include 'conexion.php';
// Recibimos por POST los datos procedentes del formulario  

$marcas = $_POST["marcas"];  
$gruactivo= $_POST["grupoactivo"];
$codi_externo = $_POST["codigo_externo"];    
$nom_marca = $_POST["nombremarca"];
$modelo = $_POST["modelo"];
$especificaciones = $_POST["especificaciones"];
$descripcion = $_POST["marcadescripcion"];
$serial = $_POST["serial"];
$fecha_compra = $_POST["marcafecha"];
$imagen = $_FILES['imagen']['name'];



$max ="SELECT MAX(actcodigo) as m FROM btyactivo";    
    $result = $conn->query($max);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        
        $cod = $row["m"];
     
    }
    
         }
        $cod = $cod + 1;




$query="INSERT INTO  btyactivo (actcodigo, marcodigo, gracodigo, actcodigoexterno, actnombre, actmodelo, actespecificaciones, actdescripcion, actserial, actfechacompra, actimagen, actestado) 
 VALUES ('$cod', '$marcas', '$gruactivo', '$codi_externo', '$nom_marca', '$modelo', '$especificaciones', '$descripcion', 
 '$serial', '$fecha_compra' ,'$imagen', '1')";



        
        if (mysqli_query($conn, $query)) {
            //echo "New record created successfully";
            $conn->close();


                    echo'<div class="alert alert-success" role="alert">se han guardados sus datos</div>';
                    //sleep(6);

                    header ("Refresh: 5; url= marca_activo.php");


        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        









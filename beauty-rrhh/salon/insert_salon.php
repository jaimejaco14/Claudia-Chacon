<?php
include '../../cnx_data.php';
$id = $_POST['id_usuario'];
if ($id != ""){

    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $tfijo = $_POST['tel_fijo'];
    $tmovil = $_POST['tel_movil'];
    $email = $_POST['sln_email'];
    $tam = $_POST['tam'];
    $fecha = $_POST['fecha_apert'];
    $alias = $_POST['alias'];
    $ciudad = $_POST['ciudad'];
    $ruta = "../../contenidos/imagenes/salon/";
    $ext = $_POST['ext'];
    $ind = $_POST['ind'];
    $planta = $_POST['planta'];

//print_r($_POST);

    $tamm = str_replace(",", ".", $tam);
    if ( "" != $_FILES['imagen']['name']){

       $img_name = $_FILES['imagen']['name'];
       $archivo = $_FILES['imagen']['tmp_name'];
       
       $partes_nombre = explode('.', $img_name);
       $extension = end( $partes_nombre );
         //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
       
       
       $codigo = $id;
       move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
       $img_name = $codigo.".".$extension;
       $sql = "UPDATE `btysalon` SET `slnnombre`='$nombre', `slndireccion`='$direccion',`slntelefonofijo`='$tfijo',`slntelefonomovil`='$tmovil',`slnemail`='$email',`slntamano`='$tam', `slnfechaapertura`='$fecha', loccodigo = $ciudad, slnextensiontelefonofijo = '$ext', slnindicativotelefonofijo='$ind',  `slnalias`='$alias',`slnimagen`='$img_name' WHERE slncodigo = $id";
   } else {
    $sql = "UPDATE `btysalon` SET `slnnombre`='$nombre', `slndireccion`='$direccion',`slntelefonofijo`='$tfijo',`slntelefonomovil`='$tmovil',`slnemail`='$email',`slntamano`='$tam', `slnfechaapertura`='$fecha', loccodigo = $ciudad, slnextensiontelefonofijo = '$ext', slnindicativotelefonofijo='$ind',  `slnalias`='$alias', `slnplantas` = $planta WHERE slncodigo = $id";
}


if (mysqli_query($conn, $sql)) { 
    echo "TRUE";
            //echo "New record created successfully";
    
            //header("Location: servicios.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo "Error updating record: " . $conn->error;
    
}




} else if ($nombre = $_POST['nombre']) {
    $direccion = $_POST['direccion'];
    $tfijo = $_POST['tel_fijo'];
    $tmovil = $_POST['tel_movil'];
    $email = $_POST['sln_email'];
    $tam = $_POST['tam'];
    $fecha = $_POST['fecha_apert'];
    $alias = $_POST['alias'];
    $ruta = "../../contenidos/imagenes/salon/";
    $ciudad = $_POST['ciudad'];
    $ext = $_POST['ext'];
    $ind = $_POST['ind'];
    $planta = $_POST['planta'];
    $tam = str_replace(",", ".", $tam);

    $sqlmax ="SELECT MAX(slncodigo) as m FROM `btysalon` ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
        $codigo = $row["m"];
        //echo "<H3>HOLAAAAAAAAAAAAAAAAAAAAAA".$codigo."</H3>";
        //$v6 = $row["tdicodigo"];
    }
    
}

$codigo = $codigo + 1;

if ( "" != $_FILES['imagen']['name']){

   $img_name = $_FILES['imagen']['name'];
   $archivo = $_FILES['imagen']['tmp_name'];
   
   $partes_nombre = explode('.', $img_name);
   $extension = end($partes_nombre);
   
         //rename($archivo, $ruta.$new_name.".".$extension);
        //$ruta = "images/galeria_servicios";
   
   move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
   $img_name = $codigo.".".$extension;
} else {
    $img_name = "default.jpg";

}         

$sql = "INSERT INTO `btysalon`(`slncodigo`, `slnnombre`, `slndireccion`, `slnindicativotelefonofijo`, `slntelefonofijo`, `slnextensiontelefonofijo`, `slntelefonomovil`, `slnemail`, `slntamano`, `slnfechaapertura`, `slnalias`, loccodigo, `slnimagen`, `slnplantas`, `slnestado`) VALUES ($codigo, '$nombre' ,'$direccion', '$ind', '$tfijo', '$ext', '$tmovil', '$email', '$tam', '$fecha', '$alias', '$ciudad', '$img_name', '$planta', 1)";
if (mysqli_query($conn, $sql)) { 
    echo "TRUE";
            //echo "New record created successfully";
    
            //header("Location: servicios.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    echo "Error updating record: " . $conn->error;
    
}

}
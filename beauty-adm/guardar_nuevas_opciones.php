<?php
include '../cnx_data.php';
$id = $_POST['id_usuario'];


//INSERTAR LINEA OK

if ($nombre = $_POST['lineaname']){
    $ruta = "imagenes/linea/";
    $alias = $_POST['linalias'];
    $descripcion = $_POST['linea_descripcion'];

    if ("" != $_FILES['linea_imagen']['name']){
        $img_name = $_FILES['linea_imagen']['name'];
        $archivo = $_FILES['linea_imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
        $sqlmax ="SELECT MAX(lincodigo) as m FROM `btylinea` ";    
        $result = $conn->query($sqlmax);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $codigo = $row["m"];
            }
    
        }
        $codigo = $codigo + 1;
        move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
        $i_nom = ($codigo+1).$extension;
        } else {
            $i_nom = "default.jpg";
            $sqlmax ="SELECT MAX(lincodigo) as m FROM `btylinea` ";    
            $result = $conn->query($sqlmax);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $codigo = $row["m"];
                }

            }
        }
        $codigo = $codigo + 1;
        $sql = "INSERT INTO btylinea(lincodigo, linnombre, linalias, lindescripcion, linimagen, linestado) VALUES('$codigo', '$nombre', '$alias', '$descripcion', '$i_nom', 1)";
        if (mysqli_query($conn, $sql)) {
            //$conn->close();
            //header("Location: newservice.php");
            echo "TRUE";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



// INSERTAR SUBLINEA OK
} else if($nombre = $_POST['sublineaname']) {
    $ruta = "imagenes/sublinea/";
    $alias = $_POST['sublinalias'];
    $descripcion = $_POST['sublinea_descripcion'];
    $lin = $_POST['linead'];

        if ("" != $_FILES['sublinea_imagen']['name']){
        $img_name = $_FILES['sublinea_imagen']['name'];
        $archivo = $_FILES['sublinea_imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
        $sqlmax ="SELECT MAX(sblcodigo) as m FROM `btysublinea` ";    
        $result = $conn->query($sqlmax);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $codigo = $row["m"];
            }
    
        }
        $codigo = $codigo + 1;
        move_uploaded_file($archivo,$ruta.($codigo).".".$extension);
        $img_name = ($codigo).".".$extension;
        } else {
            $img_name = "default.jpg";

        }

    $sqlmax ="SELECT MAX(sblcodigo) as m FROM `btysublinea` ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $codigo = $row["m"];
        }
    
    }
    $sql1 = "SELECT sblnombre FROM `btysublinea` ";
    $codigo = $codigo + 1;
    $sql = "INSERT INTO btysublinea(sblcodigo, lincodigo, sblnombre, sblalias, sbldescripcion, sblimagen, sblestado) VALUES('$codigo', '$lin', '$nombre', '$alias', '$descripcion', '$img_name', 1)";
    if (mysqli_query($conn, $sql)) {
        //$conn->close();
        //header("Location: newservice.php");
        echo "TRUE";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }







    //INSERTAR GRUPO ok
} else if($nombre = $_POST['grupo_name']) {
    $ruta = "imagenes/grupo/";
    $alias = $_POST['grupo_alias'];
    $descripcion = $_POST['grupo_descripcion'];
    $img_name = $_FILES['grupo_imagen']['name'];
    $lin = $_POST['sublineag'];

    if ("" != $_FILES['grupo_imagen']['name']){
        $img_name = $_FILES['grupo_imagen']['name'];
        $archivo = $_FILES['grupo_imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
        $sqlmax ="SELECT MAX(grucodigo) as m FROM `btygrupo` ";    
        $result = $conn->query($sqlmax);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              $codigo = $row["m"];
            }
        }
        $codigo = $codigo + 1;
        move_uploaded_file($archivo,$ruta.($codigo+1).".".$extension);
        $img_name = ($codigo+1).".".$extension;
        } else {
            $img_name = "default.jpg";
        }


$sqlmax ="SELECT MAX(grucodigo) as m FROM `btygrupo` ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        
        $codigo = $row["m"];

    }
    
         }
        $codigo = $codigo + 1;
        $sql = "INSERT INTO btygrupo(grucodigo, sblcodigo, grunombre, grualias, grudescripcion, gruimagen, gruestado) VALUES('$codigo', '$lin', '$nombre', '$alias', '$descripcion', '$img_name', 1)";
        if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
            //$conn->close();
            //header("Location: newservice.php");
            echo "TRUE";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }





    //INSERT SUBGRUPO OK
} else if($nombre = $_POST['subgrupo_name']) {
    $ruta = "imagenes/subgrupo/";
    $alias = $_POST['subgrupo_alias'];
    $descripcion = $_POST['subgrupo_descripcion'];
    $img_name = $_FILES['subgrupo_imagen']['name'];
    $lin = $_POST['gruposg'];

        if ( "" != $_FILES['subgrupo_imagen']['name']){

         $img_name = $_FILES['subgrupo_imagen']['name'];
        $archivo = $_FILES['subgrupo_imagen']['tmp_name'];
         
         $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;
    
        
        $sqlmax ="SELECT MAX(sbgcodigo) as m FROM `btysubgrupo` ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        $codigo = $row["m"];
     
    }
    
         }
         $codigo = $codigo + 1;
         move_uploaded_file($archivo,$ruta.($codigo).".".$extension);
         $img_name = ($codigo).".".$extension;
} else {
    $img_name = "default.jpg";
}

$sqlmax ="SELECT MAX(sbgcodigo) as m FROM `btysubgrupo` ";    
    $result = $conn->query($sqlmax);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
        
        $codigo = $row["m"];

    }
    
         }
        $codigo = $codigo + 1;
        $sql = "INSERT INTO btysubgrupo(sbgcodigo, grucodigo, sbgnombre, sbgalias, sbgdescripcion, sbgimagen, sbgestado) VALUES('$codigo', '$lin', '$nombre', '$alias', '$descripcion', '$img_name', 1)";
        if (mysqli_query($conn, $sql)) {
            //echo "New record created successfully";
            //$conn->close();
            //header("Location: newservice.php");
            echo "TRUE";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }



    //UPDATE SERVICIO
} else if ($id != NULL) {
         $ruta = "imagenes/servicio/";
        $nombre = $_POST['nombre'];
        $alias = $_POST['alias'];
        $descripcion = $_POST['descripcion'];
        $lin = $_POST['subgrupo'];


        if ( "" != $_FILES['imagen']['name']){

         $img_name = $_FILES['imagen']['name'];
        $archivo = $_FILES['imagen']['tmp_name'];
         
         $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
        $new_name = $id_usuario;

    move_uploaded_file($archivo,$ruta.$id.".".$extension);
    $img_name = $id.".".$extension;
         } else {
            $img_name = "default.jpg";
         }

         
 

        $sql = "UPDATE  btyservicio  SET sernombre = '$nombre', seralias = '$alias', serdescripcion = '$descripcion', serimagen = '$img_name' WHERE sercodigo = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "TRUE";
            //header("Location: servicios.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }
       // $conn->close();



        //INSERT SERVICIO
    } else if ($nombre = $_POST['nombre']) {
        $ruta = "imagenes/servicio/";
        $lin = $_POST['subgrupo']; 
        $alias = $_POST['alias'];
        $dura = $_POST['dura'];
        $descripcion = $_POST['descripcion'];
        if ( "" != $_FILES['imagen']['name']){
            $img_name = $_FILES['imagen']['name'];
            $archivo = $_FILES['imagen']['tmp_name'];
            $partes_nombre = explode('.', $img_name);
            $extension = end( $partes_nombre );
            $new_name = $id_usuario;
            $sqlmax ="SELECT MAX(sercodigo) as m FROM `btyservicio` ";    
            $result = $conn->query($sqlmax);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $codigo = $row["m"];
                }
            } else {
                $codigo = 0;
            }
            $codigo = $codigo + 1;
            move_uploaded_file($archivo,$ruta.$codigo.".".$extension);
            $img_name = $codigo.".".$extension;
        } else {
            $img_name = "default.jpg";
        }
        $sqlmax ="SELECT MAX(sercodigo) as m FROM `btyservicio` ";    
        $result = $conn->query($sqlmax);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $codigo = $row["m"];
            }
        } else {
            $codigo = 0;
        }
        $codigo = $codigo + 1;
        $sql = "INSERT INTO btyservicio(sercodigo, sernombre, serdescripcion, serimagen, seralias, serduracion, sbgcodigo, serstado) VALUES('$codigo', '$nombre', '$descripcion', '$img_name', '$alias', '$dura', '$lin', 1)";
        echo $id;
        if (mysqli_query($conn, $sql)) {
            echo "TRUE";
            //echo "New record created successfully";
            
            //header("Location: servicios.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }
        //$conn->close();
    }
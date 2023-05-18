<?php 
    session_start();
    header("Content-Type: Application/Json");
    include("../../../cnx_data.php");

    switch ($_POST['opcion']) 
    {
        case 'nuevo':
            
            $query = mysqli_query($conn, "SELECT MAX(diccodigo)AS max FROM btydirectorio_contactos");
            $FetchQuery = mysqli_fetch_array($query);
            $Max = $FetchQuery['max'] + 1;

            $nuevo = mysqli_query($conn, "INSERT INTO btydirectorio_contactos (diccodigo, slncodigo, dicnombre, dictelefonomovil, dictelefonofijo, cliemail, dicfechacreacion, dicfechaultactualizacion, dicestado)VALUES($Max, '".$_SESSION['PDVslncodigo']."', '".utf8_decode($_POST['nombre'])."', '".$_POST['movil']."', '".$_POST['fijo']."', '".$_POST['email']."', CURDATE(), NULL, 1)")or die(mysqli_error($conn));

            if ($nuevo) 
            {
               echo 1;
            }

            break;

        case 'editar':
            
            $sql = mysqli_query($conn, "SELECT * FROM btydirectorio_contactos WHERE diccodigo = '".$_POST['codigo']."' ");

            $arrayDirectorio = array();

            $rows = mysqli_fetch_object($sql);

            $arrayDirectorio[] = array(
                    'id'     => $rows->diccodigo,
                    'sln'    => $rows->slncodigo,
                    'nom'    => $rows->dicnombre,
                    'mov'    => $rows->dictelefonomovil,
                    'fij'    => $rows->dictelefonofijo,
                    'mai'    => $rows->cliemail,
                    'crea'   => $rows->dicfechacreacion,
                    'actu'   => $rows->dicfechaultactualizacion,
                    'est'    => $rows->dicestado
            );

            function utf8_converter($array)
            {
                array_walk_recursive($array, function(&$item, $key){
                    if(!mb_detect_encoding($item, 'utf-8', true)){
                        $item = utf8_encode($item);
                    }
                });

                return $array;
            }
                       

            $array= utf8_converter($arrayDirectorio);

            echo json_encode($array);

            break;

        case 'guardar_cambios':

            $id     = $_POST['id'];
            $nombre = utf8_decode($_POST['nombre']);
            $movil  = $_POST['movil'];
            $fijo   = $_POST['fijo'];
            $email  = $_POST['email'];

            $QueryMod = mysqli_query($conn, "UPDATE btydirectorio_contactos SET dicnombre = '$nombre', dictelefonofijo = '$fijo', dictelefonomovil = '$movil', cliemail = '$email', dicfechaultactualizacion = CURDATE() WHERE diccodigo = $id")or die(mysqli_error($conn));

            if ($QueryMod) 
            {
                echo 1;
            }

            break;

        case 'eliminar':

            $QueryEliminar = mysqli_query($conn, "UPDATE btydirectorio_contactos SET dicestado = 0 WHERE diccodigo = '".$_POST['id']."' ");

            if ($QueryEliminar) 
            {
              echo 1;
            }
            
            break;

        case 'counter':
           
            $QueryCounter = mysqli_query($conn, "SELECT diccodigo FROM btydirectorio_contactos WHERE dicestado = 1 AND slncodigo = '".$_SESSION['PDVslncodigo']."'");
            

            echo $conteeo = mysqli_num_rows($QueryCounter);
            break;
        
        default:
            # code...
            break;
    }
?>

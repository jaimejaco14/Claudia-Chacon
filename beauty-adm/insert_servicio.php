<?php 
include '../cnx_data.php';

$nombre             = strtoupper($_REQUEST["nombre"]);
$alias              = strtoupper($_REQUEST["alias"]);
$codigoAnterior     = $_REQUEST["codigoAnterior"];
$duracion           = round($_REQUEST["duracion"]);
$comision           = round($_REQUEST["comision"]);
$descripcion        = strtoupper($_REQUEST["descripcion"]);
$caracteristica     = $_REQUEST["caracteristica"];
$precioFijo         = $_REQUEST["precioFijo"];
$cita               = $_REQUEST["cita"];
$domicilio          = $_REQUEST["domicilio"];
$insumo             = $_REQUEST['insumo'];
$categoria          = $_REQUEST['categoria'];
$cargo              = $_REQUEST['cargo'];

$camposObligatorios = strlen($nombre) * strlen($alias) * strlen($duracion) * strlen($comision) * strlen($caracteristica);

/*echo $nombre."<br>".$alias."<br>".$codigoAnterior."<br>".$duracion."<br>".$comision."<br>".$descripcion."<br>".$caracteristica."<br>".$precioFijo."<br>".$cita."<br>".$domicilio;
exit;*/

if($camposObligatorios > 0 && ($comision >= 0 && $comision <= 100)){

    $imagen            = $_FILES['imagen']['name'];
    $maxcodigo         = "";
    $resultadoQueryMax = $conn->query("SELECT MAX(sercodigo) AS maxcodigo FROM btyservicio");

    while($registros = $resultadoQueryMax->fetch_array()){

        $maxcodigo = $registros["maxcodigo"];
    }

    if($maxcodigo == null){

        $maxcodigo = 1;
    }
    else{

        $maxcodigo = $maxcodigo + 1;
    }

    if(!empty($imagen)){

        $ruta         = "../contenidos/imagenes/servicio/";
        $archivo      = $_FILES["imagen"]["tmp_name"];
        $stringImagen = explode(".", $imagen);
        $extension    = end($stringImagen);
        $nombreImagen = $maxcodigo.".".$extension;
        move_uploaded_file($archivo, $ruta.$maxcodigo.".".$extension);
    }
    else{

        $nombreImagen = "default.jpg";
    }

    $queryCrearServicio = "INSERT INTO btyservicio(sercodigo, sercodigoanterior, crscodigo, sernombre, serdescripcion, serimagen, seralias, serduracion, serpreciofijo, sercita, serdomicilio, sercomision, sercreacion, serultactualizacion, serstado, serrequiereinsumos) VALUES ($maxcodigo, '$codigoAnterior', $caracteristica, '$nombre', '$descripcion', '$nombreImagen', '$alias', '$duracion', '$precioFijo', '$cita', '$domicilio', '$comision', CURDATE(), CURDATE(), 1,$insumo)";

    $resultQueryCrearServicio = $conn->query($queryCrearServicio);

    if($resultQueryCrearServicio){
        if($categoria>=0){
            $sql="INSERT INTO btycategoria_colaborador_servicios (ctccodigo,sercodigo,ctsestado) VALUES ($categoria,$maxcodigo,1)";
            $res=$conn->query($sql);
        }
        if($cargo[0]>0){
            for($k=0;$k<=count($cargo);$k++){
                $sql="INSERT INTO btyservicio_cargo (crgcodigo,sercodigo,secaestado) VALUES ($cargo[$k],$maxcodigo,1)";
                $conn->query($sql);
            }
        }
        echo json_encode(array("result" => "creado"));
        
        //El siguiente código comentado sirve para realizar la inserción del servicio en la tabla btylistas_precios_servicios 
            /*$listaPrecios = array();
            $resultQueryListaPrecios = $conn->query("SELECT lprcodigo FROM btylista_precios");

            if(mysqli_num_rows($resultQueryListaPrecios) > 0){
                
                while($registrosListas = $resultQueryListaPrecios->fetch_array()){

                    $listaPrecios[] = $registrosListas["lprcodigo"];
                }

                foreach($listaPrecios as $codigoLista){

                    $conn->query("INSERT INTO btylista_precios_servicios (lprcodigo, sercodigo, lpsvalor, lprcreacion, lpsactualizacion) VALUES ($codigoLista, $maxcodigo, 0, CURDATE(), CURDATE())");
                }
            }*/

            //echo json_encode(array("result" => "creado"));
    }
    else
    {
        echo json_encode(array("result" => "error"));
    }
}
else{

    echo json_encode(array("result" => "error"));
}

?>
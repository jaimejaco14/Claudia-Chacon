<?php 
	
	include '../cnx_data.php';

	$codigo         = $_REQUEST["codigo"];
	$nombre         = strtoupper(utf8_decode($_REQUEST["nombre"]));
	$codigoAnterior = $_REQUEST["codigoAnterior"];
	$duracion       = round($_REQUEST["duracion"]);
	$comision       = round($_REQUEST["comision"]);
	$precioFijo     = $_REQUEST["precioFijo"];
	$cita           = $_REQUEST["cita"];
	$domicilio      = $_REQUEST["domicilio"];
	$insumo 		= $_REQUEST['insumo'];
	$imagen         = $_FILES["imagen"]["name"];
	$alias          = strtoupper(utf8_decode($_REQUEST["alias"]));
	$descripcion    = strtoupper(utf8_decode($_REQUEST["descripcion"]));
	$categoria    	= strtoupper($_REQUEST["categoria"]);
	$cargo    		= $_REQUEST["cargo"];


	$queryServicio  = "sernombre = '$nombre', sercodigoanterior = '$codigoAnterior', serduracion = '$duracion', seralias = '$alias', serdescripcion = '$descripcion', serpreciofijo = '$precioFijo', sercita = '$cita', serdomicilio = '$domicilio', sercomision = '$comision', serultactualizacion = CURDATE(),serrequiereinsumos=$insumo";
	


	if((!empty($_REQUEST["caracteristica"])) && ($_REQUEST["caracteristica"]!='null')){
		
		$caracteristica = $_REQUEST["caracteristica"];
		$queryServicio .= ", crscodigo = '$caracteristica'";
	}

	if(!empty($imagen)){


        $ruta         = "../contenidos/imagenes/servicio/";
        $archivo      = $_FILES["imagen"]["tmp_name"];
        $stringImagen = explode(".", $imagen);
        $extension    = end($stringImagen);
        $nombreImagen = $codigo.".".$extension;
        move_uploaded_file($archivo, $ruta.$codigo.".".$extension);
        $queryServicio .= ", serimagen = '".$nombreImagen."'";
    }

	$queryServicio = "UPDATE btyservicio SET ".$queryServicio." WHERE sercodigo = '$codigo'";
	
	if($conn->query($queryServicio)){
		if($cargo[0]>0){
			$delcrg="DELETE FROM btyservicio_cargo WHERE sercodigo=$codigo";
			$conn->query($delcrg);
			for($k=0;$k<=count($cargo);$k++){
                $sql="INSERT INTO btyservicio_cargo (crgcodigo,sercodigo,secaestado) VALUES ($cargo[$k],$codigo,1)";
                $conn->query($sql);
            }
		}
		if($categoria!=''){
			$actcategoria="UPDATE btycategoria_colaborador_servicios SET ctccodigo=$categoria WHERE sercodigo=$codigo";
			$res=$conn->query($actcategoria);
			if($res){
				echo json_encode(array("result" => "actualizado"));
			}else{
				echo json_encode(array("result" => "error","sql1"=>$actcategoria));
			}
		}else{
			echo json_encode(array("result" => "actualizado"));
		}
	}
	else{

		echo json_encode(array("result" => "error","sql2"=>$queryServicio));
	}


?>
<?php 
include '../cnx_data.php';

if(isset($_REQUEST["codigoServicio"])){

	$servicio      = $_REQUEST["codigoServicio"];
	$queryBuscarServicio = "SELECT * FROM btyservicio s 
							left JOIN btycategoria_colaborador_servicios cs on cs.sercodigo=s.sercodigo
							left JOIN btycategoria_colaborador cc on cc.ctccodigo=cs.ctccodigo
							WHERE s.sercodigo = $servicio";
	$resultBuscarServicio = $conn->query($queryBuscarServicio);

	if($resultBuscarServicio != false){
 
		if(mysqli_num_rows($resultBuscarServicio) > 0){

			$codigo                = "";
			$nombre                = "";
			$codigoAnterior        = "";
			$descripcion           = "";
			$alias                 = "";
			$duracion              = "";
			$comision              = "";
			$precioFijo            = "";
			$cita                  = "";
			$domicilio             = "";
			$imagen                = "";
			$fechaCreacion         = "";
			$fechaActualizacion    = "";
			$datosServicio         = array();
			$listasPreciosServicio = array();

			while($registrosServicio = $resultBuscarServicio->fetch_array()){

				$codigo             = $servicio;
				$nombre             = $registrosServicio["sernombre"];
				$codigoAnterior     = $registrosServicio["sercodigoanterior"];
				$descripcion        = $registrosServicio["serdescripcion"];
				$categoria 			= $registrosServicio["ctcnombre"];
				$alias              = $registrosServicio["seralias"];
				$duracion           = $registrosServicio["serduracion"];
				$comision           = $registrosServicio["sercomision"];
				$precioFijo         = $registrosServicio["serpreciofijo"];
				$cita               = $registrosServicio["sercita"];
				$domicilio          = $registrosServicio["serdomicilio"];
				$imagen             = $registrosServicio["serimagen"];
				$fechaCreacion      = $registrosServicio["sercreacion"];
				$fechaActualizacion = $registrosServicio["serultactualizacion"];
				$insumo				= $registrosServicio["serrequiereinsumos"];
			}
			if($categoria==''){
				$categoria 			= 'NO DEFINIDA';
			}
			$conscargo=$conn->query("SELECT GROUP_CONCAT(c.crgcodigo)
										FROM btyservicio_cargo sc
										JOIN btycargo c ON c.crgcodigo=sc.crgcodigo
										JOIN btyservicio s ON s.sercodigo=sc.sercodigo
										WHERE s.sercodigo=".$servicio);
			$rescargo=$conscargo->fetch_array();


			$resultCategoriasServicio = $conn->query("SELECT crscodigo, crsnombre, sblcodigo, sblnombre, lincodigo, linnombre, sbgcodigo, sbgnombre, grucodigo, grunombre FROM bty_vw_servicios_categorias WHERE sercodigo = $servicio");

			while($registrosCategoriasServicio = $resultCategoriasServicio->fetch_array()){

				$datosServicio[] = array(
									"codigo"             => $codigo,
									"nombre"             => utf8_encode($nombre),
									"codigoAnterior"     => $codigoAnterior,
									"descripcion"        => utf8_encode($descripcion),
									"categoria"        	 => utf8_encode($categoria),
									"cargo"				 => $rescargo[0],
									"alias"              => utf8_encode($alias),
									"precioFijo"         => $precioFijo,
									"cita"               => $cita,
									"domicilio"          => $domicilio,
									"duracion"           => $duracion,
									"comision"           => $comision,
									"imagen"             => $imagen,
									"fechaCreacion"      => $fechaCreacion,
									"fechaActualizacion" => $fechaActualizacion,
									"insumo"			 => $insumo,
									"codGrupo"           => $registrosCategoriasServicio["grucodigo"],
									"nomGrupo"           => utf8_encode($registrosCategoriasServicio["grunombre"]),
									"codSubgrupo"        => $registrosCategoriasServicio["sbgcodigo"],
									"nomSubgrupo"        => utf8_encode($registrosCategoriasServicio["sbgnombre"]),
									"codLinea"           => $registrosCategoriasServicio["lincodigo"],
									"nomLinea"           => utf8_encode($registrosCategoriasServicio["linnombre"]),
									"codSublinea"        => $registrosCategoriasServicio["sblcodigo"],
									"nomSublinea"        => utf8_encode($registrosCategoriasServicio["sblnombre"]),
									"codCaracteristica"  => $registrosCategoriasServicio["crscodigo"],
									"nomCaracteristica"  => utf8_encode($registrosCategoriasServicio["crsnombre"]));

			}

			$resultQueryListaPrecios = $conn->query("SELECT listaPrecios.lprnombre, preciosServicios.lpsvalor, preciosServicios.lpsactualizacion FROM btylista_precios listaPrecios NATURAL JOIN btylista_precios_servicios preciosServicios WHERE sercodigo = $servicio ORDER BY listaPrecios.lprnombre");

			while($registrosListaPrecios = $resultQueryListaPrecios->fetch_array()){
				
				$listasPreciosServicio[] = array(
											"nomLista"      => utf8_encode($registrosListaPrecios["lprnombre"]),
											"valor"         => "$".number_format($registrosListaPrecios["lpsvalor"], 0, ",", "."),
											"actualizacion" => $registrosListaPrecios["lpsactualizacion"]);
			}

			echo json_encode(array("result" => "full", "data" => $datosServicio, "listaPrecios" => $listasPreciosServicio));
		}
		else{

			echo json_encode(array("result" => "error"));
		}
	}
	else{

		echo json_encode(array("result" => "error"));
	}
}

mysqli_close($conn);
?>
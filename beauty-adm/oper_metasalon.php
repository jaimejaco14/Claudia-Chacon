<?php

//En este archivo se realizan las operaciones de insertar, borrar, copiar y actualizar metas
//******************************************************
//CAMPOS TABLA btymeta_salon_cargo**********************
//******************************************************
//mtames=mes
//slncodigo=codigo salon
//crgcodigo=codigo cargo
//******************************************************
//mtatipo=porcentaje o valor definido
//mtapuntoreferencia=1 o 0
//mtavalor=valor o porcentaje asignado
//******************************************************

include '../cnx_data.php';
$op=$_POST['oper'];
switch($op){
	//INSERTAR NUEVA META*********************************************************
	case "NEW":
	//se reciben los datos por POST provenientes del formulario "form_newmeta"
		$mes=$_POST['metames'];
		$sln=$_POST['metasalon'];
		$crg=$_POST['metacargo'];
		$tipo=$_POST['metatipo'];
		$val=$_POST['metaval'];

		//dependiendo de si el nuevo registro va o no a ser de referencia, varia la consulta
		if($_POST['metaref']){
			$ref=1;//consultará si ya existe o no un registro como punto de referencia
			$sql1="SELECT * FROM btymeta_salon_cargo WHERE (mtames=$mes AND crgcodigo=$crg AND slncodigo=$sln) OR (mtames=$mes AND slncodigo=$sln AND mtapuntoreferencia=1)";
		}else{
			$ref=0;//consultará si existe un duplicado de lo que se intenta registrar
			$sql1="SELECT mtames,crgcodigo,slncodigo FROM btymeta_salon_cargo WHERE mtames=$mes AND crgcodigo=$crg AND slncodigo=$sln";
		}
		
		$result = $conn->query($sql1);
		if($ntr = $result->num_rows>0){
			$row=$result->fetch_assoc();
			if($row['mtapuntoreferencia']==1){
				echo "REF";
				//ya hay un registro seteado como punto de referencia
			}else{
				echo "DUPLI";
				//se intentó grabar un registro igual a uno existente
			}	
		}
		else{
			//se realiza la insercion del nuevo registro con los datos recibidos por POST
			$sql3="INSERT INTO btymeta_salon_cargo (mtames,slncodigo,crgcodigo,mtatipo,mtapuntoreferencia,mtavalor) 
						VALUES ($mes,$sln,$crg,'$tipo',$ref,$val)";
			if($conn->query($sql3)){
				echo "TRUE";
				//se realizó la insercion correctamente
			}else{
				echo "FALSE";
				//algo falló y las consultas sql no se realizaron
			}
		}	
	break;

	//BORRAR META*********************************************************************
	case "DEL":
	//se reciben los datos por POST provenientes de la funcion "eliminar(mes,sln,crg)"
		$mes=$_POST['mes'];
		$crg=$_POST['crg'];
		$sln=$_POST['sln'];
		$sql="DELETE FROM btymeta_salon_cargo WHERE mtames=$mes AND slncodigo=$sln AND crgcodigo=$crg ";
			if($conn->query($sql)){
				//se borró exitosamente el registro
				echo "TRUE";
			}else{
				//algo pasó y la consulta sql no se realizó
				echo "FALSE";
			}
	break;
	
	//BUSCAR META**********************************************************************
	case "BUS":
	//se reciben los datos por POST provenientes de la funcion "editar(mes,sln,crg)"
	//este case consulta los datos de un registro al pulsar el boton "editar" y los carga en el formulario "form_editmeta"
		$mes=$_POST['mes'];
		$crg=$_POST['crg'];
		$sln=$_POST['sln'];
		$sql="SELECT * FROM btymeta_salon_cargo WHERE mtames=$mes AND slncodigo=$sln AND crgcodigo=$crg";
			if($result=$conn->query($sql)){
				//se encontraron los datos y se devuelven como respuesta jsonArray para ser insertados en el modal editar
				$row=$result->fetch_assoc();
				echo json_encode(array("mes" => $row['mtames'], "sln" => $row['slncodigo'], "crg" => $row['crgcodigo'], "tpo" => $row['mtatipo'], "ref" => $row['mtapuntoreferencia'], "val" => $row['mtavalor']));
			}else{
				//algo pasó y la consulta sql no se realizó
				echo json_encode(array("RES"=>"FALSE"));
				//echo $sql;
			}
	break;

	//EDITAR META*************************************************************************
	case "UPD":
	//case que se ejecuta con el evento SUBMIT del formulario "form_editmeta"
	//se reciben por POST tanto los datos originales, como los cambiados
		$mes=$_POST['editmetames'];
		$sln=$_POST['editmetasalon'];
		$crg=$_POST['editmetacargo'];
		$tipo=$_POST['editmetatipo'];
		$val=$_POST['editmetaval'];
		if($_POST['editmetaref']){
			$ref=1;//si se quiere modificar el registro y setearlo como punto de referencia, se valida si ya existe uno en ese mes, en ese cargo, en ese salon
			$sql="SELECT * FROM btymeta_salon_cargo WHERE (mtames=$mes AND crgcodigo=$crg AND slncodigo=$sln) OR (mtames=$mes AND slncodigo=$sln AND mtapuntoreferencia=1)";
		}else{
			$ref=0;
			//se verifica que no exista mas de un registro con los mismos datos que se quieren modificar
			$sql="SELECT mtames,crgcodigo,slncodigo FROM btymeta_salon_cargo WHERE mtames=$mes AND crgcodigo=$crg AND slncodigo=$sln";
		}
		
		//campos ocultos con valores anteriores, se usan como referencia de donde se van a insertar los datos editados
		$mesh=$_POST['mesh'];
		$slnh=$_POST['slnh'];
		$crgh=$_POST['crgh'];
		$result = $conn->query($sql);
		$ntr = $result->num_rows;
		if($ntr>1){
			$row=$result->fetch_assoc();
			if($row['mtapuntoreferencia']==1){
				echo "REF";//ya existe un registro seteado como punto de referencia y no se realiza el update de registro
			}else{
				echo "DUPLI";//aparte del registro que se desea editar, existe otro con los mismos datos que los que se pretende insertar, evita duplicidad
			}	
		}
		else{
			//realiza el update despues de haber realizado las validaciones
			$sql2="UPDATE btymeta_salon_cargo 
					SET mtames=$mes, slncodigo=$sln, crgcodigo=$crg, mtatipo='$tipo', mtapuntoreferencia=$ref, mtavalor=$val 
					WHERE  mtames=$mesh AND slncodigo=$slnh AND crgcodigo=$crgh";
			if($conn->query($sql2)){
				echo "OK";//se realizó el update correctamente
			}else{
				echo "FALSE";//algo pasó y no se pudo realizar la consulta sql
			}
		}
	break;

	//COPIA MULTIPLE DE METAS********************************************************************************************************************
	case "MULTI":
	//*******datos de referencia (datos a copiar)******
	//
		$mesref=$_POST['mesr'];
		$slnref=$_POST['slnr'];

	//*************array de datos de destino************
	//Esto tmbn se puede hacer con JSON array (...) aunque es mas largo alla y aca.
	$meses=$_POST['mes'];//  "array" creado en jquery usando como separador "•" y que contiene los meses en los que se copiará la informacion
	$slnes=$_POST['sln'];//  "array" creado en jquery usando como separador "•" y que contiene los salones en los que se copiará la informacion
	$mesvec   = explode("•", $meses);//se convierte en array php
	$slnvec   = explode("•", $slnes);//se convierte en array php
	$count=count($mesvec)-1;//Cuenta la cantidad de datos en el array (ambos arrays tendran SIEMPRE la misma cantidad, por eso solo los cuento en uno solo), se le resta 1 porque el ultimo valor del array siempre será nulo [ej: (1•2•) se convertirá en {1,2,null}] ya que en el jquery se inserta (valor-separador) y despues del ultimo separador no hay ningun valor; -con este método, claro está...-
//**************************************************************************************************************************************************************// 
	// se consultan los registros que cumplen con las condiciones definidas por el usuario (datos de referencia)
	$sqlcopy="SELECT * FROM btymeta_salon_cargo WHERE slncodigo=$slnref AND mtames=$mesref";
	$res=$conn->query($sqlcopy);
	//se verifica si existen registros con los datos de referencia
	if($ntr = $res->num_rows>0)
	{//si los datos existen se asocian los registros a la variable $datos
		while($datos=$res->fetch_assoc())
		{
			//estos son los datos consultados que se insertaran por cada valor de los array de mes y salon
			$cargo=$datos['crgcodigo'];
			$tipo=$datos['mtatipo'];
			$ref=$datos['mtapuntoreferencia'];
			$val=$datos['mtavalor'];
			//el ciclo FOR se repetirá dependiendo del numrows de la variable $datos 
			for($i=0;$i<$count;$i++)
			{	//este ciclo inserta los valores consultados en cada mes y salon definido
				$sqlinsert="INSERT INTO btymeta_salon_cargo (mtames,slncodigo,crgcodigo,mtatipo,mtapuntoreferencia,mtavalor) 
						VALUES ($mesvec[$i],$slnvec[$i],$cargo,'$tipo',$ref,$val)";
				$conn->query($sqlinsert);
			}//al finalizar este ciclo(for) continua el ciclo(while) con el siguiente conjunto de datos consultados para hacer el siguiente ciclo(for) de copia
		}
		//una vez finalizados ambos ciclos(while y for) se valida que se hayan insertado los registros totales comparando la variable del for($i) con el numero de datos de los array($count)
		if($i==$count){
			//todo salió bien y se realizó la copia deseada por el usuario
			echo "TRUE";
		}
	}//
	else
	{	
		//respuesta cuando no existen registros asociados a la peticion del usuario
		echo "NOREG";
	}
	break;
}
$conn->close();
?>
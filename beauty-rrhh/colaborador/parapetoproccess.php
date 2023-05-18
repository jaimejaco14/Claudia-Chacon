<?php 
include '../../cnx_data.php';

switch ($_POST['opcion']) 
{
	case 'cargarColaborador':


		$colaborador = $_POST["datoCliente"];

			$query = "SELECT c.clbcodigo, c.trcdocumento, t.trcrazonsocial, crg.crgnombre FROM btycolaborador c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btycargo crg ON c.crgcodigo = crg.crgcodigo WHERE c.clbestado = 1 AND  t.trcrazonsocial LIKE '%$colaborador%' ORDER BY t.trcrazonsocial";

			$resultadoQuery = $conn->query($query);

			if(($resultadoQuery != false) && (mysqli_num_rows($resultadoQuery) > 0))
			{

				$colaborador = array();

				while($registros = $resultadoQuery->fetch_array())
				{

						$colaborador[] = array(
							"codigo"        => $registros["clbcodigo"],
							"documento"     => $registros["trcdocumento"],
							"nombreCliente" => $registros["trcrazonsocial"]
						);
				}

				$colaborador = utf8_converter($colaborador);
				echo json_encode(array("result" => "full", "data" => $colaborador));
			}
			else
			{
				echo json_encode(array("result" => "error"));
			}
	break;

	case 'cargarTabla':

		if ($_POST['slncodigo'] != "") 
		{
			$sln = $_POST['slncodigo'];
		}

		$diaCons = $_POST['fecha'];
		$codcol=$_POST['codigo'];

		$e = "SELECT DAY(LAST_DAY('".$diaCons."')), month('".$diaCons."'),year('".$diaCons."')";

		$lastD = mysqli_query($conn, $e);

		$fetch = mysqli_fetch_array($lastD);

		$ultimoDia = $fetch[0];
		$mes=$fetch[1];
		$anio=$fetch[2];
 

		for ($i=1; $i <=$ultimoDia; $i++) 
		{ 
			$newfecha=$anio."-".$mes."-".$i;   

			$aaa=parapeto($newfecha,$sln,$conn);
			$var[$i]= parapetoTurno($aaa, $sln, $conn, $codcol);
		}
	
				echo json_encode(array($var));
			
			
			//echo json_encode($diaCons);
	break;

	case 'puestos':
		$sln=$_POST['sln'];

		$sqlCrg = "SELECT cg.crgnombre FROM btycolaborador c join btycargo cg on cg.crgcodigo=c.crgcodigo where c.clbcodigo= '".$_POST['col']."'";

		$queryCrg = mysqli_query($conn, $sqlCrg);



		while ($fetch = mysqli_fetch_array($queryCrg)) 
		{
			if(($fetch[0]=='AUXILIAR') or ($fetch[0]=='ADMINISTRADOR') or ($fetch[0]=='ADMINISTRADOR RELEVO'))
			{
				$filtro=" AND (pt.ptrnombre LIKE 'R%' AND pt.ptrnombre NOT LIKE 'RE%')";
			}
			elseif ($fetch[0]=='MANICURISTA') 
			{
				$filtro=" AND (pt.ptrnombre LIKE 'M%' or pt.ptrnombre LIKE 'REL%')";
			}
			elseif ($fetch[0]=='ESTETICISTA') 
			{
				$filtro=" AND (pt.ptrnombre LIKE 'C%' or pt.ptrnombre LIKE 'REL%')";
			}
			elseif ($fetch[0]=='ESTILISTA') 
			{
				$filtro=" AND (pt.ptrnombre LIKE 'T%' or pt.ptrnombre LIKE 'REL%')";
			}
		}

		$sql="SELECT pt.ptrcodigo, pt.ptrnombre FROM btypuesto_trabajo pt WHERE pt.slncodigo = $sln and pt.ptrestado = 1 ".$filtro." order by pt.ptrnombre asc";

		
		$res=$conn->query($sql);
		$array = array();

		while($row=$res->fetch_array())
		{
			$array[] = array('ptrcodigo' => $row['ptrcodigo'], 'ptrnombre' => $row['ptrnombre']);
		}

		echo json_encode(array("json" => $array));
	break;

	case 'insercion':

		$ObjProg   = json_decode($_POST['datos'],true);
		$error = array();
		if (is_array($ObjProg) || is_object($ObjProg))
  		{

          		foreach($ObjProg as $obj)
          		{
              		$col          = $obj['col'];
              		$turno        = $obj['turno'];
              		$horario      = $obj['horario'];
              		$salon        = $obj['salon'];
              		$puesto       = $obj['puesto'];
              		$fecha        = $obj['fecha'];
          			$tipo         = $obj['tipo'];

          			if($tipo!=0)
          			{         				


		                  $sql="SELECT t.trcrazonsocial, concat(tn.trnnombre,' ', h.hordesde,'-', h.horhasta) as turno, sl.slnnombre, pt.ptrnombre, p.prgfecha, tp.tprnombre FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo=p.clbcodigo JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo join btyturno tn on tn.trncodigo=p.trncodigo join btyhorario h on h.horcodigo=p.horcodigo
						join btysalon sl on sl.slncodigo=p.slncodigo join btypuesto_trabajo pt on pt.ptrcodigo=p.ptrcodigo join btytipo_programacion tp on tp.tprcodigo=p.tprcodigo WHERE p.clbcodigo=$col AND p.prgfecha='$fecha'";

		                       $res=$conn->query($sql);

		                       if (mysqli_num_rows($res) == 0) 
		                       {

		                       		$insert = mysqli_query($conn, "INSERT INTO btyprogramacion_colaboradores (clbcodigo,trncodigo,horcodigo,slncodigo,ptrcodigo,prgfecha,tprcodigo) VALUES ($col, $turno, $horario, $salon, $puesto, '".$fecha."', $tipo)")or die(mysqli_error($conn)); 
		                       }
		                       

		                       		$row=$res->fetch_array();
		                       		$error[] = array('colaborador' => $row['trcrazonsocial'], 'turno' => $row['turno'], 'salon' => $row['slnnombre'], 'puesto'=>$row['ptrnombre'],'fecha' => $row['prgfecha'],'tipolab' => $row['tprnombre']);

          			}
          		}
	          				
	          				$error=utf8_converter($error);
	          				$error = array_filter($error, 'removeEmptyElements');
	          				echo json_encode(array("resp" => $error));


          	}
          	else
          	{
          		echo "NO ES UN ARRAY U OBJETO";
          	}
	break;

	default:

	break;
}


function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
            $item = utf8_encode($item);
        }
    });

    return $array;
}

function parapeto($fecha,$sln,$conn)
{

	$dia = date('l', strtotime($fecha));
		$semana = array(
			'Monday'  	=> 'LUNES' ,
			'Tuesday' 	=> 'MARTES',
			'Wednesday' => 'MIERCOLES',
			'Thursday'  => 'JUEVES',
			'Friday' 	=> 'VIERNES',
			'Saturday' 	=> 'SABADO',
			'Sunday' 	=> 'DOMINGO',
		);

		$fecha = strtotime($fecha);
		$fecha = date('Y-m-d', $fecha);

	$f = "SELECT * FROM btyfechas_especiales WHERE fesfecha = '".$fecha."' ";

		
				$cons = mysqli_query($conn, $f);

				if (mysqli_num_rows($cons) > 0) 
				{
					while ($fr = mysqli_fetch_array($cons)) 
					{

						if ($fecha == $fr['fesfecha']) 
						{

							$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '".$fr['festipo']."' AND h.horestado = 1");			

								if (mysqli_num_rows($de) > 0) 
								{
									while ($row = mysqli_fetch_array($de)) 
									{

										return $row['horcodigo'];
									}
								}

						}
						else
						{
							$dia = $semana[$dia];
							$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '$dia' AND h.horestado = 1");

										if (mysqli_num_rows($de) > 0) {
											 while ($row = mysqli_fetch_array($de)) {
											 	return  $row['horcodigo'];
											 }
										}
						}
					}
				}
				else
				{
					$dia = $semana[$dia];
						$de = mysqli_query($conn, "SELECT hs.horcodigo, h.hordia, h.hordesde, h.horhasta FROM btyhorario_salon hs JOIN btyhorario h ON h.horcodigo = hs.horcodigo WHERE hs.slncodigo = $sln AND h.hordia = '$dia' AND h.horestado = 1");

										if (mysqli_num_rows($de) > 0) 
										{
											while ($row = mysqli_fetch_array($de)) 
											{
											 	return  $row['horcodigo'];
											 }
										}
				}
}

function parapetoTurno($horario, $sln, $conn, $clbcodigo)
{
	$sqlcol="SELECT cg.crgnombre FROM btycolaborador c 
			join btycargo cg on cg.crgcodigo=c.crgcodigo
			where c.clbcodigo=".$clbcodigo;
	$rescol=$conn->query($sqlcol);
	$rowcol=$rescol->fetch_array();

	if(($rowcol[0]=='AUXILIAR') or ($rowcol[0] =='ADMINISTRADOR') or ($rowcol[0] =='ADMINISTRADOR RELEVO')){
		$filtro=" and t.trnnombre like 'T%'";
	}else{
		$filtro=" and t.trnnombre not like 'T%'";
	}

	$sql = "SELECT ts.trncodigo, CONCAT(t.trnnombre, ' DE: ', DATE_FORMAT(t.trndesde, '%H:%i'), ' A: ', DATE_FORMAT(t.trnhasta, '%H:%i'), ' ALM: ', DATE_FORMAT(t.trninicioalmuerzo, '%H:%i'), ' - ', DATE_FORMAT(t.trnfinalmuerzo, '%H:%i')) AS turno FROM btyturno_salon as ts, btyturno as t WHERE  t.trncodigo=ts.trncodigo AND ts.slncodigo = $sln AND ts.horcodigo = $horario AND t.trnestado = 1 ".$filtro." ORDER BY turno";

	$array = array();


	$query = mysqli_query($conn, $sql);

	if (mysqli_num_rows($query) > 0) 	
	{
		while ($row = mysqli_fetch_array($query)) 
		{
			$array[] = array('trncodigo' => $row['trncodigo'], 'trnnombre' => $row['turno'], 'horario' => $horario);
		}


	 	$retorno =  $array;

	 	return $retorno;

	}

}

function removeEmptyElements(&$element)
{
    if (is_array($element)) {
        if ($key = key($element)) {
            $element[$key] = array_filter($element);
        }

        if (count($element) != count($element, COUNT_RECURSIVE)) {
            $element = array_filter(current($element), __FUNCTION__);
        }

        $element = array_filter($element);

        return $element;
    } else {
        return empty($element) ? false : $element;
    }
}

?>



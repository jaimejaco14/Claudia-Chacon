<?php 
	
	include("../../../cnx_data.php");


    //if ($_POST["cargo"]=='TODOS'){

	//SELECT c.clbcodigo, c.cblimagen, ca.colposicion, cr.crgnombre,  ca.coldisponible, t.trcrazonsocial, cr.crgnombre, cc.ctcnombre from btycategoria_colaborador as cc, btyturnos_atencion as ta, btycola_atencion ca, btycolaborador as c, btycargo as cr, btytercero as t where cc.ctccodigo=c.ctccodigo and t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento and ca.slncodigo=ta.slncodigo and ta.tuafechai=ca.tuafechai and ta.tuafechai=CURDATE() and ta.slncodigo='".$_POST["cod_salon"]."' and cr.crgnombre='".$_POST["cargo"]."' and ca.clbcodigo=c.clbcodigo and c.crgcodigo=cr.crgcodigo and ca.colhorasalida IS NULL order by ca.colposicion 

// VERSION ANTERIOR AL FILTRO CUANDO UN COL LO PONEN EN ESTADO DISTINTO A LABORA

    //}else{

    //$queryColaboradores = "SELECT c.clbcodigo, c.cblimagen, ca.colposicion, cr.crgnombre, ca.coldisponible, t.trcrazonsocial, cr.crgnombre, cc.ctcnombre FROM btycategoria_colaborador AS cc, btyturnos_atencion AS ta, btycola_atencion ca, btycolaborador AS c, btycargo AS cr, btytercero AS t, btyprogramacion_colaboradores AS prg WHERE cc.ctccodigo=c.ctccodigo AND t.tdicodigo=c.tdicodigo AND t.trcdocumento=c.trcdocumento AND ca.slncodigo=ta.slncodigo AND ta.tuafechai=ca.tuafechai AND ta.tuafechai= CURDATE() AND prg.clbcodigo=ca.clbcodigo AND prg.slncodigo=ca.slncodigo AND prg.prgfecha=ca.tuafechai AND prg.tprcodigo = 1 AND ta.slncodigo= '".$_POST["cod_salon"]."' AND cr.crgnombre='".$_POST["cargo"]."' AND ca.clbcodigo=c.clbcodigo  AND c.crgcodigo=cr.crgcodigo AND ca.colhorasalida IS NULL ORDER BY ca.colposicion";



    //}

	$queryColaboradores = "SELECT c.clbcodigo, c.cblimagen, ca.colposicion, cr.crgnombre,  ca.coldisponible, t.trcrazonsocial, cr.crgnombre, cc.ctcnombre from btycategoria_colaborador as cc, btyturnos_atencion as ta, btycola_atencion ca, btycolaborador as c, btycargo as cr, btytercero as t where cc.ctccodigo=c.ctccodigo and t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento and ca.slncodigo=ta.slncodigo and ta.tuafechai=ca.tuafechai and ta.tuafechai=CURDATE() and ta.slncodigo='".$_POST["cod_salon"]."' and cr.crgnombre='".$_POST["cargo"]."' and ca.clbcodigo=c.clbcodigo and c.crgcodigo=cr.crgcodigo and ca.colhorasalida IS NULL order by ca.colposicion";


	$resultQuery        = $conn->query($queryColaboradores);
	$colaboradores      = array();

	if($resultQuery != false)
	{

		if(mysqli_num_rows($resultQuery) > 0)
		{

			while($registros = $resultQuery->fetch_array())
			{

				$colaboradores[] = array(
									"codigo"    => $registros["clbcodigo"],
									"posicion"  => $registros["colposicion"],
									"estado"    => $registros["coldisponible"],
									"nombre"    => utf8_encode($registros["trcrazonsocial"]),
									"imagen"    => $registros["cblimagen"],
									"cargo"     => $registros["crgnombre"],
									"categoria" => $registros["ctcnombre"]);
			}

			echo json_encode(array("result" => "full", "colaboradores" => $colaboradores));
		}
		else
		{

			echo json_encode(array("result" => "vacio"));
		}
	}
	else
	{

		echo json_encode(array("result" => "error"));
	}
	
	mysqli_close($conn);
?>
<?php 
	
	include("../../../cnx_data.php");
	
        
		$salon              = $_POST["slncodigo"];
		$codColaborador     = $_POST["clbcodigo"];
     

		$QueryEstadoColaborador=mysqli_fetch_array(mysqli_query($conn,"SELECT c.clbcodigo, c.cblimagen, ca.colposicion, cr.crgnombre,  ca.coldisponible, t.trcrazonsocial, cr.crgnombre, cc.ctcnombre from btycategoria_colaborador as cc, btyturnos_atencion as ta, btycola_atencion ca, btycolaborador as c, btycargo as cr, btytercero as t where cc.ctccodigo=c.ctccodigo and t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento and ca.slncodigo=ta.slncodigo and ta.tuafechai=ca.tuafechai and ta.tuafechai=CURDATE() and ta.slncodigo='".$_POST["slncodigo"]."' and ca.clbcodigo=c.clbcodigo and c.crgcodigo=cr.crgcodigo and c.clbcodigo='".$_POST["clbcodigo"]."'"));

		if ($QueryEstadoColaborador['coldisponible']==1)
		{			
				/* Debemos enviarlo al final */

			$QueryColaExcluido=mysqli_query($conn,"SELECT clbcodigo, colposicion FROM btycola_atencion WHERE (slncodigo = '".$_POST["slncodigo"]."') AND (clbcodigo <> '".$_POST["clbcodigo"]."') AND tuafechai=CURDATE() AND colhorasalida IS NULL ORDER BY colposicion");


        	$colposicion=0;

			while($colaborador = mysqli_fetch_array($QueryColaExcluido))
			{
				
				$colposicion++;

				mysqli_query($conn,"UPDATE btycola_atencion SET colposicion='".$colposicion."' WHERE clbcodigo='".$colaborador["clbcodigo"]."' AND tuafechai=CURDATE() AND slncodigo='".$_POST["slncodigo"]."'");	    
				
			}

			$conteo = mysqli_fetch_array(mysqli_query($conn,"SELECT count(*) AS maximo_val FROM btycola_atencion WHERE tuafechai = CURDATE() and slncodigo='".$_POST["slncodigo"]."' and colhorasalida IS NULL"));

			$res = $conteo['maximo_val'];

			mysqli_query($conn,"UPDATE btycola_atencion SET colposicion = $res, coldisponible='0' WHERE clbcodigo = '".$_POST["clbcodigo"]."' AND tuafechai = CURDATE() and slncodigo='".$_POST["slncodigo"]."'");


		}
		else
		{


			/* Debemos enviarlo un lugar despues del último disponible */

			$QueryDiponibles=mysqli_fetch_array(mysqli_query($conn,"SELECT max(colposicion) as colposicion  FROM btycola_atencion WHERE slncodigo = '".$_POST["slncodigo"]."' AND coldisponible='1' AND tuafechai=CURDATE() AND colhorasalida IS NULL AND (clbcodigo <> '".$_POST["clbcodigo"]."')"));

			if (is_null($QueryDiponibles['colposicion']))
			{
                  	$colposicion_inicial=$colposicion=1;                  
			}
			else
			{
               		$colposicion_inicial=$colposicion=($QueryDiponibles['colposicion']+1);               
			}

			

			$QueryColaNoDisponibles=mysqli_query($conn,"SELECT clbcodigo, colposicion FROM btycola_atencion WHERE (slncodigo = '".$_POST["slncodigo"]."') AND (clbcodigo <> '".$_POST["clbcodigo"]."') AND tuafechai=CURDATE() AND coldisponible='0' AND colhorasalida IS NULL ORDER BY colposicion");

        
			while($registros = mysqli_fetch_array($QueryColaNoDisponibles))
			{
				
				$colposicion++;
				mysqli_query($conn,"UPDATE btycola_atencion SET colposicion='".$colposicion."' WHERE clbcodigo='".$registros["clbcodigo"]."' AND tuafechai=CURDATE() AND slncodigo='".$_POST["slncodigo"]."'");			    
				
			}

          	mysqli_query($conn,"UPDATE btycola_atencion SET colposicion ='".$colposicion_inicial."', coldisponible='1' WHERE clbcodigo = '".$_POST["clbcodigo"]."' AND tuafechai = CURDATE() and slncodigo='".$_POST["slncodigo"]."'");

		}

?>
<?php 
	
	include("../../../cnx_data.php");
	
        
		$salon              = $_POST["slncodigo"];
		$codColaborador     = $_POST["clbcodigo"];
     

		$QueryEstadoColaborador=mysqli_fetch_array(mysqli_query($conn,"SELECT c.clbcodigo, c.cblimagen, ca.colposicion, cr.crgnombre,  ca.coldisponible, t.trcrazonsocial, cr.crgnombre, cc.ctcnombre from btycategoria_colaborador as cc, btyturnos_atencion as ta, btycola_atencion ca, btycolaborador as c, btycargo as cr, btytercero as t where cc.ctccodigo=c.ctccodigo and t.tdicodigo=c.tdicodigo and t.trcdocumento=c.trcdocumento and ca.slncodigo=ta.slncodigo and ta.tuafechai=ca.tuafechai and ta.tuafechai=CURDATE() and ta.slncodigo='".$_POST["slncodigo"]."' and ca.clbcodigo=c.clbcodigo and c.crgcodigo=cr.crgcodigo and c.clbcodigo='".$_POST["clbcodigo"]."'"));


		if ($QueryEstadoColaborador['colposicion']==1){
			
			if ($QueryEstadoColaborador['coldisponible']==0){			
				mysqli_query($conn,"UPDATE btycola_atencion SET coldisponible='1' WHERE clbcodigo = '".$_POST["clbcodigo"]."' AND tuafechai = CURDATE() and slncodigo='".$_POST["slncodigo"]."'");
			}

		}else{
                
                $QueryCola=mysqli_query($conn,"SELECT clbcodigo, colposicion FROM btycola_atencion WHERE (slncodigo = '".$_POST["slncodigo"]."') AND (clbcodigo <> '".$_POST["clbcodigo"]."') AND tuafechai=CURDATE() AND colhorasalida IS NULL ORDER BY colposicion");
			    $colposicion=1; 

			    while($registros = mysqli_fetch_array($QueryCola)){				
				$colposicion++;
				mysqli_query($conn,"UPDATE btycola_atencion SET colposicion='".$colposicion."' WHERE clbcodigo='".$registros["clbcodigo"]."' AND tuafechai=CURDATE() AND slncodigo='".$_POST["slncodigo"]."'");			    
				
				}

				mysqli_query($conn,"UPDATE btycola_atencion SET colposicion ='1', coldisponible='1' WHERE clbcodigo = '".$_POST["clbcodigo"]."' AND tuafechai = CURDATE() and slncodigo='".$_POST["slncodigo"]."'");			



		}

		

?>
<?php
	include '../cnx_data.php';
	include 'php/funciones.php';

	$sql = mysqli_query($conn, "SELECT p.tprcodigo, c.clbcodigo, tr.trncodigo, p.horcodigo, s.slncodigo,  p.prgfecha,  tr.trndesde, tr.trnhasta, t.trcrazonsocial, pt.ptrcodigo  FROM btyprogramacion_colaboradores p, btyturno tr,  btycolaborador c, btytercero t, btysalon as s, btypuesto_trabajo as pt WHERE pt.ptrcodigo=p.ptrcodigo and c.clbcodigo=p.clbcodigo and  s.slncodigo=p.slncodigo and t.trcdocumento=c.trcdocumento and t.tdicodigo=c.tdicodigo and tr.trncodigo=p.trncodigo   and tr.trncodigo = '".$_POST['turno']."' AND p.prgfecha = '".$_POST['fecha']."' AND s.slncodigo = ".$_POST['salon']."");
	

	$conta = 0;
	
	if (mysqli_num_rows($sql) > 0) 
	{
		while ($row = mysqli_fetch_array($sql)) 
		{

			if (Disponibilidad_colaborador($row['clbcodigo'], $_POST['nuevafecha'] , $row['trndesde'], $row['trnhasta'],$conn))
			{

				$dia = date('l', strtotime($_POST['nuevafecha']));

				$semana = array(
					'Monday'  	=> 'LUNES' ,
					'Tuesday' 	=> 'MARTES',
					'Wednesday' => 'MIERCOLES',
					'Thursday'  => 'JUEVES',
					'Friday' 	=> 'VIERNES',
					'Saturday' 	=> 'SABADO',
					'Sunday' 	=> 'DOMINGO',
				);

				$dia = $semana[$dia];

				$QueryEspeciales="Select * from btyfechas_especiales where fesfecha='".$_POST['nuevafecha']."' and fesestado='1'";
				$SqlFechasEspeciales=mysqli_query($conn,$QueryEspeciales);

				if (mysqli_num_rows($SqlFechasEspeciales) > 0) {
					$RsFechasEspeciales = mysqli_fetch_array($SqlFechasEspeciales);

				$QueryHorario="SELECT * from btyhorario as h, btyhorario_salon as hs where h.horcodigo=hs.horcodigo and hs.slncodigo='".$_POST['salon']."' and h.hordia='".$RsFechasEspeciales['festipo']."'";

				}else{

				$QueryHorario="SELECT * from btyhorario as h, btyhorario_salon as hs where h.horcodigo=hs.horcodigo and hs.slncodigo='".$_POST['salon']."' and h.hordia='".$dia."'";

			    }

				//echo $QueryHorario;

				$RsHorario = mysqli_fetch_array(mysqli_query ($conn,$QueryHorario));
		

				$QueryInsert="INSERT INTO `btyprogramacion_colaboradores`(`clbcodigo`, `trncodigo`, `horcodigo`, `slncodigo`, `ptrcodigo`, `prgfecha`, `tprcodigo`) VALUES (".$row['clbcodigo'].",".$_POST['nuevoTurno'].",".$RsHorario ["horcodigo"].",".$_POST['salon'].",".$row['ptrcodigo'].", '".$_POST['nuevafecha']."', ".$row['tprcodigo'].")";

				//echo $QueryInsert;


		        $sql2 = mysqli_query($conn,$QueryInsert)or die(mysqli_error($conn));
                    
					$conta = $conta +1;
					
				
		    }
		    else
		    {
		        echo $row['trcrazonsocial'] . "\n";
		        
		    }
			
		}
	}



?>


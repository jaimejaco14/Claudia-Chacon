<?php 
    	include("../../../cnx_data.php");

	switch ($_POST['opcion']) 
	{
		case 'validarServicio':

		$d= "SELECT DISTINCT pc.clbcodigo, ter.trcrazonsocial FROM btyprogramacion_colaboradores AS pc, btycolaborador AS col, btytercero AS ter, btyturno AS tur, btyservicio_colaborador AS sc, btytipo_programacion AS tp, btypermisos_colaboradores AS per WHERE pc.clbcodigo=col.clbcodigo AND ter.trcdocumento=col.trcdocumento AND tur.trncodigo=pc.trncodigo AND sc.clbcodigo=pc.clbcodigo AND tp.tprcodigo=pc.tprcodigo AND pc.prgfecha = '".$_POST['fecha']."' AND (tur.trndesde <= '".$_POST['hora']."' AND tur.trnhasta >= '".$_POST['hora']."') AND sc.sercodigo = '".$_POST['servicio']."' AND pc.slncodigo = '".$_POST['salon']."' AND per.perfecha_desde = '".$_POST['fecha']."' 

				AND pc.clbcodigo NOT IN(SELECT DISTINCT a.clbcodigo FROM btypermisos_colaboradores a, btycolaborador AS c,btytercero AS t WHERE c.clbcodigo=a.clbcodigo AND t.trcdocumento=c.trcdocumento AND a.perfecha_desde = '".$_POST['fecha']."' AND a.perestado_tramite = 'AUTORIZADO' AND a.perhora_desde <= '".$_POST['hora']."' AND a.perhora_hasta >= '".$_POST['hora']."')

				AND pc.clbcodigo NOT IN(SELECT clbcodigo FROM btycita as cita, btyservicio as serv WHERE cita.sercodigo=serv.sercodigo AND cita.slncodigo = '".$_POST['salon']."' AND cita.citfecha = '".$_POST['fecha']."' AND '".$_POST['hora']."' BETWEEN SUBTIME(cita.cithora,sec_to_time(1)) AND SUBTIME(ADDTIME(cita.cithora ,sec_to_time(serv.serduracion*60)),1))";
			
			$QueryValidar = mysqli_query($conn, $d);

			if (mysqli_num_rows($QueryValidar) > 0) 
			{
				while ($row = mysqli_fetch_array($QueryValidar)) 
				{
					echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
				}
			}
			else
			{

				$c = "SELECT DISTINCT pc.clbcodigo, ter.trcrazonsocial FROM btyprogramacion_colaboradores AS pc, btycolaborador AS col, btytercero AS ter, btyturno AS tur, btyservicio_colaborador AS sc, btytipo_programacion AS tp WHERE pc.clbcodigo=col.clbcodigo AND ter.trcdocumento=col.trcdocumento AND tur.trncodigo=pc.trncodigo AND sc.clbcodigo=pc.clbcodigo AND tp.tprcodigo=pc.tprcodigo AND pc.prgfecha = '".$_POST['fecha']."' AND (tur.trndesde <= '".$_POST['hora']."' AND tur.trnhasta >= '".$_POST['hora']."') AND sc.sercodigo = '".$_POST['servicio']."' AND pc.slncodigo = '".$_POST['salon']."' AND pc.clbcodigo NOT IN(SELECT clbcodigo FROM btycita AS cita, btyservicio AS serv WHERE cita.sercodigo=serv.sercodigo AND cita.slncodigo = '".$_POST['salon']."' AND cita.citfecha = '".$_POST['fecha']."' AND '".$_POST['hora']."' BETWEEN SUBTIME(cita.cithora, SEC_TO_TIME(1)) AND SUBTIME(ADDTIME(cita.cithora, SEC_TO_TIME(serv.serduracion*60)),1)) ";

				//echo $c;
				$sql = mysqli_query($conn, $c);

					if (mysqli_num_rows($sql) > 0) 
					{
						while ($row = mysqli_fetch_array($sql)) 
						{
							echo "<option value='".$row['clbcodigo']."'>".utf8_encode($row['trcrazonsocial'])."</option>";
						}
					}
					else
					{
						echo "<option value='0'>No hay disponibilidad</option>";						
					}
			}


			break;
		
		default:
			# code...
			break;
	}
	
 ?>
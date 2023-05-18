<?php 
include '../../cnx_data.php';
$idact=$_POST['idact'];
$opc=$_POST['opc'];
switch($opc){
	case 'loadact':
		if($_POST['filtipo']!=''){
			$filtipo=$_POST['filtipo'];
			$ftipo=" and pgmtipo='$filtipo'";
		}else{
			$ftipo='';
		}

		if($_POST['filestado']!=''){
			$filestado=$_POST['filestado'];
			$fsta=" and pgmestado='$filestado'";
		}else{
			$fsta='';
		}

		if($_POST['filfe']!=''){
			$filfe=$_POST['filfe'];
			$ffe=" and pgmfecha BETWEEN $filfe";
		}else{
			$ffe='';
		}


		$sql="SELECT * FROM btyactivo_programacion WHERE actcodigo=$idact ".$ftipo.$fsta.$ffe." order by pgmfecha";

		$res=$conn->query($sql);
		$nr=mysqli_num_rows($res);
		?>

		<div class="table-responsive">
			<?php
			$rowsPerPage = 5;
			$pageNum = 1;

			if(isset($_POST['page'])) {
			    $pageNum = $_POST['page'];
			}
			$offset = ($pageNum - 1) * $rowsPerPage;
			$total_paginas = ceil($nr / $rowsPerPage);

			$sql2=$sql." limit $offset, $rowsPerPage";
			$result = $conn->query($sql2);
			if ($result->num_rows > 0) {
				?>
				<table class="table table-bordered">
					<thead>
					<tr>
						<th colspan="5" class="text-center">ACTIVIDADES REGISTRADAS Y PROGRAMADAS</th>
					</tr>
						<tr>
							<th class="text-center">TIPO</th>
							<th class="text-center">FECHA</th>
							<th class="text-center">ESTADO</th>
							<th class="text-center">OPCIONES</th>
						</tr>
					</thead>
					<tbody>				
				<?php
				while($row=$result	->fetch_array()){
					switch($row['pgmestado']){
			    		case 'PROGRAMADO':
			    			$color="color:orange;";
			    		break;
			    		case 'EJECUTADO':
			    			$color="color:green;";
			    		break;
			    		case 'CANCELADO':
			    			$color="color:red;";
			    		break;
			    	}   
					?>
						<tr>
							<td><?php echo $row['pgmtipo'];?></td>
							<td class="text-center"><?php echo $row['pgmfecha'];?></td>
							<td class="text-center"><b style="<?php echo $color;?>"><?php echo $row['pgmestado'];?></b></td>
							<td class="text-center">
								<?php 
									if($row['pgmestado']=='PROGRAMADO'){
										?>
										<a class="btnejecutaract" data-cod-id="<?php echo $row['actcodigo'];?>" data-id="<?php echo $row['pgmconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Cambiar estado de actividad a Ejecutado"><span class="fa fa-check text-success"></span></a>
										<a class="btncancelaract" data-cod-id="<?php echo $row['actcodigo'];?>" data-id="<?php echo $row['pgmconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Cancelar actividad"><span class="fa fa-ban text-danger"></span></a>							
										<?php

									}else{
										echo 'sin opciones';
									}
								?>
							</td>
						</tr>
					<?php
				}
				?>
					</tbody>
				</table>
			    <?php
			}
			else{
			    echo 'No hay historico de actividades';

			}

			?>

			<?php  
			//paginacion                
				if ($total_paginas > 1) {
				echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
				echo '<ul class="pagination pull-right"></ul>';
				    if ($pageNum != 1)
				            echo '<li><a class="paginate" onclick="paginarm('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
				        for ($i=1;$i<=$total_paginas;$i++) {
				            if ($pageNum == $i)
				                    //si muestro el índice de la página actual, no coloco enlace
				                    echo '<li class="active"><a onclick="paginarm('.$i.');">'.$i.'</a></li>';
				            else
				                    //si el índice no corresponde con la página mostrada actualmente,
				                    //coloco el enlace para ir a esa página
				                    echo '<li><a class="paginate" onclick="paginarm('.$i.');" data="'.$i.'">'.$i.'</a></li>';
				    }
				    if ($pageNum != $total_paginas)
				            echo '<li><a class="paginate" onclick="paginarm('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
				echo '</ul>';
				echo '</div> </div></center></td></tr> '; 
				}
			//fin paginacion
			?>
		</div>
		<script>
			$('[data-toggle="tooltip"]').tooltip();
		</script>
		<?php
	break;

	case 'addrevmtto':
		$idact=$_POST['idact'];
		$fmtto=$_POST['ultfechamtto'];
		$frev=$_POST['ultfecharev'];
		$cons="SELECT actfreq_rev,actfreq_mant FROM btyactivo where actcodigo=$idact";
		$rcons=$conn->query($cons);
		$rowcons=$rcons->fetch_array();
		$ok=0;

		if($rowcons[1]>0){
			$sql="INSERT INTO btyactivo_programacion (pgmconsecutivo,actcodigo,pgmtipo,pgmfecha,pgmestado,pgmobservaciones) 
				VALUES ((SELECT if(MAX(c.pgmconsecutivo) is null,1,MAX(c.pgmconsecutivo)+1) from btyactivo_programacion as c),
					$idact,'MANTENIMIENTO',(SELECT DATE_ADD('$fmtto', INTERVAL $rowcons[1] DAY)),'PROGRAMADO',' ')";
					//echo $sql;
			if($conn->query($sql)){
				$ok=1;
				if($_POST['automtto']){
					$sw=true;
					while($sw){
						$sqlautomtto="SELECT IF(YEAR(DATE_ADD(MAX(ap.pgmfecha), INTERVAL a.actfreq_mant DAY)) = YEAR(CURDATE()),DATE_ADD(MAX(ap.pgmfecha), INTERVAL a.actfreq_mant DAY),0) AS fecha
										FROM btyactivo_programacion ap
										JOIN btyactivo a ON a.actcodigo=ap.actcodigo
										WHERE ap.actcodigo=$idact AND ap.pgmtipo='MANTENIMIENTO'";
						$resmtto=$conn->query($sqlautomtto);
						$rowmtto=$resmtto->fetch_array();
						$fecha=$rowmtto['fecha'];
						//echo $sqlautomtto;
						if($fecha!=0){
							$sqlinsmtto="INSERT IGNORE INTO btyactivo_programacion (pgmconsecutivo,actcodigo,pgmtipo,pgmfecha,pgmestado,pgmobservaciones) 
								VALUES ((SELECT if(MAX(c.pgmconsecutivo) is null,1,MAX(c.pgmconsecutivo)+1) from btyactivo_programacion as c),
								$idact,'MANTENIMIENTO','$fecha','PROGRAMADO',' ')";
							if($conn->query($sqlinsmtto)){
								$ok=1;
							}else{
								$sw=false;
							}
						}else{
							$sw=false;
						}
					}
				}
			}
		}
		if($rowcons[0]>0){
			$sql2="INSERT INTO btyactivo_programacion (pgmconsecutivo,actcodigo,pgmtipo,pgmfecha,pgmestado,pgmobservaciones) 
				VALUES ((SELECT if(MAX(c.pgmconsecutivo) is null,1,MAX(c.pgmconsecutivo)+1) from btyactivo_programacion as c),
					$idact,'REVISION',(SELECT DATE_ADD('$frev', INTERVAL $rowcons[0] DAY)),'PROGRAMADO',' ')";
			if($conn->query($sql2)){
				if($_POST['autorev']){
					$sw=true;
					while($sw){
						$sqlautorev="SELECT IF((YEAR(DATE_ADD(MAX(ap.pgmfecha), INTERVAL a.actfreq_rev DAY)) = YEAR(CURDATE())), (DATE_ADD(MAX(ap.pgmfecha), INTERVAL a.actfreq_rev DAY)),0) AS fecha
										FROM btyactivo_programacion ap
										JOIN btyactivo a ON a.actcodigo=ap.actcodigo
										WHERE ap.actcodigo=$idact AND ap.pgmtipo='REVISION' AND ap.pgmestado='PROGRAMADO'";
						$resrev=$conn->query($sqlautorev);
						$rowrev=$resrev->fetch_array();
						$fecha=$rowrev['fecha'];
						if($fecha!=0){
							$sqlctrl="SELECT IF('$fecha' IN (
										SELECT ap.pgmfecha
										FROM btyactivo_programacion ap
										WHERE ap.actcodigo=$idact AND ap.pgmtipo='MANTENIMIENTO' and ap.pgmestado='PROGRAMADO'),1,0)";
							$resbool=$conn->query($sqlctrl);
							$bool=$resbool->fetch_array();
							//echo $bool[0];
							if($bool[0]==0){
								$sqlinsrev="INSERT IGNORE INTO btyactivo_programacion (pgmconsecutivo,actcodigo,pgmtipo,pgmfecha,pgmestado,pgmobservaciones) 
									VALUES ((SELECT if(MAX(c.pgmconsecutivo) is null,1,MAX(c.pgmconsecutivo)+1) from btyactivo_programacion as c),
									$idact,'REVISION','$fecha','PROGRAMADO',' ')";
							}else{
								$sqlinsrev="INSERT IGNORE INTO btyactivo_programacion (pgmconsecutivo,actcodigo,pgmtipo,pgmfecha,pgmestado,pgmobservaciones) 
									VALUES ((SELECT if(MAX(c.pgmconsecutivo) is null,1,MAX(c.pgmconsecutivo)+1) from btyactivo_programacion as c),
									$idact,'REVISION',(DATE_ADD('$fecha', INTERVAL $rowcons[0] DAY)),'PROGRAMADO',' ')";
							}
							if($conn->query($sqlinsrev)){
								$ok=1;
							}else{
								$sw=false;
							}

						}else{
							$sw=false;
						}
					}
				}
			}
		}
		
		if($ok==1){
			echo 'true';
		}else{
			echo $sql1."\n".$sql2;
		}
	break;

	case 'chkprog':
		$sql="SELECT 
				SUM(CASE WHEN ap.actcodigo=$idact and ap.pgmestado='PROGRAMADO' THEN 1 ELSE 0 END) pass, 
				SUM(CASE WHEN ap.actcodigo=$idact and ap.pgmestado='PROGRAMADO' AND ap.pgmfecha >= CURDATE() THEN 1 ELSE 0 END) fut
				FROM btyactivo_programacion ap";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if(($row[0]>0) && ($row[1]>0)){
			echo 'true';
		}else{
			echo 'false';
		}
	break;

	case 'canact':
		$pgm=$_POST['idpgm'];
		$sql="UPDATE btyactivo_programacion SET pgmestado='CANCELADO' WHERE pgmconsecutivo=$pgm";
		if($conn->query($sql)){
			echo 'true';
		}else{
			echo 'false';
		}
	break;

	case 'exeact':
		$pgm=$_POST['idpgm'];
		$sql="UPDATE btyactivo_programacion SET pgmestado='EJECUTADO' WHERE pgmconsecutivo=$pgm";
		if($conn->query($sql)){
			echo 'true';
		}else{
			echo 'false';
		}
	break;
}

?>
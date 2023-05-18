<?php
include '../../cnx_data.php';
session_start();
$opc=$_POST['opc'];
switch($opc){
	case 'seek':
		$colaborador = $_POST["texto"];
		$query = "SELECT c.clbcodigo, c.trcdocumento, t.trcrazonsocial, crg.crgnombre,crg.crgcodigo,c.ctccodigo,cc.ctcnombre
					FROM btycolaborador c 
					JOIN btycategoria_colaborador cc on cc.ctccodigo=c.ctccodigo
					INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento 
					INNER JOIN btycargo crg ON c.crgcodigo = crg.crgcodigo 
					WHERE c.clbestado = 1 AND  t.trcrazonsocial LIKE '%$colaborador%' and crg.crgcodigo not in (4,5,6) ORDER BY t.trcrazonsocial";
		$resultadoQuery = $conn->query($query);
		while($registros = $resultadoQuery->fetch_array()){
			$array[]=(array("codigo"=>$registros["clbcodigo"],"codcateg"=>$registros["ctccodigo"], "nomcateg"=>$registros["ctcnombre"], "cargo"=>$registros["crgcodigo"] ,"nombrecol"=>utf8_encode($registros["trcrazonsocial"].' ('.$registros['crgnombre'].')')));
		}
		echo json_encode($array);
	break;
	case 'proc':
		$clb=$_POST['clb'];
		$crg=$_POST['crg'];
		$sql="SELECT ctcnombre,ctccodigo FROM btycategoria_colaborador where ctcestado=1 order by ctccodigo desc";
		$res=$conn->query($sql);

		$i=1;
		while($row=$res->fetch_array()){
			?>
				<div class="panel-heading titleser<?php echo $i;?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" style="cursor: pointer;">
	          		<h4 class="panel-title">
		              	<i class="pull-right fa fa-angle-double-down"></i>
		                <?php 
		                	echo '<b>Servicios '.$row['ctcnombre'].'</b>';
		                	$sql2="SELECT distinct(s.sercodigo),s.sernombre,ifnull(scol.secstado,0) AS estado
									FROM btyservicio s
									JOIN btyservicio_cargo sc ON sc.sercodigo=s.sercodigo
									JOIN btycategoria_colaborador_servicios ccs ON ccs.sercodigo=sc.sercodigo
									LEFT JOIN btyservicio_colaborador scol ON scol.sercodigo=s.sercodigo AND scol.clbcodigo=$clb
									WHERE sc.crgcodigo=$crg AND ccs.ctccodigo=$row[1] order by s.sernombre";
		                	$res2=$conn->query($sql2);
		                	echo '<small class="pull-right"><b> Total servicios: </b><b class="cont"></b><b> de '.$res2->num_rows.'</b></small>';
		                ?> 
	          		</h4>
	            </div>
	            <div id="collapse<?php echo $i;?>" class="panel-collapse collapse detser">
					<div class="panel-body">
						<div class="form-group" style="max-height: 300px;overflow-y: auto;">
							<?php 
							if($res2->num_rows>0){
								?>
							<table class="table table-stripped table-hover">
								<thead>
									<tr>
										<th>SERVICIO</th>
										<th class="text-center">ESTADO</th>
									</tr>
								</thead>
								<tbody>	
							    <?php 
			                    	while($row2=$res2->fetch_array()){
			                    		?>
			                    		<tr>
				                    		<td><?php echo utf8_encode($row2['sernombre']);?></td>
				                    		<td class="text-center">
				                    			<?php
				                    			if($row2['estado']==0){
				                    				echo '<a class="enabser" data-id="'.$row2['sercodigo'].'" data-toggle="tooltip" data-placement="left" title="Haga click para habilitar este servicio"><i class="sw fa fa-times texto-danger"></i></a>';
				                    			}else{
				                    				echo '<a class="disabser" data-id="'.$row2['sercodigo'].'" data-toggle="tooltip" data-placement="left" title="Haga click para deshabilitar este servicio"><i class="sw fa fa-check texto-success"></i></a>';
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
							}else{
								echo '<center>No hay servicios en esta categoría</center>';
							}
							?>
						</div>
					</div>
				</div>
			<?php
			$i++;
		}
	break;
	case 'updser':
		$idcol=$_POST['idcol'];
		$idser=$_POST['idser'];
		$sql="SELECT COUNT(*) FROM btyservicio_colaborador WHERE clbcodigo=$idcol AND sercodigo=$idser";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]==0){
			$sql2="INSERT INTO btyservicio_colaborador (sercodigo,clbcodigo,secdesde,sechasta,secstado) VALUES ($idser,$idcol,curdate(),null,1)";
			if($conn->query($sql2)){
				echo 'ok';
			}else{
				echo $sql2;
			}
		}else{
			$sql3="UPDATE btyservicio_colaborador SET sechasta=null, secstado=1 WHERE clbcodigo=$idcol AND sercodigo=$idser";
			if($conn->query($sql3)){
				echo 'ok';
			}else{
				echo $sql3;
			}
		}
	break;
	case 'disser':
		$idcol=$_POST['idcol'];
		$idser=$_POST['idser'];
		$sql="UPDATE btyservicio_colaborador SET sechasta=curdate(), secstado=0 WHERE sercodigo=$idser AND clbcodigo=$idcol";
		if($conn->query($sql)){
			echo 'ok';
		}else{
			echo $sql;
		}
	break;
	case 'perf':
		$idcol=$_POST['idcol'];
		$idctg=$_POST['idctg'];
		$user=$_SESSION['codigoUsuario'];
		if(isset($user)){
			$sql="UPDATE btycolaborador SET ctccodigo=$idctg WHERE clbcodigo=$idcol";
			if($conn->query($sql)){
				$sql2="UPDATE btycategoria_clb_historico SET clcthasta=curdate() WHERE clbcodigo=$idcol AND clcthasta is null";
				if($conn->query($sql2)){
					$sql3="INSERT INTO btycategoria_clb_historico (clbcodigo,ctccodigo,clctdesde,clcthasta,usucodigo) VALUES ($idcol,$idctg,curdate(),null,$user)";
					if($conn->query($sql3)){
						echo 'ok';
					}else{
						echo $sql3;
					}
				}
				else{
					echo $sql2;
				}
			}
			else{
				echo $sql;
			}
		}else{
			echo 'no user';
		}
	break;
	case 'histo':
		$idcol=$_POST['idcol'];
		$sql="SELECT cc.ctcnombre,ch.clctdesde,ch.clcthasta,t.trcrazonsocial
				FROM btycategoria_clb_historico ch
				JOIN btycolaborador c ON c.clbcodigo=ch.clbcodigo
				JOIN btycategoria_colaborador cc ON cc.ctccodigo=ch.ctccodigo
				JOIN btyusuario u ON u.usucodigo=ch.usucodigo
				JOIN btytercero t ON t.trcdocumento=u.trcdocumento
				WHERE ch.clbcodigo=$idcol order by clcthasta asc";
		$res=$conn->query($sql);
		?>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Categoria</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Realizado por</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row=$res->fetch_array()){
					?>
					<tr>
						<td><?php echo $row['ctcnombre'];?></td>
						<td><?php echo $row['clctdesde'];?></td>
						<td><?php echo $row['clcthasta'];?></td>
						<td><?php echo $row['trcrazonsocial'];?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<?php
	break;
}

?>
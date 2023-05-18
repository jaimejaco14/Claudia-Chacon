<?php
//include 'conexion.php';
//$opc=$_GET['opc'];
switch($opc){
	//////////////////////  OPERACIONES DE LUGAR  ///////////////////
		case 'loadlug':
			if($_GET['str']){
				$str=$_GET['str'];
				$sql="SELECT * from btyactivo_lugar where lugestado=1 and lugcodigo>0 and lugnombre like '%".$str."%' order by lugnombre";
			}else{
				$sql="SELECT * from btyactivo_lugar where lugestado=1 and lugcodigo>0 order by lugnombre";
			}
			$res=$conn->query($sql);
			$nr=mysqli_num_rows($res);
			if($nr>0){
				///////////////////////////////////////////////////////////////////////////
				
				$rowsPerPage = 5;
	            $pageNum = 1;

	            if(isset($_GET['page'])) {
	                $pageNum = $_GET['page'];
	            }
	            $offset = ($pageNum - 1) * $rowsPerPage;
	            $total_paginas = ceil($nr / $rowsPerPage);

	            $sql2=$sql." limit $offset, $rowsPerPage";
	            $result = $conn->query($sql2);

				//////////////////////////////////////////////////////////////////////////
				?>
				<table class="table table-bordered">
					<thead>
						<th class="text-center">Nombre</th>
						<th class="text-center">Acciones</th>
					</thead>
					<tbody>
						<?php
						while($row=$result->fetch_array()){
							?>
							<tr>
								<td><?php echo $row[1];?></td>
								<td class="text-center">
									<button class="btn btn-default btn-sm editar" data-id="<?php echo $row['lugcodigo'];?>" data-toggle="tooltip" title="Editar Lugar" data-placement="top"><span class="fa fa-edit text-info"></span></button>
									<button class="btn btn-default btn-sm delete" data-id="<?php echo $row['lugcodigo'];?>" data-toggle="tooltip" title="Eliminar Lugar" data-placement="top"><span class="fa fa-trash text-danger"></span></button>
								</td>
							</tr>
							<?php
						}?>
					</tbody>
				</table>
				<?php
				//paginacion                
		        if ($total_paginas > 1) {
		            echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
		            echo '<ul class="pagination pull-right"></ul>';
		                if ($pageNum != 1)
		                        echo '<li><a class="paginate" onclick="paginar('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
		                    for ($i=1;$i<=$total_paginas;$i++) {
		                        if ($pageNum == $i)
		                                //si muestro el índice de la página actual, no coloco enlace
		                                echo '<li class="active"><a onclick="paginar('.$i.');">'.$i.'</a></li>';
		                        else
		                                //si el índice no corresponde con la página mostrada actualmente,
		                                //coloco el enlace para ir a esa página
		                                echo '<li><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';
		                }
		                if ($pageNum != $total_paginas)
		                        echo '<li><a class="paginate" onclick="paginar('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
		           echo '</ul>';
		           echo '</div> </div></center></td></tr> '; 
		        }
		        ?>
				<script>
				$(document).ready(function() {
					
					$('[data-toggle="tooltip"]').tooltip();
					
				});
				</script>
				<?php
			}else{
				echo '<center><h4>No hay datos para mostrar.</h4></center>';
			}
		break;

		case 'addlug':
			$nomlug=strtoupper($_GET['lugname']);
			$sql="INSERT INTO btyactivo_lugar (lugcodigo,lugnombre,lugestado) values ((SELECT if(MAX(c.lugcodigo) is null,1,MAX(c.lugcodigo)+1) from btyactivo_lugar as c),'$nomlug',1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'dellug':
			$id=$_GET['id'];
			$sql="UPDATE btyactivo_lugar SET lugestado=0 WHERE lugcodigo=$id";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'editlug':
			$id=$_GET['idlugar'];
			$name=strtoupper($_GET['editlugname']);
			$sql="UPDATE btyactivo_lugar SET lugnombre='$name' WHERE lugcodigo=$id";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'buslug':
			$str=$_GET['str'];
			$sql="SELECT COUNT(*) from btyactivo_lugar where lugnombre = '".$str."'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
	///////////////////// FIN OPERACIONES DE LUGAR ////////////////////////
	
	///////////////////// INICIO OPERACIONES DE AREA //////////////////////
		case 'loadsellug':
			$txt=$_GET['key'];
			$array = array();
			$sqlpro="SELECT *  FROM btyactivo_lugar where lugestado=1 and  lugcodigo > 0 and lugnombre  like '%".$txt."%' order by lugnombre asc";
			$respro=$conn->query($sqlpro);
			while($rowpro=$respro->fetch_array()){
				$array[]=(array("id"=>$rowpro['lugcodigo'], "name"=>utf8_encode($rowpro['lugnombre'])));
			} 
			echo json_encode($array);
		break;

		case 'loadarea':
			$id=$_GET['id'];
			$sql="SELECT * FROM btyactivo_area where lugcodigo=$id and areestado=1 order by arenombre";
			$res=$conn->query($sql);
			$nr=mysqli_num_rows($res);
			if($nr>0){
				//////////////////////////////paginacion/////////////////////////////////////////////
				
					$rowsPerPage = 5;
		            $pageNum = 1;

		            if(isset($_GET['page'])) {
		                $pageNum = $_GET['page'];
		            }
		            $offset = ($pageNum - 1) * $rowsPerPage;
		            $total_paginas = ceil($nr / $rowsPerPage);

		            $sql2=$sql." limit $offset, $rowsPerPage";
		            $result = $conn->query($sql2);

				//////////////////////////////////////////////////////////////////////////
				?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre del área</th>
							<th>Descripción</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody>
				<?php
				while($row=$result->fetch_array()){
					?>
					<tr>
						<td><?php echo $row['arenombre'];?></td>
						<td><?php echo $row['aredescripcion'];?></td>
						<td class="text-center">
							<button class="editarea btn btn-default" data-id="<?php echo $row['arecodigo']?>" data-toggle="tooltip" title="Editar Area" data-placement="top"><span class="fa fa-edit text-info"></span></button>
							<button class="delarea btn btn-default" data-id="<?php echo $row['arecodigo']?>" data-toggle="tooltip" title="Eliminar Area" data-placement="top"><span class="fa fa-trash text-danger"></span></button>
						</td>
					</tr>
					<?php
				}
				?>
					</tbody>
				</table>
				<script>
				$(document).ready(function() {
					$('[data-toggle="tooltip"]').tooltip();
				});
				</script>
				<?php
				//////////////////////////////////////////////////////////paginacion//////////////////////////////////////////////////////////////                
			        if ($total_paginas > 1) {
			            echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
			            echo '<ul class="pagination pull-right"></ul>';
			                if ($pageNum != 1)
			                        echo '<li><a class="paginate" onclick="paginar2('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
			                    for ($i=1;$i<=$total_paginas;$i++) {
			                        if ($pageNum == $i)
			                                //si muestro el índice de la página actual, no coloco enlace
			                                echo '<li class="active"><a onclick="paginar2('.$i.');">'.$i.'</a></li>';
			                        else
			                                //si el índice no corresponde con la página mostrada actualmente,
			                                //coloco el enlace para ir a esa página
			                                echo '<li><a class="paginate" onclick="paginar2('.$i.');" data="'.$i.'">'.$i.'</a></li>';
			                }
			                if ($pageNum != $total_paginas)
			                        echo '<li><a class="paginate" onclick="paginar2('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
			           echo '</ul>';
			           echo '</div> </div></center></td></tr> '; 
			        }
		        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}else{
				echo '<center><h4>Este lugar no tiene áreas creadas.</h4></center>';
			}
		break;

		case 'loadselarea'://se usa en new_activo.php
			$id=$_GET['id'];
			$sql="SELECT * FROM btyactivo_area where lugcodigo=$id and areestado=1 order by arenombre";
			$res=$conn->query($sql);
			$nr=mysqli_num_rows($res);
			if($nr>0){
				while($roware=$res->fetch_array()){
					$array[]=(array("id"=>$roware['arecodigo'], "name"=>utf8_encode($roware['arenombre'])));
				} 
			}else{
				$array[]=(array("id"=>'', "name"=>"No hay áreas creadas"));
			}
			echo json_encode($array);
		break;

		case 'addarea':
			$id=$_GET['idlug'];
			$nom=strtoupper($_GET['arname']);
			$des=$_GET['ardesc'];
			$sql="INSERT INTO btyactivo_area (arecodigo,lugcodigo,arenombre,aredescripcion,areestado) VALUES ((SELECT if(MAX(c.arecodigo) is null,1,MAX(c.arecodigo)+1)from btyactivo_area as c),$id,'$nom','$des',1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'valnomarea':
			$str=$_GET['str'];
			$id=$_GET['idlug'];
			$sql="SELECT COUNT(*) from btyactivo_area where lugcodigo=$id AND arenombre ='".$str."'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'delarea':
			$id=$_GET['id'];
			$sql="UPDATE btyactivo_area SET areestado=0 WHERE arecodigo=$id";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'editarea':
			$id=$_GET['editarcod'];
			$name=strtoupper($_GET['editarname']);
			$desc=$_GET['editardesc'];
			$sql="UPDATE btyactivo_area SET arenombre='$name', aredescripcion='$desc' WHERE arecodigo=$id";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;
	///////////////////// FIN OPERACIONES DE AREA ////////////////////////
}
?>
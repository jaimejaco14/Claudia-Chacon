<?php 
//include 'conexion.php';
$idact=$_POST['idact'];
$sql="SELECT u.actcodigo,l.lugnombre,a.arenombre,u.ubcdesde,ifnull(u.ubchasta,'-') as hasta,m.mvaestado,m.mvaconsecutivo
		FROM btyactivo_ubicacion u
		NATURAL JOIN btyactivo ac
		JOIN btyactivo_area a ON a.arecodigo=u.arecodigo
		JOIN btyactivo_lugar l ON l.lugcodigo=a.lugcodigo
		join btyactivo_movimiento m on m.mvaconsecutivo=u.mvaconsecutivo
		WHERE u.actcodigo=$idact
		order by m.mvaconsecutivo desc";
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
			<caption>HISTORICO UBICACIONES DE ACTIVO</caption>
			<!-- <thead>
				<tr>
					<th rowspan="2" class="text-center">Registrado</th>
					<th rowspan="2" class="text-center">Ejecución</th>
					<th colspan="2" class="text-center">Ubicacion Anterior</th>
					<th colspan="2" class="text-center">Nueva Ubicación</th>
					<th rowspan="2" class="text-center">Descripción del Movimiento</th>
					<th rowspan="2" class="text-center">Registrado por</th>
					<th rowspan="2" class="text-center">Ejecutado por</th>
					<th rowspan="2" class="text-center">Estado</th>
					<th rowspan="2" class="text-center">Acciones</th>
				</tr>
				<tr>
					<th class="text-center">Lugar</th>
					<th class="text-center">Área</th>
					<th class="text-center">Lugar</th>
					<th class="text-center">Área</th>
				</tr>
			</thead> -->
			<thead>
				<tr>
					<th colspan="2" class="text-center">UBICACION</th>
					<th rowspan="2" class="text-center">DESDE</th>
					<th rowspan="2" class="text-center">HASTA</th>
					<th rowspan="2" class="text-center">ESTADO MOVIMIENTO</th>
					<th rowspan="2" class="text-center">OPCIONES</th>
				</tr>
				<tr>
					<th class="text-center">Lugar</th>
					<th class="text-center">Área</th>
				</tr>
			</thead>
			<tbody>
			
	    <?php
	    while ($row = $result->fetch_assoc()) {     
	    	switch($row['mvaestado']){
	    		case 'REGISTRADO':
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
					<td><?php echo $row['lugnombre'];?></td>
					<td><?php echo $row['arenombre'];?></td>
					<td class="text-center"><?php echo $row['ubcdesde'];?></td>
					<td class="text-center"><?php echo $row['hasta'];?></td>
					<td class="text-center"><b style="<?php echo $color;?>"><?php echo $row['mvaestado'];?></b></td>
					<td class="text-center">
					<?php 
						if($row['mvaestado']=='REGISTRADO'){
							?>
							<a class="btnejecutarmv" data-cod-id="<?php echo $row['actcodigo'];?>" data-id="<?php echo $row['mvaconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Cambiar estado de movimiento a Ejecutado"><span class="fa fa-check text-success"></span></a>
							<a class="btncancelarmv" data-cod-id="<?php echo $row['actcodigo'];?>" data-id="<?php echo $row['mvaconsecutivo'];?>" data-toggle="tooltip" data-placement="top" title="Cancelar Movimiento"><span class="fa fa-ban text-danger"></span></a>							
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
	    echo 'No hay historico de ubicaciones';

	}

	?>

	<?php  
	//paginacion                
		if ($total_paginas > 1) {
		echo '<tr><td><center><div class="col-lg-12"><div class="pagination">';
		echo '<ul class="pagination pull-right"></ul>';
		    if ($pageNum != 1)
		            echo '<li><a class="paginate" onclick="paginar4('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
		        for ($i=1;$i<=$total_paginas;$i++) {
		            if ($pageNum == $i)
		                    //si muestro el índice de la página actual, no coloco enlace
		                    echo '<li class="active"><a onclick="paginar4('.$i.');">'.$i.'</a></li>';
		            else
		                    //si el índice no corresponde con la página mostrada actualmente,
		                    //coloco el enlace para ir a esa página
		                    echo '<li><a class="paginate" onclick="paginar4('.$i.');" data="'.$i.'">'.$i.'</a></li>';
		    }
		    if ($pageNum != $total_paginas)
		            echo '<li><a class="paginate" onclick="paginar4('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
		echo '</ul>';
		echo '</div> </div></center></td></tr> '; 
		}
	//fin paginacion
	?>
</div>
<script>
	$('[data-toggle="tooltip"]').tooltip();
	
</script>
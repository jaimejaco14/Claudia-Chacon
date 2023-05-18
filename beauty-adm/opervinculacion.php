
<?php 
include '../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadvincu':
		$clecod=$_POST['clecod'];
		$sql="SELECT tivnombre,vinnombre from btycolaborador_vinculacion
				natural join btycolaborador_tipo_vinculacion
				natural join btycolaborador_vinculador
				where clecodigo=$clecod";
		$res=$conn->query($sql);
		?>
		<table class="table table-bordered">
			<?php
			if($res->num_rows>0){
				$row=$res->fetch_array();?>
				<tr><th>Tipo de vinculación:</th><td><?php echo $row[0];?></td></tr>
				<tr><th>Vinculado por:</th><td><?php echo $row[1];?></td></tr>
				<?php
			}else{
				echo '<td colspan="2" class="text-center">Este estado no tiene datos de vinculacion definidos</td>';
			}
			?>
		</table>
		<?php
	break;

	case 'loadtivincu':
		$sql="SELECT * FROM btycolaborador_tipo_vinculacion where tivstado=1 order by tivnombre";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$opt='<option value="">Seleccione tipo de vinculacion</option>';
			while($row=$res->fetch_array()){
				$opt.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
			echo $opt;
		}else{
			echo '<option value="">No hay opciones disponibles</option>';
		}
	break;

	case 'loadvinculador':
		$sql="SELECT * FROM btycolaborador_vinculador where vinstado=1 order by vinnombre";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			$opt='<option value="">Seleccione vinculador</option>';
			while($row=$res->fetch_array()){
				$opt.='<option value="'.$row[0].'">'.$row[1].'</option>';
			}
			echo $opt;
		}else{
			echo '<option value="">No hay opciones disponibles</option>';
		}
	break;

	case 'addvincu':
		$clecod=$_POST['idcle'];
		$tivin=$_POST['seltipovinc'];
		$vincu=$_POST['selvinculador'];
		$cons="SELECT count(*) from btycolaborador_vinculacion where clecodigo=$clecod";
		$rescon=$conn->query($cons);
		$rowcon=$rescon->fetch_array();
		if($rowcon[0]>0){
			$sql="UPDATE btycolaborador_vinculacion SET tivcodigo=$tivin, vincodigo=$vincu where clecodigo=$clecod";
			if($conn->query($sql)){
				echo 1;
			}else{
				echo $sql;
			}
		}else{
			$sql="INSERT INTO btycolaborador_vinculacion (tivcodigo,vincodigo,clecodigo) values ($tivin,$vincu,$clecod)";
			if($conn->query($sql)){
				echo 1;
			}else{
				echo $sql;
			}
		}
	break;

	case 'newtivin':
		$tivin=strtoupper($_POST['txt']);
		$sqlmax="SELECT max(tivcodigo)+1 from btycolaborador_tipo_vinculacion";
		$res=$conn->query($sqlmax);
		$max=$res->fetch_array();
		$sqlins="INSERT INTO btycolaborador_tipo_vinculacion (tivcodigo,tivnombre,tivstado) VALUES ($max[0],'$tivin',1)";
		if($conn->query($sqlins)){
			$sqlsel="SELECT * from btycolaborador_tipo_vinculacion where tivstado=1 order by tivnombre";
			$ressel=$conn->query($sqlsel);
			$opt='<option value="">Seleccione tipo de vinculacion</option>';
			while($row=$ressel->fetch_array()){
				if($row[0]==$max[0]){
					$opt.='<option value="'.$row[0].'" selected>'.$row[1].'</option>';
				}else{	
					$opt.='<option value="'.$row[0].'">'.$row[1].'</option>';
				}
			}
			echo $opt;
		}else{
			echo 'false';
		}
	break;

	case 'newvin':
		$vin=strtoupper($_POST['txt']);
		$sqlmax="SELECT max(vincodigo)+1 from btycolaborador_vinculador";
		$res=$conn->query($sqlmax);
		$max=$res->fetch_array();
		$sqlins="INSERT INTO btycolaborador_vinculador (vincodigo,vinnombre,vinstado) VALUES ($max[0],'$vin',1)";
		if($conn->query($sqlins)){
			$sqlsel="SELECT * from btycolaborador_vinculador where vinstado=1 order by vinnombre";
			$ressel=$conn->query($sqlsel);
			$opt='<option value="">Seleccione vinculador</option>';
			while($row=$ressel->fetch_array()){
				if($row[0]==$max[0]){
					$opt.='<option value="'.$row[0].'" selected>'.$row[1].'</option>';
				}else{	
					$opt.='<option value="'.$row[0].'">'.$row[1].'</option>';
				}
			}
			echo $opt;
		}else{
			echo 'false';
		}
	break;
}
?>
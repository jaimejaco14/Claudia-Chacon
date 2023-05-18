<?php 
include "../../cnx_data.php";
$opc=$_POST['opc'];
switch($opc){
	/////////////operaciones de carga///////////////////////
		case 'tipo':
			$sql="SELECT * FROM btyactivo_tipo WHERE tiaestado=1 order by tianombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					echo '<tr><td><div class="nomti">'.$row[1].'</div>
					<div class="btn-group pull-right"><button data-tipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Ver Subtipos" class="btn btn-default btn-sm pull-right tipo"><i class="fa fa-arrow-right text-warning"></i></button>
					<button data-tipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-default btn-sm pull-right edit"><i class="fa fa-edit text-info"></i></button>
					<button data-tipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-default btn-sm pull-right delete"><i class="fa fa-trash text-danger"></i></button></div>
					</td></tr>';
				}
			}else{
				echo '<tr><td class="text-center">No hay datos</td></tr>';
			}
		break;

		case 'sbtipo':
			$tp=$_POST['tipo'];
			$sql="SELECT * FROM btyactivo_subtipo WHERE tiacodigo=$tp and sbtestado=1 order by sbtnombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					echo '<tr><td><div class="nomst">'.$row[2].'</div>
					<div class="btn-group pull-right"><button data-sbtipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Ver Grupos" class="btn btn-default btn-sm pull-right sbtipo"><i class="fa fa-arrow-right text-warning"></i></button>
					<button data-sbtipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-default btn-sm pull-right sbtedit"><i class="fa fa-edit text-info"></i></button>
					<button data-sbtipo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-default btn-sm pull-right sbtdelete"><i class="fa fa-trash text-danger"></i></button></div>
					</td></tr>';
				}
			}else{
				echo '<tr><td class="text-center">No hay datos</td></tr>';
			}
		break;

		case 'grupo':
			$sb=$_POST['sbtipo'];
			$sql="SELECT * FROM btyactivo_grupo WHERE sbtcodigo=$sb and graestado=1 order by granombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					echo '<tr><td><div class="nomgru">'.$row[2].'</div>
					<div class="btn-group pull-right"><button data-grupo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Ver Subgrupos" class="btn btn-default btn-sm pull-right grupo"><i class="fa fa-arrow-right text-warning"></i></button>
					<button data-grupo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-default btn-sm pull-right gredit"><i class="fa fa-edit text-info"></i></button>
					<button data-grupo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-default btn-sm pull-right grdelete"><i class="fa fa-trash text-danger"></i></button></div>
					</td></tr>';
				}
			}else{
				echo '<tr><td class="text-center">No hay datos</td></tr>';
			}
		break;

		case 'sbgrupo':
			$gru=$_POST['grupo'];
			$sql="SELECT sg.sbgcodigo,sg.sbganombre,sg.sbgubicacionetiqueta,p.pranombre
					FROM btyactivo_subgrupo sg  
					JOIN btyactivo_prioridad p on p.pracodigo=sg.pracodigo 
					WHERE gracodigo=$gru and sbgestado=1 order by sbganombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					echo '<tr><td><div class="nomsg">'.$row[1].'</div><br><small>Etiqueta:'.$row[2].'</small><br><small>Prioridad:'.$row[3].'</small>
					<div class="btn-group pull-right"><button data-sbgrupo="'.$row[0].'" data-etiqueta="'.$row[2].'" data-prio="'.$row[3].'" data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-default btn-sm pull-right sgedit"><i class="fa fa-edit text-info"></i></button>
					<button data-sbgrupo="'.$row[0].'" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn btn-default btn-sm pull-right sgdelete"><i class="fa fa-trash text-danger"></i></button></div>
					</td></tr>';
				}
			}else{
				echo '<tr><td class="text-center">No hay datos</td></tr>';
			}
		break;
	///////////operaciones de borrado///////////////////////
		case 'deltipo':
			$tipo=$_POST['tipo'];
			$sql="UPDATE btyactivo_tipo SET tiaestado=0 WHERE tiacodigo=$tipo";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'delsubtipo':
			$stipo=$_POST['subtipo'];
			$sql="UPDATE btyactivo_subtipo SET sbtestado=0 WHERE sbtcodigo=$stipo";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'delgrupo':
			$grupo=$_POST['grupo'];
			$sql="UPDATE btyactivo_grupo SET graestado=0 WHERE gracodigo=$grupo";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'delsubgrupo':
			$sbg=$_POST['sbg'];
			$sql="UPDATE btyactivo_subgrupo SET sbgestado=0 WHERE sbgcodigo=$sbg";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;	
	/////////////operaciones de edicion/////////////////////
		case 'edtipo':
			$codtipo=$_POST['codtipo'];
			$nomtipo=strtoupper($_POST['tianame2']);
			$sql="UPDATE btyactivo_tipo SET tianombre='$nomtipo' WHERE tiacodigo=$codtipo";
			if($conn->query($sql)){
				echo 'TRUE';
			}else{
				echo $sql;
			}
		break;	

		case 'edsubtipo':
			$codstipo=$_POST['codsubtipo'];
			$nomstp=strtoupper($_POST['subtianame2']);
			$sql="UPDATE btyactivo_subtipo SET sbtnombre='$nomstp' WHERE sbtcodigo=$codstipo";
			if($conn->query($sql)){
				echo 'TRUE';
			}else{
				echo $sql;
			}
		break;	

		case 'edgrupo':
			$grupo=$_POST['codgru'];
			$nomgru=strtoupper($_POST['graname2']);
			$sql="UPDATE btyactivo_grupo SET granombre='$nomgru' WHERE gracodigo=$grupo";
			if($conn->query($sql)){
				echo 'TRUE';
			}else{
				echo $sql;
			}
		break;	

		case 'edsubgru':
			$sgnom = strtoupper($_POST['sbgname2']);
			$gru = $_POST['grucodigo2'];
			$pracod=$_POST['prioact2'];
			$ubic=$_POST['labelubic2'];

		    $sql = "UPDATE btyactivo_subgrupo SET pracodigo=$pracod, sbganombre='$sgnom', sbgubicacionetiqueta='$ubic' WHERE sbgcodigo=$gru";
		    if (mysqli_query($conn, $sql)) {
		        echo "TRUE";
		    }else{
		    	echo 'false';echo $sql;
		    }
		break;
}
?>
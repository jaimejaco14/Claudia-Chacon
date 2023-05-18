<?php 
include '../../cnx_data.php';

$opc=$_POST['opc'];
switch($opc){
	/////////////////tipo,subtipo,grupo,subgrupo////////////////////////////////////
		case 'tia':
			$result = $conn->query("SELECT tiacodigo, tianombre FROM  btyactivo_tipo where tiaestado = 1 order by tianombre");
			$opt= '<option value="0">- Seleccione Tipo de activo -</option>';
	        if ($result->num_rows > 0) {
	            while ($row = $result->fetch_assoc()) {         
	                $opt.= '<option value="'.$row['tiacodigo'].'">'.$row['tianombre'].'</option>';
	            }
	        }
	        echo $opt;
		break;

		case 'subtia':
			$tia=$_POST['tia'];
			$result = $conn->query("SELECT sbtcodigo, sbtnombre FROM  btyactivo_subtipo where sbtestado = 1 and tiacodigo=$tia order by sbtnombre");
			if ($result->num_rows > 0) {
				$opt= '<option value="0">- Seleccione SubTipo -</option>';
		        if ($result->num_rows > 0) {
		            while ($row = $result->fetch_assoc()) {         
		                $opt.= '<option value="'.$row['sbtcodigo'].'">'.$row['sbtnombre'].'</option>';
		            }
		        }
		        echo $opt;
		    }else{
		    	echo '<option value=""> -no hay resultados- </option>';
		    }
		break;

		case 'gru':
			$sbt = $_POST["sbt"];
			$sql="SELECT ag.gracodigo,ag.granombre FROM btyactivo_grupo ag WHERE ag.sbtcodigo=$sbt AND ag.graestado=1";
		    $result = $conn->query($sql);
		    if ($result->num_rows > 0) {
		    	$opt.= "<option value='0'> -Seleccione Grupo- </option>";
		        while ($row = $result->fetch_assoc()) {                
		             $opt.= "<option value='".$row['gracodigo']."'>".$row['granombre']."</option>";
		        }
		        echo $opt;
		    } else {

		        echo '<option value="">--no hay resultados--</option>';
		        
		    }
		break;

		case 'subgru':
			$gru = $_POST["gru"];
			$sql="SELECT sg.sbgcodigo,sg.sbganombre,sg.pracodigo,p.pranombre,sg.sbgubicacionetiqueta 
					FROM btyactivo_subgrupo sg 
					join btyactivo_prioridad p on p.pracodigo=sg.pracodigo
					WHERE sg.gracodigo=$gru and sg.sbgestado=1";
		    $result = $conn->query($sql);
		    if ($result->num_rows > 0) {
		    	$opt.= "<option value='0'> -Seleccione SubGrupo- </option>";
		        while ($row = $result->fetch_assoc()) {                
		             $opt.= "<option value='".$row['sbgcodigo']."' data-prio='".$row['pranombre']."' data-codprio='".$row['pracodigo']."' data-labelact='".$row['sbgubicacionetiqueta']."'>".$row['sbganombre']."</option>";
		        }
		        echo $opt;
		    } else {

		        echo '<option value="">--no hay resultados--</option>';
		        
		    }
		break;

		case 'addtia':
			$tianombre = strtoupper($_POST['tianame']);
			
		    $cod = 0;
		    $max ="SELECT MAX(tiacodigo) as m FROM btyactivo_tipo";    
		    $result = $conn->query($max);
		    if ($result->num_rows > 0) {
		         while($row = $result->fetch_assoc()) { 
		            $cod = $row["m"];
		        }
		    }
		    $cod = $cod + 1; 
		    $sql = "INSERT INTO `btyactivo_tipo` (`tiacodigo`, `tianombre`, `tiaestado`) VALUES ($cod, '$tianombre', 1)";
		    if (mysqli_query($conn, $sql)) {
		        echo "TRUE";
		    } else {
		        echo 'false';echo $sql;        
			}
		break;

		case 'addsubtia':
			$tia=strtoupper($_POST['tiacodigo']);
			$sbtnom=strtoupper($_POST['subtianame']);
			$sql="INSERT INTO btyactivo_subtipo (sbtcodigo,tiacodigo,sbtnombre,sbtestado) VALUES ((SELECT if(MAX(c.sbtcodigo) is null,1,MAX(c.sbtcodigo)+1)from btyactivo_subtipo as c),$tia,'$sbtnom',1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'addgru':
			$granombre = strtoupper($_POST['graname']);
			$sbt = $_POST['subtiacodigo'];
		    $sql = "INSERT INTO btyactivo_grupo (gracodigo, sbtcodigo, granombre, graestado)   VALUES ((SELECT if(MAX(c.gracodigo) is null,1,MAX(c.gracodigo)+1)from btyactivo_grupo as c), $sbt , '$granombre', 1)";
		    if (mysqli_query($conn, $sql)) {
		        echo "TRUE";
		    }else{
		    	echo 'false';echo $sql;
		    }
		break;

		case 'addsubgru':
			$sgnom = strtoupper($_POST['sbgname']);
			$gru = $_POST['grucodigo'];
			$pracod=$_POST['prioact'];
			$ubic=$_POST['labelubic'];

		    $sql = "INSERT INTO btyactivo_subgrupo (sbgcodigo,gracodigo,pracodigo,sbganombre,sbgubicacionetiqueta,sbgestado)   VALUES ((SELECT if(MAX(c.sbgcodigo) is null,1,MAX(c.sbgcodigo)+1)from btyactivo_subgrupo as c), $gru,$pracod,'$sgnom','$ubic', 1)";
		    if (mysqli_query($conn, $sql)) {
		        echo "TRUE";
		    }else{
		    	echo 'false';echo $sql;
		    }
		break;

		case 'seekgra':
			$txt=$_POST['key'];
			$sbt=$_POST['sbt'];
			$sql="SELECT COUNT(*) FROM btyactivo_grupo WHERE granombre='$txt' and sbtcodigo=$sbt";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seeksubgra':
			$txt=$_POST['key'];
			$sbt=$_POST['gra'];
			$sql="SELECT COUNT(*) FROM btyactivo_subgrupo WHERE sbganombre='$txt' and gracodigo=$sbt";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seektia':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btyactivo_tipo WHERE tianombre='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seeksubtia':
			$txt=$_POST['key'];
			$tia=$_POST['tia'];
			$sql="SELECT COUNT(*) FROM btyactivo_subtipo WHERE sbtnombre='$txt' and tiacodigo=$tia";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
	///////////////marca, pais, fabricante, prioridad///////////////////////////////
		case 'mar':
	        $result = $conn->query("SELECT marcodigo, marnombre FROM  btyactivo_marca order by marnombre");
	        echo '<option value="0">- Seleccione una marca -</option>';
	        if ($result->num_rows > 0) {
	            while ($row = $result->fetch_assoc()) {                
	                echo '<option value="'.$row['marcodigo'].'">'.$row['marnombre'].'</option>';
	            }
	        }               
		break;

		case 'addmar':
			$marnombre = strtoupper($_POST['marname']);
		    $cod = 0;
		    $max ="SELECT MAX(marcodigo) as m FROM btyactivo_marca";    
		    $result = $conn->query($max);
		    if ($result->num_rows > 0) {
		         while($row = $result->fetch_assoc()) { 
		            $cod = $row["m"];
		        }
		    }
		    $cod = $cod + 1; 
		    $sql = "INSERT INTO `btyactivo_marca` (`marcodigo`, `marnombre`, `marestado`) VALUES ($cod, '$marnombre', 1)";
		    if (mysqli_query($conn, $sql)) {
		        echo "TRUE";
		    } else {
		        echo 'error en:';echo $sql;        
			}
		break;

		case 'prov':
			$txt=$_POST['key'];
			$sql="SELECT p.prvcodigo,t.trcrazonsocial FROM btyproveedor p NATURAL JOIN btytercero t where p.prvestado=1 and t.trcrazonsocial like '%".$txt."%' order by t.trcrazonsocial";
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['prvcodigo'].'">'.$row['trcrazonsocial'].'</option>';
			}
			echo $opcsel;
		break;

		case 'fab':
			$sql="SELECT * FROM btyactivo_fabricante where fabestado=1 order by fabnombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Seleccione fabricante - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['fabcodigo'].'">'.$row['fabnombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'pais':
			$sql="SELECT * FROM btypais where paiestado=1 order by painombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Seleccione país - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['paicodigo'].'">'.$row['painombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'prio':
			$sql="SELECT * FROM btyactivo_prioridad where praestado=1 order by pranombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Seleccione Prioridad - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['pracodigo'].'">'.$row['pranombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'addfab':
			$nomfa=strtoupper($_POST['fabname']);
			$sql="INSERT INTO btyactivo_fabricante (fabcodigo,fabnombre,fabestado) VALUES ((SELECT if(MAX(c.fabcodigo) is null,1,MAX(c.fabcodigo)+1)from btyactivo_fabricante as c),'$nomfa',1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekfab':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btyactivo_fabricante WHERE fabnombre='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'addpais':
			$nompa=strtoupper($_POST['paisname']);
			$sql="INSERT INTO btypais (paicodigo,painombre,paiestado) VALUES ((SELECT if(MAX(c.paicodigo) is null,1,MAX(c.paicodigo)+1)from btypais as c),'$nompa',1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekpais':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btypais WHERE painombre='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seekmar':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btyactivo_marca WHERE marnombre='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
	///////////////////////////validacion de nombre de activos,serial y codigo ext////
		case 'seekactnom':
			$txt=$_POST['act_name'];
			$sql="SELECT COUNT(*) FROM btyactivo WHERE actnombre='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seeksn':
			$txt=$_POST['txt'];
			$sql="SELECT COUNT(*) FROM btyactivo WHERE actserial='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seeksnedt':
			$txt=$_POST['txt'];
			$actcod=$_POST['actcod'];
			$sql="SELECT COUNT(*) FROM btyactivo WHERE actserial='$txt' and actcodigo <> $actcod";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seekcodex':
			$txt=$_POST['txt'];
			$sql="SELECT COUNT(*) FROM btyactivo WHERE actcodigoexterno='$txt'";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'seekcodexedt':
			$actcod=$_POST['actcod'];
			$txt=$_POST['txt'];
			$sql="SELECT COUNT(*) FROM btyactivo WHERE actcodigoexterno='$txt' and actcodigo <> $actcod";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
	//////////////////////////////garantia/////////////////////////////////////////////////
		
		case 'unitie':
			$sql="SELECT * FROM btyactivo_unidad where unaestado=1 and unatiempo=1 order by unanombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Unidad - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['unacodigo'].'">'.$row['unanombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'uniuso':
			$sql="SELECT * FROM btyactivo_unidad where unaestado=1 and unatiempo=0 order by unanombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Unidad - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['unacodigo'].'">'.$row['unanombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'adduni1':
			$nomuni=strtoupper($_POST['uniname1']);
			$sql="INSERT INTO btyactivo_unidad (unacodigo, unanombre, unatiempo, unaestado) VALUES ((SELECT if(MAX(c.unacodigo) is null,1,MAX(c.unacodigo)+1)from btyactivo_unidad as c), '$nomuni', 1, 1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekuni1':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btyactivo_unidad WHERE unanombre='$txt' unatiempo=1";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'adduni2':
			$nomuni=strtoupper($_POST['uniname2']);
			$sql="INSERT INTO btyactivo_unidad (unacodigo, unanombre, unatiempo, unaestado) VALUES ((SELECT if(MAX(c.unacodigo) is null,1,MAX(c.unacodigo)+1)from btyactivo_unidad as c), '$nomuni', 0, 1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekuni2':
			$txt=$_POST['key'];
			$sql="SELECT COUNT(*) FROM btyactivo_unidad WHERE unanombre='$txt' and unatiempo=0";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;
	////////////////////////////////insumos///////////////////////////////////////////////

		case 'addinsumo':
			$nomins=strtoupper($_POST['insname']);
			$refins=strtoupper($_POST['insref']);
			$espins=$_POST['insespec'];
			$sql="INSERT INTO btyactivo_insumo (inscodigo, insnombre, insreferencia, insespecificaciones, insestado) VALUES ((SELECT if(MAX(c.inscodigo) is null,1,MAX(c.inscodigo)+1)from btyactivo_insumo as c), '$nomins', '$refins','$espins', 1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekins':
			$txt=$_POST['str'];
			$sql="SELECT COUNT(*) FROM btyactivo_insumo WHERE insnombre='$txt' and insestado=1";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'insumo':
			$txt=$_POST['key'];
			$sql="SELECT * FROM btyactivo_insumo where insestado=1 and insnombre like '%".$txt."%' order by insnombre";
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['inscodigo'].'">'.$row['insnombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'assignins':
			$idact=$_POST['idact'];
			$idins=$_POST['idins'];
			$cant=$_POST['cant'];
			$sql0="SELECT COUNT(*) from btyactivo_insumo_detalle WHERE inscodigo=$idins and actcodigo=$idact";
			$res=$conn->query($sql0);
			$row=$res->fetch_array();
			if($row[0]==0){
				$sql1="UPDATE btyactivo SET actreq_insumos=1 where actcodigo=$idact";
				if($conn->query($sql1)){
					$sql="INSERT INTO btyactivo_insumo_detalle (inscodigo,actcodigo,indcantidad,indestado) VALUES ($idins,$idact,$cant,1)";
					if($conn->query($sql)){
						echo 'true';
					}else{
						echo $sql;
					}
				}
			}else{
				echo 'dup';
			}
		break;

		case 'loadtbinsu':
			$idact=$_POST['idact'];
			$sql="SELECT id.inscodigo,i.insnombre,i.insreferencia,i.insespecificaciones,id.indcantidad
					FROM btyactivo_insumo_detalle id
					JOIN btyactivo_insumo i ON i.inscodigo=id.inscodigo
					where id.actcodigo=$idact and id.indestado=1 order by i.insnombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					?>
					<tr>
						<td><?php echo $row['insreferencia'];?></td>
						<td><?php echo $row['insnombre'];?></td>
						<td><?php echo $row['insespecificaciones'];?></td>
						<td class="text-center cant"><?php echo $row['indcantidad'];?></td>
						<td class="text-center opc">
							<button class="btneditins btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" title="Editar cantidad de insumo" data-act-id="<?php echo $idact;?>" data-ins-id="<?php echo $row['inscodigo'];?>"><i class="fa fa-edit text-info"></i></button>
							<button class="btndelins btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Eliminar insumo" data-act-id="<?php echo $idact;?>" data-ins-id="<?php echo $row['inscodigo'];?>"><i class="fa fa-trash text-danger"></i></button>
						</td>
					</tr>
					<?php
				}
			}else{
				echo '<tr><td colspan="5" class="text-center">No hay insumos asignados</td></tr>';
			}
		break;

		case 'delinsumo':
			$idact=$_POST['idact'];
			$idins=$_POST['idins'];
			$sql="UPDATE btyactivo_insumo_detalle SET indestado=0 where actcodigo=$idact and inscodigo=$idins";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'updins':
			$idact=$_POST['idact'];
			$idins=$_POST['idins'];
			$cant=$_POST['cant'];
			if($cant>0){
				$sql="UPDATE btyactivo_insumo_detalle SET indcantidad=$cant WHERE actcodigo=$idact AND inscodigo=$idins";
				if($conn->query($sql)){
					echo 'true';
				}else{
					echo $sql;
				}
			}else{
				echo '0';
			}
		break;
	/////////////////////////////repuestos//////////////////////////////////////////////////

		case 'repuesto':
			$txt=$_POST['key'];
			$sql="SELECT * FROM btyactivo_repuesto where repestado=1 and repnombre like '%".$txt."%' order by repnombre";
			$res=$conn->query($sql);
			$opcsel.='<option value="0"> - Seleccione repuesto - </option>';
			while($row=$res->fetch_array()){
				$opcsel.='<option value="'.$row['repcodigo'].'">'.$row['repnombre'].'</option>';
			}
			echo $opcsel;
		break;

		case 'loadtbrep':
			$idact=$_POST['idact'];
			$sql="SELECT id.repcodigo,i.repnombre,i.repreferencia,i.repespecificaciones,id.redcantidad
					FROM btyactivo_repuesto_detalle id
					JOIN btyactivo_repuesto i ON i.repcodigo=id.repcodigo
					where id.actcodigo=$idact and id.redestado=1 order by i.repnombre";
			$res=$conn->query($sql);
			if($res->num_rows>0){
				while($row=$res->fetch_array()){
					?>
					<tr>
						<td><?php echo $row['repreferencia'];?></td>
						<td><?php echo $row['repnombre'];?></td>
						<td><?php echo $row['repespecificaciones'];?></td>
						<td class="text-center cant2"><?php echo $row['redcantidad'];?></td>
						<td class="text-center opc">
							<button class="btneditrep btn btn-default btn-sm" data-toggle="tooltip" data-placement="left" title="Editar cantidad de repuesto" data-act-id="<?php echo $idact;?>" data-rep-id="<?php echo $row['repcodigo'];?>"><i class="fa fa-edit text-info"></i></button>
							<button class="btndelrep btn btn-default btn-sm" data-toggle="tooltip" data-placement="right" title="Eliminar repuesto" data-act-id="<?php echo $idact;?>" data-rep-id="<?php echo $row['repcodigo'];?>"><i class="fa fa-trash text-danger"></i></button>
						</td>
					</tr>
					<?php
				}
			}else{
				echo '<tr><td colspan="5" class="text-center">No hay repuestos asignados</td></tr>';
			}
		break;

		case 'addrepu':
			$nomrep=strtoupper($_POST['repname']);
			$refrep=strtoupper($_POST['repref']);
			$esprep=$_POST['repespec'];
			$sql="INSERT INTO btyactivo_repuesto (repcodigo, repnombre, repreferencia, repespecificaciones, repestado) VALUES ((SELECT if(MAX(c.repcodigo) is null,1,MAX(c.repcodigo)+1)from btyactivo_repuesto as c), '$nomrep', '$refrep','$esprep', 1)";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'seekrep':
			$txt=$_POST['str'];
			$sql="SELECT COUNT(*) FROM btyactivo_repuesto WHERE repnombre='$txt' and repestado=1";
			$res=$conn->query($sql);
			$row=$res->fetch_array();
			if($row[0]>0){
				echo 'false';
			}else{
				echo 'true';
			}
		break;

		case 'assignrep':
			$idact=$_POST['idact'];
			$idrep=$_POST['idrep'];
			$cant=$_POST['cant'];
			$sql0="SELECT COUNT(*) from btyactivo_repuesto_detalle WHERE repcodigo=$idrep and actcodigo=$idact";
			$res=$conn->query($sql0);
			$row=$res->fetch_array();
			if($row[0]==0){
				$sql1="UPDATE btyactivo SET actreq_repuestos=1 where actcodigo=$idact";
				if($conn->query($sql1)){
					$sql="INSERT INTO btyactivo_repuesto_detalle (repcodigo,actcodigo,redcantidad,redestado) VALUES ($idrep,$idact,$cant,1)";
					if($conn->query($sql)){
						echo 'true';
					}else{
						echo $sql;
					}
				}
			}else{
				echo 'dup';
			}
		break;

		case 'delrep':
			$idact=$_POST['idact'];
			$idrep=$_POST['idrep'];
			$sql="UPDATE btyactivo_repuesto_detalle SET redestado=0 where actcodigo=$idact and repcodigo=$idrep";
			if($conn->query($sql)){
				echo 'true';
			}else{
				echo $sql;
			}
		break;

		case 'updrep':
			$idact=$_POST['idact'];
			$idrep=$_POST['idrep'];
			$cant=$_POST['cant'];
			if($cant>0){
				$sql="UPDATE btyactivo_repuesto_detalle SET redcantidad=$cant WHERE actcodigo=$idact AND repcodigo=$idrep";
				if($conn->query($sql)){
					echo 'true';
				}else{
					echo $sql;
				}
			}else{
				echo '0';
			}
		break;
}
?>
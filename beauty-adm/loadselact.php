<?php 
//include 'conexion.php';

$opc=$_POST['opc'];
switch($opc){
	case 'gru':
		$tia_cod = $_POST["codigo"];
	    $result = $conn->query("SELECT a.gracodigo, a.granombre , p.pranombre, p.pracodigo
								FROM btyactivo_grupo a
								natural join btyactivo_prioridad p 
								where tiacodigo = $tia_cod order by granombre");

	    if ($result->num_rows > 0) {
	        while ($row = $result->fetch_assoc()) {                
	             $opt.= "<option value='".$row['gracodigo']."' data-prio='".$row['pranombre']."' data-codprio='".$row['pracodigo']."'>".$row['granombre']."</option>";
	        }
	        echo $opt;
	    } else {

	        echo '<option value="">--no hay resultados--</option>';
	        
	    }
	break;

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

	case 'addgru':
		$prio=$_POST['priogruac'];
		$granombre = $_POST['graname'];
		$tiacodigo = $_POST['tiacodigo'];
		$cod = 0;
		$max ="SELECT MAX(gracodigo) as m FROM btyactivo_grupo";    
	    $result = $conn->query($max);
	    if ($result->num_rows > 0) {
	         while($row = $result->fetch_assoc()) { 
	        	$cod = $row["m"];
	    	}
	    }
	    $cod = $cod + 1;
	    $sql = "INSERT INTO btyactivo_grupo (gracodigo, tiacodigo, granombre, pracodigo, graestado) VALUES ($cod, $tiacodigo , '$granombre', $prio, 1)";
	    if (mysqli_query($conn, $sql)) {
	        echo "TRUE";
	    }else{
	    	echo 'false';echo $sql;
	    }
	break;

	case 'addtia':
		$tianombre = $_POST['tianame'];
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

	case 'seekgra':
		$txt=$_POST['key'];
		$tia=$_POST['tia'];
		$sql="SELECT COUNT(*) FROM btyactivo_grupo WHERE granombre='$txt' and tiacodigo=$tia";
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
		$sql="SELECT * FROM btyactivo_insumo where insestado=1 order by insnombre";
		$res=$conn->query($sql);
		$opcsel.='<option value="0"> - Seleccione insumo - </option>';
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
				where id.actcodigo=$idact and id.indestado=1 ";
		$res=$conn->query($sql);
		if($res->num_rows>0){
			while($row=$res->fetch_array()){
				?>
				<tr>
					<td><?php echo $row['insnombre'];?></td>
					<td><?php echo $row['insreferencia'];?></td>
					<td><?php echo $row['insespecificaciones'];?></td>
					<td class="text-center"><?php echo $row['indcantidad'];?></td>
					<td class="text-center">
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

}
?>
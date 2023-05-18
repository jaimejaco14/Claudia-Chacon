<?php 
include "../cnx_data.php";
$opc=$_POST['opc'];
switch($opc){

	case 'del':
		$ser=$_POST['ser'];
		$pro=$_POST['pro'];
		$sqldel="UPDATE btyservicio_producto sp set sp.sprstado=0 where sp.sercodigo=$ser and sp.procodigo=$pro";
		$resdel=$conn->query($sqldel);
		if($resdel){
			echo 'true';
		}else{
			echo 'false';
		}
	break;

	case 'add':
		$ser=$_POST['selser'];
		$pro=$_POST['selpro'];
		if($_POST['reqcant']){
			$req=1;
			$cant=0;
		}else{
			$req=0;
			$cant=$_POST['cant'];
		}
		$sqlsk="SELECT COUNT(*) FROM btyservicio_producto WHERE sercodigo=$ser AND procodigo=$pro";
		$ressk=$conn->query($sqlsk);
		$rowsk=$ressk->fetch_array();
		if($rowsk[0]==0){
			$sqladd="INSERT INTO btyservicio_producto (sercodigo,procodigo,spcantidad,sprequierecantidad,sprstado) VALUES ($ser,$pro,$cant,$req,1)";
			$resadd=$conn->query($sqladd);
			if($resadd){
				echo 'true';
			}else{
				echo $sqladd;
			}
		}else{
			echo 'dup';
		}
	break;

	case 'upd':
		$ser=$_POST['selseredt'];
		$pro=$_POST['selproedt'];
		$oldpro=$_POST['oldpro'];
		
		if($_POST['reqcantedt']){
			$req=1;
			$cant=0;
		}else{
			$req=0;
			$cant=$_POST['cantedt'];
		}
		$sqlsk="SELECT COUNT(*) FROM btyservicio_producto WHERE sercodigo=$ser";
		if($pro!=$oldpro){
			$cond=" AND procodigo=".$pro;
			$per=0;
		}else{
			$cond=" AND procodigo=".$oldpro;
			$per=1;
		}
		$ressk=$conn->query($sqlsk.$cond);
		$rowsk=$ressk->fetch_array();
		if($rowsk[0]==$per){
			$sqlupd="UPDATE btyservicio_producto SET  procodigo=$pro, spcantidad=$cant, sprequierecantidad=$req WHERE sercodigo=$ser AND procodigo=$oldpro";
			$resupd=$conn->query($sqlupd);
			if($resupd){
				echo 'true';
			}else{
				echo $sqlupd;
			}
		}else{
			echo 'dup';
		}
	break;

	case 'fill':
		$txt=$_POST['txt'];
		$sqlpro="SELECT p.procodigo,p.pronombre  FROM btyproducto p where p.proestado=1 and p.pronombre like '%".$txt."%' order by p.pronombre asc";
		$respro=$conn->query($sqlpro);
		while($rowpro=$respro->fetch_array()){
			?>
			<option value="<?php echo $rowpro[0];?>"><?php echo utf8_encode($rowpro[1]);?></option>
			<?php
		}                                 
	break;

	case 'llen':
		$txt=$_POST['key'];
		$array = array();
		$sqlpro="SELECT p.procodigo,p.pronombre  FROM btyproducto p where p.proestado=1 and p.pronombre like '%".$txt."%' order by p.pronombre asc";
		$respro=$conn->query($sqlpro);
		while($rowpro=$respro->fetch_array()){
			$array[]=(array("id"=>$rowpro['procodigo'], "name"=>utf8_encode($rowpro['pronombre'])));
		} 
		echo json_encode($array);                   
	break;

	case 'chk':
		$id=$_POST['id'];
		$sql="SELECT count(*) from btyservicio_producto sp where sp.sercodigo=$id and sp.sprstado=1";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]>0){
			echo 'true';
		}else{
			echo 'false';
		}
	break;
}
?>
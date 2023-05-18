<?php 
/*ini_set('display_errors',1);
error_reporting(E_ALL);*/
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadcoldocu':
		$sql="SELECT t.taccodigo,t.tacnombre
				FROM btytipo_adjunto_colaborador t
				WHERE t.tacestado=1 AND t.tacobliga=1
				ORDER BY t.tacnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['taccodigo'],'nom'=>$row['tacnombre']);
		}
		echo json_encode($array);
	break;
	case 'savedoc':
	$err='';
		$idcol=$_POST['idcol'];
		$codcol=mysqli_fetch_array(mysqli_query($conn,"SELECT c.clbcodigo FROM btycolaborador c WHERE c.trcdocumento=$idcol"));
		$ruta='/var/www/html/beauty/contenidos/documentos_colaborador/';
		$sql="SELECT t.taccodigo FROM btytipo_adjunto_colaborador t
				WHERE t.tacestado=1 AND t.tacobliga=1
				ORDER BY t.taccodigo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$tac=$row['taccodigo'];
			if($_FILES[$tac]['name']!=''){
				$file_name = $_FILES[$tac]['name'];
                $archivo = $_FILES[$tac]['tmp_name'];
                $arrname = explode('.', $file_name);
                $ext = strtolower(end($arrname));
                $dac=mysqli_fetch_array(mysqli_query($conn,"SELECT IFNULL(MAX(d.daccodigo)+1,1) FROM btydocumento_adjunto_colaborador d"));
                if(move_uploaded_file($archivo , $ruta.$dac[0].".".$ext)){
                    $file_name = $dac[0].".".$extension;
                    $ins="INSERT INTO btydocumento_adjunto_colaborador (daccodigo,taccodigo,clbcodigo,dacfecharegistro,dachoraregistro,dacobseracion,dacestado) 
                    		VALUES ($dac[0],$tac,$codcol[0],CURDATE(),CURTIME(),'',1)";
                    if($conn->query($ins)){
                    	$array[]=array('tac'=>$tac,'up'=>'1');
                    }else{
                    	$array[]=array('tac'=>$tac,'up'=>$ins);
                    }
                }else{
                	$array[]=array('tac'=>$tac,'up'=>'0');
                }
			}
		}
		echo json_encode($array);
	break;
}
?>
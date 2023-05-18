<?php
include '../../cnx_data.php';
$opc=$_POST['opc'];

switch($opc){
	case 'upd':
		/*$sqlupd="SELECT dac.taccodigo,dac.dacobseracion FROM btydocumento_adjunto_colaborador dac where dac.daccodigo=$numdoc";
		$resupd=$conn->query($sqlupd);
		$rowupd=$resupd->fetch_array();
		echo json_encode(array("tipo"=>$rowupd[0],"obs"=>$rowupd[1],"numdoc"=>$numdoc));*/
	break;
	case 'del':
		$adj=$_POST['adj'];
		$sqldel="DELETE FROM btyactivo_adjunto where adjcodigo=$adj";
		$resdel=$conn->query($sqldel);
		if($resdel){
			echo 'true';
		}
	break;
	case 'nuca':
		$cat=strtoupper($_POST['textinput1']);
	    $sqlnc="INSERT INTO btyactivo_tipoadjunto  (tadcodigo,tadnombre,tadestado) 
				VALUES ((SELECT if(MAX(c.tadcodigo) is null,1,MAX(c.tadcodigo)+1) from btyactivo_tipoadjunto as c),'$cat',1)";
	    $resnc=$conn->query($sqlnc);
	    if($resnc){
	    	echo 'true';
	    }else{
	    	echo 'false';
	    }
	break;
	case 'load':
		$sqltd="SELECT * from btyactivo_tipoadjunto tac where tac.tadestado=1 order by tac.tadnombre ";
		$restd=$conn->query($sqltd);
		$opt='<option value="">- Seleccione Tipo de adjunto -</option>';
		while($rowtd=$restd->fetch_array()){
			 $opt.= '<option value="'.$rowtd[0].'">'.$rowtd[1].'</option>';
		}
		echo $opt;
	break;
}
?>
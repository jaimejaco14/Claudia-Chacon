<?php
include '../../cnx_data.php';
$opc=$_POST['opc'];
$numdoc=$_POST['numdoc'];
switch($opc){
	case 'upd':
		$sqlupd="SELECT dac.taccodigo,dac.dacobseracion FROM btydocumento_adjunto_colaborador dac where dac.daccodigo=$numdoc";
		$resupd=$conn->query($sqlupd);
		$rowupd=$resupd->fetch_array();
		echo json_encode(array("tipo"=>$rowupd[0],"obs"=>$rowupd[1],"numdoc"=>$numdoc));
	break;
	case 'del':
		$sqldel="UPDATE btydocumento_adjunto_colaborador dac SET dac.dacestado=0 where dac.daccodigo=$numdoc";
		$resdel=$conn->query($sqldel);
		if($resdel){
			echo 'true';
		}
	break;
	case 'nuca':
		$cat=strtoupper($_POST['textinput1']);
	    $dsc=strtoupper($_POST['textinput2']);
	    $sqlnc="INSERT INTO btytipo_adjunto_colaborador  (taccodigo,tacnombre,tacdescripcion,tacestado) 
				VALUES ((SELECT if(MAX(c.taccodigo) is null,1,MAX(c.taccodigo)+1) from btytipo_adjunto_colaborador as c),'$cat','$dsc',1)";
	    $resnc=$conn->query($sqlnc);
	    if($resnc){
	    	echo 'true';
	    }else{
	    	echo 'false';
	    }
	break;
	case 'load':
		?>
		<option value="">Seleccione tipo de documento</option>
		<?php
		$sqltd="SELECT * from btytipo_adjunto_colaborador tac where tac.tacestado=1 order by tac.tacnombre ";
		$restd=$conn->query($sqltd);
		while($rowtd=$restd->fetch_array()){
		    ?>
		    <option value="<?php echo $rowtd[0];?>"><?php echo $rowtd[1];?></option>
		    <?php
		}
	break;
}
?>
<?php 
include '../../cnx_data.php';
$txt=utf8_decode($_POST['txt']);
$sql="SELECT c.clbcodigo,t.trcrazonsocial from  btycolaborador c
    join btytercero t on t.trcdocumento=c.trcdocumento where t.trcrazonsocial like '%".$txt."%' AND bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'
    order by trcrazonsocial";
$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['clbcodigo'], 'nom'=>utf8_encode($row['trcrazonsocial'])));
		}
		echo json_encode($array);

?>
<?php 
include("../../../cnx_data.php");
$opc=$_POST['opc'];
switch($opc){
	case 'loadstats':
		$codpro=$_POST['codpro'];
		$sql = mysqli_query($conn, "SELECT sl.slnnombre, s.sernombre, t.trcrazonsocial, rp.repfecha, t2.trcnombres
									FROM btyredencion_promo rp
									JOIN btycliente c ON c.clicodigo=rp.clicodigo
									JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
									JOIN btyservicio s ON s.sercodigo=rp.sercodigo
									JOIN btysalon sl ON sl.slncodigo=rp.slncodigo
									JOIN btyusuario u ON u.usucodigo=rp.usucodigo
									JOIN btytercero t2 ON t2.tdicodigo=u.tdicodigo AND t2.trcdocumento=u.trcdocumento
									WHERE rp.pmocodigo=$codpro
									ORDER BY repfecha DESC");

  				$array = array();

			if(mysqli_num_rows($sql) > 0)
			{
			    
			     	while($data = mysqli_fetch_assoc($sql))
				{
				      $array['data'][] = $data;

				}        
		     
		     		$array= utf8_converter($array);
		    
			}
			else			  
			{
			      $array=array('data'=>'');
			}
			echo json_encode($array);
	break;
	case 'graphsln':
		$codpromo=$_POST['codpromo'];
		$sql="SELECT s.slnnombre, COUNT(*)
				FROM btyredencion_promo rp
				JOIN btysalon s ON s.slncodigo=rp.slncodigo
				WHERE rp.pmocodigo=$codpromo
				GROUP BY rp.slncodigo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('salon'=>$row[0],'cant'=>$row[1]));
		}
		$array= utf8_converter($array);
		echo json_encode($array);
	break;
	case 'graphser':
		$codpromo=$_POST['codpromo'];
		$sql="SELECT s.sernombre, COUNT(*)
				FROM btyredencion_promo rp
				JOIN btyservicio s ON s.sercodigo=rp.sercodigo
				WHERE rp.pmocodigo=$codpromo
				GROUP BY rp.sercodigo";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('serv'=>$row[0],'cant'=>$row[1]));
		}
		$array= utf8_converter($array);
		echo json_encode($array);
	break;
	case 'graphuni':
		$sql="SELECT pu.punnombre, COUNT(*)
				FROM btypromoregistro pr
				JOIN btypromouniversidad pu ON pu.puncodigo=pr.prodato
				GROUP BY pu.punnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('uni'=>$row[0],'cant'=>$row[1]));
		}
		$array= utf8_converter($array);
		echo json_encode($array);
	break;
	case 'loadclireg':
		$codpro=$_POST['codpro'];
		$sql = mysqli_query($conn, "SELECT t.trcrazonsocial, u.punnombre, t.trctelefonomovil, c.cliemail, pr.profechareg
									FROM btypromoregistro pr
									JOIN btycliente c ON c.clicodigo=pr.clicodigo
									JOIN btytercero t ON t.trcdocumento=c.trcdocumento AND t.tdicodigo=c.tdicodigo
									JOIN btypromouniversidad u ON u.puncodigo=pr.prodato
									WHERE pr.proestado=1 AND pr.pmocodigo=3
									ORDER BY pr.profechareg");

  				$array = array();

			if(mysqli_num_rows($sql) > 0)
			{
			    
			     	while($data = mysqli_fetch_assoc($sql))
				{
				      $array['data'][] = $data;

				}        
		     
		     		$array= utf8_converter($array);
		    
			}
			else			  
			{
			      $array=array('data'=>'');
			}
			echo json_encode($array);
	break;
}
function utf8_converter($array){
	array_walk_recursive($array, function(&$item, $key)
	{
		if(!mb_detect_encoding($item, 'utf-8', true))
		{
  			$item = utf8_encode($item);
		}
	});

	return $array;
}
?>

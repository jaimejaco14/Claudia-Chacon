<?php 	
include '../../cnx_data.php'; 
$slncod=$_POST['sln'];
$sql2="SELECT p.imgnomarchivo
		FROM btyimg_pantalla_salon ips
		JOIN btyimg_pantalla p ON p.imgcodigo=ips.imgcodigo
		WHERE ips.slncodigo=$slncod AND CURDATE() BETWEEN ips.ipsdesde AND ips.ipshasta AND p.imgestado=1";
$res2=$conn->query($sql2);
$opc='<div id="auto" style="display:none;margin-left:25px;min-height:500px;">';
while($row2=$res2->fetch_array()){
		$opc.='<img src="contenidos/'.$row2[0].'" class="img-responsive">';
}
$opc.='</div>';
echo $opc;
?>
<script src="slider/js/jquery.bbslider.min.js"></script>
<script type="text/javascript">
	$("#auto").bbslider({
		auto:true,
		timer:10000,
		loop:true
	});
	$("#auto").show();
</script>
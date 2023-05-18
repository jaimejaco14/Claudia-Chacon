<?php 
include '../../cnx_data.php'; 
$sql="SELECT sev.sevsrc, sev.sevinicio, sev.sevfinal
		FROM btyscreen_evento sev
		WHERE sev.sevestado=1 AND sev.sevfecha= CURDATE() OR sev.sevfecha IS NULL ORDER BY sev.sevinicio";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$eventos.='<input type="hidden" class="evento" data-start="'.$row[1].'" data-end="'.$row[2].'" value="'.$row[0].'">';
}
echo $eventos;
?>
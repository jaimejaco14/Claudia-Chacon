<?php
include '../../cnx_data.php';
$sql = "SELECT s.`slnnombre`, s.`slndireccion`, s.`slnindicativotelefonofijo`, s.`slntelefonofijo`, s.`slnextensiontelefonofijo`, s.`slntelefonomovil`, s.`slnemail`, s.`slntamano`, s.`slnfechaapertura`, s.`slnalias`, s.`slnplantas`, l.locnombre FROM `btysalon` s INNER JOIN btylocalidad l ON l.loccodigo = s.loccodigo WHERE slncodigo = ".$_POST['codigo'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo $row['slnnombre'].","; 	//0
		echo $row['slnalias'].","; 	//1
		echo $row['slnindicativotelefonofijo'].","; 	//2
		echo $row['slntelefonofijo'].","; 	//3
		echo $row['slnextensiontelefonofijo'].",";	//4
		echo $row['slntelefonomovil'].",";		//5
		echo $row['slnemail'].",";		//6
		echo $row['slndireccion'].",";	//7
		echo $row['locnombre'].",";//8
		echo $row['slntamano'].",";//9
		echo $row['slnplantas'].","; //10
		echo $row['slnfechaapertura'].","; //11
	}
} else {
	echo "string";
}
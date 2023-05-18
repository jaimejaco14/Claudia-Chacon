<?php 
	include("../../../cnx_data.php");

	switch ($_POST['opcion']) 
	{
		case 'conteoNovHead':
			$sql = mysqli_query($conn, "SELECT COUNT(*) FROM btyasistencia_procesada a JOIN btyasistencia_procesada_tipo b ON a.aptcodigo=b.aptcodigo WHERE  year(a.prgfecha) = year(CURDATE()) AND MONTH(a.prgfecha) = MONTH(CURDATE()) AND NOT a.prgfecha = CURDATE() AND a.slncodigo =  '".$_SESSION['PDVslncodigo']."' AND NOT b.aptfactor = '0.0000' AND  a.apcobservacion = ''");

                $row = mysqli_fetch_array($sql);

                echo $row[0];
                   
			break; 
		
		default:
			# code...
			break;
	}

	mysqli_close($conn);
 ?>
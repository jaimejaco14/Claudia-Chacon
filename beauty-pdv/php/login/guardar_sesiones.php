<?php 
session_start();
include("../../../cnx_data.php");
include 'mobile.php';

print_r($_SESSION);

$sw=$_SESSION['sw'];
$info=detect();
if($ismobile) { 
	$info['os'] = "OTHER";
	echo "¡Estás usando un dispositivo móvil!";
	$os=array("ANDROID","IPHONE","IPAD","BLACKBERRY","WINDOWS PHONE"); 
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
		
	}

}


echo "estado del whitch sw :".$sw;
//echo "estado del whitch :".$_SESSION['sw1'];
	$sql= "SELECT * FROM `btysesiones`";
	if ($conn->query($sql)){
	$sqlmax = "SELECT MAX(`sescodigo`) as m FROM `btysesiones`";
	$max = $conn->query($sqlmax);
	if ($max->num_rows > 0) {
		while ($row = $max->fetch_assoc()) {
			$cod = $row['m'];
		} 
	} else {
		echo $cod = 0;
		echo "<br>";
	}

	$cod=$cod+1;
	$_SESSION['numero_sesion']=$cod;
}


if ($sw==1) {
		echo "<br>";
		echo $codee= $_SESSION["codigoUsuario"];
		echo "<br>";
		echo $nomb_us=$_SESSION['userr'];
		echo "<br>";
		echo $ipwan = $_SERVER['REMOTE_ADDR'];
		echo "<br>";
		echo $brow=$info['browser'];
		echo "<br>";
		echo $sist=$info['os'];
		echo "<br>";
		echo $sesinf= date("Y-n-j"); 
		echo "<br>";
		echo $sesinh =date("H:i:s");
		echo "<br>";
		echo $sesfinf = date("Y-n-j");
		echo "<br>";
		echo $sesfinh = date("H:i:s");
		$fallo=0;
		if (!isset($_SESSION['userr'])) {
			echo $est = 0;
		}else {
			 echo $est=1;
		}
		echo "<br>";
		
	}else if($_SESSION['sw1']==2){
		echo "<br>";
		echo $codee= $_SESSION["codigoUsuario"];
		echo "<br>";
		echo $nomb_us=$_SESSION['userr'];
		echo "<br>";
		echo $ipwan = $_SERVER['REMOTE_ADDR'];
		echo "<br>";
		echo $brow=$info['browser'];
		echo "<br>";
		echo $sist=$info['os'];
		echo "<br>";
		echo $sesinf= date("Y-n-j"); 
		echo "<br>";
		echo $sesinh =date("H:i:s");
		echo "<br>";
		echo $sesfinf = date("Y-n-j");
		echo "<br>";
		echo $sesfinh = date("H:i:s");
		$fallo=1;
		if (!isset($_SESSION['userr'])) {
			echo $est = 0;
		}else {
			 echo $est=1;
		}
		echo "<br>";
		

	}else{
		echo "<br>";
		echo $codee= 'NULL';
		echo "<br>";
		echo $nomb_us=$_SESSION['userr'];
		echo "<br>";
		echo $ipwan = $_SERVER['REMOTE_ADDR'];
		echo "<br>";
		echo  $brow=$info['browser'];
		echo "<br>";
		echo $sist=$info['os'];
		echo "<br>";
		echo $sesinf= date("Y-n-j"); 
		echo "<br>";
		echo $sesinh =date("H:i:s");
		echo "<br>";
		echo $sesfinf = date("Y-n-j");
		echo "<br>";
		echo $sesfinh = date("H:i:s");
		echo "<br>";
		echo $fallo=1;
		echo "<br>";
		if (!isset($_SESSION['userr'])) {
			echo $est = 0;
		}else {
			 echo $est=1;
		}
		echo "<br>";


	}

	//echo "INSERT INTO `btysesiones`(`sescodigo`, `sesmodulo`, `usucodigo`, `seslogin`, `sesdireccionipv4wan`, `sestipodispotivo`, `sesnavegador`, `sesfechainicio`, `seshorainicio`, `sesfechafin`, `seshorafin`, `sesfallida`, `sesestado`) VALUES ($cod, 'PUNTO DE VENTA',".$_SESSION['codigoUsuario']." ,'$nomb_us','$ipwan','$sist','$brow', CURDATE(),'CURTIME()','CURDATE()','CURTIME()',$fallo,$est)";

$sql=mysqli_query($conn,"INSERT INTO `btysesiones`(`sescodigo`, `sesmodulo`, `usucodigo`, `seslogin`, `sesdireccionipv4wan`, `sestipodispotivo`, `sesnavegador`, `sesfechainicio`, `seshorainicio`, `sesfechafin`, `seshorafin`, `sesfallida`, `sesestado`) VALUES ($cod, 'PUNTO DE VENTA',".$_SESSION['codigoUsuario']." ,'$nomb_us','$ipwan','$sist','$brow', CURDATE(),CURTIME(),CURDATE(),CURTIME(),$fallo,$est)")or die(mysqli_error($conn));
if ($sql) 
{
		echo "TRUE";
		echo "Error: " . $sql . "" . mysqli_error($conn);
		header("Location: ../../inicio.php");
} 
else 
{
		echo "Error: " . $sql . "" . mysqli_error($conn);
		//header("Location: ../../inicio.php");
}	
 
	/**
 * Función para detectar el sistema operativo, navegador y versión del mismo
 */
/**
 */
function detect()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WINDOWS","MAC","LINUX");
 
	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";
 
	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
		$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
		$f = $s + strlen($parent);
		$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
		$version = preg_replace('/[^0-9,.]/','',$version);
		if ($s)
		{
			$info['browser'] = $parent;
			$info['version'] = $version;
		}
	}
 
	# obtenemos el sistema operativo
	foreach($os as $val)
	{
		if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
			$info['os'] = $val;
	}
 
	# devolvemos el array de valores
	return $info;
}

 ?>
<?php 
if ($_POST['user_cod'] != ""){
	$cedula = $_POST['user_cod'];
	$primos =  array(3, 7, 13,17,19,23,29,37,41,43);
$sum = 0;
$j = strlen($cedula) - 1;
	for($i=0;$i<strlen($cedula);$i++){ 
		$sum = $sum+ ($primos[$j]*$cedula[$i]);
    	////echo $primos[$j]." x ".$cedula[$i]." = ".($primos[$j]*$cedula[$i])."<br>"; 
    	$j = $j - 1;
	} 
	//echo "--------------";
	//echo $sum;
	$dv = $sum % 11;
	//echo "<br>".$sum." MOD 11 = ".($dv);
	if ($dv != 1 and $dv !=0)
		$dv = 11 - $dv;
	}
	echo $dv;
	//echo "<br> El digito verificador es: ".$dv;  
?>
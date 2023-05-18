<?php 

	 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    function RevisarLogin() {
        if (! isset ( $_SESSION ['user_session'] )) {
            header ('Location:index.html');        
        }
    }

	function VerificarPrivilegio($Privilegio, $Perfil, $Db) 
	{
		$SqlPrivilegio = "SELECT p.pricodigo as pricodigo FROM btyprivilegioperfil AS pp, btyprivilegio AS p WHERE p.pricodigo=pp.pricodigo and pp.tiucodigo='" .$Perfil. "' and p.prinombre='".$Privilegio."'";
		$RsPrivilegio = mysqli_query ($Db,$SqlPrivilegio);
		$DatPrivilegio = mysqli_fetch_array($RsPrivilegio);
		
		if (is_null($DatPrivilegio ["pricodigo"] )) 
		{
		    echo "<script type='text/javascript'>window.top.location='noautorizado.php';</script>";
	        
		}
	}

	function privilegiologin($Privilegio, $Perfil, $Db) 
	{
		$SqlPrivilegio = "SELECT p.pricodigo as pricodigo FROM btyprivilegioperfil AS pp, btyprivilegio AS p WHERE p.pricodigo=pp.pricodigo and pp.tiucodigo='" .$Perfil. "' and p.prinombre='".$Privilegio."'";
		$RsPrivilegio = mysqli_query ($Db,$SqlPrivilegio);
		$DatPrivilegio = mysqli_fetch_array($RsPrivilegio);
		
		if (is_null($DatPrivilegio ["pricodigo"] )) 
		{
		    return false;
	        
		}else{
			return true;
		}
	}

	function generaPass()
	{

		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena=strlen($cadena);

		$pass = "";
		$longitudPass=8;

		for($i=1 ; $i<=$longitudPass ; $i++)
		{

		$pos=rand(0,$longitudCadena-1);

		$pass .= substr($cadena,$pos,1);
		}

		return $pass;
	}


	function getOS() 
	{ 

    		global $user_agent;

    		$os_platform    =   "Unknown OS Platform";

        	$os_array   =   array(
	            '/windows nt 10/i'      =>  'WINDOWS 10',
	            '/windows nt 6.3/i'     =>  'WINDOWS 8.1',
	            '/windows nt 6.2/i'     =>  'WINDOWS 8',
	            '/windows nt 6.1/i'     =>  'WINDOWS 7',
	            '/windows nt 6.0/i'     =>  'WINDOWS Vista',
	            '/windows nt 5.2/i'     =>  'WINDOWS Server 2003/XP x64',
	            '/windows nt 5.1/i'     =>  'WINDOWS XP',
	            '/windows xp/i'         =>  'WINDOWS XP',
	            '/windows nt 5.0/i'     =>  'WINDOWS 2000',
	            '/windows me/i'         =>  'WINDOWS ME',
	            '/win98/i'              =>  'WINDOWS 98',
	            '/win95/i'              =>  'WINDOWS 95',
	            '/win16/i'              =>  'WINDOWS 3.11',
	            '/macintosh|mac os x/i' =>  'MAC OS X',
	            '/mac_powerpc/i'        =>  'Mac OS 9',
	            '/linux/i'              =>  'LINUX',
	            '/ubuntu/i'             =>  'UBUNTU',
	            '/iphone/i'             =>  'IPHONE',
	            '/ipod/i'               =>  'IPOD',
	            '/ipad/i'               =>  'IPAD',
	            '/android/i'            =>  'ANDROID',
	            '/blackberry/i'         =>  'BLACKBERRY',
	            '/webos/i'              =>  'MOBILE'
        	);

        	foreach ($os_array as $regex => $value) 
	      { 
	            if (preg_match($regex, $user_agent)) 
	            {
	                $os_platform    =   $value;
	            }
	      }   

        	return $os_platform;
	}

	function getBrowser() 
	{

    		global $user_agent;

    		$browser        =   "Unknown Browser";

	    	$browser_array  =   array(
	        '/msie/i'       =>  'INTERNET EXPLORER',
	        '/firefox/i'    =>  'FIREFOX',
	        '/safari/i'     =>  'SAFARI',
	        '/chrome/i'     =>  'CHROME',
	        '/edge/i'       =>  'EDGE',
	        '/opera/i'      =>  'OPERA',
	        '/netscape/i'   =>  'NESTCAPE',
	        '/maxthon/i'    =>  'MAXTHON',
	        '/konqueror/i'  =>  'KONQUEROR',
	        '/mobile/i'     =>  'NAVEGADOR ANDROID'
	    	);

	    	foreach ($browser_array as $regex => $value) 
	    	{
	        	if (preg_match($regex, $user_agent)) 
	        	{
	            	$browser    =   $value;
	        	}
	    	}

    		return $browser;
	}


		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} 
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else 
		{
		    $ip = $_SERVER['REMOTE_ADDR'];
		}



		function utf8_converter($array)
		{
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
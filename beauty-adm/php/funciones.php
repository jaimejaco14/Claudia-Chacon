<?php
	 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    function RevisarLogin() {
        if (! isset ( $_SESSION ['user_session'] )) {
            header ('Location:./login.php');        
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

    function asistencia($tiporeg,$fecha,$codcol){

           if($tiporeg == 'ENTRADA'){
                $sql="SELECT 
                    (case 
                    when (time_to_Sec(subtime(tn.trndesde,ab.abmhora))<-(ap.abmingresodespues*60)) then 'RET'
                    when (time_to_Sec(subtime(tn.trndesde,ab.abmhora))>(ap.abmingresoantes*60)) then 'ADT'
                    else 'OK'
                    end ) as res
                    from btyasistencia_parametros ap,btyprogramacion_colaboradores col 
                    JOIN btyturno tn ON col.trncodigo=tn.trncodigo
                    JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo and col.prgfecha=ab.abmfecha
                    where ab.clbcodigo =$codcol and col.prgfecha='$fecha' and ab.abmtipo='ENTRADA'";

           }
           else if($tiporeg == 'SALIDA'){
                $sql="SELECT
                    (case 
                    when (time_to_Sec(subtime(ab.abmhora,tn.trnhasta))<-(ap.abmsalidaantes*60)) then 'ADT'
                    when (time_to_Sec(subtime(ab.abmhora,tn.trnhasta))>(ap.abmsalidadespues*60)) then 'DDT'
                    else 'OK'
                    end ) as res
                    from btyasistencia_parametros ap,btyprogramacion_colaboradores col 
                    JOIN btyturno tn ON col.trncodigo=tn.trncodigo
                    JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo and col.prgfecha=ab.abmfecha
                    where ab.clbcodigo =$codcol and col.prgfecha='$fecha' and ab.abmtipo='SALIDA'";
           }
            $row=$conn->query($sql);
            $res=$row->fetch_assoc();
            return $res['res'];

    }

    function disp_colab_cita($codcol, $fecha, $hora, $Db) 
    {
        $sql1="SELECT * FROM btycita WHERE clbcodigo=$codcol AND citfecha='$fecha' AND cithora='$hora'";
        $sql2="SELECT * FROM btypermisos_colaboradores WHERE clbcodigo=$codcol AND ('$fecha' BETWEEN perfecha_desde AND perfecha_hasta) AND ('$hora' BETWEEN perhora_desde AND perhora_hasta)";
        $res=mysqli_query($Db,$sql1);
        $rows=mysqli_num_rows($res);
        if($rows==0){
            $res2=mysqli_query($Db,$sql2);
            $rows2=mysqli_num_rows($res2);
            if($rows2==0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


	function Disponibilidad_colaborador ($codigo_Colaborador, $fecha, $hora_inicio, $hora_fin, $Db)
	{
		$query = "SELECT t.trndesde, t.trnhasta from btyprogramacion_colaboradores as pc, btysalon as s, btyturno as t where pc.clbcodigo='".$codigo_Colaborador."' and pc.prgfecha='".$fecha."' and pc.trncodigo=t.trncodigo and pc.slncodigo=s.slncodigo and (('".$hora_inicio."' between t.trndesde and t.trnhasta) or ('".$hora_fin."' between t.trndesde and t.trnhasta))";

		$disponibilidad       = mysqli_query ($Db,$query);
		$queryDisponibilidad  = mysqli_fetch_array($disponibilidad);

		if (is_null($queryDisponibilidad ["trndesde"] )) 
		{		    
			//print_r(true);
			//echo "<script>console.log('Valor: True');</script>";
			return true;

	    }
	    else
	    {
	    	//print_r(false);
	    	//echo "<script>console.log('Valor: False');</script>";
	    	return false;
	    }

		
	}

	function validarRegistroBio ($codigo_Colaborador, $fecha, $hora, $salon, $tipo, $Db)
	{
        $resp='';
        if((!is_numeric($codigo_Colaborador)) or ($tipo=='NO DEFINIDO')){
            $resp="error";
		}
        else
        {
            $query = "SELECT COUNT(*) FROM btyasistencia_biometrico a WHERE a.clbcodigo = $codigo_Colaborador AND a.slncodigo = $salon AND a.abmnuevotipo = '$tipo' AND a.abmfecha = '$fecha' AND a.abmhora = '$hora'";

            $registros = $Db->query($query); 
            $numrow  = $registros->fetch_array();

            if ($numrow[0] == 0)
            {           
                $resp="true";
            }
            else
            {
                $resp="false";
            }
        }
        return $resp;
	}

    function procesarbiometrico ($codCol, $turno, $horario, $salon, $mes, $abmcod, $apt, $Db)
    {
            $resp="";
            if($abmcod=='null'){
                $query="SELECT COUNT(*) FROM btyasistencia_procesada 
                    where clbcodigo =  $codCol
                    and   trncodigo =  $turno
                    and   horcodigo =  $horario
                    and   slncodigo =  $salon
                    and   prgfecha  =  '$mes'
                    and   aptcodigo =  $apt";
                $res=$Db->query($query);
                $numrow=$res->fetch_array();
                
                if ($numrow[0]==0)
                {           
                    $resp="ok";
                }
                else
                {
                    $resp="no";
                }
            }else{
                $antiduplic="SELECT count(*)
                            FROM btyasistencia_biometrico
                            WHERE clbcodigo = $codCol
                            AND slncodigo = $salon
                            AND abmfecha = '$mes' 
                            and abmcodigo=$abmcod
                            and abmcodigo NOT IN(
                            SELECT n1.abmcodigo
                            FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
                            WHERE n1.clbcodigo = n2.clbcodigo 
                            AND n1.abmnuevotipo=n2.abmnuevotipo 
                            AND n1.abmfecha=n2.abmfecha 
                            AND n1.abmhora > n2.abmhora 
                            AND n1.abmnuevotipo='ENTRADA' AND n1.slncodigo=$salon
                            UNION
                            SELECT n1.abmcodigo
                            FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
                            WHERE n1.clbcodigo = n2.clbcodigo 
                            AND n1.abmnuevotipo=n2.abmnuevotipo 
                            AND n1.abmfecha=n2.abmfecha 
                            AND n1.abmhora < n2.abmhora 
                            AND n1.abmnuevotipo='SALIDA' 
                            AND n1.slncodigo=$salon)";
                $datadup=$Db->query($antiduplic);
                $sw=$datadup->fetch_array();
                if($sw[0]==1){
                    $query="SELECT COUNT(*) FROM btyasistencia_procesada 
                        where clbcodigo =  $codCol
                        and   trncodigo =  $turno
                        and   horcodigo =  $horario
                        and   slncodigo =  $salon
                        and   prgfecha  =  '$mes'
                        and   abmcodigo =  $abmcod
                        and   aptcodigo =  $apt";
                    $res=$Db->query($query);
                    $numrow=$res->fetch_array();
                    
                    if ($numrow[0]==0)
                    {           
                        $resp="ok";
                    }
                    else
                    {
                        $resp="no";
                    }
                }else{
                    $resp="no";
                }
                
            }
            
            
        
        return $resp;
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
?>
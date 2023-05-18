<?php

include '../cnx_data.php';
function VerificarPrivilegio($Privilegio, $Perfil, $Db) 
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

if(VerificarPrivilegio("RESET CLAVE (ADM)", $_SESSION['tipo_u'], $conn)){

    function generaPass(){
        //Se define una cadena de caractares. Te recomiendo que uses esta.
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //Obtenemos la longitud de la cadena de caracteres
        $longitudCadena=strlen($cadena);
         
        //Se define la variable que va a contener la contraseña
        $pass = "";
        //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
        $longitudPass=10;
         
        //Creamos la contraseña
        for($i=1 ; $i<=$longitudPass ; $i++){
            //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
            $pos=rand(0,$longitudCadena-1);
         
            //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    $clave = generaPass();
    $clavecript= md5($clave);
    $fecha = date("Y-m-d");
    $codigo = $_POST['cod'];
    $sql = "UPDATE btyusuario SET usuclave='$clavecript', usufechaultcambioclave='$fecha' WHERE usucodigo = $codigo";
    if ($conn->query($sql)) {
        echo "TRUE,";
        echo $clave.",";
    }
}else{
    echo 'NOAUT';
}


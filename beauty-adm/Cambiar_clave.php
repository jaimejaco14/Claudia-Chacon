<?php
session_start();

if(!isset($_SESSION['user_session']))
{
	header("Location: index.php");
    
    
}

include '../cnx_data.php';


$fecha = getdate();
$usuario = $_SESSION['user_session'];
$newpass = $_POST["newpassword"];

$oldpass = md5($_POST["password"]);
$sql = "SELECT usulogin, usuclave from btyusuario where usulogin = '$usuario'";
$fecha_clave=date("Y-m-d");
//echo $usuario.' --< '.$oldpass;
if ($newpass != $_POST["password"]){
$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        
         while($row = $result->fetch_assoc()) {
             
            
        if ($row["usulogin"] == $usuario and $row["usuclave"] == $oldpass){
             //echo 'well';
            $sql = "UPDATE `btyusuario` SET `usuclave`= md5('$newpass'), usufechaultcambioclave = '$fecha_clave'  WHERE usulogin = '$usuario'";
        
            
            if ($conn->query($sql)) {
              //echo "Record updated successfully";
                $respuesta1 = "<h3>Su contraseña ha sido actualizada satisfactoriamente";
                $respuesta2 = "actualiza tu contraseña periodicamente para mayor seguridad";
                $_SESSION['Respuesta'] = '';
                } else {
                    $respuesta1 = "Vaya... Algo ha salido mal.";
                    $respuesta2 = "Por favor intente otra vez, si el problema persiste vuelva mas tarde.";
                    $_SESSION['Respuesta'] = '<div class="alert alert-danger">La contraseña actual es incorrecta</div>';
                    //echo "Error updating record: " . $conn->error;
                    
                    }

                
            
            
             
            
            
        } else{
            $_SESSION['Respuesta'] = '<div class="alert alert-danger">La contraseña actual es incorrecta</div>';
            header("Location: cambio_clave.php");
            

            //echo 'alert("LA contraseña introducida no es correcta");';
            ///echo 'window.locationf="cambio_clave.php";';
            //echo '</script>';
            //echo '<meta http-equiv="R   efresh" content=; url="" />';
            
        //echo "<H3>HOLAAAAAAAAAAAAAAAAAAAAAA".$codigo."</H3>";
        //$v6 = $row["tdicodigo"];
    }} }
    
    include 'respuesta.php';
} else {
    $_SESSION['Respuesta'] = '<div class="alert alert-danger">Nueva contraseña igual a contraseña anterior</div>';
     header("Location: cambio_clave.php");
}
//$sql = "UPDATE btyusuario SET usuclave='$newpass', usufechaultcambioclave='$fecha'  WHERE usulogin = '$usuario'";



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


<?php 
    session_start();
    include("php/conexion.php");
    $codigo = $_GET['slncodigo'];

    if ($_SESSION['cookiesln'] != $codigo) 
    {
        header("Location: index.php");
    }

  
 ?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="theme-color" content="#c9ad7d" />

    <!-- Page title -->
    <title>Beauty Soft ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../beauty/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../beauty/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../beauty/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../beauty/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="shortcut icon" type="image/ico" href="../beauty/imagenes/favicon.png" />

    <!-- App styles -->
    <link rel="stylesheet" href="../beauty/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../beauty/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../beauty/styles/style.css">
    <link rel="stylesheet" href="../beauty/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    
   

</head>
<body class="blank">


<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Beauty Soft ERP - INVELCON SAS</h1><p>Software de gestión integrada de recursos para negocios de servicios de belleza y estética</p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->





<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <img src="../beauty/images/claudia-chacon_logo-365.png">                
                <h3></h3>
                                
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <form  id="loginForm" name="loginForm" action="php/login/login_process.php" method="POST">
                    <div id="error">
                        <?php 
                        session_start();
                        $_SESSION['sw']=0;
                        echo $_SESSION['Respuesta'];
                        $_SESSION['Respuesta'] = "";
                        ?> <!-- error will be shown here ! --> 
                    </div>
                            <div class="form-group">
                                hola
                                <label class="control-label" for="username">Usuario</label>
                                <input type="text" placeholder="Usuario" title="Ingrese su usuario" required name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">                                
                                <label class="control-label" for="password">Contraseña</label>
                                <input type="password" title="Ingrese su contraseña" placeholder="******" required name="password" id="password" class="form-control">
                            </div>
                             <div class="form-group"> 
                                <label class="control-label" for="password">Salón</label>
                                <?php 
                                    $sql = mysqli_query($conn, "SELECT slnnombre FROM btysalon WHERE slncodigo = $codigo");
                                    $row = mysqli_fetch_array($sql);
                                    echo '<input type="text" id="salon" value="'.$row['slnnombre'].'" disabled class="form-control">';
                                    echo '<input type="hidden" value="'.$_GET['slncodigo'].'" name="sel_salones" id="sel_salones">';                               
                                 ?>
                                 <!-- <button type="button" id="btn_detectar" onclick="leerCookie_Traslado('Salon');" class="btn-link">Detectar salón</button> -->
                            </div>
                            <div class="form-group">
                            <select name="Db" id="input" class="form-control" required="required">
                                <?php include("conexionxml.php"); ?>
                            </select>
                        </div>
                            <div class="">
                                <input type="checkbox" class="i-checks" checked>
                                     Recordarme
                                <p class="help-block small">(Si este es un dispositivo privado)</p>
                                
                            </div>
                       <button id="btn-login" class="btn btn-success btn-block">Ingresar</button><br>
                        <div class="col-md-12" style="text-align: center;">
                            <button type="button" id="btn_recovery_pass" class="btn btn-success" data-toggle="modal" data-target="#modal_login_recovery_pass">¿Olvidó su contraseña?</button> 
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="" >
        <center>
            <a href="whatsapp://send?text=https://goo.gl/wxBwqG" data-action="share/whatsapp/share">
                <img border="0" src="../beauty/imagenes/logo_whatsapp.png" width="30" height="30">
            </a><br>
        </center>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center">
            <br><strong>©</strong>2017 Copyright INVELCON SAS<br/> <a href="http://www.claudiachacon.com" target="_blank">www.claudiachacon.com </a>
        </div>
    </div>
</div>




<!-- Vendor scripts -->
<script src="../beauty/vendor/jquery/dist/jquery.min.js"></script>
<script src="../beauty/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../beauty/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../beauty/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../beauty/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../beauty/vendor/iCheck/icheck.min.js"></script> 
<script src="../beauty/vendor/sparkline/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="../beauty/vendor/toastr/build/toastr.min.js"></script>
<!-- App scripts -->
<script src="../beauty/scripts/homer.js"></script>   
<script src="js/login.js"></script> 
<script src="../beauty/js/cookies.js"></script> 
</body>
</html>




<script>

/*$(document).ready(function() {

     if(window.location.href.indexOf("slncodigo") > 0) 
     {
        
     }
     else
    {
        swal({
            title: "Detectar el salón.",
            type: "info",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Detectar",
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () 
        {
       
            setTimeout(function () 
            {
                leerCookie_Traslado('Salon');
            }, 3000);
        });
    }


   
});*/


$(document).on('click', '#btn_recovery_pass', function() 
{
    swal({
        title: "Recuperar Contraseña",
        text: "Ingrese su Usuario",
        type: "input",
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Digite su usuario registrado",
    },
    function(inputValue){
        if (inputValue === false) return false;
      
        if (inputValue === "") {
            swal.showInputError("Debes ingresar tu usuario");
            return false
        }
            
        swal("Enhorabuena", "Te enviaremos una nueva contraseña a tu correo electronico.");
    });
    
});



</script>




<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title> WebApp | admin </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="styles/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>WebApp - Admin </h1><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php
session_start();
if ($_SESSION['record']=="true"){
    
    echo '<div class="color-line"></div>
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>Se ha enviado una nueva contraseña a su correo electronico</h3>
                <small>Por favor inicie session con nueva contraseña...</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <p>
                        Si no ha recibido ningun correo puedes intentar de nuevo con el siguiente enlace <a href="recovery.php" style="color: blue;">Click aqui</a>
                    </p>
                    <center><a href="login.php" class="btn btn-success">Ya recibì mi nueva contraseña</a></center>
                    
                </div>
            </div>
        </div>
    </div>
   <div class="row">
        <div class="col-md-12 text-center">
            <strong>©</strong>2017 Copyright Claudia Chacón<br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
        </div>
    </div>
</div>';

} else {
    echo '<div class="color-line"></div>
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>Recuperar contraseña</h3>
                <small>Complete la informacion para recuperar su contraseña</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    <p>
                        Ingrese su nombre de usuario, enviaremos una nueva contraseña a su correo electronico
                    </p>
                    <form action="recovery.php" id="loginForm" method="post">
                            <div class="form-group">
                                <label class="control-label" for="username">Usuario</label>
                                <input type="text" placeholder="nombre de usuario" title="Ingrese su nombre de usuario" required="" value="" name="username" id="username" class="form-control">
                                <div id="Info" class="help-block with-errors"></div>
                                <span class="help-block small">Su usuario registrado</span>
                            </div>

                            <button class="btn btn-success btn-block">Restablecer contraseña</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
   <div class="row">
        <div class="col-md-12 text-center">
            <strong>©</strong>2017 Copyright Claudia Chacón<br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
        </div>
    </div>
</div>';
    
}

?>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>
$(document).ready(function() {
    function validar () {
        var username = $('#username').val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "check_pass.php",
            data: dataString,
            success: function(data) {
                $('#Info').fadeIn(1000).html(data);
            }
        });
    }  
   $('#username').change(function(){
        validar();
    }); 
   $('#username').keypress(function(){
        validar();
    }); 
   $('#username').blur(function(){
        validar();
    }); 
});
</script>

</body>
</html>
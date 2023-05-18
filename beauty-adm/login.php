<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="theme-color" content="#c9ad7d" />

    <title>Beauty ERP - Administrador de Recursos para Pymes de Belleza y Estética</title>


    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    
   

</head>
<body class="blank">


<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Beauty ERP - INVELCON SAS</h1><p>Administracion de recursos para Pymes de Belleza y Estetica</p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>

<div class="login-container" style="padding-top: 2%!important">
    <div class="row">
        <div class="col-md-12">
            <div class="hpanel">
                <div class="panel-body">
                    <a href="../"><img class="img-responsive" src="../contenidos/images/logo_beauty_horizontal.png"></a><br>
                        <form  id="" name="" action="">
                            <div class="form-group">
                                <label class="control-label" for="username">Usuario</label>
                                <input type="text" placeholder="Digite su usuario" title="Ingrese su usuario." name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">                                
                                <label class="control-label" for="password">Contraseña</label>
                                <input type="password" title="Ingrese su contraseña." placeholder="******" name="password" id="password" class="form-control">
                            </div>
                             <div class="form-group">
                                <select name="Db" id="Db" class="form-control" required="required">
                                    <?php include("./conexionxml.php"); ?>
                                </select>
                            </div> 
                            <button id="btn_login" type="button" name="btn-login" class="btn btn-success btn-block">Ingresar</button><br>
                            <div class="">
                                <a class="succes" style="color: blue;" href="recuperar_contraseña.php">¿Olvidó su contraseña?</a>                                
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-12 text-center">
            <br><strong>Copyright ©<script>var f = new Date(); document.write(f.getFullYear())</script> INVELCON S.A.S </strong><br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script> 
<script src="../lib/vendor/sparkline/index.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>
<script src="js/login.js"></script>
  
</body>
</html>
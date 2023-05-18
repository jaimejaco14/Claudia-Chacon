<?php 
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
session_start();
if(isset($_COOKIE['datacookie'])){
    $jsoncookie=json_decode($_COOKIE['datacookie']);
    if($jsoncookie->logstatus == 1){
        header('location: inicio.php');
    }
}else if(isset($_SESSION['clbcodigo'])){
    header('location: inicio.php');
}
//print_r($_COOKIE);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="theme-color" content="#c9ad7d" />

    <title>BeautySoft | Colaboradores</title>


    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />
    <link rel="stylesheet" href="js/sweetalert.min.css" />
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />

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
                    <img src="../contenidos/images/logo_beauty_horizontal.png" class="img-responsive"><br>
                        <form  id="" name="" action="">
                            <div class="form-group">
                                 <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-user"></i></span> <input type="text" placeholder="Usuario" class="form-control" id="username"></div>
                            </div>
                            <div class="form-group">                                
                                 <div class="input-group m-b"><span class="input-group-addon"><i class="fa fa-lock"></i></span> <input type="password" placeholder="Contraseña" id="password" class="form-control"></div>
                            </div> 
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><input type="checkbox" id="rememb" checked></span><input value="Mantener la sesion iniciada" class="form-control" readonly>
                                </div>
                                <small>Active si no desea volver a digitar su usuario y clave</small>
                            </div>
                            <button id="btn_login" type="button" name="btn-login" class="btn btn-success btn-block">Ingresar</button><br>
                            <div class="">
                                <center><button type="button" id="btn_recovery_pass" class="btn btn-info" data-toggle="modal" data-target="#modal_login_recovery_pass">¿Olvidó su contraseña?</button></center>                             
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
<!-- <script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script> -->
<script src="js/sweetalert.min.js"></script>

<script src="../lib/vendor/toastr/build/toastr.min.js"></script>

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>
<script src="js/login.js"></script>
  
</body>
</html>

<script>
    $(document).on('click', '#btn_recovery_pass', function() 
{

    swal({
        title: "Recuperar Contraseña",
        text: "E-mail",
        type: "input",
        closeOnConfirm: false,
        animation: "slide-from-top",
        inputPlaceholder: "Por favor ingrese su e-mail",
    },
    function(inputValue)
    {
        var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        var Db    = $('#Db').val();

        if (inputValue === false) return false;
      
        if (inputValue === "") 
        {
            swal.showInputError("Debe ingresar su e-mail");
            return false;
        }
        else
        { 
            if (!regex.test(inputValue.trim())) 
            {
                 swal.showInputError("Ingrese un e-mail válido");
            }
            else
            {
                $.ajax({
                    url: 'php/cambioclave/process.php',
                    method: 'POST',
                    data: {email:inputValue, opcion: "recovery"},
                    success: function (data) 
                    {
                        if (data == 1) 
                        {   
                            swal("Aviso", "Te enviaremos una nueva contraseña a tu correo electronico.", "success");
                        }
                        else
                        {
                            swal("Atención","Este e-mail no se encuentra registrado. Intente de nuevo", "error");
                        }
                    }
                });  
               
            }
        }
    });
    
});
</script>
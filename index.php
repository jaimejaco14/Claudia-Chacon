<?php
$str = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$var =explode("//",explode(".",$str)[0])[1];
if($var!="beauty"){
  //header('location:claudiachacon.com/');
}
?>
<!DOCTYPE html>
<html>
<head>
   

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty SOFT - ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <link rel="shortcut icon" type="image/ico" href="contenidos/imagenes/favicon.png" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="./lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="./lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="./lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="./lib/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="./lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="./lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="./lib/styles/style.css">

</head>
<body class="blank">

<!-- Simple splash screen-->
<!-- <div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div> -->
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- <div class="color-line"></div> -->
<div class="login-container" style="padding-top: 0%!important">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
               
            </div>
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                
                            </div>
                        </div>
                    </div>
            <div class="hpanel">
                <div class="panel-body">                  
                        <form action="#" id="loginForm">
                           <!--  <div class="form-group">
                               <select name="" id="sel_init" class="form-control" required="required">
                                   <option value="0" selected>MÓDULO ADMINISTRATIVO</option>
                                   <option value="1">MÓDULO PUNTO DE VENTA</option>
                               </select>
                           </div> -->
                            <div class="color-line"></div>
                                <div class="modal-header text-center">
                                    <h4 class="modal-title"><b>BEAUTY SOFT</b><br></h3><b>ADMINISTRADOR DE RECURSOS PARA PYMES DE BELLEZA Y EST&Eacute;TICA</b><br><br></h4>
                                    <center>
                                    <img src="./contenidos/images/logo_beauty.png" class="img-responsive">
                                    </center>
                                    <small class="font-bold"></small>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                       <select name="" id="sel_init" class="form-control" required="required">
                                           <option value="0" selected>MÓDULO ADMINISTRATIVO</option>
                                           <option value="3">MÓDULO GESTIÓN HUMANA</option>
                                           <option value="2">MÓDULO MANTENIMIENTO</option>
                                           <option value="1">MÓDULO PUNTO DE VENTA</option>
                                       </select>
                                    </div> 
                                </div>                               

                            <button type="button" class="btn h-bg-blue btn-block btn_init" style="color: white"><i class="fa fa-paper-plane"></i> ACCEDER</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Vendor scripts -->
<script src="./lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="./lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="./lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="./lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="./lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="./lib/vendor/iCheck/icheck.min.js"></script>
<script src="./lib/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="./lib/scripts/homer.js"></script>

<script>
    $(document).on('click', '.btn_init', function() 
    {
        var opcion = $('#sel_init').val();
        switch(opcion){
            case "0":
            window.location="./beauty-adm/";
            break;

            case "1":
            window.location="./beauty-pdv/";
            break;

            case "2":
            window.location="./beauty-mantenimiento/";
            break;

            case "3":
            window.location="./beauty-rrhh/";
            break;
        }
    });
</script>

</body>
</html>
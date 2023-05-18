<?php 
header('location:claudiachacon.com/');
exit;
 ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty Soft</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">

</head>
<body class="landing-page" style="position: relative;">


<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>BIENVENIDOS A BEAUTY SOFT</h1><p>ADMINISTRADOR DE RECURSOS PARA PYMES DE BELLEZA Y ESTÉTICA </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.html" class="navbar-brand">HOMER</a>
            <div class="brand-desc">
                Landing page for Homer app
            </div>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a class="page-scroll" href="#page-top">Home</a></li>
                <li><a class="page-scroll" page-scroll href="#components">UI</a></li>
                <li><a class="page-scroll" page-scroll href="#features">Features</a></li>
                <li><a class="page-scroll" page-scroll href="#team">Team</a></li>
                <li><a class="page-scroll" page-scroll href="#pricing">Pricing </a></li>
                <li><a class="page-scroll" page-scroll href="#clients">Clients </a></li>
                <li><a class="page-scroll" page-scroll href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav> -->


            <center><h1 style="padding-top: 30px; font-weight: bold">
                BEAUTY SOFT
            </h1>
            <span>ADMINISTRADOR DE RECURSOS PARA PYMES DE <br> BELLEZA Y ESTÉTICA</span></center>


<div class="container-fluid" style="padding-top: 20px">
    <div class="content animate-panel">
            <div class="row">
                <div class="col-md-3">
                        <div class="hpanel hbgviolet">
                            <div class="panel-body">
                                <a href="javascript:void(0)" id="btnGoCitas" title="Click para agendar citas" style="color: white">
                                        <div class="text-center">
                                            <h3>CITAS</h3>
                                            <p class="text-big font-light">
                                                <i class="pe pe-7s-pen" style="color: white"></i>
                                            </p>
                                            <small>
                                                En este módulo puede registrar citas
                                            </small>
                                        </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="col-md-3">
                        <div class="hpanel hbgyellow">
                            <div class="panel-body">
                                <a href="javascript:void(0)" id="btnGoClientes" title="Click para registrarse" style="color: white">
                                        <div class="text-center">
                                            <h3>CLIENTES</h3>
                                            <p class="text-big font-light">
                                                <i class="pe-7s-add-user" style="color: white"></i>
                                            </p>
                                            <small>
                                                En este módulo puede registrarse.
                                            </small>
                                        </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="col-md-3">
                        <div class="hpanel hbgred">
                            <div class="panel-body">
                                <a href="javascript:void(0)" id="btnPQRF" title="Click para radicar un PQRF" style="color: white">
                                        <div class="text-center">
                                            <h3>PQRF</h3>
                                            <p class="text-big font-light">
                                                <i class="pe-7s-mail-open-file" style="color: white"></i>
                                            </p>
                                            <small>
                                                En este módulo puede radicar PQRF.
                                            </small>
                                        </div>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="col-md-3">
                        <div class="hpanel hbgred">
                            <div class="panel-body" style="background-color: #74d348!important">
                                <a href="javascript:void(0)" id="" data-toggle="modal" data-target="#modalLogin" title="Click para agendar una cita" style="color: white">
                                        <div class="text-center">
                                            <h3>RESERVAS</h3>
                                            <p class="text-big font-light">
                                                <i class="pe-7s-notebook" style="color: white"></i>
                                            </p>
                                            <small>
                                                En este módulo puede reservar citas.
                                            </small>
                                        </div>
                                </a>
                            </div>
                        </div>
                </div>
            </div>
      </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLogin"  role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Iniciar Sesión</h4>
      </div>
      <div class="modal-body">
          <div class="panel panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title"></h3>
              </div>
              <div class="panel-body">
                    <form action="" method="POST" role="form">
                    
                        <div class="form-group">
                            <label for="">Documento de Identidad</label>
                            <input type="text" class="form-control" id="docIdentidad" placeholder="Documento de Identidad">
                        </div>
                        <div class="form-group">
                            <label for="">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" placeholder="Contraseña">
                        </div>
                    </form>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnSesion">Ingresar</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer-->
 <footer class="footer" style="position: fixed;"">
    <span class="pull-right">
       <b> Derechos Reservados 2018</b>
    </span>
    <b>BEAUTY SOFT</b> 
</footer>
<script src="js/main.js"></script>

<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>

<script src="js/main.js"></script>
<script src="js/login.js"></script>


</body>
</html>

<style type="text/css" media="screen">
    .landing-page header {
    background: #fff!important;
    height: 570px!important;
    padding-top: 50px;
    margin-bottom: 30px;
}

.landing-page .heading {
    margin-top: 60px;
    color: #555;
}
</style>
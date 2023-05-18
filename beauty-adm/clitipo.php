<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty</title>

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
<body class="landing-page">

<!-- Simple splash screen-->
<div class="splash">
 <div class="color-line"></div>
 <div class="splash-title"><h1>Cargando...</h1>
<div class="spinner"> 
<div class="rect1"></div> 
<div class="rect2"></div> 
<div class="rect3"></div> 
<div class="rect4"></div> 
<div class="rect5"></div> 
</div> 
</div> 
</div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->




<center><img class="img-animate" src="../contenidos/images/logo_beauty_horizontal.png"></center>


<section id="clients">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-6 col-md-offset-3">
                <h2>Nos gustaría saber qué tipo de cliente es usted</h2>
                <p>
                    ¿Es usted persona o empresa? Seleccione el tipo de cliente y registre sus datos para empezar a disfrutar los beneficios de ser cliente de Claudia Chacón.
                </p>
            </div>
        </div>

        <div class="row text-center m-t-lg">
            <div class="col-md-6 col-md-offset-3">

                <div class="row">




                       <a href="registro.php?cli_type=Persona">     
                    <div class="col-md-6">
                        <div class="client">Persona</div>
                    </div>
                    </a>
                    <a href="registro.php?cli_type=Empresa">
                    <div class="col-md-6">
                        <div class="client">Empresa</div>
                    </div>
                    </a>
                    

                </div>

                

            </div>

        </div>


    </div>
</section>

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

<!-- Local script for menu handle -->
<!-- It can be also directive -->
<script>
    $(document).ready(function () {
        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
        });

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

    });
</script>

</body>
</html>
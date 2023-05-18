<?php
    //session_start(); 
    include '../cnx_data.php';
    include 'php/funciones.php';
    RevisarLogin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <!-- Page title -->
    <title>Beauty Soft ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />

    <!-- Vendor styles -->
    
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
     <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="../lib/vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="../lib/vendor/select2-bootstrap/select2-bootstrap.css" />

    <link rel="stylesheet" href="../lib/vendor/fullcalendar/dist/fullcalendar.print.css" media="print"/>
    <link rel="stylesheet" href="../lib/vendor/fullcalendar/dist/fullcalendar.min.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="js/selectpicker/selectpicker.css" />
    

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">
    
<!--     <script src="https://www.google.com/recaptcha/api.js?hl=es"></script> -->

</head>

<body class="fixed-navbar fixed-sidebar hide-sidebar" style="position:relative;" id="body" onload="autoblock();">
<input type="hidden" id="codColaborador" value="<?php echo $_SESSION['clbcodigo']; ?>">
<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            BEAUTY
        </span>
    </div>
    <nav role="navigation">
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown" title="Cerrar Sesión">
                    <a href="logout.php" >
                        <i class="pe-7s-power"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Navigation -->
<!-- <aside id="menu" style="background-color: #FFF">
     <div id="navigation">
         <div class="profile-picture">
             <div class="stats-label text-color">
                 <span class="font-extra-bold font-uppercase"><?php echo $_SESSION['nombre']; ?></span>
 
                 <div class="dropdown">
                     <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                         <small class="text-muted">Mi perfil <b class="caret"></b></small>
                     </a>
                     <ul class="dropdown-menu animated flipInX m-t-xs">
                         <li><a href="logout.php" title="Cerrar Sesión">Cerrar sesión <i class="pe-7s-sign-out"></i></a></li>
                     </ul>
                 </div>
 
 
             </div>
         </div>
         <input type="hidden" id="trcdocumento" value="<?php echo $_SESSION['documento'];?>">
         <ul class="nav" id="side-menu">
             <li id="INICIO" class="active">
                 <a href="inicio.php"> <span class="nav-label">INICIO</span> </a>
             </li>
         </ul>
 
     </div>
 </aside> --> 

<!-- Right sidebar -->
    
    
<div id="wrapper">

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script>


function lo () {
    //var url = document.location.href.match(/[^\/]+$/)[0];
    var href = document.location.href;
    var url = href.substr(href.lastIndexOf('/') + 1);
    var usu = "<?php echo $usuario;?>";
    var datastring="url="+url;
    $.ajax({
        url: 'logout.php',
        method: 'POST',
        data: datastring,
        success: function (data) 
        {
            //window.location="bloquear_pantalla.php?url="+url+"";
            window.location="logout.php";
        }
    });
}


function autoblock(){

    function redireccion() {
       lo();
    }

    var temp = setTimeout(redireccion, 1.8e+6);
    //var temp = setTimeout(redireccion, 60000);

    document.addEventListener("mousemove", function() {
        clearTimeout(temp);
        temp = setTimeout(redireccion, 1.8e+6);
        //temp = setTimeout(redireccion, 60000);
    });
    document.addEventListener("keypress", function() {
        clearTimeout(temp);
        temp = setTimeout(redireccion, 1.8e+6);
        //temp = setTimeout(redireccion, 60000);
    });
}

</script>


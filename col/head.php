<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
include '../cnx_data.php';
if(isset($_COOKIE['datacookie'])){
    $jsoncookie=json_decode($_COOKIE['datacookie']);
    if($jsoncookie->logstatus==1){
        $_SESSION['clbcodigo']      = $jsoncookie->codcol;
        $_SESSION['trcdocumento']   = $jsoncookie->idnum;
        $_SESSION['nombre']         = $jsoncookie->nombre;           
        $_SESSION['apellido']       = $jsoncookie->apellido;         
        $_SESSION['incluturno']     = $jsoncookie->sb;       
        $_SESSION['cargo']          = $jsoncookie->cargo;           
        $_SESSION['email']          = $jsoncookie->email;            
        $_SESSION['categoria']      = $jsoncookie->categoria;
        
    }else{
        header("Location: index.php");
    }
}else if(!isset($_SESSION['clbcodigo'])){
    header("Location: index.php");
    exit;
}

include 'php/funciones.php';
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
    <title>BeautySoft | Colaboradores</title>

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
    

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">
    
    <!--     <script src="https://www.google.com/recaptcha/api.js?hl=es"></script> -->
    <style type="text/css" media="screen">
        @media only screen and (max-width: 600px) {
    .datepicker,
    .table-condensed {
        width: 300px;
        height:300px;
        font-size:18px!important;
        }
    }
    footer {
    position: absolute!important;
    bottom: 0!important;
    left: 0!important;
    right: 0!important;
    z-index: $zindex-fixed!important;
}
    </style>
</head>

<body class="bodys fixed-navbar fixed-sidebar hide-sidebar" style="background-color: #F1F3F6;" id="body">
<input type="hidden" id="codColaborador" value="<?php echo $_SESSION['clbcodigo']; ?>">

<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Beauty ERP - INVELCON SAS</h1><p>Cargando, por favor espere...</p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
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
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">BEAUTYSOFT</span>
        </div>

        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown" id="" style="display: block">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <p style="font-size: .8em"><?php echo $_SESSION['categoria']; ?></p>
                    </a>
                    
                </li> 

                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-keypad"></i>
                    </a>

                    <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                        <table>
                            <tbody>
                            <tr>
                                <td>
                                    <a href="inicio.php">
                                        <i class="pe pe-7s-home text-info"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                        $html=''; 
                                        if ($_SESSION['incluturno'] != 0) 
                                        {
                                            $html.='
                                               <a href="agenda.php">
                                                    <i class="pe pe-7s-pen violet" style="color: #9b59b6!important"></i>
                                                    <h5>Agenda</h5>
                                                </a>     
                                            ';
                                            echo $html;
                                        }
                                        else
                                        {
                                            $html.='
                                               <a href="javascript:void(0)">
                                                    <i class="pe pe-7s-pen violet" style="color: #9b59b6!important"></i>
                                                    <h5>Agenda</h5>
                                                </a>     
                                            ';
                                            echo $html;
                                        }
                                        
                                     ?>

                                      <td>
                                    <a href="biometrico.php">
                                        <i class="pe-7s-display1 text-warning" style="color: #34495e!important"></i>
                                        <h5>Ajuste de contrato</h5>
                                    </a>
                                </td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="novedades.php">
                                        <i class="pe-7s-note2 text-warning"></i>
                                        <h5>Novedades</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="permisos.php">
                                        <i class="pe-7s-coffee text-danger"></i>
                                        <h5>Suspension de contrato</h5>
                                    </a>
                                </td>

                                <td>
                                    <a href="programacion.php">
                                        <i class="pe-7s-note2 text-danger" style="color:#74d348!important"></i>
                                        <h5>Programación</h5>
                                    </a>
                                </td>

                               
                                                             
                            </tr>

                            <tr>
                               
                                <td>
                                    <?php 
                                        $html=''; 
                                        if ($_SESSION['incluturno'] != 0) 
                                        {
                                           $html.='
                                               <a href="servicios.php">
                                                <i class="pe-7s-scissors" style="color: #3498db!important"></i>
                                                <h5>Servicios</h5>
                                            </a>    
                                            ';
                                            echo $html;
                                        }
                                        else
                                        {
                                            $html.='
                                               <a href="javascript:void(0)">
                                                <i class="pe-7s-scissors" style="color: #3498db!important"></i>
                                                <h5>Servicios</h5>
                                            </a>    
                                            ';
                                            echo $html;
                                        }
            
                                     ?>
                                </td> 

                                <td>
                                    <a href="javascript:void(0)">
                                        <i class="pe-7s-file" style="color:#f500c5!important"></i>
                                        <h5>Instructivo</h5>
                                    </a>
                                </td> 
                           </tr> 
                           
                            </tbody>
                        </table>
                    </div>
                </li>

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
<aside id="menu" style="background-color: #FFF">
    <div id="navigation">
        <div class="profile-picture">
            <img src="../contenidos/imagenes/colaborador/beauty_erp/<?php echo $_SESSION['trcdocumento'];  ?>.jpg" class="img-circle m-b" alt="logo" style="width: 70px; height: 70px">
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo $_SESSION['nombre']; ?></span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Mi perfil <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="cambio_clave.php">Cambio de clave</a></li>
                        <li><a href="logout.php" title="Cerrar Sesión">Cerrar sesión <i class="pe-7s-sign-out"></i></a></li>
                    </ul>
                </div>


            </div>
        </div>
        <input type="hidden" id="trcdocumento" value="<?php echo $_SESSION['documento'] ?>">
        <ul class="nav" id="side-menu">
            <li id="INICIO" class="active ">
                <a href="inicio.php" class="opcmenu"> <span class="nav-label">INICIO</span> </a>
            </li>

                <?php
                    $html='';

                    if ($_SESSION['incluturno'] != 0) 
                    {
                        $html.='<li id="AGENDA" class=""><a href="agenda.php" class="opcmenu"><span class="nav-label">AGENDA</span></a></li>';
                        echo $html;
                    }
                ?>

            <li id="BIOMETRICO" class="">
                <a href="biometrico.php" class="opcmenu"> <span class="nav-label">AJUSTE DE CONTRATO</span></a>
            </li>

            <li id="PERMISOS" class="">
                <a href="permisos.php" class="opcmenu"> <span class="nav-label">INTERRUPCION POR AUSENCIA</span></a>
            </li>
            <li id="PROGRAMACION" class="">
                <a href="programacion.php" class="opcmenu"> <span class="nav-label">PROGRAMACIÓN</span></a>
            </li>            

                <?php
                    $html='';

                    if ($_SESSION['incluturno'] != 0) 
                    {
                        $html.='
                            <li id="SERVICIOS" class=""><a href="servicios.php" class="opcmenu"> <span class="nav-label">SERVICIOS</span></a></li>';
                        echo $html;
                    }                   
                 ?>
                

            <li id="SOLICITUDES" class="">
                <a href="solicitudes.php" class="opcmenu"> <span class="nav-label">SOLICITUDES</span></a>
            </li>  
            <li id="SALIR" class="">
                <a href="logout.php" class="opcmenu"> <span class="nav-label">SALIR <i class="fa fa-sign-out pull-right"></i></span></a>
            </li>   
        </ul>

    </div>
    
</aside>


    <!-- Right sidebar -->
   
    
<div id="wrapper">


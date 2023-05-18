<?php
include '../cnx_data.php';
include 'php/funciones.php';

RevisarLogin();


$usuario = $_SESSION['user_session'];

$sql = mysqli_query($conn, "SELECT trcnombres, trcdocumento FROM btytercero WHERE trcdocumento IN (SELECT trcdocumento FROM btyusuario WHERE usulogin ='$usuario')"); 

$row = mysqli_fetch_array($sql);

$name = $row['trcnombres'];

//header("HTTP/1.1 202 Accepted");

//$_SESSION['modulo'] = basename($_SERVER['PHP_SELF']);
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<head> 
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <!-- Page title -->
    <title>Beauty | ERP Invelcon SAS</title>

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
    <link rel="stylesheet" href="../lib/vendor/multiselect/multiselect.css" />
    

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">
    <link rel="stylesheet" href="js/selectpicker/selectpicker.css">


    

    
    
<!--     <script src="https://www.google.com/recaptcha/api.js?hl=es"></script> -->
<style>
  .modal-open {
overflow: visible !important;
}
</style>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  var OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "2ec6dece-1677-4f68-b654-3f2e6f8c7688",
      notifyButton: {
        enable: true,
      },
    });
  });
</script>
</head>

<body class="fixed-navbar fixed-sidebar hide-sidebar" style="background-color: #F1F3F6;position: relative;" id="body" onload="autoblock();">
<input type="hidden" id="db" value="<?php echo $_SESSION['Db']; ?>">

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
            <span class="text-primary">BEAUTY</span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="Buscar..." class="form-control" name="search">
            </div>
        </form>
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="" href="#">Link</a>
                    </li>
                    <li>
                        <a class="" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li class="dropdown" id="li_acme" style="display: block">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <p style="font-size: .9em"></p>
                    </a>
                   
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-config"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown notification animated flipInX">
                        <li>
                            <a href="cookies.php">
                                <span class="label label-warning">COOKIES</span>Configuración de equipos
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-warning">WAR</span> There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="label label-danger">ERR</span> Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See all notifications</a></li>
                    </ul>
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
                                    <a href="projects.html">
                                        <i class="pe pe-7s-portfolio text-info"></i>
                                        <h5>Projects</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="mailbox.html">
                                        <i class="pe pe-7s-mail text-warning"></i>
                                        <h5>Email</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="contacts.html">
                                        <i class="pe pe-7s-users text-success"></i>
                                        <h5>Contacts</h5>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="forum.html">
                                        <i class="pe pe-7s-comment text-info"></i>
                                        <h5>Forum</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="analytics.html">
                                        <i class="pe pe-7s-graph1 text-danger"></i>
                                        <h5>Analytics</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="file_manager.html">
                                        <i class="pe pe-7s-box1 text-success"></i>
                                        <h5>Files</h5>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a type="" id="" onclick="lo();" title="Bloquear pantalla" class="Bloquear">
                                        <i class="pe pe-7s-lock text-danger"></i>
                                        <h5>Bloquear</h5>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="#" data-toggle="dropdown">
                        <i class="pe-7s-mail"></i>
                        <span class="label label-success">4</span>
                    </a>
                    <ul class="dropdown-menu hdropdown animated flipInX">
                        <div class="title">
                            You have 4 new messages
                        </div>
                        <li>
                            <a>
                                It is a long established.
                            </a>
                        </li>
                        <li>
                            <a>
                                There are many variations.
                            </a>
                        </li>
                        <li>
                            <a>
                                Lorem Ipsum is simply dummy.
                            </a>
                        </li>
                        <li>
                            <a>
                                Contrary to popular belief.
                            </a>
                        </li>
                        <li class="summary"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" id="sidebar" class="right-sidebar-toggle">
                        <i class="pe-7s-upload pe-7s-news-paper"></i>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="logout.php" >
                        <i class="pe-7s-upload pe-rotate-90"></i>
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

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo $name ?></span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Mi perfil <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <!-- <li><a href="bloquear_pantalla.php">Bloquear pantalla</a></li> -->
                        <li><a onclick="privilegio(<?php echo $_SESSION['documento'] ?>, 2)">Cambio de clave</a></li>
                        <li><a href="logout.php">Cerrar sesión <i class="pe-7s-sign-out"></i></a></li>
                    </ul>
                </div>


            </div>
        </div>
        <input type="hidden" id="trcdocumento" value="<?php echo $_SESSION['documento'] ?>">
        <ul class="nav" id="side-menu">
            <li id="INICIO" class="active">
                <a href="index.php"> <span class="nav-label">INICIO</span> <span class="label label-success pull-right">start</span> </a>
            </li>

           <!--  <li id="BIOMETRICO">
               <a href="#"><span class="nav-label">BIOMETRICO</span><span class="fa arrow"></span> </a>
               <ul class="nav nav-second-level">
                   <li id="BIOMETRICO"><a href="leercsv.php"> <span class="nav-label">CARGAR CSV</span> </a></li> 
                   <li id="BIOMETRICO"><a href="parametro_asistencia.php">PARAMETROS DE ASISTENCIA</a></li>  
                   <li id="BIOMETRICO"><a href="procesar_asistencia.php"><span class="nav-label">PROCESAMIENTO DE ASISTENCIA</span></a></li> 
                   <li id="BIOMETRICO"><a href="reporte_asistencia_individual.php"><span class="nav-label">REPORTE INDIVIDUAL</span></a></li>
                   <li id="BIOMETRICO"><a href="reporte_asistencia_general.php"><span class="nav-label">REPORTE GENERAL</span></a></li>      
                   <li id="BIOMETRICO"><a href="fechas_especiales.php"> <span class="nav-label">FECHAS ESPECIALES</span> </a></li>  
               </ul> 
           </li> -->
            <!-- <li id="CLIENTES">
                <a href="#"><span class="nav-label">CLIENTES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                        
                </ul> 
            </li>  -->
                  
            <li id="COLABORADORES">
                <a href="#"><span class="nav-label">COLABORADORES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="COLABORADOR"><a href="config_solicitudes.php"> <span class="nav-label">SOLICITUDES</span> </a></li>
                </ul>
            </li> 
            <li id="COMERCIAL">
                <a href="#"><span class="nav-label">COMERCIAL</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="CLIENTE"><a href="cliview.php"> <span class="nav-label">CLIENTE</span> </a></li> 
                    <li id="PROMOCIONES"><a href="promociones.php"> <span class="nav-label">PROMOCIONES</span> </a></li>
                    <li id="PQRF"><a href="gestionpqrf.php">PQRF</a></li> 
                    <li id="BONOS"><a href="bonos.php">BONOS REGALO</a></li>    
                </ul>
            </li>
            <!-- <li id="CONTABILIDAD">
                <a href="#"><span class="nav-label">CONTABILIDAD</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                </ul>
            </li> -->
           <!--  <li id="FECHAS ESPECIALES">    
               <a href="fechas_especiales.php"> <span class="nav-label">FECHAS ESPECIALES</span> </a>
           </li>   -->
            <li id="INVENTARIO">
                <a href="#"><span class="nav-label">INVENTARIO</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                     <li id="BODEGA"><a href="bodega.php"> <span class="nav-label">BODEGA</span></a></li>
                     <li id="CARACTERISTICA"><a href="caracteristica.php"> <span class="nav-label">CARACTERISTICA</span> </a></li>
                     <li id="GRUPO"><a href="grupo.php"> <span class="nav-label">GRUPO</span></a></li>
                     <li id="IVA"><a href="iva.php"> <span class="nav-label">IVA</span> </a></li>
                     <li id="LINEA"><a href=linea.php> <span class="nav-label">LINEA</span></a></li>
                     <li id="LISTAPRECIOS"><a href="listaPrecios.php">  <span class="nav-label"></span>LISTA DE PRECIOS </a></li>                     
                     <li id="PRODUCTOS"><a href="productos.php"> <span class="nav-label">PRODUCTOS</span></a></li>
                     <li id="PROVEEDORES"><a href="proveedores.php"> <span class="nav-label">PROVEEDORES</span></a></li>
                      <li id="SERVICIOS"><a value="servicios.php" href="servicios.php"><span class="nav-label">SERVICIOS</span></a></li>
                     <li id="SUBGRUPO"><a href="subgrupo.php"> <span class="nav-label">SUBGRUPO</span></a></li>
                     <li id="SUBLINEA"><a href="sublinea.php"> <span class="nav-label">SUBLINEA</span></a></li>
                     <li id="TIPO"><a href="tipo.php"> <span class="nav-label">TIPO</span></a></li>
                     <li id="UNIDAD"><a href="unidad.php"> <span class="nav-label">UNIDAD</span></a></li>
                </ul>
            </li>
            <li id="REPORTES">
                <a href="#"><span class="nav-label">REPORTES</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li id="REPORTES"><a href="aastat.php"><span class="nav-label">ADMI</span></a></li>
                    <li id="REPORTES"><a href="appreporte.php"><span class="nav-label">AGENDA APP</span></a></li>
                    <li id="REPORTES"><a href="appredencion.php"><span class="nav-label">APP REDENCIÓN</span></a></li>
                    <li id="REPORTES"><a href="reportecitas.php"><span class="nav-label">CITAS</span></a></li>
                    <li id="REPORTES"><a href="reportedomicilio.php"><span class="nav-label">DOMICILIOS</span></a></li>
                    <li id="REPORTES"><a href="#"><span class="nav-label">INVENTARIO</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li id="CARACTERISTICA">
                                <a href="inventario.php?tipoReporte=pdf" target="_blank"><span class="nav-label">ESTRUCTURA CLASIFICACIÓN</span></a>
                            </li>
                        </ul>
                    </li>

                    <li id="REPORTES"><a href="aaredenpuntos.php"><span class="nav-label">PUNTOS CHACÓN</span></a></li>


                    <!-- <li id="REPORTES">
                        <a href="#"><span class="nav-label">REDENCION PUNTOS CHACÓN</span><span class="fa arrow"></span> </a>
                        <ul class="nav nav-second-level">
                            <li id=""><a href="">CLIENTE</a></li>
                            <li id=""><a href="">SALON</a></li>
                        </ul> 
                    </li> -->
                    <li id="REPORTES"><a href="reporteregclientes.php"><span class="nav-label">REGISTRO DE CLIENTES</span></a></li>  
                    <li id="REPORTES"><a href="reportesubibaja.php"><span class="nav-label">SUBE Y BAJA</span></a></li>   
                </ul>
            </li>
            <li id="SALONES">
                <a href="#"><span class="nav-label">SALONES</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <!-- <li id="CITAS"><a href="citas.php"><span class="nav-label">CITAS</span></a></li>
                    <li id="HORARIOS"><a href="horarios_salon.php"> <span class="nav-label">HORARIOS</span> </a></li> -->
                    <li id="METAS"><a href="meta_salon.php"> <span class="nav-label">METAS</span> </a></li>
                    <!-- <li id="PUESTOS"><a href="puestos_de_trabajo.php"> <span class="nav-label">PUESTOS DE TRABAJO</span> </a></li> -->
                    <li id="SALON"><a href="salon.php"> <span class="nav-label">SALONES</span> </a></li>
                    <!-- <li id="TIPO_PUESTO"><a href=tipo_puesto.php> <span class="nav-label">TIPO DE PUESTO</span> </a></li>
                    <li id="TIPO_PROGRAMACION"><a href="tipo_programacion.php"><span class="nav-label">TIPO DE PROGRAMACION</span> </a></li>
                    <li id="TIPO_TURNO"><a href="tipo_turno.php"><span class="nav-label">TIPO DE TURNO</span> </a></li> -->
                </ul>
            </li> 
            <li id="USUARIOS">
                <a href="#"><span class="nav-label">USUARIOS</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="SESIONES"><a href="sesiones.php">SESIONES</a></li>
                    <li id="PRIVILEGIOS"><a href="privilegios_perfil.php">PRIVILEGIOS</a></li>
                    <li id="USUARIO"><a href="new_usuario.php">USUARIOS</a></li>
                </ul>
            </li>
        </ul>

    </div>
</aside>


    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> ggf </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>


    </div>
    
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
        url: 'bloquear_pantalla.php',
        method: 'POST',
        data: datastring,
        success: function (data) 
        {
            window.location="bloquear_pantalla.php?url="+url+"";
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


<?php
    include("../cnx_data.php");
    include("php/funciones.php");
    
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
    <!-- <link rel="stylesheet" type="text/css" href="js/toastr.min.css"> -->

    <!-- <link rel="stylesheet" href="../lib/vendor/select2-3.5.2/select2.css" /> -->
    <!-- <link rel="stylesheet" href="../lib/vendor/select2-bootstrap/select2-bootstrap.css" /> -->

    <link rel="stylesheet" href="../lib/vendor/fullcalendar/dist/fullcalendar.print.css" media="print"/>
    <link rel="stylesheet" href="../lib/vendor/fullcalendar/dist/fullcalendar.min.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="../lib/vendor/selectpicker/selectpicker.css">

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">
    <link rel="stylesheet" href="../lib/vendor/select2-3.5.2/select2.css">
    <link rel="stylesheet" href="../lib/vendor/select2-bootstrap/select2-bootstrap.css">
    
    <script src="https://www.google.com/recaptcha/api.js?hl=es"></script>
    <!-- CDN para sube y baja de pantallas de publicidad -->    
    <script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" > </script>
<style>
    /* .modalstyle{
    overflow-y: initial !important
    }
    .modalstyle2{
    height: 500px;
    overflow-y: auto;
    } */
</style>
</head>

<body  class="fixed-navbar fixed-sidebar hide-sidebar" style="background-color: #F1F3F6; position: relative;" id="body" onload="autoblock();">
<input type="hidden" value="<?php echo $_SESSION['PDVslnNombre']?>" class="sln">
<input type="hidden" value="<?php echo $_SESSION['PDVslncodigo']; ?>" id="cod_salon">
<input type="hidden" id="db" value="<?php echo $_SESSION['PDVDb']; ?>">
<input type="hidden" id="usuario" value="<?php echo $_SESSION['PDVuser_session']; ?>">
<input type="hidden" id="swscreen" value="<?php echo $_SESSION['PVDscreen']; ?>">
<input type="hidden" id="usucod" value="<?php echo $_SESSION['PDVcodigoUsuario']; ?>">
<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span style="font-size: .9em;">
           <a href="javascript:void(0)" type="button" class="sln_nombre"><?php echo $_SESSION['PDVslnNombre'] ?></a>   
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
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse" style="display: none">
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
                 <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <p style="font-size: .9em" id=""><?php echo $_SESSION['namedb']; ?></p>
                    </a>                   
                </li>
                 <li class="dropdown" title="Ir al inicio">
                    <a class="dropdown-toggle" href="inicio.php" title="Ir al inicio">
                        <i class="pe-7s-home"></i>
                    </a>
                 </li>




                <!-- <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-speaker"></i>
                    </a>
                    <ul class="dropdown-menu hdropdown notification animated flipInX">
                        <li>
                            <a>
                                <span class="label label-success">NEW</span> It is a long established.
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
                </li> -->
                <li class="dropdown">
                    <a id="btnpromo" title="Redimir promociones">
                        <i class="fa fa-gift"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a id="btninconf" title="Registro de Inconformidades">
                        <i class="fa fa-thumbs-down"></i>
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
                                        <i class="pe pe-7s-home text-danger"></i>
                                        <h5>Inicio</h5>
                                    </a>
                                </td> 
                               <td>
                                 <a href="./biometrico.php" type="button">
                                     <i class="pe-7s-clock text-success"></i>
                                     <h5>Biométrico</h5>
                                 </a>
                               </td>                             
                                <!-- <td id="SUBEBAJA">
                                    <a href="./citas.php" type="button" >
                                        <i class="pe-7s-pen text-primary"></i>
                                        <h5>Citas</h5>
                                    </a>
                                </td> --> 

                                <td id="SUBEBAJA">
                                    <a href="./citas/" type="button" >
                                        <i class="pe-7s-pen text-primary"></i>
                                        <h5>Citas</h5>
                                    </a>
                                </td>                                                                               
                                                               
                            </tr>
                            <tr>
                                <td id="CLIENTES">
                                    <a href="./cliview.php" type="button" >
                                        <i class="pe-7s-users text-success"></i>
                                        <h5>Clientes</h5>
                                    </a>
                                </td>
                                 <td>
                                    <a href="./permisos.php" type="button">
                                        <i class="pe-7s-coffee text-info"></i>
                                        <h5>Permisos</h5>
                                    </a>
                                </td> 
                                
                                 <td id="DIRECTORIO">
                                    <a href="./directorio.php" type="button" >
                                        <i class="pe-7s-note text-warning"></i>
                                        <h5>Directorio</h5>
                                    </a>
                                </td> 
                                
                                
                               
                            </tr>
                            <tr>
                                <td>
                                     <a href="./pdv_programacion.php" type="button" >
                                        <i class="pe pe-7s-date text-primary"></i>
                                        <h5>Programación</h5>
                                    </a>
                                </td> 
                                 <td>
                                     <a href="./sube_baja.php" type="button" >
                                        <i class="pe-7s-menu text-info"></i>
                                        <h5>Sube y Baja</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btnModalReporte" type="button">
                                        <i class="pe-7s-display1 text-success"></i>
                                        <h5>Reporte</h5>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>                                    
                                    <a href="javascript:void(0)" class="selector" type="button" data-url="<?php echo $_SERVER['SCRIPT_NAME']?>" title="Bloquear pantalla">
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
                    <a class="dropdown-toggle label-menu-corner" href="biometrico.php" title="<?php echo $row[0] . " Novedades encontradas en el uso del biométrico"; ?>">
                        <i class="pe-7s-note2"></i>
                        <span class="label label-warning" id="conteoNoved">
                          

                        </span>
                    </a>
                </li> 
                <li>
                    <a href="javascript:void(0)" id="sidebar" class="right-sidebar-toggle" onclick="ListarCola();" data-toggle="tooltip" title="Sube y Baja">
                        <i class="pe-7s-menu"></i>
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
                <span class="font-extra-bold font-uppercase"><?php echo $_SESSION['PDVnombreCol'] ?></span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Mi perfil <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <!-- <li><a href="bloquear_pantalla.php">Bloquear pantalla</a></li> -->
                        <li><a href="./changepass.php" ">Cambio de clave</a></li>
                        <li><a href="logout.php">Cerrar Sesión <i class="pe-7s-sign-out"></i></a></li>
                    </ul>
                </div>


            </div>
        </div>
        <input type="hidden" id="trcdocumento" value="<?php echo $_SESSION['PDVdocumento'] ?>">
        <ul class="nav" id="side-menu">
            <li id="INICIO" class="active">
                <a href="inicio.php" title="Ir al inicio"> <span class="nav-label">INICIO</span> </a>
            </li> 
           <!--  <li id="" class="active">
                          <a href="./changepass.php" title="Ir al módulo de de cambio de contraseña"> <span class="nav-label">CAMBIAR CLAVE</span> </a>
                      </li> --> 
            <li id="" class="active">
                <a href="./biometrico.php" title="Ir al módulo de Biométrico"> <span class="nav-label">BIOMÉTRICO</span> </a>
            </li>          
           <!--  <li id="" class="active">
               <a href="./citas.php" title="Ir al módulo de citas"> <span class="nav-label">CITAS</span> </a>
           </li> -->
            <li id="" class="active">
                <a href="./citas/" title="Ir al módulo de citas"> <span class="nav-label">CITAS</span> </a>
            </li>
            <li id="" class="active">
                <a href="./cliview.php" title="Ir al módulo de clientes"> <span class="nav-label">CLIENTES</span> </a>
            </li>
            <li id="" class="active">
                <a href="./directorio.php" title="Ir al módulo de directorio"> <span class="nav-label">DIRECTORIO</span> </a>
            </li>
            <li id="" class="active">
                <a href="./permisos.php" title="Ir al módulo de permisos"> <span class="nav-label">PERMISOS</span> </a>
            </li>            
            <li id="" class="active">
                <a href="./pdv_programacion.php" title="Ir al módulo de programación"> <span class="nav-label">PROGRAMACIÓN</span> </a>
            </li>

            <li>
                <a href="#"><span class="nav-label">REPORTE</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="./reporteAgenda.php">AGENDAS</a></li>
                    <li><a href="./reporteBiometrico.php">BIOMÉTRICO</a></li>
                </ul>
            </li>
            
            <li id="" class="active">
                <a href="./sube_baja.php" title="Ir al módulo del sube y baja"> <span class="nav-label">SUBE Y BAJA</span> </a>
            </li>
        </ul>
    </div>
</aside>
<!-- modal nuevo cliente -->
<div class="modal fade" id="modalNuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 1600;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Nuevo Cliente</h4>
            </div>
            <div class="modal-body">                           
                                       

                    <input type="hidden" id="txtSexo">
                    <input type="hidden" id="txtFechaN">
                    <input type="hidden" id="txtTipoS">
                                <div class="row">
                                    <div class="col-md-10" id="btnBarcode">
                                        <span  data-toggle="tooltip" style="cursor: pointer" data-placement="top" title="Click para leer código de barra"><i class="fa fa-barcode fa fa-3x" ></i></span>
                                        <div id="spin" style="display: none">
                                            <i class="fa fa-spinner fa-spin fa 2x text-info" ></i> <span class="text-info"><b>Esperando por lectura de documento</b></span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="text" id="dataCapture" class="form-control" style="border: none!important; border-color: transparent!important; color: transparent!important">
                                    </div>
                                </div>
                                    
                                    
                                    <div class="row">                                                   
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">                                                            
                                                <label for="">TIPO DOCUMENTO</label>
                                                <br>
                                                    <select class="form-control" id="tipodoc"  style="width: 100%!important">
                                                        <?php 
                                                        $sql = mysqli_query($conn, "SELECT tdicodigo, tdialias FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

                                                        while ($row = mysqli_fetch_array($sql)) 
                                                        {
                                                        if ($row[1] == "CC") 
                                                        {
                                                        echo '<option value="'.$row[0].'" selected data-toggle="tooltip" data-placement="top" title="Cedula">'.$row[1].'</option>';                 
                                                        }
                                                        else
                                                        {
                                                        echo '<option value="'.$row[0].'">'.$row[1].'</option>';
                                                        }

                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="text" name="" id="docReadonly" class="form-control" value="" style="display: none">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">DOCUMENTO</label>                                                               
                                                    <input type="text" id="nroDoc" placeholder="Digite documento" class="form-control">                                             
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">NOMBRES</label>
                                                    <input type="text" class="form-control" id="nombres" placeholder="Digite nombres">
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">APELLIDOS</label>
                                                    <input type="text" class="form-control" id="apellidos" placeholder="Digite apellidos">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">MES CUMPLEAÑOS</label>
                                                <select name="" id="mes" class="form-control">
                                                    <option value="0" selected>SELECCIONE MES</option>
                                                    <option value="01">ENERO</option>
                                                    <option value="02">FEBRERO</option>
                                                    <option value="03">MARZO</option>
                                                    <option value="04">ABRIL</option>
                                                    <option value="05">MAYO</option>
                                                    <option value="06">JUNIO</option>
                                                    <option value="07">JULIO</option>
                                                    <option value="08">AGOSTO</option>
                                                    <option value="09">SEPTIEMBRE</option>
                                                    <option value="10">OCTUBRE</option>
                                                    <option value="11">NOVIEMBRE</option>
                                                    <option value="12">DICIEMBRE</option>
                                                </select>

                                                <input type="text" name="" id="mesReadonly" class="form-control" value="" style="display: none">
                                            </div>                                                        
                                        </div> 

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">DÍA CUMPLEAÑOS</label>
                                                <select name="" id="dia" class="form-control">
                                                    <option value="0">SELECCIONE DÍA</option>
                                                    <?php 
                                                    for ($i=01; $i <= 31; $i++) { 
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                    }
                                                    ?>
                                                    </select>
                                                    <input type="text" name="" id="diaReadonly" class="form-control" value="" style="display: none">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="">E-MAIL</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Digite el e-mail">
                                                        <p class="help-block text-danger" id="txtAlertEmail" style="display:none"><b>Digite el e-mail</b></p>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="">MÓVIL</label>
                                                    <div class="input-group"><input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
                                                        <p class="help-block text-danger" id="txtAlertMovil" style="display:none"><b>Digite el número del móvil</b></p></div>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-4">
                                            <label for="">FIJO</label>
                                                <div class="input-group"><input type="number" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" /> <p class="help-block text-danger" id="txtAlertFijo" style="display:none"><b>Digite el número fijo</b></p></span></div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">NOTIFICACIONES AL MOVIL</label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="" id="nm" checked>
                                                        </label>
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="">NOTIFICACIONES AL E-MAIL</label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="" id="ne" checked>
                                                        </label>
                                                    </div>
                                            </div>
                                        </div>
                                    </div> 

                              

                                <div class="text-right m-t-xs">
                                    <br>
                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
                                        <a class="btn btn-primary next btnNext2" type="button" href="javascript:void(0)"><i class="fa fa-save"></i> Registrar</a>
                                </div>
               
            </div>
        </div>
    </div>
</div>
<!-- fin modal nuevo cliente -->


<!-- Modal Ver Salon -->
<div class="modal fade" id="modalVerSalon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title_imagen"></h4>
      </div>
      <div class="modal-body">
          <img id="imagen_salon" src="" alt="Salón" class="img-responsive">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">
        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-danger m-b-md"><i class="pe pe-7s-close"></i>
            </button>
             <button  class="sidebar-button btn btn-info m-b-md pull-right" data-toggle="modal" data-target="#modalDocumento" title="Añadir/Sacar colaboradores al Sube y Baja"><i class="pe pe-7s-users"></i>
            </button>

            <select name="" id="filtro_cargos" class="form-control" required="required">
                 <?php    
                 $queryCargo = mysqli_query($conn,"SELECT crgnombre, crgcodigo from btycargo where crgestado='1' and crgincluircolaturnos='1' order by crgnombre");
                    while ($rsCargo = mysqli_fetch_array($queryCargo)) {
                        echo '<option value='.$rsCargo['crgnombre'].'>'.$rsCargo['crgnombre'].'</option>';
                    }
                ?>
               <!-- <option value="TODOS">TODOS</option> -->
            </select>
            <div>              
               <div class="sube_baja">
               </div>
            </div>
            
            
        </div>        
    </div>

<!-- Modal Lectura Documento -->
<div class="modal fade" id="modalDocumento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id=""><i class="fa fa-file-text-o"></i> Lector de Documento</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">
            <h5 id="txtInfo" style="color: red; text-align: center"></h5>
            <div class="col-md-10" id="btnBarcodeDoc">
                <span  data-toggle="tooltip" style="cursor: pointer" data-placement="top" title="Click para leer código de barra"><i class="fa fa-barcode fa fa-3x" ></i></span>
                <div id="spinL" style="display: block">
                 <i class="fa fa-spinner fa-spin fa 2x text-info" ></i> <span class="text-info"><b>Esperando por lectura de documento</b></span>
                    
                </div>
            </div>
            <input type="text" id="dataCaptureDoc" class="form-control" style=" border: none; border-color: transparent;color: transparent;">
              <div class="form-group">
                  <label for="">Número Documento</label>
                  <input type="text" class="form-control" id="docColaborador">
              </div>

              <div class="form-group">
                  <label for="">Colaborador</label>
                  <input type="text" class="form-control" id="nombreColaborador">
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modoal redención de promociones -->
<div class="modal fade" id="modal-promo" role="dialog" style="z-index: 1400;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title"><i class="addcli fa fa-gift"></i> Registro de redención de promos</h5>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon fa fa-gift"></span>
                    <select class="form-control" id="slpromo"></select>
                </div>
                <div class="input-group col-md-10 col-md-push-1">
                    <small class="detallepromo text-primary"></small>
                </div>
                <div class="input-group">
                    <span class="input-group-addon fa fa-scissors"></span>
                    <select class="form-control" id="slservicio" disabled></select>
                </div>
                <div class="input-group">
                    <span class="input-group-addon fa fa-user"></span>
                    <select class="form-control" id="slcliente" disabled></select>
                </div>
                <div class="input-group col-md-10 col-md-push-1">
                    <small class="detallecli text-danger"></small>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="btnredimir" class="btn btn-primary">Redimir Promo</button>
            </div>
        </div>
    </div>
</div>

<!-- modal reporte de inconformidades -->
<div class="modal fade" id="modal-inconf">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-thumbs-down"></i> Registro de Inconformidades</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon fa fa-user"></span>
                        <select class="form-control" id="slcliente-inc"></select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon fa fa-users"></span>
                        <select class="form-control" id="slcol-inc" disabled></select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon fa fa-check-square-o"></span>
                        <select class="form-control" id="sltipo-inc"  disabled></select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" style="resize: none;" id="txtdesc-inc" rows="5" placeholder="Describa la inconformidad..." disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="savereginc" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div id="wrapper">


<style>
    li{
        list-style: none!important;
    }
</style>
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/select2-3.5.2/select2.min.js"></script>
<script src="js/newcli.js"></script>
<script>


    $(document).ready(function() {  
        $('[data-toggle="tooltip"]').tooltip();

        $(document).on('click', '.sln_nombre', function() {
           var id = $('#cod_salon').val();
            $('#modalVerSalon').modal("show");
            $('body').removeClass("modal-open");
            $('body').removeAttr("style");
           $.ajax({
                url: 'php/sube_baja/cargar_imagen_sln.php',
                method: 'POST',
                data: {id:id},
                success: function (data) {
                    var array = eval(data);
                    for(var i in array){
                        $("#imagen_salon").removeAttr("src");        
                        $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
                    }
                }
           });
           /* cargar_imagen_modal ();
            $(".sln_nombre").removeAttr("href");        
            $('.sln_nombre').attr("data-target", "#modalVerSalon");*/
        });
    
    });

  
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

        document.addEventListener("mousemove", function() {
            clearTimeout(temp);
            temp = setTimeout(redireccion, 1.8e+6);
        });
        document.addEventListener("keypress", function() {
            clearTimeout(temp);
            temp = setTimeout(redireccion, 1.8e+6);
        });
    }
</script>

<script type="text/javascript">//script de modal promociones
    //se carga el select de promociones al abrir modal
    $(document).on('click', "#btnpromo", function(e){
        var sln=$("#cod_salon").val();
        $.ajax({
            url:'php/promociones/redenpromo.php',
            type:'POST',
            data:'opc=loadpromo&sln='+sln,
            success:function(res){
                var datos=JSON.parse(res);
                var opcs = "<option value='' selected disabled>Seleccione la Promo a redimir..</option>";
                for(var i in datos){
                    opcs += "<option value='"+datos[i].cod+"' data-cond='"+datos[i].cond+"' data-reqreg='"+datos[i].reqreg+"'>"+datos[i].nom+"</option>";
                }
                $("#slpromo").html(opcs);
            }
        })
        $("#modal-promo").modal('show');
    })

    $("#slpromo").change(function(e){
        /*$("#slservicio").val('default').selectpicker("refresh");*/
        //$("#slcliente").selectpicker("destroy");
        if($("#slcliente").val()>0){
            $("#modal-promo").modal('hide');
        }else{
            $(".dropdown-menu.inner").empty()
            $(".detallecli").empty();
            $(".detallepromo").empty();
            var cond=$('#slpromo option:selected').data('cond');
            var rq=$("#slpromo option:selected").data('reqreg');
            if(rq==1){
                $(".detallecli").html('*Esta promo requiere que el cliente se haya registrado previamente en la página web; si no aparece en la búsqueda, no tiene habilitada la promoción o no se ha registrado.');
            }
            $(".detallepromo").html('<b>Condiciones: </b>'+cond);
            $("#slservicio").removeAttr('disabled');
            $("#slservicio").selectpicker({
                liveSearch: true,
                title:'Buscar y seleccionar servicio...'
            })
        }
    })

    //se habilita y carga el select de servicios
    $('#slservicio').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });
    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        if(seek.length>2){
            $.ajax({
                url: 'php/promociones/redenpromo.php',
                type: 'POST',
                data:'opc=loadser&txt='+seek,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                        }
                        $("#slservicio").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    $('#slservicio').change(function(e){
        $("#slcliente").removeAttr('disabled');
        $("#slcliente").selectpicker({
            liveSearch: true,
            title:'Buscar Cliente por nombre o cedula...'
        })
    });

    //se habilita y carga el select de cliente
    $('#slcliente').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo2');
        $('.algo2 .form-control').attr('id', 'fucker2');
    });
    $(document).on('keyup', '#fucker2', function(event) {
        var seek = $(this).val();
        var pmo=$("#slpromo").val();
        var rq=$("#slpromo option:selected").data('reqreg');
        if(seek.length>2){
            $.ajax({
                url: 'php/promociones/redenpromo.php',
                type: 'POST',
                data:'opc=loadcli&txt='+seek+'&reqreg='+rq+'&pmo='+pmo,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+" ["+json[i].ced+"] "+json[i].adic+"</option>";
                        }
                        $("#slcliente").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });

    //submit de formulario
    $("#btnredimir").click(function(e){
        e.preventDefault();
        var pro=$("#slpromo").val();
        var ser=$("#slservicio").val();
        var cli=$("#slcliente").val();
        var user=$("#usucod").val();
        var salon=$("#cod_salon").val();
        if((pro!='') && (ser>0) && (cli>0)){
            $.ajax({
                url:'php/promociones/redenpromo.php',
                type:'POST',
                data:'opc=regis&pro='+pro+'&ser='+ser+'&cli='+cli+'&sln='+salon+'&usr='+user,
                success:function(res){
                    if(res==0){
                        swal('Registrado!','La promoción se ha registrado correctamente','success');
                    }else{
                        swal('Error!','La promoción NO se ha registrado, hubo un error. Refresque la página e intentelo nuevamente. Si el error persiste comuníquese con el área de sistemas.','error');
                    }
                    $("#modal-promo").modal('toggle');
                }
            })
        }else{
            swal('Faltan datos!','Debe completar todos los campos','warning');
        }
    })

    //se limpian los campos del formulario al cerrar modal
    $("#modal-promo").on("hidden.bs.modal", function () {
        $("#slservicio").val('default').selectpicker("refresh").attr('disabled', 'disabled');
        $("#slcliente").val('default').selectpicker("refresh").attr('disabled', 'disabled');
        $(".detallepromo").empty();
        $(".detallecli").empty();
        $(".dropdown-menu.inner").empty()
    });
</script>
<script type="text/javascript">//script modal reporte de inconformidades
    $(document).on('click', "#btninconf", function(e){
        $("#slcliente-inc").selectpicker({
            liveSearch: true,
            title:'Buscar Cliente por nombre o cedula...'
        })
        $("#modal-inconf").modal('show');
    });
    //Busqueda de clientes
    $('#slcliente-inc').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo3');
        $('.algo3 .form-control').attr('id', 'fucker3');
    });
    $(document).on('keyup', '#fucker3', function(event) {
        var seek = $(this).val();
        if(seek.length>2){
            $.ajax({
                url: 'php/inconformidades/process.php',
                type: 'POST',
                data:'opc=loadcli&txt='+seek,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+" ["+json[i].ced+"]</option>";
                        }
                        $("#slcliente-inc").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    $('#slcliente-inc').change(function(e){
        $("#slcol-inc").removeAttr('disabled');
        $("#slcol-inc").selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar Colaborador que atendió al cliente...'
        })
    });
    //Busqueda de colaborador que atendió.
    $('#slcol-inc').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo4');
        $('.algo4 .form-control').attr('id', 'fucker4');
    });
    $(document).on('keyup', '#fucker4', function(event) {
        var seek = $(this).val();
        if(seek.length>2){
            $.ajax({
                url: 'php/inconformidades/process.php',
                type: 'POST',
                data:'opc=loadcol&txt='+seek,
                success: function(data){
                    if(data){
                        var json = JSON.parse(data);
                        var opcs = "";
                        for(var i in json){
                            opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+" ["+json[i].ced+"]</option>";
                        }
                        $("#slcol-inc").html(opcs).selectpicker('refresh');
                    }
                }
            }); 
        }
    });
    //select tipo de inconformidad
    $('#slcol-inc').change(function(e){
        $("#sltipo-inc").removeAttr('disabled').attr('multiple','multiple');
         $.ajax({
            url: 'php/inconformidades/process.php',
            type: 'POST',
            data:'opc=loadtinc',
            success: function(data){
                if(data){
                    var json = JSON.parse(data);
                    var opcs = "";
                    for(var i in json){
                        opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                    }
                    $("#sltipo-inc").html(opcs).select2({placeholder:'Seleccione tipo de inconformidad'});
                }
            }
        }); 
    });
    $("#sltipo-inc").change(function(e){
        $("#txtdesc-inc").removeAttr('disabled');
    });

    //guardar registro de inconformidades
    $("#savereginc").click(function(e){
        var cli=$("#slcliente-inc").val();
        var clb=$("#slcol-inc").val();
        var tin=$("#sltipo-inc").val();
        var des=$("#txtdesc-inc").val();
        var usu=$("#usucod").val();
        var sln=$("#cod_salon").val();
        if((cli>0) && (clb>0) && (tin!=null) && (des.length>0)){
            $.ajax({
                url:'php/inconformidades/process.php',
                type:'POST',
                data:{opc:'saveinc',cli:cli,clb:clb,tin:tin,des:des,usu:usu,sln:sln},
                success:function(res){
                    if(res==1){
                        swal('Registrado correctamente','','success');
                        $("#modal-inconf").modal('toggle');
                        $("#slcliente-inc").val('default').selectpicker("refresh");
                        $("#slcol-inc").val('default').attr('disabled', 'disabled');
                        $("#sltipo-inc").empty().attr('disabled', 'disabled');
                        $("#txtdesc-inc").val('').attr('disabled', 'disabled');
                    }else{
                        swal('Oops!','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente. Si el problema persiste comuníquese con el departamento de sistemas','error');
                    }
                }
            })
        }else{
            swal('Complete todos los campos!','Todos los campos son obligatorios.','warning');
        }
    });
</script>
<script type="text/javascript">//script modal nuevo cliente
    $(".addcli").click(function(e){
        $('#modalNuevoCliente').modal('show');
    })

</script>

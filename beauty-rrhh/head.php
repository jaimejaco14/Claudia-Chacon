<?php
    //session_start();
    include '../../cnx_data.php';
    include '../php/funciones.php';
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
    <title>Beauty | ERP Invelcon SAS</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="../../contenidos/imagenes/favicon.png" />

    <!-- Vendor styles -->
    
    <link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css" />
     <link rel="stylesheet" href="../../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../../lib/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="../../lib/vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="../../lib/vendor/select2-bootstrap/select2-bootstrap.css" />

    <link rel="stylesheet" href="../../lib/vendor/fullcalendar/dist/fullcalendar.print.css" media="print"/>
    <link rel="stylesheet" href="../../lib/vendor/fullcalendar/dist/fullcalendar.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="../js/selectpicker/selectpicker.css" />
    

    <!-- App styles -->
    <link rel="stylesheet" href="../../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../../lib/styles/style.css">
    <link rel="stylesheet" href="../../lib/styles/static_custom.css">
    <script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script>
        function conteoPermisos () 
        {
            $.ajax({
                url: '../php/countsPermisos.php',
                method: 'POST',
                success: function (data) 
                {
                    $('#countPermisos').html(data);
                }
            });
        }
    </script>
</head>

<body class="fixed-navbar fixed-sidebar hide-sidebar" style="position:relative;" id="body" onload="autoblock();">
	<input type="hidden" id="usucodi" value="<?php echo  $_SESSION['codigoUsuario'];?>">
<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            GESTIÓN HUMANA
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">BEAUTY</span>
        </div>
        
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li>
                    <a class="dropdown-toggle label-menu-corner" href="../inicio.php" title="Ir a Inicio">
                        <i class="pe-7s-home"></i>
                        
                    </a>
                </li>
                <li class="dropdown">
                    <a id="btnactpend" class="dropdown-toggle label-menu-corner" href="#" title="Actualizaciones de datos por revisar">
                        <i class="pe-7s-id"></i>
                        <span class="label label-danger" id="countActu"></span>
                    </a>
                </li>
                <li class="dropdown">
                    <a id="btnsolpend" class="dropdown-toggle label-menu-corner" href="../solicitudes/solicitudes.php" title="Solicitudes sin responder">
                        <i class="pe-7s-phone"></i>
                        <span class="label label-primary" id="countsolpend"></span>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle label-menu-corner" href="../colaborador/permisos.php" title="Ausencias programadas">
                        <i class="pe-7s-coffee"></i>
                        <span class="label label-info" id="countPermisos"></span>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="pe-7s-keypad"></i>
                    </a>

                    <div class="dropdown-menu hdropdown bigmenu animated flipInX">
                        <table>
                            <tbody>
                            <tr> <td colspan="2" align="center">BIOMETRICO</td></tr>
                            <tr>
                                <td>
                                    <a href="../biometrico/leercsv.php">
                                        <i class="pe-7s-cloud-upload text-info"></i>
                                        <h5>Cargar CSV</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="../biometrico/procesar_asistencia.php">
                                        <i class="pe-7s-wristwatch text-warning"></i>
                                        <h5>Procesamiento</h5>
                                    </a>
                                </td>
                            </tr>
                            <tr> <td colspan="2" align="center">COLABORADORES</td></tr>
                            <tr>
                                <td>
                                    <a href="../colaborador/programacion.php">
                                        <i class="pe-7s-note2 text-info"></i>
                                        <h5>Programacion</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="../usuario/new_usuario.php">
                                        <i class="pe-7s-id text-danger"></i>
                                        <h5>Usuarios</h5>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li class="dropdown" title="Cerrar Sesión">
                    <a href="../logout.php" >
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
            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase"><?php echo $_SESSION['nombre']; ?></span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Mi perfil <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="../cambio_clave.php">Cambio de clave</a></li>
                        <li><a href="../logout.php" title="Cerrar Sesión">Cerrar sesión <i class="pe-7s-sign-out"></i></a></li>
                    </ul>
                </div>


            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li id="INICIO" class="active">
                <a href="../inicio.php"><i class="fa fa-home"></i> <span class="nav-label">INICIO</span> </a>
            </li>
            <li id="BIOMETRICO">
                <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">BIOMETRICO</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="BIOMETRICO"><a href="../biometrico/leercsv.php"> <span class="nav-label">CARGAR CSV</span> </a></li> 
                    <li id="BIOMETRICO"><a href="../biometrico/parametro_asistencia.php">PARAMETROS DE ASISTENCIA</a></li>  
                    <li id="BIOMETRICO"><a href="../biometrico/procesar_asistencia.php"><span class="nav-label">PROCESAMIENTO DE ASISTENCIA</span></a></li> 
                    <li id="BIOMETRICO"><a href="../biometrico/reporte_asistencia_individual.php"><span class="nav-label">REPORTE INDIVIDUAL</span></a></li>
                    <li id="BIOMETRICO"><a href="../biometrico/reporte_asistencia_general.php"><span class="nav-label">REPORTE GENERAL</span></a></li>   
                    <li id="BIOMETRICO"><a href="../fechasespeciales/fechas_especiales.php"> <span class="nav-label">FECHAS ESPECIALES</span> </a></li>     
                </ul> 
            </li>
            <li id="COLABORADORES">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">COLABORADORES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="PERMISOS"><a href="../colaborador/permisos.php"> <span class="nav-label">AUSENCIAS PROGRAMADAS</span> </a></li>
                    <li id="AUTORIZACIONES"><a href="../colaborador/author.php"> <span class="nav-label">AUTORIZACIONES</span> </a></li>
                    <li id="COLABORADOR"><a href="../colaborador/colview.php"> <span class="nav-label">COLABORADORES</span> </a></li>
                    <li id="COVID"><a href="../colaborador/consultacovid.php"> <span class="nav-label">ENCUESTA COVID</span> </a></li>
                    <li id="COSTEO"><a href="../costeo/costeo.php"> <span class="nav-label">COSTEO COLABORADORES</span> </a></li>
                    <li id="NOVEDADES"><a href="../colaborador/novedadesPro.php"> <span class="nav-label">NOVEDADES</span> </a></li>
                    <li id="PERMANTENIMIENTO"><a href="../colaborador/permantenimiento.php"> <span class="nav-label">PERSONAL MANTENIMIENTO</span> </a></li>
                    <li id="PROGRAMACION"><a href="../colaborador/programacion.php"> <span class="nav-label">PROGRAMACI&Oacute;N</span> </a></li>
                    <li id="SERVICIOS"><a href="../colaborador/servicios.php"> <span class="nav-label">SERVICIOS</span> </a></li>
                    <li id="SOLICITUDES"><a href="../solicitudes/solicitudes.php"> <span class="nav-label">SOLICITUDES</span> </a></li>
                </ul>
            </li>

            <li id="SALONES">
                <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">SALONES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">                    
                    <li id="HORARIOS"><a href="../salon/horarios_salon.php"> <span class="nav-label">HORARIOS</span> </a></li>
                    <li id="PUESTOS"><a href="../salon/puestos_de_trabajo.php"> <span class="nav-label">PUESTOS DE TRABAJO</span> </a></li>
                    <li id="SALON"><a href="../salon/salon.php"> <span class="nav-label">SALONES</span> </a></li>
                    <li id="TIPO_PUESTO"><a href=../salon/tipo_puesto.php> <span class="nav-label">TIPO DE PUESTO</span> </a></li>
                    <li id="TIPO_PROGRAMACION"><a href="../salon/tipo_programacion.php"><span class="nav-label">TIPO DE PROGRAMACION</span> </a></li>
                    <li id="TIPO_TURNO"><a href="../salon/tipo_turno.php"><span class="nav-label">TIPO DE TURNO</span> </a></li>
                </ul>
            </li>
            <li id="USUARIOS" class="">
                <a href="../usuario/new_usuario.php"><i class="fa fa-user-plus"></i> <span class="nav-label">USUARIOS</span></a>   
            </li>  
            <li id="USUARIOS" class="">
                <a href="../logout.php" ><i class="fa fa-sign-out"></i> <span class="nav-label">SALIR</span></a>
            </li>  
                   
        </ul>

    </div>
</aside>

<div class="modal fade" id="modal-actpend">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="pe-7s-id"></i> Actualizaciones de datos por revisar</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="tbactpendcol table table-hover table-bordered hidden">
                        <tbody></tbody>
                    </table>
                    <h4 class="nhact">No hay actualizaciones pendientes por revisar</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

    <!-- Right sidebar -->
    
    
<div id="wrapper">

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script>
    $("#countActu").html('<i class="fa fa-spin fa-spinner"></i>');
    $("#countsolpend").html('<i class="fa fa-spin fa-spinner"></i>');
    

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

    conteoPermisos();
</script>
<script type="text/javascript">
    $(window).load(function() {
        actupend();
        solpend();
    });
    function actupend(){
        $(".tbactpendcol tbody").empty();
        $("#countActu").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            url:'../colaborador/actualizaciondatos/process.php',
            type:'POST',
            data:{opc:'countact'},
            success:function(res){
                var dcol='';
                var dat=JSON.parse(res);
                $("#countActu").html(dat.cant);
                if(dat.cant>0){
                    for(i in dat.datos){
                        dcol+='<tr><td>'+dat.datos[i].nom+'</td><td class="text-center"><button class="veract btn btn-default btn-sm" data-ced="'+dat.datos[i].ced+'"><i class="fa fa-eye text-info"></i></button></td></tr>';
                    }
                    $(".nhact").addClass('hidden');
                    $(".tbactpendcol tbody").html(dcol);
                    $(".tbactpendcol").removeClass('hidden');
                }else{
                    $(".nhact").removeClass('hidden');
                }
            }
        })
    }
    function solpend(){
    	var usu=$("#usucodi").val();
        $("#countsolpend").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
            url:'../solicitudes/process.php',
            type:'POST',
            data:{opc:'countsolpend',usu:usu},
            success:function(res){
                $("#countsolpend").html(res);
            }
        })
    }
    $("#btnactpend").click(function(e){
        e.preventDefault();
        var ruta=(window.location.pathname).split('/').pop();
        if(ruta!='colview.php'){
            window.location='../colaborador/colview.php';
        }else{
            $("#modal-actpend").modal('show');
        }
    });
    $(document).on('click','.veract', function(){
        $ctrl=$(this);
        $ctrl.html('<i class="fa fa-spin fa-spinner"></i>');
        var ced = $(this).attr('data-ced');
        detalles(ced);
        setTimeout(function(){
            $(".pctabs li").last().addClass('active');
            $(".pctabs li").first().removeClass('active');
            $("#tab-1").removeClass('active');
            $("#tab-6").addClass('active');
            $("#modal-actpend").modal('toggle');
            $ctrl.html('<i class="fa fa-eye text-info"></i>');
        },1600);
    })
</script>


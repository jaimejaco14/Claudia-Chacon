<?php 
    include '../cnx_data.php';
    include 'php/funciones.php';
    RevisarLogin();
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    
?>
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
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />

    <!-- Vendor styles -->
    
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
   

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">

    <script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
    <script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <!-- App scripts -->
    <script src="../lib/scripts/homer.js"></script>
    <style>
        #flotTip {
            padding: 3px 5px;
            background-color: #000;
            z-index: 100;
            color: #fff;
            opacity: .80;
            filter: alpha(opacity=85);
        }
    </style>
</head>

<body class="fixed-navbar fixed-sidebar hide-sidebar" style="position:relative;" id="body">
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
                                    <a href="biometrico/leercsv.php">
                                        <i class="pe-7s-cloud-upload text-info"></i>
                                        <h5>Cargar CSV</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="biometrico/procesar_asistencia.php">
                                        <i class="pe-7s-wristwatch text-warning"></i>
                                        <h5>Procesamiento</h5>
                                    </a>
                                </td>
                            </tr>
                            <tr> <td colspan="2" align="center">COLABORADORES</td></tr>
                            <tr>
                                <td>
                                    <a href="colaborador/programacion.php">
                                        <i class="pe-7s-note2 text-info"></i>
                                        <h5>Programacion</h5>
                                    </a>
                                </td>
                                <td>
                                    <a href="usuario/new_usuario.php">
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
        <ul class="nav" id="side-menu">
            <li id="INICIO" class="active">
                <a href="inicio.php"><i class="fa fa-home"></i> <span class="nav-label">INICIO</span> </a>
            </li>
            <li id="BIOMETRICO">
                <a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">BIOMETRICO</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="BIOMETRICO"><a href="biometrico/leercsv.php"> <span class="nav-label">CARGAR CSV</span></a></li> 
                    <li id="BIOMETRICO"><a href="biometrico/parametro_asistencia.php">PARAMETROS DE ASISTENCIA</a></li>  
                    <li id="BIOMETRICO"><a href="biometrico/procesar_asistencia.php"><span class="nav-label">PROCESAMIENTO DE ASISTENCIA</span></a></li> 
                    <li id="BIOMETRICO"><a href="biometrico/reporte_asistencia_individual.php"><span class="nav-label">REPORTE INDIVIDUAL</span></a></li>
                    <li id="BIOMETRICO"><a href="biometrico/reporte_asistencia_general.php"><span class="nav-label">REPORTE GENERAL</span></a></li>   
                    <li id="BIOMETRICO"><a href="fechasespeciales/fechas_especiales.php"> <span class="nav-label">FECHAS ESPECIALES</span> </a></li>   
                </ul> 
            </li>
            <li id="COLABORADORES">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">COLABORADORES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li id="PERMISOS"><a href="colaborador/permisos.php"> <span class="nav-label">AUSENCIAS PROGRAMADAS</span> </a></li>
                    <li id="AUTORIZACIONES"><a href="colaborador/author.php"> <span class="nav-label">AUTORIZACIONES</span> </a></li>
                    <li id="COLABORADOR"><a href="colaborador/colview.php"> <span class="nav-label">COLABORADORES</span> </a></li>
                    <li id="COVID"><a href="colaborador/consultacovid.php"> <span class="nav-label">ENCUESTA COVID</span> </a></li>
                    <li id="COSTEO"><a href="costeo/costeo.php"> <span class="nav-label">COSTEO COLABORADORES</span> </a></li>
                    <li id="NOVEDADES"><a href="colaborador/novedadesPro.php"> <span class="nav-label">NOVEDADES</span> </a></li>
                    <li id="PERMANTENIMIENTO"><a href="colaborador/permantenimiento.php"> <span class="nav-label">PERSONAL MANTENIMIENTO</span> </a></li>
                    <li id="PROGRAMACION"><a href="colaborador/programacion.php"> <span class="nav-label">PROGRAMACI&Oacute;N</span> </a></li>
                    <li id="SERVICIOS"><a href="colaborador/servicios.php"> <span class="nav-label">SERVICIOS</span> </a></li>
                    <li id="SOLICITUDES"><a href="solicitudes/solicitudes.php"> <span class="nav-label">SOLICITUDES</span> </a></li>
                </ul>
            </li>

            <li id="SALONES">
                <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">SALONES</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">                    
                    <li id="HORARIOS"><a href="salon/horarios_salon.php"> <span class="nav-label">HORARIOS</span> </a></li>
                    <li id="PUESTOS"><a href="salon/puestos_de_trabajo.php"> <span class="nav-label">PUESTOS DE TRABAJO</span> </a></li>
                    <li id="SALON"><a href="salon/salon.php"> <span class="nav-label">SALONES</span> </a></li>
                    <li id="TIPO_PUESTO"><a href=salon/tipo_puesto.php> <span class="nav-label">TIPO DE PUESTO</span> </a></li>
                    <li id="TIPO_PROGRAMACION"><a href="tipo_programacion.php"><span class="nav-label">TIPO DE PROGRAMACION</span> </a></li>
                    <li id="TIPO_TURNO"><a href="salon/tipo_turno.php"><span class="nav-label">TIPO DE TURNO</span> </a></li>
                </ul>
            </li>
            <li id="USUARIOS" class="">
                <a href="usuario/new_usuario.php"><i class="fa fa-user-plus"></i> <span class="nav-label">USUARIOS</span></a>
            </li>  
            <li id="USUARIOS" class="">
                <a href="logout.php" ><i class="fa fa-sign-out"></i> <span class="nav-label">SALIR</span></a>
            </li>         
        </ul>

    </div>
</aside>


    <!-- Right sidebar -->
    
    
<div id="wrapper">


<div class="container-fluid">
    <div class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel hbgblue">
                    <div class="panel-body" id="cumplehoy" style="cursor:pointer;">
                        <div class="text-center" >
                            <h3>CUMPLEA&Ntilde;OS</h3>
                            <p class="text-big font-light">
                                <?php  
                                    $QueryCumpleanos = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(c.clbcodigo) from btycolaborador as c where MONTH(c.clbfechanacimiento)=MONTH(CURDATE()) AND DAY(c.clbfechanacimiento)=DAY(CURDATE()) and bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'"));
                                     echo $QueryCumpleanos[0];?>
                            </p>
                            <small><br>
                                Cumpleaños de colaboradores hoy.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel hbgyellow">
                    <div class="panel-body" id="detalleper" style="cursor:pointer;">
                        <div class="text-center">
                            <h3>AUSENCIAS</h3>
                            <p class="text-big font-light">
                               <?php  
                                    $QueryPermisos = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS Cantidad from btypermisos_colaboradores as pc where  pc.perestado_tramite = 'REGISTRADO' and pc.perestado=1"));
                                    echo $QueryPermisos[0];
                                ?>
                            </p>
                            <small><br>
                                Ausencias pendientes por gestionar
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel hbgred">
                    <div class="panel-body" id="detallecol" style="cursor:pointer;">
                        <div class="text-center">
                            <h3>COLABORADORES</h3>
                            <p class="text-big font-light">
                                <?php  
                                    $QueryCol = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS cant
                                                FROM (
                                                SELECT bty_fnc_estado_colaborador(c.clbcodigo)
                                                FROM btycolaborador AS c
                                                WHERE bty_fnc_estado_colaborador(c.clbcodigo) = 'VINCULADO') AS c"));
                                    echo $QueryCol[0];
                                ?>
                            </p>
                            <small><br>
                                Colaboradores activos
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <a href="solicitudes/solicitudes.php">
	            <div class="col-md-3">
	                <div class="hpanel hbggreen">
	                    <div class="panel-body" style="background-color: #62cb31!important">
	                        <div class="text-center">
	                            <h3>SOLICITUDES</h3>
	                            <p class="text-big font-light">
	                            <?php
	                                $sqlcont= mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*)
												FROM btysolicitudes s
												JOIN btysolicitudes_log sl ON sl.solcodigo=s.solcodigo
												JOIN btysolicitudes_responsable sr ON sl.solrescod=sr.solrescod
												WHERE sr.usucodigo=".$_SESSION['codigoUsuario']." AND sl.sollogestado=1 AND sl.solescod <> 3"));
	                                echo $sqlcont[0];
	                            ?>
	                            </p>
	                            <small>
	                                Solicitudes pendientes por responder<br>Click aqui para ver detalles.
	                            </small>
	                        </div>
	                    </div>
	                </div>
	            </div>
        	</a>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">CUMPLEAÑOS</h2>
                            <div class="m">
                                <i class="fa fa-birthday-cake fa-5x"></i>
                            </div>
                            <?php 
                            $QueryCumpleMes = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(c.clbcodigo) FROM btycolaborador AS c WHERE MONTH(c.clbfechanacimiento)= MONTH(CURDATE()) and bty_fnc_estado_colaborador(c.clbcodigo)='vinculado'"));                              
                             ?>
                            <button class="btn btn-info btn-sm" type="button" id="btncumplemes" title="Cumpleaños de este mes">Ver Mes (<?php echo $QueryCumpleMes[0];?>) <span class="badge badge-info"></span></button>
                             <button class="btn btn-default btn-sm" type="button" id="btncumplemes2" title="Cumpleaños del mes siguiente">Ver sgte Mes<span class="badge badge-info"></span></button><br><br>
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">AUSENCIAS PROGRAMADAS</h2>
                            <!-- <p class="font-bold text-warning">Lorem ipsum</p> -->
                            <div class="m">
                                <i class="pe-7s-coffee fa-5x"></i>
                            </div>
                            <!-- <p class="small">
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p> -->
                            <a href="colaborador/permisos.php"><button class="btn btn-warning btn-sm"  id="btnVerPermisos">Ir a Ausencias Programadas</button></a><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">COLABORADORES</h2>
                            <!-- <p class="font-bold text-danger">Lorem ipsum</p> -->
                            <div class="m">
                                <i class="pe-7s-users fa-5x"></i>
                            </div>
                            <!-- <p class="small">
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p> -->
                            <a href="colaborador/colview.php"><button class="btn btn-danger btn-sm" id="btnVerColab">Ir a Colaboradores</button></a><br><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $detallebio = mysqli_fetch_array(mysqli_query($conn, "SELECT
                            IFNULL(sum(case when ap.aptcodigo = 2 then 1 else 0 end),'0'),
                            IFNULL(sum(case when ap.aptcodigo = 3 then 1 else 0 end),'0'),
                            IFNULL(sum(case when ap.aptcodigo = 4 then 1 else 0 end),'0'),
                            IFNULL(sum(case when ap.aptcodigo = 6 then 1 else 0 end),'0')
                            FROM btysalon sl
                            JOIN btyasistencia_procesada ap  ON sl.slncodigo=ap.slncodigo
                            WHERE ap.prgfecha=date_sub(curdate(),interval 1 day)
                            ORDER BY sl.slnnombre")); 
            ?>
            <div class="col-md-3" style="">
                <div class="hpanel">
                    <div class="panel-body">
                    <h5 class="m-b-xs text-center">Detalle Biométrico por tipo</h5>
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <th>
                                        <h5 class="font-bold" style="color: #009900!important">Ingreso tarde</h5>
                                    </th>
                                    <td align="right"><?php echo $detallebio[0];?></td>
                                </tr>
                                <tr>
                                    <th>
                                        <h5 class="font-bold" style="color: #009900!important">Salida Temprano</h5>
                                    </th>
                                    <td align="right"><?php echo $detallebio[1];?></td>
                                </tr>
                                <tr>
                                    <th>
                                        <h5 class="font-bold" style="color: #009900!important">Ausencias</h5>
                                    </th>
                                    <td align="right"><?php echo $detallebio[2];?></td>
                                </tr>
                                <tr>
                                    <th>
                                        <h5 class="font-bold" style="color: #009900!important">Incompletos</h5>
                                    </th>
                                    <td align="right"><?php echo $detallebio[3];?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
        <div id="divgraficos">
            
        </div>
    </div>
</div>


<div class="modal fade" id="modal-cumplehoy">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-birthday-cake"></i> CUMPLEAÑOS DE HOY</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Nombre Colaborador</th>
                            <th>Salón Base</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sqlcumphoy="SELECT distinct(t.trcrazonsocial),s.slnnombre
                                    FROM btycolaborador c
                                    JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                                    JOIN btysalon_base_colaborador sb ON sb.clbcodigo=c.clbcodigo
                                    JOIN btysalon s ON s.slncodigo=sb.slncodigo
                                    WHERE sb.slchasta IS NULL AND DAY(c.clbfechanacimiento )=DAY(NOW()) AND MONTH(c.clbfechanacimiento )=MONTH(NOW())
                                    and bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'
                                    ORDER BY t.trcrazonsocial";
                        $reshoy=$conn->query($sqlcumphoy);
                        if($reshoy->num_rows>0){     
                            while($rowhoy=$reshoy->fetch_array()){
                                ?>
                                    <tr>
                                        <td><?php echo utf8_encode($rowhoy[0]);?></td>
                                        <td><?php echo $rowhoy[1]?></td>
                                    </tr>
                                <?php
                            }
                        }else{
                            echo '<tr><td colspan="2" class="text-center">No hay cumpleaños el dia de hoy</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cumplemes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-birthday-cake"></i> CUMPLEAÑOS DE <?php echo strtoupper($mes[date('m')-1]);?> </h4>
                <button class="btn btn-default pull-right exportmes" data-mes="<?php  echo strtoupper($mes[date('m')-1]);?>" data-toggle="tooltip" data-placement="left" title="Exportar a Excel"><i class="fa fa-file-excel-o fa-2x" style="color:green;"></i></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center">Dia</th>
                            <th>Nombre Colaborador</th>
                            <th>Salón Base</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sqlcumpmes="SELECT t.trcrazonsocial,day(c.clbfechanacimiento) as dia, CASE WHEN bty_fnc_salon_colaborador(c.clbcodigo) IS NULL THEN '' ELSE bty_fnc_salon_colaborador(c.clbcodigo) end as slnnombre FROM btycolaborador c JOIN btytercero t ON t.trcdocumento=c.trcdocumento WHERE MONTH(c.clbfechanacimiento )= MONTH(CURDATE()) AND bty_fnc_estado_colaborador(c.clbcodigo)='vinculado' ORDER BY dia";
                        $resmes=$conn->query($sqlcumpmes);
                        if($resmes->num_rows>0){     
                            while($rowmes=$resmes->fetch_array()){
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $rowmes[1];?></td>
                                        <td><?php echo utf8_encode($rowmes[0]);?></td>
                                        <td><?php echo $rowmes[2];?></td>
                                    </tr>
                                <?php
                            }
                        }else{
                            echo '<tr><td colspan="3" class="text-center">No hay cumpleaños este mes</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cumplemes2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                
                 <?php
                 $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                 $ind=date('m')+0;
                 if($ind==12){
                    $nommes= strtoupper($mes[0]);
                 }else{
                    $nommes= strtoupper($mes[$ind]);
                 }
                 ?> 
                <h4 class="modal-title"><i class="fa fa-birthday-cake"></i>
                     CUMPLEAÑOS DE <?php echo $nommes;?>
                 </h4>
                 <button class="btn btn-default pull-right exportmesn" data-mes="<?php  echo $nommes;?>" data-toggle="tooltip" data-placement="left" title="Exportar a Excel"><i class="fa fa-file-excel-o fa-2x" style="color:green;"></i></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center">Dia</th>
                            <th>Nombre Colaborador</th>
                            <th>Salón Base</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($ind==12){
                            $ind=1;
                        }else{
                            $ind++;
                        }
                        $sqlcumpmes="SELECT distinct(t.trcrazonsocial),day(c.clbfechanacimiento) as dia,sl.slnnombre
                                    FROM btycolaborador c
                                    JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                                    join btysalon_base_colaborador sb on sb.clbcodigo=c.clbcodigo
                                    join btysalon sl on sl.slncodigo=sb.slncodigo
                                    WHERE MONTH(c.clbfechanacimiento)= $ind
                                    AND bty_fnc_estado_colaborador(c.clbcodigo)='vinculado'
                                    and sb.slchasta is null
                                    ORDER BY dia";
                        $resmes=$conn->query($sqlcumpmes);
                        if($resmes->num_rows>0){     
                            while($rowmes=$resmes->fetch_array()){
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $rowmes[1];?></td>
                                        <td><?php echo utf8_encode($rowmes[0]);?></td>
                                        <td><?php echo $rowmes[2];?></td>
                                    </tr>
                                <?php
                            }
                        }else{
                            echo '<tr><td colspan="3" class="text-center">No hay cumpleaños éste mes</td></tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detpermiso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="pe-7s-coffee"></i> AUSENCIAS PROGRAMADAS PENDIENTES POR SALÓN</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">SALÓN</th>
                            <th class="text-center">CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $sql="SELECT 
                                sl.slnnombre,count(*)
                                FROM btypermisos_colaboradores as pc 
                                join btysalon sl on sl.slncodigo=pc.slncodigo
                                where  pc.perestado_tramite = 'REGISTRADO' and pc.perestado=1
                                group by pc.slncodigo";
                        $res=$conn->query($sql);
                        while($row=$res->fetch_array()){
                    ?>
                        <tr>
                            <td><?php echo $row[0];?></td>
                            <td align="center"><?php echo $row[1];?></td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detcol">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="pe-7s-users"></i> DETALLE COLABORADORES</h4>
            </div>
            <div class="modal-body">
            <?php
                $totcol = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM btycolaborador c WHERE c.clbestado=1"));
                $vincul = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS cant
                                                FROM (
                                                SELECT bty_fnc_estado_colaborador(c.clbcodigo)
                                                FROM btycolaborador AS c
                                                WHERE bty_fnc_estado_colaborador(c.clbcodigo) = 'VINCULADO') AS c"));
                $desvincul=intval($totcol[0])-intval($vincul[0]);
            ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Vinculados</td>
                            <td><?php echo $vincul[0];?></td>
                        </tr>
                        <tr>
                            <td>Desvinculados</td>
                            <td><?php echo $desvincul;?></td>
                        </tr>
                        <tr>
                            <th>Total colaboradores</th>
                            <td><?php echo $totcol[0];?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer-->
<footer class="footer" style="position: fixed;">
    <span class="pull-right">
       <b> Derechos Reservados <script>var f = new Date(); document.write(f.getFullYear())</script>
    </span>
    <b>BEAUTY SOFT</b> 
</footer>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script>//select de cambio de graficos
    $("#cumplehoy").click(function(e){
        $("#modal-cumplehoy").modal('show');
    })
    $("#btncumplemes").click(function(e){
        $("#modal-cumplemes").modal('show');
    })
    $("#btncumplemes2").click(function(e){
        $("#modal-cumplemes2").modal('show');
    })
    $("#detalleper").click(function(e){
        $("#modal-detpermiso").modal('show');
    })
    $("#detallecol").click(function(e){
        $("#modal-detcol").modal('show');
    })
</script>
<script>
    $(".exportmes").click(function(e){
        var mes=$(this).data('mes');
        window.open('php/reportecumpleanos.php?opc=mesact&mes='+mes);
    });
    $(".exportmesn").click(function(e){
        var mes=$(this).data('mes');
        window.open('php/reportecumpleanos.php?opc=nextmes&mes='+mes);
    });
</script>


<?php
 include '../cnx_data.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty Soft | Citas </title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">

    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />

    <!-- <link rel="stylesheet" href="../../lib/vendor/select2-3.5.2/select2.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css"> -->

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" /> -->

    <link rel="stylesheet" href="js/select2-4-0-1.min.css" />

</head>
<body class="fixed-navbar sidebar-scroll" style="position: relative;">


<!-- Main Wrapper -->

<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="hpanel">
                <div class="panel-heading">REGISTRO DE CITAS <a href="./" class="btn btn-primary btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="Volver al inicio."><i class="fa fa-chevron-left"></i></a></div>
                    <div class="panel-body">
                        <div class="text-center m-b-md" id="wizardControl">
                            <a class="btn btn-primary" id="paso1" href="#step1" data-toggle="tab" title="Indique su número de documento">Paso 1</a>
                            <a class="btn btn-default disabled" id="paso2" href="#step2" data-toggle="tab" title="Agende su cita">Paso 2</a>
                            <a class="btn btn-default disabled" id="paso3" href="#step3" data-toggle="tab">Paso 3</a>
                        </div>
                            
                        <div class="tab-content">
                            <div id="step1" class="p-m tab-pane active">
                                <div class="row">
                                    <div class="col-lg-3 text-center">
                                        <i class="pe-7s-user fa-5x text-muted"></i>
                                            <p class="small m-t-md">
                                                Digite su <strong> documento de identidad </strong>para validar su registro.
                                            </p>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="form-group col-lg-12">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="txtValDoc" placeholder="Documento de identidad"> 
                                                        <span class="input-group-btn"> 
                                                            <button type="button" id="btnValdoc" class="btn btn-primary"><i class="fa fa-search"></i>
                                                            </button> 
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="step2" class="p-m tab-pane">
                                <div class="row">
                                    <div class="col-lg-3 text-center">
                                        <i class="pe-7s-pen fa-5x text-muted"></i>
                                            <p class="small m-t-md">
                                                <strong>Agende</strong> el servicio deseado y estaremos contactándonos con usted.
                                            </p>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <form id="formCliente" action="" method="POST">
                                                <input type="hidden" name="codcli" id="codcli">
                                                <input type="hidden" name="documCli" id="documCli">

                                                    <div class="form-group col-lg-6">
                                                        <label>Salón</label>
                                                            <select class="selectpicker form-control" id="salon" name="salon" data-live-search="true" data-size="10"  style="width: 100%">
                                                                <option value="0">SELECCIONE</option>
                                                                <?php 
                                                      
                                                                $sql = mysqli_query($conn,"SELECT a.slncodigo, a.slnnombre FROM btysalon a ORDER BY a.slnnombre");

                                                                while ($row = mysqli_fetch_array($sql)) 
                                                                {  
                                                                    echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';

                                                                }

                                                                ?>                                            
                                                            </select>
                                                    </div>

                                                    <div class="form-group col-lg-6">
                                                        <label for="">Fecha</label>
                                                            <div class="row">                                    
                                                                <div class="col-md-12">
                                                                    <div class="input-group date">
                                                                        <input type="text" class="form-control" name="fecha_de" id="fecha_de" value="<?php echo $today ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                                    </div>
                                                                </div>                                    
                                                            </div>                              
                                                    </div>

                                                     <div class="form-group col-lg-6">
                                                        <label for="">Hora</label>
                                                            <div class="row">                                    
                                                                <div class="col-md-12">
                                                                    <div class="input-group clockpicker">
                                                                        <input type="text" class="form-control" value="00:00" name="hora_de" id="hora_de"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                                    </div>
                                                                </div>                                    
                                                            </div>                              
                                                    </div>

                                                    <div class="form-group col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12 form-group">
                                                                <label>Observaciones</label>
                                                                     <textarea name="txtobser" id="txtobser" class="form-control" placeholder="Observaciones" rows="3" required="required" style="resize: none"></textarea>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    
                                        </div><!-- row -->
                                    </div><!-- col-lg-9 -->
                                </div><!-- row arriba -->

                                <div class="text-right m-t-xs"> 
                                <p class="text-primary">¿Desea ampliar los detalles del agendamiento?</p>   
                                    <a class="btn btn-warning" id="btnSI">SI</a>
                                    <a class="btn btn-primary" id="btnAgendar">NO</a>
                                </div>
                            </div><!-- /step2 -->

                            <div id="step3" class="tab-pane">
                                <div class="row text-center m-t-lg m-b-lg">
                                    <div class="col-lg-12">
                                        <h3 class="panel-title"><span id="txtResumen"></span></h3>
                                        <p class="small m-t-md" style="font-size: 1.1em;">
                                                <strong>Recuerde</strong> llegar al salón 10 minutos antes.                                
                                        </p>
                                        <div class="list-group" id="lista"></div>
                                       
                                    </div>                               
                                </div>
                        </form>
                        </div>
                    </div> 
                </div><!-- panel-body -->
            </div>
        </div>
    </div>
</div>

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
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
        <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a1.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a3.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a4.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>

                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>

</div>



<!-- Modal Nuevo Cliente-->
<div class="modal fade" id="modalNuevoCli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> REGISTRO</h4>

      </div>
        <div class="modal-body">
            <div class="row centered-form">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-edit"></i> Diligencie el formulario </h3>
                        </div>
                        <div class="panel-body">
                            <!-- <form name="simpleForm" novalidate id="simpleForm" action="#" method="post"> -->

                                <div class="text-center m-b-md" id="wizardControl">
                                    <a class="btn btn-primary" id="tipodecliente" href="#data1" data-toggle="tab">TIPO CLIENTE</a>
                                    <a class="btn btn-default" id="datosregistro" href="#data2" data-toggle="tab">DATOS DE REGISTRO</a>
                                    <a class="btn btn-default" id="registrar" href="#data3" data-toggle="tab">REGISTRAR</a>
                                </div>

                                <div class="tab-content">
                                    <div id="data1" class="p-m tab-pane active">
                                        <div class="row">
                                
                                            <!-- <form role="form"> -->
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">TIPO DOCUMENTO</label>
                                                            <br>
                                                                <select class="selectpicker" id="tipodoc" data-live-search="true" data-size="10" style="width: 100%!important">
                                                                    <?php                                            
                                                                        $sql = mysqli_query($conn,"SELECT a.tdicodigo, a.tdinombre FROM btytipodocumento a WHERE a.tdiestado = 1 ORDER BY a.tdinombre");
                                                                            echo '<option value="0" selected>TIPO DE DOCUMENTO</option>';

                                                                            while ($row = mysqli_fetch_array($sql)) 
                                                                            {  
                                                                                echo '<option value="'.$row['tdicodigo'].'">'.utf8_encode($row['tdinombre']).'</option>';

                                                                            }
                                                                    ?>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                             <label for="">DOCUMENTO</label>
                                                                <div class="input-group">
                                                                    <input type="number" id="nroDoc" placeholder="" class="form-control"> 
                                                                        <span class="input-group-btn"> 
                                                                                <button type="button" id="btnDv" class="btn btn-primary"><i class="fa fa-check"></i></button> 
                                                                        </span>
                                                                </div>
                                                         </div>
                                                    </div>
                                                </div>

            

                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">NOMBRES</label>
                                                                <input type="text" class="form-control" id="nombres" placeholder="">
                                                        </div>
                                                    </div>

                                                   <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">APELLIDOS</label>
                                                            <input type="text" class="form-control" id="apellidos" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="input-group"><select name="" id="sexo" class="form-control" required="required">
                                                            <option value="0" selected>SEXO</option>
                                                            <option value="M">MASCULINO</option>
                                                            <option value="F">FEMENINO</option>
                                                        </select><span class="input-group-addon"> <span style="font-size: .8em">EXTRANJERO</span> <input type="checkbox" id="extranjero"> </span> </div>
                                                    </div>
                                                     <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <select class="selectpicker" id="tipoocupacion" data-live-search="true" title='OCUPACIÓN' data-size="10" style="width: 100%!important">
                                                                <?php                                            
                                                                    $sql = mysqli_query($conn,"SELECT ocucodigo, ocunombre FROM btyocupacion WHERE ocuestado = 1");

                                                                        while ($row = mysqli_fetch_array($sql)) 
                                                                        {  
                                                                            echo '<option value="'.$row['ocucodigo'].'">'.utf8_encode($row['ocunombre']).'</option>';

                                                                        }
                                                                ?>
                                                        </select>
                                                    </div>
                                                </div>                      
                                        </div>

                                        <div class="text-right m-t-xs">
                                            <br>
                                            <a class="btn btn-info next" id="btnNext2" href="#"><i class="fa fa-chevron-right"></i></a>
                                        </div>
                                    </div>

                                    <div id="data2" class="p-m tab-pane">

                                        <div class="row">                               

                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="">FECHA DE NACIMIENTO</label>
                                                            <div class="input-group date">
                                                            <input type="text" class="form-control" id="fechaNac" placeholder="0000-00-00"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                        </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6" id="coldepto">
                                                        <div class="form-group">
                                                             <label for="">DEPARTAMENTO</label>
                                                                <select class="selectpicker" id="selDepartamento" data-live-search="true" title='DEPARTAMENTO' data-size="10" style="width: 100%!important">
                                                                <?php                                            
                                                                    $sql = mysqli_query($conn,"SELECT depcodigo, depombre FROM btydepartamento WHERE NOT depcodigo = 0 AND depstado = 1");

                                                                        while ($row = mysqli_fetch_array($sql)) 
                                                                        {  
                                                                            echo '<option value="'.$row['depcodigo'].'">'.utf8_encode($row['depombre']).'</option>';

                                                                        }
                                                                ?>
                                                        </select>
                                                         </div>
                                                    </div>
                                                </div>

        

                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6" id="colciudad">
                                                            <div class="form-group">
                                                                <label for="">CIUDAD</label>
                                                                <select name="" id="selCiudad" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6" id="colbarrio">
                                                            <div class="form-group">
                                                                <label for="">BARRIO</label>
                                                                 <select name="" id="selBarrio" class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">DIRECCIÓN</label>
                                                                <input type="text" class="form-control" id="direccion" placeholder="DIGITE SU DIRECCIÓN">
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">MÓVIL</label>
                                                                <input type="number" class="form-control" id="movil" placeholder="DIGITE SU MÓVIL">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                     <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">FIJO</label>
                                                                <input type="number" class="form-control" id="fijo" placeholder="DIGITE SU TELÉFONO FIJO">
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">E-MAIL</label>
                                                                <input type="email" class="form-control" id="email" placeholder="DIGITE SU E-MAIL">
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">RECIBIR NOTIFICACIONES AL MOVIL</label>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="nm" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="">RECIBIR NOTIFICACIONES AL E-MAIL</label>
                                                               <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" value="" id="ne" checked>
                                                                        
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                    
                                       
                                        </div>
                                        <div class="text-right m-t-xs">
                                            <a class="btn btn-default next" id="btnNext">Siguiente</a>
                                        </div>

                                    </div>
                                    <div id="data3" class="tab-pane">
                                        <div class="row text-center m-t-lg m-b-lg">
                                            <div class="col-lg-12">
                                                <i class="pe-7s-check fa-5x text-muted"></i>
                                                <div class="form-group col-lg-12" id="terminos">
                                        <textarea class="form-control" readonly style="resize: none; min-height: 200px;font-family: Garamond; text-align:justify;">Declaro que he sido informado: (i) Que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, como responsable de los datos personales obtenidos a través de sus distintos canales de atención, han puesto a mi disposición la línea de atención nacional (5) 385 49 55, el correo electrónico direccion.comercial@claudiachacon.com y las oficinas de atención al cliente a nivel nacional, cuya información puedo consultar en www.claudiachacon.com, disponibles de lunes a viernes de 8:00 a.m. a 06:00 p.m., para la atención de requerimientos relacionados con el tratamiento de mis datos personales y el ejercicio de los derechos mencionados en esta autorización. (ii) Esta autorización permitirá al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, recolectar, transferir, almacenar, usar, circular, suprimir, compartir, actualizar y transmitir, de acuerdo con el procedimiento para el tratamiento de los datos personales en procura de cumplir con las siguientes finalidades: (1) validar la información en cumplimiento de la exigencia legal de conocimiento del cliente aplicable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (2) adelantar las acciones legales del caso, en procura de hacer sostenible y estable a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, (3) para el tratamiento de los datos personales protegidos por nuestro ordenamiento jurídico, (4) para el tratamiento y protección de los datos de contacto (direcciones de correo físico, electrónico, redes sociales y teléfono), (5) para solicitar y recibir de las distintas bases de datos y/o empresas de carácter privado la información personal, que reposa en sus bases de datos. A su vez se solicita a los titulares de los datos de los servicios ofrecidos por la Dirección Comercial de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON, de manera expresa, libre y voluntaria autorice el tratamiento de datos personales sensibles tales como el origen racial o étnico, al tenor de lo dispuesto en el artículo 6 de la ley 1581 de 2012. El alcance de la autorización comprende la facultad para que INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON le envíe mensajes con contenidos institucionales, notificaciones, información del estado de cuenta, saldos, y demás información relativa al portafolio de servicios de la entidad, a través de correo electrónico y/o mensajes de texto al teléfono móvil. (iii) Mis derechos como titular del dato son los previstos en la constitución y la ley, especialmente el derecho a conocer, actualizar, rectificar y suprimir mi información personal; así como el derecho a revocar el consentimiento otorgado para el tratamiento de datos personales. Estos los puedo ejercer a través de los canales dispuestos por NVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para la atención al público y observando la política de tratamiento de datos personales de INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON  disponible en www.claudiachacon.com; Otorgo mi consentimiento al INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON para tratar mi información personal, de acuerdo con la política de tratamiento de datos personales, y por tanto me comprometo a leer el aviso de privacidad y la política mencionada disponible en: www.claudiachacon.com. Autorizo a INVELCON SAS y sus establecimientos PELUQUERIAS CLAUDIA CHACON a modificar o actualizar su contenido, a fin de atender reformas legislativas, políticas internas o nuevos requerimientos para la prestación u ofrecimiento de servicios o productos, dando aviso previo por medio de la página web de la compañía, y/o correo electrónico. La información del formato del cual forma parte la presente autorización la he suministrado de forma voluntaria y es verídica.
                                    </textarea>
                                    </div>
                                            </div>
                                            <div class="checkbox col-lg-12">
                                                <input type="checkbox" class="i-checks approveCheck" name="approve" id="aprobar">
                                                Estoy de acuerdo
                                            </div>
                                        </div>
                                        <div class="text-right m-t-xs">
                                            <button type="button" id="btnRegistrarCli" class="btn btn-default">REGISTRAR</button>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div> -->
    </div>
  </div>
</div>



<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="../lib/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../lib/vendor/moment/min/moment-with-locales.js"></script>

<script src="../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script> -->

<script src="js/select-2-4-0-1.min.js"></script>

 <script src="https://www.google.com/recaptcha/api.js?hl=es"></script> 

<!-- <script src="../../lib/vendor/select2-3.5.2/select2.min.js"></script> -->


<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>
<script src="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>



<script src="js/main.js"></script>

</body>
</html>

<style>
	.select2-no-results 
	{
    	display: none !important;
	}

    .btn-group .bootstrap-select
    {
        width: 100%!important;
    }

    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
}

.bcli{
    font-size: .8em;
}
</style>

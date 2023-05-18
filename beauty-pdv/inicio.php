<?php 
    session_start();
    include("../cnx_data.php");
    include("head.php");
    include("librerias_js.php");

    $cod_salon = $_SESSION['PDVslncodigo'];
    $salon     = $_SESSION['PDVslnNombre'];
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>


<style>
    #flotTip 
    {
        padding: 3px 5px;
        background-color: #000;
        z-index: 100;
        color: #fff;
        opacity: .80;
        filter: alpha(opacity=85);
    } 
</style>

<input type="hidden" value="<?php echo $salon ?>" class="sln">
<input type="hidden" value="<?php echo $cod_salon ?>" id="cod_salon">

<div class="container-fluid">
    <div class="content animate-panel">
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel hbggreen">
                    <a href="citas"><div class="panel-body" style="background-color: #62cb31!important">
                        <div class="text-center">
                            <h3>CITAS</h3>
                            <p class="text-big font-light">
                                <?php  

                                    $QueryCitas =mysqli_fetch_array(mysqli_query($conn,"SELECT count(*) as Cantidad from btycita where slncodigo='".$_SESSION['PDVslncodigo']."' and citfecha=CURDATE()"));
                                    echo $QueryCitas['Cantidad'];

                                ?>
                            </p><br>
                            <small>
                                Recuerde que los clientes se deben presentar con al menos diez (10) minutos de anticipaci&oacute;n a la Cita.<br>
                            </small>
                        </div>
                    </div></a>
                </div>
            </div>


            <div class="col-md-3">
                <div class="hpanel hbgblue">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>CUMPLEA&Ntilde;OS</h3>
                            <p class="text-big font-light">
                                <?php  

                                    $QueryCumpleanos =mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS Cantidad FROM ((select c.clbcodigo from btycolaborador as c where MONTH(c.clbfechanacimiento)=MONTH(CURDATE()) AND DAY(c.clbfechanacimiento)=DAY(CURDATE())) UNION (select c.clicodigo from btycliente as c where MONTH(c.clifechanacimiento)=MONTH(CURDATE()) AND DAY(c.clifechanacimiento)=DAY(CURDATE()))) AS A "));
                                    echo $QueryCumpleanos['Cantidad'];

                                ?>
                            </p><br>
                            <small>
                                Recuerda llamar a tus clientes y compañeros para desearles un Feliz Dia !<br>
                            </small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="hpanel hbgyellow">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>AUSENCIAS</h3>
                            <p class="text-big font-light">
                               <?php  

                                    $QueryPermisos =mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS Cantidad from btypermisos_colaboradores as pc where pc.perfecha_desde=CURDATE() AND pc.slncodigo='".$_SESSION['PDVslncodigo']."' AND pc.perestado_tramite='AUTORIZADO' OR (CURDATE() BETWEEN pc.perfecha_desde and pc.perfecha_hasta) and pc.perestado_tramite='AUTORIZADO' and pc.slncodigo='".$_SESSION['PDVslncodigo']."'"));
                                    echo $QueryPermisos['Cantidad'];

                                ?>
                            </p><br>
                            <small>
                                Novedades ya autorizadas en la Programación.
                            </small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="hpanel hbgred">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>COLABORADORES</h3>
                            <p class="text-big font-light">
                                <?php  

                                $QueryColaboradores =mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) as Cantidad FROM btyprogramacion_colaboradores as p, btytipo_programacion as tp, btyturno as t, btycolaborador as c, btycargo as cr  where c.clbcodigo=p.clbcodigo and c.crgcodigo=cr.crgcodigo and cr.crgincluircolaturnos='1' and t.trncodigo=p.trncodigo and  tp.tprcodigo=p.tprcodigo and tp.tprlabora='1' and  p.slncodigo='".$_SESSION['PDVslncodigo']."' and p.prgfecha=CURDATE() and (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trndesde and t.trnhasta ) and not (TIME_FORMAT(CURTIME(),'%H:%i:%s') BETWEEN t.trninicioalmuerzo and t.trnfinalmuerzo)"));
                                echo $QueryColaboradores['Cantidad'];

                                ?>

                            </p><br>
                            <small>
                                Recuerde verificar si a esta hora cuenta en el Salón con esta cantidad de Colaboradores.<br>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row -->

        <div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">CITAS</h2>
                            <div class="m">
                                <i class="pe-7s-pen fa-5x"></i>
                            </div>
                            <button class="btn btn-success btn-sm" id="btnModalCitas" style="background-color: #62cb31!important; border-color:#62cb31!important ">Ver Hoy</button>

                            <?php 

                                $ultimoDia = "SELECT LAST_DAY(CURDATE());";

                                $hoy = date("Y-m-d");

                                $date = mysqli_fetch_array($ultimoDia);

                                $QueryCitasB = mysqli_query($conn, "SELECT * FROM btycita WHERE slncodigo='".$_SESSION['PDVslncodigo']."' AND MONTH(citfecha) = MONTH(CURDATE())  AND year(citfecha) = year(CURDATE()) AND DAY(citfecha)= DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY))");
                                $countcitas = mysqli_num_rows($QueryCitasB);
                                if ($countcitas > 0) 
                                {
                                    echo '<button class="btn btn-default btn-sm" type="button" id="btnCitasSig" title="Para el día de mañana se registra(n) '.$countcitas.' cita(s)">Ver Mañana <span class="badge badge-success" style="background-color: #62cb31 !important">'.$countcitas.'</span></button>';
                                }
                                else
                                {
                                    echo '<button class="btn btn-default btn-sm disabled" type="button" title="Para mañana no se registran citas" id="">Ver Mañana</button>';                                    
                                }
                            ?>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">CUMPLEAÑOS</h2>
                            <div class="m">
                                <i class="fa fa-birthday-cake fa-5x"></i>
                            </div>
                            <button class="btn btn-info btn-sm" type="button" id="btnModalCumple">Ver Hoy</button>
                            <?php 
                            $QueryCumpleClientes = mysqli_query($conn, "SELECT b.trcrazonsocial, a.clifechanacimiento, b.trctelefonomovil, a.cliemail FROM btycliente a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE MONTH(a.clifechanacimiento) = MONTH(CURDATE()) AND DAY(a.clifechanacimiento) = DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY)) ");
                                $rows = mysqli_num_rows($QueryCumpleClientes);
                                if ($rows > 0) 
                                {
                                    echo '<button class="btn btn-default btn-sm" type="button" id="btnModalCumpleSig" title="El día de mañana cumple(n) '.$rows.' cliente(s)">Ver Mañana <span class="badge badge-info">'.$rows.'</span></button>';
                                }
                                else
                                {
                                    echo '<button class="btn btn-default btn-sm disabled" type="button" title="Para mañana no se registran cumpleaños" id="">Ver Mañana</button>';                                    
                                }
                             ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">AUSENCIAS</h2>
                            <div class="m">
                                <i class="pe-7s-coffee fa-5x"></i>
                            </div>
                            <button class="btn btn-warning btn-sm"  id="btnVerPermisos">Ver detalles</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">COLABORADORES</h2>
                            <div class="m">
                                <i class="pe-7s-users fa-5x"></i>
                            </div>
                            <button class="btn btn-danger btn-sm" id="btnVerColab">Ver detalles</button>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row -->


        <div class="row">           
            <div class="col-md-6">
                <div class="hpanel">
                    <div class="panel-body" style="padding-top: 20px">
                        <h6><center>CUMPLEAÑOS</center></h6>
                        <br>
                        <select name="" id="selClienteCol" class="form-control" required="required">
                                <option value="1">COLABORADOR</option>
                                <option value="2">CLIENTE</option>                               
                        </select>
                        <br>
                       
                        <div class="contenedorAni">
                            <canvas id="cumpleAnio" style="width:100%;height:300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body" style="padding-top: 0px">
                         <div class="stats-title">
                            <h4 style="text-align: center;">Ausencias / Col <?php echo $_SESSION['PDVslnNombre'] ?></h4>
                        </div>
                            <select name="" id="selMes" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                                <option value="3">AÑO ACTUAL</option>
                            </select>

                        <canvas id="permisosCol1" style="width:100%;height:300px;"></canvas>
                        <canvas id="permisosCol2" style="width:100%;height:300px;"></canvas>
                        <canvas id="permisosCol3" style="width:100%;height:300px;"></canvas>
                    </div>

                </div>
            </div>


            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <h6><center><b>METAS</center></b></h6>
                            <table class="table table-striped" id="tblmetascargo">                                
                                <tbody>
                                                               
                                </tbody>
                            </table>
                            <h6><center><b>PROMOCIÓN DEL DÍA</center></b></h6>

                            <table class="table table-striped">
                                <tbody>
                             <?php 
                                $dia = date('l');
                                $semana = array(
                                    'Monday'    => 'LUNES' ,
                                    'Tuesday'   => 'MARTES',
                                    'Wednesday' => 'MIERCOLES',
                                    'Thursday'  => 'JUEVES',
                                    'Friday'    => 'VIERNES',
                                    'Saturday'  => 'SABADO',
                                    'Sunday'    => 'DOMINGO',
                                );

                                $d = "SELECT a.pmonombre, a.pmocodigo, b.tpmnombre, a.pmocondyrestric, a.pmodescripcion,a.lgbfechainicio,a.lgbfechafin, d.slnnombre FROM btypromocion a JOIN btypromocion_tipo b ON a.tpmcodigo=b.tpmcodigo JOIN btypromocion_detalle c ON c.pmocodigo=a.pmocodigo JOIN btysalon d ON d.slncodigo=c.slncodigo WHERE c.slncodigo = '".$cod_salon."' AND c.pmddia = '".$semana[$dia]."'";

                                $sql = mysqli_query($conn, $d);

                                if (mysqli_num_rows($sql) > 0) 
                                {
                                    while ($row = mysqli_fetch_array($sql)) 
                                    {
                                        echo '<tr>
                                                <td>
                                                    <center><span id="btnVermas" data-idpromo="'.$row['pmocodigo'].'" class="text-info font-bold" data-toggle="tooltip" data-placement="top" title="'.utf8_encode($row['pmodescripcion']).'" style="cursor: pointer">'.utf8_encode($row['tpmnombre']) . " ".utf8_encode($row['pmonombre']).'</span></center>
                                                </td>
                                                
                                            </tr>';
                                    }
                                }
                                else
                                {
                                     echo '<tr>
                                                <td>
                                                    <span class="text-info font-bold"><center>NO HAY PROMOCIONES ESTE DÍA</center></span>
                                                </td>
                                            </tr>';
                                }

                             ?>
                               
                                
                               
                                </tbody>
                            </table>    
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row -->


        <div class="row">            
            <div class="col-md-6">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Total Citas por Salón </h4>
                        </div>
                            <select name="" id="rangoMes" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                            </select>
                        <br><br>
                       <canvas id="myChart" width="400" height="170"></canvas>
                       <canvas id="myChart2" width="400" height="170"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
               <div class="hpanel">
                   <div class="panel-body">
                       <div class="stats-title pull-left">
                           <h4>Top 10 Colaboradores más agendado</h4>
                       </div>
                            <select name="" id="rangoMesTop" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                            </select>
                        <br><br>
                       <canvas id="top10" width="400" height="170"></canvas>
                       <canvas id="top10a" width="400" height="170"></canvas>
                   </div>
               </div>
           </div>
        </div><!-- End Row --> 


        <div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Citas / Medios: <?php echo $_SESSION['PDVslnNombre'] ?></h4>
                        </div>
                            <select name="" id="selRangoMedios" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                            </select>

                        <canvas id="flot-pie-chart" style="width:100%;height:300px;"></canvas>
                        <canvas id="flot" style="width:100%;height:300px;"></canvas>
                       
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Col más agendado: <?php echo $_SESSION['PDVslnNombre'] ?></h4>
                        </div>
                            <select name="" id="selSalnCol" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                            </select>

                        <canvas id="citasCol1" style="width:100%;height:300px;"></canvas>
                        <canvas id="citasCol2" style="width:100%;height:300px;"></canvas>
                       
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="hpanel">
                    <div class="panel-body">
                       <div class="stats-title pull-left">
                            <h4>Novedades Biométrico <?php echo $_SESSION['PDVslnNombre'] ?></h4>
                        </div>

                            <select name="" id="selMesNov" class="form-control" required="required">
                                <option value="1">MES ACTUAL</option>
                                <option value="2">MES ANTERIOR</option>
                                <option value="3">AÑO ACTUAL</option>
                            </select>
                        <br>
                       <div class="contenedor">
                            <canvas id="novedadCol2" width="400" height="170"></canvas>
                        </div>                       
                    </div>
                </div>
            </div>
        </div><!-- End Row -->      
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalCumple" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cumpleaños del Día <i class="fa fa-birthday-cake"></i></h4>
            </div>
            <div class="modal-body">
                <center><h5><b>CUMPLEAÑOS COLABORADORES</b></h5></center>
                    <div class="table-responsive">
                         <table class="table table-hover table-bordered table-striped" id="tblcumple">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>CARGO</th>
                                    <th>SALÓN BASE</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <center><h5><b>CUMPLEAÑOS CLIENTES</b></h5></center>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="tblcumplecli">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>MOVIL</th>
                                    <th>E-MAIL</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal -->


<!-- Modal Cumple Dia siguiente -->
<div class="modal fade" id="modalCumpleClientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cumpleaños de Clientes Día de Mañana <i class="fa fa-birthday-cake"></i></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tblcumpleCliente">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>MOVIL</th>
                                <th>E-MAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal Cumple Dia siguiente -->


<!-- Modal  citas-->
<div class="modal fade" id="modalcitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document"  style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Citas del Día <i class="pe-7s-pen"></i></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tblcitas">
                        <thead>
                            <tr>
                                <th>CITA N°</th>
                                <th>CLIENTE</th>
                                <th>MÓVIL</th>
                                <th>SERVICIO</th>
                                <th>HORA</th>
                                <th>COLABORADOR</th>
                                <th>ESTADO</th>
                                <th style="text-align: center;">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal  citas-->


<!-- Modal  Dia siguiente Citas -->
<div class="modal fade" id="modalcitasSig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document"  style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Citas de Mañana <i class="pe-7s-pen"></i></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tblcitassig">
                        <thead>
                            <tr>
                                <th>CITA N°</th>
                                <th>CLIENTE</th>
                                <th>MÓVIL</th>
                                <th>SERVICIO</th>
                                <th>HORA</th>
                                <th>COLABORADOR</th>
                                <th>ESTADO</th>
                                <th style="text-align: center;">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal  Dia siguiente Citas -->


<!-- Modal Permisos-->
<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ausencias del Día <i class="pe-7s-coffee"></i></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tblpermisos" >
                        <thead>
                            <tr>
                                <th>PERMISO N°</th>
                                <th>COLABORADOR</th>
                                <th>DESDE</th>
                                <th>HORA</th>
                                <th>HASTA</th>
                                <th>HORA</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id="styleTbl>">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal Permisos-->


<!-- Modal Colaboradores-->
<div class="modal fade" id="modalColaboradores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog modal-lg" role="document" style="width: 70%!important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Colaboradores <i class="pe-7s-users"></i></h4>
            </div>
            <div class="modal-body modalstyle2">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tblcolaboradores" style="width: 100%">
                        <thead>
                            <tr>
                                <th>COLABORADOR</th>
                                <th>CARGO</th>
                                <th>TURNO</th>
                                <th>PERFIL</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- Fin Modal Colaboradores-->


<!-- Modal modalServicios-->
<div class="modal fade" id="modalServicios" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Servicios del colaborador</h4>
            </div>

            <div class="modal-body">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Servicios Autorizados</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <img src="" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="180" height="180">
                            </div>
                            <div class="col-xs-9">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" id="txtCodigoColaborador">
                                    </div>
                                </div>                                
                        
                                <div class="form-group">                  
                                    <div id="listaData"></div>         
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" id="">                             
                            <table class="table table-hover table-bordered table-striped" id="tblLista" style="width: 100%">
                                <thead>
                                    <tr class="info">
                                        <th>Servicio</th>
                                        <th>Duración</th> 
                                    </tr>         
                                </thead>

                                <tbody>

                                </tbody>                        
                            </table>                      
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" title="Cerrar ventana">Cerrar</button>
            </div>
        </div>
    </div>
</div><!-- Fin Modal modalServicios-->


<!-- Modal Reporte -->
<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="myModalLabel">Seleccionar Tipo Reporte</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <select name="" id="selReport" class="form-control" required="required">
                            <option value="1">AGENDA</option>
                            <option value="2">BIOMÉTRICO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnIr">Ir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal Reporte -->


<!-- Modal Info-->
<div class="modal fade" id="masInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="pe-7s-info"></i> Condiciones y Restricciones</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Condiciones</h3>
                    </div>
                    <div class="panel-body" id="tblCondicion"></div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Aplica para los Días</h3>
                    </div>
                    <div class="panel-body" id="">
                        <table class="table table-bordered table-hover" id="tblDias">                   
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div><!-- Fin Modal Info-->



<style>
    td, th
    {
        white-space: nowrap;
    }   
</style>


<script src="js/sube_baja.js"></script>
<script src="js/indicadores.js"></script>

<script>

$(document).ready(function() 
{
   
    $('[data-toggle="tooltip"]').tooltip();

        $(document).on('click', '.sln_nombre', function() 
        {
            var id = $('#cod_salon').val();
            $('#modalVerSalon').modal("show");
            $('body').removeClass("modal-open");
            $('body').removeAttr("style");

            $.ajax({
                url: 'php/sube_baja/cargar_imagen_sln.php',
                method: 'POST',
                data: {id:id},
                success: function (data) 
                {
                    var array = eval(data);
                    for(var i in array)
                    {
                        $('#title_imagen').html("Salón "+array[i].nombre);
                        $("#imagen_salon").removeAttr("src");        
                        $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
                    }
                }
            });
        });
});
       

/***********************************/
         //GRAFICA MEDIOS//
/***********************************/

$(document).on('change', '#selRangoMedios', function() 
{   
    var rango = $('#selRangoMedios').val();
    fnMedios (rango);
});


function fnMedios (rango) 
{
    var rango = $('#selRangoMedios').val();

    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "medios", rango:rango},
        success: function (data) 
        {
            var nombre = [];
            var sum    = [];

            for(var count in data)
            {
                nombre.push(data[count].nombre);
                sum.push(data[count].count);
            }

            if (rango == 1) 
            {
                $('#flot-pie-chart').show();
                $('#flot').hide();
                new Chart(document.getElementById("flot-pie-chart"), 
                {
                    type: 'pie',
                    data: 
                    {
                        labels: nombre,
                        datasets: [{
                            backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                            data: sum
                        }]
                    },
                        options: {
                            title: {
                                display: true,
                            }
                        }
                });
            }
            else
            {
                $('#flot-pie-chart').hide();
                $('#flot').show();
                new Chart(document.getElementById("flot"), 
                {
                    type: 'pie',
                    data: 
                    {
                        labels: nombre,
                        datasets: [{
                            backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                            data: sum
                        }]
                    },
                        options: {
                            title: {
                                display: true,
                            }
                        }
                });
            }

           
        }
       
    });
}
       
  /**************************************/

$(document).ready(function() 
{
    loadGraph ();
    loadTop();
    loadColSalon ();
    fnPermisosCol();
    Chart.defaults.global.legend.display = false;
    fnMedios(); 
});

var sln    = $('#cod_salon').val();
var canvas = $('#myChart')[0];


$(document).on('change', '#rangoMes', function() 
{   
    var rango = $('#rangoMes').val();
    loadGraph (rango);
});

$(document).on('change', '#rangoMesTop', function() 
{   
    var rango = $('#rangoMesTop').val();
    loadTop (rango);
});

$(document).on('change', '#selSalnCol', function() 
{   
    var rango = $('#selSalnCol').val();
    loadColSalon (rango);
});



function loadGraph (rango) 
{
        rango = $('#rangoMes').val();
        $.ajax({
            url: 'php/indicadores/dataGrafica.php',
            type: 'POST',
            data: {opcion: "graph1", rango:rango, sln:sln},
            success:function(data)
            {
                var nombre = [];
                var sum    = [];
                var col    = [];

                col = ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc"];

                for(var count in data)
                {
                    nombre.push(data[count].nombre);
                    sum.push(data[count].count);
                    col.push(data[count].col);
                }



                var chartdata = 
                {
                    labels: nombre,
                    datasets: [
                        {
                            label: 'Citas por Salón',
                            backgroundColor: col,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverbackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverborderColor: 'rgba(200, 200, 200, 1)',
                            data:sum
                        }
                    ] 
                };

                if (rango == 1) 
                {
                
                    $('#myChart').show();
                    $('#myChart2').hide();
                    var ctx = $('#myChart').get(0).getContext("2d");
                    var barGraph = new Chart(ctx, 
                    {
                        type:'bar',
                        data: chartdata,
                        options: 
                        {
                            legend: 
                            {
                                display: false
                            },
                            scales: 
                            {
                                pointLabelFontSize: 10
                            }        
                        }
                    });
                }
                else
                {
                    $('#myChart').hide();
                    $('#myChart2').show();
                    ctx = $('#myChart2').get(0).getContext("2d");
                    barGraph = new Chart(ctx, 
                    {
                        type:'bar',
                        data: chartdata,
                        options: 
                        {
                            legend: 
                            {
                                display: false
                            },
                            scales: 
                            {
                                pointLabelFontSize: 10
                            }        
                        }
                    });
                }
            },
                error:function(data)
                {
                    //console.log(data);
                }
        });
}

/*****************************/


function loadTop () 
{

        rango = $('#rangoMesTop').val();
        $.ajax({
            url: 'php/indicadores/dataGrafica.php',
            type: 'POST',
            data: {opcion: "graph2", rango: rango},
            success:function(data)
            {
                //console.log(data);   

                var nombre = [];
                var sum    = [];
                var nom    = [];
                var col    = [];

                col = ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc"];

                for(var count in data)
                {
                  nombre.push(data[count].nombre);
                  sum.push(data[count].count);
                }

                var chartdata = 
                {
                    labels: nombre,
                    datasets: [
                        {
                            label: 'Top 10 Colaboradores',
                            backgroundColor: col,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverbackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverborderColor: 'rgba(200, 200, 200, 1)',
                            data:sum
                        }
                    ] 
                };

                if (rango == 1) 
                {
                    $('#top10').show();
                    $('#top10a').hide();
                    var ctx = $('#top10').get(0).getContext("2d");
                    var barGraph = new Chart(ctx, 
                    {
                        type:'horizontalBar',
                        backgroundColor: "#4e62d8",
                        data: chartdata,
                        options: 
                        {
                            legend: 
                            {
                                display: false
                            },      
                        }
                    });
                }
                else
                {
                    $('#top10a').show();
                    $('#top10').hide();
                    ctx = $('#top10a').get(0).getContext("2d");
                    barGraph = new Chart(ctx, 
                    {
                        type:'horizontalBar',
                        backgroundColor: "#4e62d8",
                        data: chartdata,
                        options: 
                        {
                            legend: 
                            {
                                display: false
                            },      
                        }
                    });
                }

                
                       
            },
                error:function(data)
                {
                    //console.log(data);
                }
        });
}


/************************************/
        //GRAFICA COLAB CITAS
/************************************/


function loadColSalon () 
{

    rango = $('#selSalnCol').val();
    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "colabSln", rango:rango},
        success: function (data) 
        {
            var nombre = [];
            var sum    = [];

            for(var count in data)
            {
                nombre.push(data[count].nombre);
                sum.push(data[count].count);
            }

            if (rango == 1) 
            {
                $('#citasCol1').show();
                $('#citasCol2').hide();
                new Chart(document.getElementById("citasCol1"), 
                {
                    type: 'pie',
                    data: 
                    {
                        labels: nombre,
                        datasets: [{
                            backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                            data: sum
                        }]
                    },
                        options: {
                            title: {
                                display: true,
                            }
                        }
                });
            }
            else
            {
                $('#citasCol1').hide();
                $('#citasCol2').show();
                new Chart(document.getElementById("citasCol2"), 
                {
                    type: 'pie',
                    data: 
                    {
                        labels: nombre,
                        datasets: [{
                            backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                            data: sum
                        }]
                    },
                        options: {
                            title: {
                                display: true,
                            }
                        }
                });
            }
           
        }
       
    });
}


/*===============================================
=            GRAFICA DE PERMISOS COL            =
===============================================*/

$(document).on('change', '#selMes', function() 
{
    var rango = $('#selMes').val();
    fnPermisosCol (rango);
});

function fnPermisosCol (rango) 
{
    var rango = $('#selMes').val();

    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "permisos", rango:rango},
        success: function (data) 
        {
            var nombre = [];
            var sum    = [];

            for(var count in data)
            {
                nombre.push(data[count].nombre);
                sum.push(data[count].count);
            }


            switch (rango) 
            {
                case '1':
                    $('#permisosCol1').show();
                    $('#permisosCol2').hide();
                    $('#permisosCol3').hide();

                    new Chart(document.getElementById("permisosCol1"), 
                    {
                        type: 'pie',
                        data: 
                        {
                            labels: nombre,
                            datasets: [{
                                backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                                data: sum
                            }]
                        },
                            options: {
                                title: {
                                    display: true,
                                }
                            }
                    });

                    break;

                case '2':

                        $('#permisosCol1').hide();
                        $('#permisosCol3').hide();
                        $('#permisosCol2').show();
                        new Chart(document.getElementById("permisosCol2"), 
                        {
                            type: 'pie',
                            data: 
                            {
                                labels: nombre,
                                datasets: [{
                                    backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                                    data: sum
                                }]
                            },
                                options: {
                                    title: {
                                        display: true,
                                    }
                                }
                        });

                    break;

                case '3':

                        $('#permisosCol1').hide();
                        $('#permisosCol2').hide();
                        $('#permisosCol3').show();
                        new Chart(document.getElementById("permisosCol3"), 
                        {
                            type: 'pie',
                            data: 
                            {
                                labels: nombre,
                                datasets: [{
                                    backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#64e35e", "#cad124", "##24d1cb"],
                                    data: sum
                                }]
                            },
                                options: {
                                    title: {
                                        display: true,
                                    }
                                }
                        });

                    break;
                default:
                    // statements_def
                    break;
            }
          
        }
       
    });
}

/*=====  End of GRAFICA DE PERMISOS COL  ======*/


/*========================================================
=            NOVEDADES BIOMETRICO COLABORADOR            =
========================================================*/

$(document).on('change', '#selMesNov', function() 
{
    var rango = $('#selMesNov').val();
    GraficaBarra (rango);
});

function fnNovedadCol (rango)//ACTUAL GRAFICA DE NOVDADES 
{
    var rango = $('#selMesNov').val();

    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "novedades", rango:rango},
        success: function (data) 
        {
            var nombre = [];
            var sum    = [];

            for(var count in data)
            {
                nombre.push(data[count].nombre);
                sum.push(data[count].count);
            }


            switch (rango) 
            {
                case '1':
                    $('#novedadCol1').show();
                    $('#novedadCol2').hide();
                    $('#novedadCol3').hide();

                    new Chart(document.getElementById("novedadCol1"), 
                    {
                        type: 'pie',
                        data: 
                        {
                            labels: nombre,
                            datasets: [{
                                backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                                data: sum
                            }]
                        },
                            options: {
                                title: {
                                    display: true,
                                }
                            }
                    });

                    break;

                case '2':

                        $('#novedadCol1').hide();
                        $('#novedadCol3').hide();
                        $('#novedadCol2').show();
                        new Chart(document.getElementById("novedadCol2"), 
                        {
                            type: 'pie',
                            data: 
                            {
                                labels: nombre,
                                datasets: [{
                                    backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                                    data: sum
                                }]
                            },
                                options: {
                                    title: {
                                        display: true,
                                    }
                                }
                        });

                    break;

                case '3':

                        $('#novedadCol1').hide();
                        $('#novedadCol2').hide();
                        $('#novedadCol3').show();
                        new Chart(document.getElementById("novedadCol3"), 
                        {
                            type: 'pie',
                            data: 
                            {
                                labels: nombre,
                                datasets: [{
                                    backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "##0d8ccb", "#0d51ce", "#290ccd"],
                                    data: sum
                                }]
                            },
                                options: {
                                    title: {
                                        display: true,
                                    }
                                }
                        });

                    break;
                default:
                    // statements_def
                    break;
            }
          
        }
       
    });
}


/***********************************/

/*********NUEVA BARRA  NOVEDADES****/

$(document).ready(function() 
{
    GraficaBarra ();
    fnAniversario();
});


function GraficaBarra (rango) 
{
    rango = $('#selMesNov').val();
    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "novedades", rango:rango},
        success:function(data)
        {


            var nombre = [];
            var sum    = [];
            var col    = [];

            col = ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc", "#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc"];

            for(var count in data)
            {
                nombre.push(data[count].nombre);
                sum.push(data[count].count);
            }



            var chartdata = 
            {
                labels: nombre,
                datasets: [
                    {
                        label: '',
                        backgroundColor: col,
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverbackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverborderColor: 'rgba(200, 200, 200, 1)',
                        data:sum
                    }
                ] 
            };

            $('.contenedor').html('');
            $(".contenedor").html('<canvas id="novedadCol2" width="400" height="170"></canvas>');
            var ctx = $('#novedadCol2').get(0).getContext("2d");
            var barGraph = new Chart(ctx, 
            {
                type:'bar',
                data: chartdata,
                options: 
                {
                    legend: 
                    {
                        display: false
                    },                        
                    tooltips: 
                    {
                        enabled: true
                    },
                    scales: 
                    { xAxes: 
                        [{ display: false, }], yAxes: [{ display: false, }], 
                    }     
                }
            });
           
            
                
            
        },
            error:function(data)
            {
                //console.log(data);
            }
    });
}

/*=====  End of NOVEDADES BIOMETRICO COLABORADOR  ======*/


/*============================================
=            GRAFICA DE CUMLEAÑOS            =
============================================*/

$(document).on('change', '#selClienteCol', function() 
{
        $('#selClienteCol').val();
        $('#selCumpleMes').val();
        fnAniversario ();
});

$(document).on('change', '#selCumpleMes', function() 
{
        $('#selClienteCol').val();
        $('#selCumpleMes').val();
        fnAniversario ();
});


function fnAniversario (rango1, rango2)//ACTUAL GRAFICA DE NOVDADES 
{
    rango1 = $('#selClienteCol').val();    


    $.ajax({
        url: 'php/indicadores/dataGrafica.php',
        type: 'POST',
        data: {opcion: "aniversario", rango1:rango1},
        success: function (data) 
        {
            var mes    = [];
            var sum    = [];

            for(var count in data)
            {
                sum.push(data[count].count);
            }
            
                $('.contenedorAni').html('');
                $(".contenedorAni").html('<canvas id="cumpleAnio" width="400" height="170"></canvas>');
                new Chart(document.getElementById("cumpleAnio"), 
                {
                    type: 'bar',
                    data: 
                    {
                        labels: ["ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEPT", "OCT", "NOV", "DIC"],
                        datasets: [{
                            backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc", "#fb9b00"],
                            data: sum
                        }]
                    },
                        options: 
                        {
                            title: 
                            {
                                display: true,
                            }
                        }
                });                   
          
        }
       
    });
}


/*=====  End of GRAFICA DE CUMLEAÑOS  ======*/



$('#modalDocumento').on('show.bs.modal', function () {
    $('#dataCaptureDoc').focus();
    $('#spinL').show();
    $('.fa-spin').addClass('fa-spin');
}); 


$(document).on('click', '#btnBarcodeDoc', function() 
{
    $('#dataCaptureDoc').focus();  
    $('#spinL').show();
    $('#docColaborador').val('');
    $('#dataCaptureDoc').val('');
    $('#nombreColaborador').val('');
});


$(document).on('blur', '#dataCaptureDoc', function() 
{
    $('#spinL').removeClass('fa-spin');
    $('#spinL').hide();
});

</script>
<?php 
include 'head.php';
include "librerias_js.php";
include "../cnx_data.php";
VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
RevisarLogin();
?>
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Servicios</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
     <div class="content animated-panel">
     	<div class="panel-body" style="background-color: white;">
            <form id="form_filtro">
                <div class="row"> 
                    <div class="form-group col-md-2">
                        <select class="form-control" id="filtipo" name="filtipo">
                            <option value=""> -Filtrar por tipo- </option>
                            <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                            <option value="REVISION">REVISIÓN</option>
                            <option value="SERVICIO">REPARACION</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <select class="form-control" id="filest" name="filest">
                            <option value=""> -Filtrar por estado- </option>
                            <option value="CANCELADO">CANCELADO</option>
                            <option value="EJECUTADO">EJECUTADO</option>
                            <option value="PROGRAMADO">PROGRAMADO</option>
                            <option value="RE-PROGRAMADO">RE-PROGRAMADO</option>
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <h5><b>Filtrar por fecha</b></h5>
                    </div>
                     <div class="form-group col-md-2">
                        <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="fildesde" id="fildesde" placeholder="Desde">
                    </div>
                    <div class="form-group col-md-1">
                        <center><h5><b>a:</b></h5></center>
                    </div>
                     <div class="form-group col-md-2">
                        <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="filhasta" id="filhasta" placeholder="Hasta" disabled>
                    </div>
                    <div class="form-group col-md-2" style="display:none;" id="divreset">
                        <button id="resetfil" type="reset" class="btn btn-info pull-left" data-toggle="tooltip" data-placement="right" title="Reiniciar filtro"><span class="fa fa-filter"></span></button>
                    </div>
                </div>
                <div class="row">  
                    <style>
                        .txt-success{
                            color:green;
                        }  
                    </style>  
                    <div id="tbmantenimiento" class="table-responsive">
                    	<?php include 'php/loadmtto.php';?>
                    </div>
                </div>
            </form>
        </div>
     </div>
</div>
<!-- MODAL CANCELAR ACTIVIDAD -->
<div class="modal fade" id="modal-obs">
    <div class="modal-dialog">
        <div class="modal-content panel-danger">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-times"></span> Cancelar Actividad</h4>
            </div>
            <form id="form-obs">
                <div class="modal-body">
                        <input type="hidden" id="pgmcon" value="">
                        <textarea class="form-control" style="resize: none;" id="txtobserva" placeholder="Describa aquí el motivo de la cancelación de esta actividad..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="sbmtobs" type="submit" class="btn btn-danger">Guardar observacion y cancelar actividad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL REPROGRAMAR ACTIVIDAD -->
<div class="modal fade" id="modal-repro">
    <div class="modal-dialog">
        <div class="modal-content panel-warning">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-refresh"></span> Reprogramar Actividad</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="codact2">
                <input type="hidden" id="pgmcon2">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Activo:</th><td id="nomact"></td></tr>
                        <tr><th>Ubicación:</th><td id="ubiact"></td></tr>
                        <tr><th>Actividad:</th><td id="actact"></td></tr>
                        <tr> <th>Fecha programada:</th><td id="fecact"></td></tr>
                        <tr><th>Nueva fecha:</th><td><input class="text-center" type="text" id="fecharepro" style="cursor:pointer;caret-color: transparent !important;" placeholder="Elija nueva fecha"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="sbmrepro" class="btn btn-warning" data-dismiss="modal">Reprogramar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL INFORMACION -->
<div class="modal fade" id="modal-info">
    <div class="modal-dialog">
        <div class="modal-content panel-info">
            <div class="modal-header panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="fa fa-info-circle"></span> Información de Actividad</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="pgmcon3">
                <table class="table table-bordered">
                    <tbody>
                        <tr><th>Activo:</th><td id="nomact2"></td></tr>
                        <tr><th>Ubicación:</th><td id="ubiact2"></td></tr>
                        <tr><th>Actividad:</th><td id="actact2"></td></tr>
                        <tr> <th>Fecha programada:</th><td id="fecact2"></td></tr>
                        <tr><th>Estado:</th><td id="estado"></td></tr>
                        <tr><th>Realizado por:</th><td id="executer"></td></tr>
                        <tr><th>Fecha y hora:</th><td id="datetime"></td></tr>
                        <tr><th>Observaciones:</th><td id="tbobs"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#fildesde").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
        });
        $("#fecharepro").datepicker({
            format:'yyyy-mm-dd',
            autoclose:true
        });
    });
</script>
<script type="text/javascript">
    $("#filtipo").change(function(e){
       filtro();
    })
    $("#filest").change(function(e){
       filtro();
    })
    $("#fildesde").change(function(e){
        $("#filhasta").datepicker('remove');
        $("#filhasta").val('');
        $("#filhasta").removeAttr('disabled');
        final = $(this).val();
        $("#filhasta").datepicker({
            format:'yyyy-mm-dd',
            startDate:final,
            autoclose:true,
        })
        $("#filhasta").focus();
    });
    $("#filhasta").on('changeDate', function(){
        filtro();
    })
    $("#resetfil").click(function(e){
        location.reload();
    })
    function filtro(){
        var tipo=$("#filtipo").val();
        var est=$("#filest").val();
        var desde=$("#fildesde").val();
        var hasta=$("#filhasta").val();
        var fecha =desde+'•'+hasta;
         $.ajax({
            url:'php/loadmtto.php',
            type:'POST',
            data:'tipo='+tipo+'&estado='+est+'&fecha='+fecha,
            success:function(res){
                $("#tbmantenimiento").html('');
                $("#tbmantenimiento").html(res);
                $("#rango").html(fecha);
                $("#divreset").show();
            }
        })
    }
</script>
<script type="text/javascript">
    $(document).on('click','.btnver',function(e){
        var pgmcon=$(this).data('pgmcon');
        $("#pgmcon3").val(pgmcon);
        var nomact=$(this).parents("tr").find(".actnombre").html();
        var ubiact=$(this).parents("tr").find(".actubic").html();
        var actact=$(this).parents("tr").find(".pgmtipo").html();
        var fecact=$(this).parents("tr").find(".pgmfecha").html();
        var estact=$(this).parents("tr").find(".estado").html();
        $("#nomact2").html(nomact);
        $("#ubiact2").html(ubiact);
        $("#actact2").html(actact);
        $("#fecact2").html(fecact);
        $("#estado").html(estact);
        $.ajax({
            url:'php/opermtto.php',
            type:'POST',
            data:'opc=info&pgmcon='+pgmcon,
            success:function(res){
                var datos=JSON.parse(res);
                if(datos.res=='OK'){
                    $("#tbobs").html(datos.obs);
                    $("#executer").html(datos.executer);
                    $("#datetime").html(datos.fechaexe);
                    $("#modal-info").modal('show');
                }else{
                    swal('Oops!','Ha ocurrido un error, refresque la página e intentelo nuevamente','warning');
                }
            }
        })
    })
    $(document).on('click','.btncancel',function(e){
        var pgmcon=$(this).data('pgmcon');
        $("#txtobserva").val('');
        $("#pgmcon").val(pgmcon);
        $("#modal-obs").modal('show');
    })
    $(document).on('click','.btnrepro',function(e){
        var pgmcon=$(this).data('pgmcon');
        $("#pgmcon2").val(pgmcon);
        $("#fecharepro").val('');
        var codact=$(this).parents("tr").find(".actcodigo").html();
        var nomact=$(this).parents("tr").find(".actnombre").html();
        var ubiact=$(this).parents("tr").find(".actubic").html();
        var actact=$(this).parents("tr").find(".pgmtipo").html();
        var fecact=$(this).parents("tr").find(".pgmfecha").html();
        $("#codact2").val(codact);
        $("#nomact").html(nomact);
        $("#ubiact").html(ubiact);
        $("#actact").html(actact);
        $("#fecact").html(fecact);
        $("#modal-repro").modal('show');
    })
    $("#sbmtobs").click(function(e){
        e.preventDefault();
        var pgmcon=$("#pgmcon").val();
        var obs=$("#txtobserva").val().trim();
        if(obs.length>0){
            $.ajax({
                url:'php/opermtto.php',
                type:'POST',
                data:'opc=cancel&pgmcon='+pgmcon+'&obs='+obs,
                success:function(res){
                    if(res=='OK'){
                        $("#modal-obs").modal('hide');
                        filtro();
                    }else{
                        swal('Oops!','Ha ocurrido un error, refresque la página e intentelo nuevamente','warning');
                    }
                }
            });
        }
        else{
            swal('Faltan datos!','Debe justificar la cancelación de la actividad','warning');
        }
    })
    $("#sbmrepro").click(function(e){
        e.preventDefault();
        var codact=$("#codact2").val();
        var pgmcon=$("#pgmcon2").val();
        var newfec=$("#fecharepro").val().trim();
        if(newfec.length==10){
            $.ajax({
                url:'php/opermtto.php',
                type:'POST',
                data:'opc=repro&codact='+codact+'&pgmcon='+pgmcon+'&newfec='+newfec,
                success:function(res){
                    if(res=='OK'){
                        $("#modal-repro").modal('hide');
                        filtro();
                    }else if(res=='dupli'){
                        swal('Duplicado!','ya existe una actividad programada para el activo este dia, verifique','warning');
                    }else{
                        swal('Oops!','Ha ocurrido un error, refresque la página e intentelo nuevamente','error');
                    }
                }
            })
        }else{
            swal('Elija fecha!','Debe elejir una fecha para reprogramar la actividad','warning');
        }
    })
</script>
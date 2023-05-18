<?php
include 'head.php';
include '../../cnx_data.php';
$today = date("Y-m-d");
VerificarPrivilegio("MOVIMIENTO (ACTIVOS)", $_SESSION['tipo_u'], $conn);
RevisarLogin();
?>
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <h5>REGISTRO DE MOVIMIENTOS DE ACTIVO</h5>
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Movimientos</span>
                    </li>
                </ol>
            </div>
        </div>        
    </div>
</div>

<div class="content animated-panel">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="tab-content">
                <div class="panel-body">
                     <div class="row">
			            <form id="form_mov" role="form" autocomplete="off">
				            <div class="col-md-6">
				            	<!-- ACTIVO -->
				            	<div class="form-group">
				            		<label>Activo</label>
				            		<select id="selact" name="selact" class="form-control picker" title="Buscar y seleccionar activo" required></select>
				            	</div>
								
				            	<br><h5>Ubicación actual</h5><br>								
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>Lugar</th>
											<th>Área</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td id="tblugar"></td>
											<td id="tbarea"></td>
										</tr>
									</tbody>
								</table>
								<input type="hidden" id="selar" name="selar">

								<br><h5>Nueva Ubicación</h5><br>
				            	<!-- LUGAR -->
				            	<div class="form-group col-md-6">
				            		<label>Lugar</label>
				            		<select id="selug2" name="selug2" class="form-control picker" title="Buscar y seleccionar lugar" required></select>
				            	</div>
				            	<!-- AREA -->
				            	<div class="form-group col-md-6">
				            		<label>Área</label>
				            		<select id="selar2" name="selar2" class="form-control" title="Buscar y seleccionar area" required></select>
				            	</div>

								<!-- FECHA Y HORA-->
				            	<div class="form-group col-md-6">
				            		<label>Fecha de ejecución</label>
				            		<input type="text" id="fechaeje" name="fechaeje" class="form-control" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" required>
				            	</div>
				            	<div class="form-group col-md-6">
				            		<label>Hora de ejecución</label>
				            		<input type="text" id="horaeje" name="horaeje" class="form-control" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" required>
				            	</div>
				            </div>
				            <div class="col-md-6">
				            	<!-- USUARIO EJECUTA -->
				            	<div class="form-group">
				            		<label>Ejecutado por:</label>
				            		<select id="selusu" name="selusu" class="form-control picker" title="Buscar y seleccionar usuario que realizó el movimiento" required></select>
				            	</div>
				            	<!-- USUARIO EJECUTA -->
				            	<div class="form-group">
				            		<label>Descripción movimiento</label>
				            		<textarea id="descrip" name="descrip" class="form-control" rows="6" style="resize: none;" required></textarea>
				            	</div>

				            	<div class="form-group">
				            	<br><br><br><br>
				            		<button class="btn btn-primary pull-right" data-toggle="tooltip" data-placement="top" title="Registrar movimiento"><span class="fa fa-save"></span></button>
				            	</div>
				            </div>
				           
			            </form>
		            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'librerias_js.php';?>
<script>
  $("side-menu").children(".active").removeClass("active");
  $("#MOVIMIENTOS").addClass("active");
  $('[data-toggle="tooltip"]').tooltip();
</script>
<script>
	$(".picker").selectpicker({
		liveSearch: true
	});
	var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $.fn.datepicker.dates['es'] = 
    {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Today",
        weekStart: 0
    };
	$("#fechaeje").datepicker({
		format: "yyyy-mm-dd",
        language:"es",
        today:"Today",
        option:"defaultDate",
        autoclose: true
      }).keydown(false); 
	$("#horaeje").clockpicker({autoclose: true});
</script>
<script>
	//CARGA DE TODOS LOS SELECTS

	//carga de select ACTIVOS********************************************
	$('#selact').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('sel1');
        $('.sel1 .form-control').attr('id', 'activos');
    });

    $(document).on('keyup', '#activos', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=selact&key='+seek,
            success: function(data){
                var json = JSON.parse(data);
                var lugs = "";
                for(var i in json){
                    lugs += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#selact").html(lugs);
                $("#selact").selectpicker('refresh');
            }
        }); 
    });



    //carga de select LUGAR NUEVO*****************************************
    $('#selug2').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('sel3');
        $('.sel3 .form-control').attr('id', 'lugares2');
    });

    $(document).on('keyup', '#lugares2', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=selug2&key='+seek,
            success: function(data){
                var json = JSON.parse(data);
                var lugs = "";
                for(var i in json){
                    lugs += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#selug2").html(lugs);
                $("#selug2").selectpicker('refresh');
            }
        }); 
    });

    //carga de select USUARIO*****************************************
    $('#selusu').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('sel4');
        $('.sel4 .form-control').attr('id', 'usuarios');
    });

    $(document).on('keyup', '#usuarios', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=selusu&key='+seek,
            success: function(data){
                var json = JSON.parse(data);
                var lugs = "";
                for(var i in json){
                    lugs += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#selusu").html(lugs);
                $("#selusu").selectpicker('refresh');
            }
        }); 
    });

    //CARGA DE LUGAR Y AREA ANT
    $('#selact').change(function(e){
    	var id=$(this).val();
    	$.ajax({
    		url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=loadlugarea&id='+id,
            success: function(data){
                var datos = JSON.parse(data);
                $("#tblugar").html(datos.lugar);
                $("#tbarea").html(datos.area);
                $("#selar").val(datos.codarea);

            }
    	})
    });

    //CARGA DE SELECT AREA NUEVA
    $('#selug2').change(function(e){
    	var idlug=$(this).val();
    	$.ajax({
    		url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=selarea&id='+idlug,
            success: function(data){
                $("#selar2").html(data);
            }
    	})
    });
</script>
<script>
	$("#form_mov").submit(function(e){
		e.preventDefault();
		var formdata=$(this).serialize();
		$.ajax({
			url:'php/opermovimiento.php',
			type:'POST',
			data:'opc=registrar&'+formdata,
			success:function(res){
				if(res=='true'){
					swal('Guardado!','Movimiento registrado exitosamente.','success');
					location.reload();
				}else if(res=='open'){
					swal('Atención!','Este activo tiene un movimiento registrado sin gestionar.'+'\n'+' No se pueden registrar nuevos movimientos si no gestiona el anterior.','warning');
				}else{
					swal('Oops!','Ha ocurrido un error inesperado, recargue la pagina e intentelo nuevamente','error');
				}
			}
		});
	});
</script>
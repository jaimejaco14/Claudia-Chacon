<?php
    include '../head.php';
?>

<div class="content">

	<div class="row">
		<div class="col-lg-12">
			<div class="hpanel">
				<div class="panel-heading">
					Programación por Colaborador
				</div>
				<div class="panel-body">					

					<table class="table table-hover table-striped" id="tblProg">
			                    <thead>
			                    <tr>
			                        <th>
			                            FECHA
			                        </th>
			                        <th>
			                            SALON
			                        </th>
			                        <th>
			                            COLABORADOR
			                        </th>
			                       
			                    </tr>		                   
			                   
			                    <tr>
			                       
			                        <td>
			                            <input type="text" name="" id="fecha1" class="form-control" placeholder="Fecha" required="required" pattern="" title="">
			                        </td>

			                        <td>
			                            <select name="" id="slncodigo" class="form-control" required="required">
			                            	<option value="0" selected>SELECCIONE SALON</option>
			                            	<?php 
			                            		$sql= mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

			                            		while ($row = mysqli_fetch_array($sql)) 
			                            		{
			                            			echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
			                            		}
			                            	?>
			                            </select>
			                        </td>

			                        <td>
			                            <select required name="selectCliente" id="selectClienteCitas" class="selectpicker" data-live-search="true" title='Selecciona Colaborador' data-size="10" style="width: 100%">
									<option value="0" selected>Seleccione Colaborador</option>	
	  							</select> 

			                        </td>
	                        			
			                    </tr>
			                    
			                  </thead>
			                    <tbody>
			                    </tbody>
                			</table>
                			<span class="pull-right"><button type="button" class="btn btn-info" id="btnEnviar"><i class="fa fa-cog fa-spin send" style="display:none"></i> Ingresar</button></span>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalErrores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-times text-danger"></i> Programación encontrada</h4>
      </div>
      <div class="modal-body">
         <table class="table table-bordered table-hover" id="tblErrores">
         	<thead>
         		<tr>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Salón</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Fecha</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Turno</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Tipo</th>
         			<th><i class="fa fa-dot-circle-o" aria-hidden="true"></i> Puesto</th>
         		</tr>
         	</thead>
         	<tbody>
         		
         	</tbody>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <p class="pull-left"><b><i class="fa fa-info-circle"></i> Se ha ignorado la inserción en estos días</b></p>
      </div>
    </div>
  </div>
</div>


<?php include "../librerias_js.php"; ?>



<script>

$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});

$('#btnModificar').click(function() 
{
	window.open("modificarPro.php?clbcodigo="+$('#selectClienteCitas').val()+" ", "_blank"); 
});

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = {
days: ["Domingo", "Lunes", "Martes", "MiÃ©rcoles", "Jueves", "Viernes", "SÃ¡bado"],
daysShort: ["Dom", "Lun", "Mar", "MiÃ©", "Jue", "Vie", "Sá"],
daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
today: "Today",
weekStart: 0
};


$('#fecha1').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fecha1').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
});


$('#selectClienteCitas').on('show.bs.select', function (e) 
{
    $('.bs-searchbox').addClass('newCliente');
    $('.newCliente .form-control').attr('id', 'newCliente');
});

var selectCliente  = $("#selectClienteCitas");

$(document).on('keyup', '#newCliente', function(event) 
{
    
	var cliente = $(this).val();
	$.ajax({
		url: 'parapetoproccess.php',
		type: 'POST',
		data: {datoCliente:cliente, opcion: "cargarColaborador"},

		success: function(data)
        	{

			var json = JSON.parse(data);
			if(json.result == "full")

				var clientes = "";

				for(var datos in json.data)
                		{

					clientes += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombreCliente+" ("+json.data[datos].documento+")</option>";
				}

				selectCliente.html(clientes);
                		selectCliente.selectpicker('refresh');
		}
	});	
});

$('.selectpicker').on('changed.bs.select',function(e, clickedIndex, newValue, oldValue){

	var col   	= $('#newCliente').val();
	var codigo	= $(e.currentTarget).val();
	var sln   	= $('#slncodigo').val();
	var fecha 	= $('#fecha1').val();
	$('#fecha1').attr("disabled", true);

	$.ajax({
		url: 'parapetoproccess.php',
		method: 'POST',
		data: {opcion: "cargarTabla", fecha:fecha, clbcodigo: col, slncodigo:sln, codigo:codigo},
		success: function (data) 
		{
			var opt = JSON.parse(data);
			var tam = Object.keys(opt[0]).length;

			$('#tblProg tbody').empty();
			
			for (var i=1;i<=tam;i++)
			{
				$('#tblProg tbody').append('<tr><td>'+fecha.substring(0, 7)+'-'+i+'</td><td><select class="form-control turno" id="sel'+i+'">');
				for (var j = 0; j < Object.keys(opt[0][i]).length; j++) 
				{
					$('#sel'+i).append('<option value="'+opt[0][i][j].trncodigo+ ","+opt[0][i][j].horario+'">'+opt[0][i][j].trnnombre+'</option>');
					
				}
					

			}
				$('#tblProg tbody tr').append('</select></td><td><select class="ptr form-control"></select></td><td><select class="form-control tipo"><option value="1">LABORA</option><option value="2">DESCANSO</option><option value="3">INCAPACIDAD</option><option value="4">CAPACITACION</option><option value="5">META</option><option value="6">PERMISO</option><option value="7">VACACIONES</option><option value="0">IGNORAR</option></select></td>');

				puestos();
		}
	});

});

$(document).on('change','.ptr',function(e){
	var val=$(this).val();
	$(".ptr").val(val);
});

/*$(document).on('change','.tipo',function(e){
	var val=$(this).val();
	$(".tipo").val(val);
});
*/


function puestos(){
	var sln = $("#slncodigo").val();
	var col = $('#selectClienteCitas').val();
	$.ajax({
		url:'parapetoproccess.php',
		method: 'POST',
		data:{opcion: "puestos", sln:sln, col:col},		
		success:function(data){
			var opt=JSON.parse(data);
			for(var i in opt.json){
				$('.ptr').append('<option value="'+opt.json[i].ptrcodigo+'">'+opt.json[i].ptrnombre+'</option>');
			}
			$('#tblProg tbody').append('</tr>');
		},
		

	});
}

/*=============================================
=            ENVIO DE PROGRAMACION            =
=============================================*/

$(document).on('click', '#btnEnviar', function() 
{
	if ($('#fecha1').val() == "") 
	{
		swal("Ingrese la fecha", "", "warning");
	}
	else if ($('#slncodigo').val() == 0) 
	{
		swal("Seleccione el salón", "", "warning");	
	}
	else if ($('#selectClienteCitas').val() == 0) 
	{
		swal("Seleccione el colaborador", "", "warning");
	}
	else
	{
		 	var datos = [];

		    	$('#tblProg tbody tr').each(function() 
		    	{
		    	    var itemCom = {};
		    	    var tds = $(this).find("td");

		    	    var a = tds.filter(":eq(1)").find('.turno').val();
		    	    var b = a.split(",");
		    	    var turno = b[0];
		    	    var horario = b[1];

		    	    itemCom.fecha     = tds.filter(":eq(0)").text();
		          itemCom.turno     = turno;
		          itemCom.horario   = horario;
		          itemCom.puesto    = tds.filter(":eq(2)").find('.ptr').val();
		          itemCom.tipo      = tds.filter(":eq(3)").find('.tipo').val();
		          itemCom.col       = $('#selectClienteCitas').val();
		          itemCom.salon     = $('#slncodigo').val();
		          datos.push(itemCom);
		    	});

          		var data = JSON.stringify(datos);

    			$.ajax({
		            url: 'parapetoproccess.php',
		            method: 'POST',
		            data: {datos:data, opcion: "insercion"},  
		             beforeSend: function () 
					{
						$('.send').show();
					},       
		            success: function (data) 
		            {
		            	$('#tblErrores tbody').empty();
		            	var jsondata=JSON.parse(data);

		            	if (jsondata.resp != "") 
		            	{
		            		$('#modalErrores').modal("show");
			            	for(var i in jsondata.resp)
			            	{
			            		$('#tblErrores tbody').append('<tr><td>'+jsondata.resp[i].salon+'</td><td>'+jsondata.resp[i].fecha+'</td><td>'+jsondata.resp[i].turno+'</td><td>'+jsondata.resp[i].tipolab+'</td><td>'+jsondata.resp[i].puesto+'</td></tr>');
			            	}
		            		
		            	}

		            	$("#tblProg tbody").empty();
		            	selectCliente.html('');
					selectCliente.selectpicker('refresh');
					$('#fecha1').attr("disabled", false);
		            },
				complete: function () 
				{
					$('.send').hide();
				}
      		});
	}   
});


/*=====  End of ENVIO DE PROGRAMACION  ======*/
$("#slncodigo").change(function(e){
	$("#tblProg tbody").empty();
	selectCliente.html('');
	selectCliente.selectpicker('refresh');
});

</script>
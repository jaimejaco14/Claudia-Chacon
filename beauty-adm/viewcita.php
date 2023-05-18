<?php 
	session_start();
	include("../cnx_data.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gestión de Citas</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
	<link rel="stylesheet" href="mailtip.css" />
	<link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
</head>
<body>


<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<h3>LISTADO DE CITAS </h3>
			<input type="text" name="" id="fechaAgenda" class="form-control " placeholder="Fecha" required="required" pattern="" title="" style="width: 100%">
			<br>

			<select name="" id="selSalones" class="form-control" required="required">
					<option value="0" selected>Selecciona</option>
				<?php 
					$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon where slnestado = 1 ORDER BY slnnombre");

					while ($row = mysqli_fetch_array($sql)) 
					{
						echo '<option value="'.$row[0].'">'.utf8_encode($row[1]).'</option>';
					}
				?>
			</select>
		</div>		
	</div>
	<br>
	<div class="row">	
		<div class="col-md-12">		
			<div class="table-responsive">
				<table class="table table-hover table-bordered" id="tblcitas">
					<thead>
						<tr class="active">
							<th>Código</th>
							<th>Colaborador</th>
							<th>Salon</th>
							<th>Servicio</th>
							<th>Duración</th>
							<th>Hora</th>
							<th>Quien Agendó</th>
							<th><center><i class="fa fa-gear"></i></center></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="mailtip.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>

</body>
</html>


<script>
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = {
days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
today: "Today",
weekStart: 0
};


$('#fechaAgenda').datepicker({ 

format: "yyyy-mm-dd",
setDate: "today",
language: 'es',
});

$('#fechaAgenda').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).on('change', '#selSalones', function() 
{
	var fecha = $('#fechaAgenda').val();
	var salon = $('#selSalones').val();

	$.ajax({
		url: 'processCita.php',
		method: 'POST',
		data: {opcion: "cargar", fecha:fecha, salon:salon},
		success: function (data) 
		{
			var jsondata = JSON.parse(data);
			$('#tblcitas tbody').empty();
			if (jsondata.res == "full") 
			{
				for(var i in jsondata.json)
				{
					$('#tblcitas').append('<tr><td>'+jsondata.json[i].citcodigo+'</td><td>'+jsondata.json[i].clbnombre+'</td><td>'+jsondata.json[i].slnnombre+'</td><td>'+jsondata.json[i].sernombre+'</td><td>'+jsondata.json[i].serduracion+'</td><td>'+jsondata.json[i].cithora+'</td><td>'+jsondata.json[i].usunombre+'</td><td><center><button class="btn btn-md btn-danger" data-citcodigo="'+jsondata.json[i].citcodigo+'" id="btnEliminar"><i class="fa fa-trash"></i></button></center></td></tr>');
				}
			}
			else
			{
				$('#tblcitas ').append('<tr><td colspan="8"><center><b>NO HAY CITAS</b></center></td></tr>');
			}
		}
	});
});



$(document).on('click', '#btnEliminar', function() 
{
	var citcodigo = $(this).data("citcodigo");

	swal({
	title: "Eliminar Cita",
	text: "Eliminar sin miedo",
	type: "warning",
	showCancelButton:  true,
	cancelButtonText:"No",
	confirmButtonColor: "#DD6B55",
	confirmButtonText: "Sí"  

	},function () 
	{
		$.ajax({
			type: "POST",
			url: 'processCita.php',
			data: {opcion: "eliminar", citcodigo:citcodigo},
			success: function (data) 
			{

				if (data == 1) 
				{
					swal('Cita eliminada', "Advertencia", 'success');
					location.reload();
				}				
			}

		});
	});
});



</script>
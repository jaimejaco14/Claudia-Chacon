<?php
    include '../../cnx_data.php';
    include '../head.php';
    $hoy = date("Y-m-d");
?>


<div id="wrapper">
	<div class="container-fluid">
	    <div class="content animate-panel">
	        <div class="row">
	            <div class="col-md-12">
	               <div class="hpanel">
            			<div class="panel-body">
                			<h3>Reporte de programación</h3>
            			</div>
        			</div>
	            </div>

		        <div class="col-md-12">
		        	<div class="hpanel">
	        			<div class="panel-body">
	            			<div class="col-md-4">
	            				<select name="" id="slncodigo" class="form-control" required="required">
	            					<option value="0" selected>SELECCIONE SALÓN</option>
	            					<?php 
	            						$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

	            						while ($row = mysqli_fetch_array($sql)) 
	            						{
	            							echo '<option value="'.$row['slncodigo'].'">'.utf8_encode($row['slnnombre']).'</option>';
	            						}
	            					?>
	            				</select>
	            			</div>

	            			<div class="col-md-4">
	            				<input type="text" name="" id="fecha" class="form-control" placeholder="<?php echo $hoy; ?>" required="required" pattern="" title="">
	            			</div>


	            			<div class="col-md-4">
	            				<label class="label label-info" id="conteo"></label>
	            			</div>
							
	            			<div class="col-md-12">
	            				<div class="table-responsive">
	            					<br>
	            					<table class="table table-hover table-bordered" id="tbllista">
	            						<thead>
	            							<tr>
	            								<th>Colaborador</th>
	            								<th>Turno</th>
	            								<th>Tipo</th>
	            							</tr>
	            						</thead>
	            						<tbody>
	            						</tbody>	            						
	            					</table>
	            				</div>
	            			</div>	            		
	        			</div>
	        		</div>
		        </div>
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

<?php include "../librerias_js.php"; ?>

<script>
	$(document).prop('title', 'Beauty Soft | Reporte de Programación');


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


	$('#fecha').datepicker({ 

	format: "yyyy-mm-dd",
	setDate: "today",
	language: 'es',
	});

	$('#fecha').on('changeDate', function(ev)
	{
	    $(this).datepicker('hide');
	    $('[data-toggle="tooltip"]').tooltip();
	    loadData ();
	});


	function loadData () 
	{
		var slncodigo = $('#slncodigo').val();
		var fecha     = $('#fecha').val();

		$.ajax({
			url: 'processData.php',
			method: 'POST',
			data: {opcion: "load", slncodigo:slncodigo, fecha:fecha},
			success: function (data) 
			{
				var jsondata = JSON.parse(data);
				$('#tbllista tbody').empty();

				if (jsondata.res == "full") 
				{
					for(var i in jsondata.json)
					{
						$('#tbllista tbody').append('<tr><td>'+jsondata.json[i].trcrazonsocial + "  <b>[" + jsondata.json[i].cargo +"]</b>" +'</td><td>'+jsondata.json[i].turno+'</td><td>'+jsondata.json[i].tipo+'</td></tr>');
						$('#conteo').html(jsondata.conteo + " COLABORADORES DISPONIBLES");
					}
					
				}
			}
		});
	}

</script>

<?php
 include '../cnx_data.php';
?>
<!DOCTYPE html>
	<html>
		<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="theme-color" content="#c9ad7d" />

		<title>Beauty Soft | Buzón de Sugerencias</title>


		<!-- Vendor styles -->
		<link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
		<link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
		<link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
		<link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />

		<!-- App styles -->
		<link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
		<link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
		<link rel="stylesheet" href="../lib/styles/style.css">
		<link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />
		<link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />
		<link rel="stylesheet" href="../lib/vendor/select2-3.5.2/select2.css" />

		<link rel="stylesheet" href="../lib/vendor/ladda/dist/ladda-themeless.min.css" />


	</head>
	
<body ondragstart="return false" onselectstart="return false" >

<div class="color-line"></div>

<div class="register-container" style="margin-top: -4%;">
	<div class="row">
		<div class="hpanel">
			<div class="panel-body">

				<div class="panel panel-info">
					<div class="panel-heading">
							<a href="./" class="btn btn-primary btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="Volver al inicio"><i class="fa fa-chevron-left"></i></a> 
							<h3 class="panel-title"><i class="fa fa-envelope"></i> Peticiones Quejas/Reclamos, Recursos o Felicitaciones </h3>
					</div>

					<div class="panel-body">
							<center><img src="../../contenidos/imagenes/logo_empresa.jpg" class="img-responsive" alt="" style="width: 50%; height: auto"></center>
							<hr>
							
							<form action="" method="POST" id="Form">

									<div class="form-group">
										<label for="">Seleccione Tipo</label>
												<select class="js-source-states required" required="required" id="tipo" name="tipo" style="width: 100%"> 
														<option value="0" selected>SELECCIONE TIPO</option>                              
														<option value="FELICITACION">FELICITACIÓN</option>
														<option value="INQUIETUD">INQUIETUD</option>                             
														<option value="QUEJA">QUEJA</option>
														<option value="SUGERENCIA">SUGERENCIA</option>                                
												</select>

									</div>

									<div class="form-group">
											<label for="">Seleccione Salón</label>
												<select class="js-source-states required" id="salon" name="sln" required="required" style="width: 100%"> 
														<option value="0" selected>SELECCIONE SALÓN</option>                               
															<?php 
																

																	$Sql = mysqli_query($conn, "SELECT a.slncodigo, a.slnnombre FROM btysalon a WHERE a.slnestado = 1 ORDER BY slnnombre ")or die(mysqli_error($conn));

																	while ($row = mysqli_fetch_array($Sql)) 
																	{
																		echo ' <option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';  
																	}
															?>                                
												</select>
									</div>


									<div class="form-group">                    
											<label for="">NOMBRE</label>
													<input type="text" name="name" id="nombre" class="form-control" value="" required="required" placeholder="Digite su nombre" title="Digite su nombre">
									</div>

									<div class="form-group">                    
											<label for="">MÓVIL</label>
													<input type="number" name="movil" id="movil" class="form-control" value="" required="required" placeholder="Digite su número celular" title="Digite su número celular">
									</div>

									<div class="form-group">                    
											<label for="">FIJO</label>
													<input type="number" name="fijo" id="fijo" class="form-control" value="" placeholder="Digite su teléfono fijo" title="Digite su teléfono fijo">
									</div>

									<div class="form-group">                    
											<label for="">E-MAIL</label>
													<input type="email" name="email" id="email" class="form-control" required="required" value="" placeholder="Digite su e-mail" title="Digite su e-mail">
									</div>

									<div class="form-group">                    
											<label for="">COMENTARIO</label>
													<textarea name="comentario" id="comentario" class="form-control" required="required" placeholder="Comentario" rows="5"></textarea>
									</div>

									<div class="g-recaptcha" data-sitekey="6LcQ9S4UAAAAAPZm9IVrvG9Do27W4goyFmLOpOQp"></div>
									

									<div class="form-group">
											<button class="ladda-button ladda-button-demo btn btn-primary pull-right" id="" type="submit" data-style="zoom-in">ENVIAR</button>
									</div>
							</form>
					</div>

					<div class="panel-footer" style="text-align: justify;">
							<small>Por favor diligencie por completo sus datos de contacto para retroalimentarlo del estado de su PQRF.</small>
					</div>
			</div>
		</div>
	</div>       
</div>


<div class="row">
<div class="col-md-12 text-center">
<strong>©</strong>2017 Copyright Claudia Chacón<br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
</div>
<!-- <small>Su opinión es un muy importante para nosotros, le agradecemos que nos cuente sus comentarios</small> -->
</div>
</div>

<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>
<script src="../lib/vendor/select2-3.5.2/select2.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js?hl=es-419" async defer></script>

<script src="../lib/vendor/ladda/dist/spin.min.js"></script>
<script src="../lib/vendor/ladda/dist/ladda.min.js"></script>
<script src="../lib/vendor/ladda/dist/ladda.jquery.min.js"></script>
<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>



<script>
$(".js-source-states").select2();

$(function () {
	$('[data-toggle="tooltip"]').tooltip();
});


/*var l = $( '.ladda-button-demo' ).ladda();
l.click(function(){

// Start loading
l.ladda( 'start' );




setTimeout(function(){
l.ladda('stop');
},1500);

});*/

toastr.options = {
    "debug": false,
    "newestOnTop": false,
    "positionClass": "toast-top-center",
    "closeButton": true,
    "toastClass": "animated fadeInDown",
};


$("#Form").submit(function(e) {

		var url = "pqrf/validatePQR.php"; // the script where you handle the form input.

		$.ajax({
			type: "POST",
			url: url,
			data: $("#Form").serialize(), // serializes the form's elements.
			success: function(data)
			{
				var jsoncod = JSON.parse(data);

					if (jsoncod.res == 1) 
					{
						toastr.success("PQRF\n radicado con el código "+jsoncod.codigo);
						$('#nombre').val('');
						$('#movil').val('');
						$('#fijo').val('');
						$('#email').val('');
						$('#comentario').val('');
						$("#tipo").select2('data', { id:"0", text: "SELECCIONE TIPO"});
						$("#salon").select2('data', { id:"0", text: "SELECCIONE SALÓN"});
						$('#Form')[0].reset();
						
						setTimeout(function(){
							window.location="index.php";
						},10000);

					}
			}
		});

					e.preventDefault(); 
});


$(document).ready(function() {
	//$(".js-source-states").select2("destroy");
	$('#Form').trigger("reset");
	//$("#tipo").select2("val", "");
	//$("#customers_select").empty().trigger('change')
});
</script>


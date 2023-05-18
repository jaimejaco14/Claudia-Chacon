<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Trabaja con nosotros • Claudia Chacon</title>
	<link rel="shortcut icon" type="image/ico" href="/beauty/contenidos/imagenes/favicon.png" />
	<link rel="stylesheet" href="/beauty/lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/beauty/lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <!-- App styles -->
    <link rel="stylesheet" href="/beauty/lib/styles/style.css">
    <link rel="stylesheet" href="/beauty/lib/styles/static_custom.css">
    <script src="/beauty/lib/vendor/jquery/dist/jquery.min.js"></script>
    <script src="/beauty/lib/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="/beauty/lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/beauty/lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>	
    <style type="text/css" media="screen">
        .bodys{
        	background-color: #1D1D1B;
		    font-size: 14px;
		    line-height: 20px;
		    border: 0px;
        }
        .divs{
        	background-color: #1D1D1B;
        	border: 0px;
        }
        .navbar{
			background: #1D1D1B;
			border: 0px;
        }
        .panel{
        	background: #1D1D1B;
			border: 0px;
        }
    </style>
    <link rel="stylesheet" href="/beauty/lib/vendor/sweetalert/lib/sweet-alert.css" />
</head>
<body class="bodys">

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<br>
				<a href="https://www.claudiachacon.com"><img class="img-responsive" style="max-width: 60%;" src="/beauty/contenidos/imagenes/logocch.png"></a><br>
			</div>		
			<ul class="nav navbar-nav navbar-right"><br>
				<h5 style="color: #999;">Tel:<b class="text-success"> 385 4955</b> • Cel:<b class="text-success"> 313 573 0944</b> • Barranquilla, Colombia</b></h5 class="color: #999;">
			</ul>	
		</div>
	</nav>
	<hr align="center" noshade="noshade" size="4" width="85%" />
	<div class="content">
		<div class="panel-body">
			<div class="container-fluid">
				<div class="row">
					<form class="form-horizontal" id="formtrab" enctype="multipart/form-data" autocomplete="off">
						<div class="form-group">
							<div class="col-md-10 col-md-push-1">
							<h3 class="text-success"><b>Envíanos tu hoja de vida</b></h3>
							<p>Para trabajar con nosotros, por favor diligencia el siguiente formulario y adjunta tu hoja de vida en formato Microsoft Word (*.docx) o Adobe PDF (*.pdf).<br>Todos los campos son requeridos.</p>	
							</div>
						</div><br>
						<fieldset>

						<div class="form-group">
						  <label class="col-md-4 control-label" for="nombre">Nombre Completo</label>  
						  <div class="col-md-4">
						  <input id="nombre" name="nombre" type="text" class="form-control input-md" required="">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-4 control-label" for="mail">Correo Electrónico</label>  
						  <div class="col-md-4">
						  <input id="mail" name="mail" type="email" class="form-control input-md" required="">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-4 control-label" for="phone">Teléfono</label>  
						  <div class="col-md-4">
						  <input id="phone" name="phone" type="text" class="form-control input-md" required="">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-4 control-label" for="address">Dirección</label>  
						  <div class="col-md-4">
						  <input id="address" name="address" type="text" class="form-control input-md" required="">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-md-4 control-label" for="city">Ciudad</label>  
						  <div class="col-md-4">
						  <input id="city" name="city" type="text" class="form-control input-md" required="">
						  </div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="cargo">Cargo</label>  
						  	<div class="col-md-4">
								<select name="cargo" id="cargo" class="form-control" aria-required="true" aria-invalid="false">
									<option value="">---</option>
									<option value="Administradora de Punto de Venta">Administradora de Punto de Venta</option>
									<option value="Cajera">Cajera</option>
									<option value="Estilista">Estilista</option>
									<option value="Manicurista">Manicurista</option>
									<option value="Esteticista">Esteticista</option>
									<option value="Auxiliar del Back (zona húmeda)">Auxiliar del Back (zona húmeda)</option>
									<option value="Otro">Otro</option>
								</select>
							</div>
						</div>
						<div class="form-group">
						  <label class="col-md-4 control-label" for="archivo">Archivo adjunto</label>  
						  <div class="col-md-4">
						  <label class="btn btn-default btn-block" for="archivo" id="falbut">Click para seleccionar archivo</label>
						  <input id="archivo" name="archivo" type="file" class="form-control input-md" required="" style="opacity: 0;position: absolute;z-index: -1;">
						  </div>
						</div>
						<div class="form-group">
						  <div class="col-md-4 col-md-push-4">
						  	<center>
							  		<a style="color:#999;" data-toggle="modal" href='#modal-term'>Lea y acepte los términos de uso</a>
							  		<input id="termino" name="termino" type="checkbox" class="form-control" required="" oninvalid="this.setCustomValidity('Debe leer y aceptar nuestros terminos y condiciones')" oninput="this.setCustomValidity('')" >
						  	</center>
						  </div>
						</div>
						<div class="form-group">
							<div class="col-md-4 col-md-push-4">
						  		<button id="btnSubmit" type="submit" class="btn btn-success btn-block" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Enviando..."><b>Enviar</b></button>
							</div>
						</div>
						</fieldset>
					</form>
				</div>
				
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-footer">
			<h5>© <?php echo date('Y');?> Claudia Chacón <b><a href="https://www.claudiachacon.com" class="text-success">www.claudiachacon.com</a></b></h5>
		</div>
	</div>
</body>
<div class="modal fade" id="modal-term">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Terminos y condiciones de uso</h4>
			</div>
			<div class="modal-body">
				 <p>RESPONSABILIDADES DE LA EMPRESA<br><br>Este servicio se creó con el propósito de ofrecer un medio de comunicación entre INVELCON SAS y los usuarios que deseen registrar la hoja de vida, con el fin de ser tenidos en cuenta en los procesos de selección definidos por la empresa.<br>INVELCON SAS no censura las hojas de vida que ingresen al sitio, sin embargo, la empresa no garantiza que el usuario que registre la hoja de vida obtenga un empleo, nos reservamos el derecho de selección.<br>La información que el usuario registra: datos personales, dirección de residencia, formación académica, experiencia laboral, composición familiar y otros, es de uso exclusivo de INVELCON SAS, no será revelada a terceras personas y el tratamiento de los mismos se dará de acuerdo a la Política de Tratamiento de Datos Personales de INVELCON SAS<br><br>RESPONSABILIDADES DEL USUARIO<br><br>El usuario es responsable de la información que suministre, de la veracidad de los datos y actualización de los mismos. De igual forma, autoriza a la empresa para verificar la autenticidad de éstos.<br>Si el usuario ingresa la hoja de vida al sitio web de INVELCON SAS, declara aceptar y estar de acuerdo con las condiciones de uso de esta información.<br>Cuando se convoque para entrevista o inducción las citaciones se enviarán al correo electrónico y/o teléfono que usted registra, por lo tanto éste debe ser veráz.<br><br>AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES POR INVELCON SAS<br><br>INVELCON SAS con el propósito de dar un adecuado tratamiento a sus datos personales de acuerdo al Régimen General de Protección de Datos Personales colombiano reglamentado por la Ley 1581 de 2012 y el Decreto 1377 de 2013. El cual regula el derecho que tienen las personas de conocer, actualizar, rectificar y suprimir sus datos personales cuando sean objeto de tratamiento por personas naturales o jurídicas en sus bases de datos. Solicita su autorización para proceder a almacenar y tratar sus datos personales.<br>El titular de los datos personales tiene todo el derecho de conocer, corregir, actualizar, rectificar o suprimir los datos personales tratados por INVELCON SAS Si su deseo es realizar cualquiera de estas acciones, lo invitamos comuncarse con nosotros a: INVELCON SAS Kra 45B 94-45 Barranquilla, Colombia. PBX: (5) 3854955.<br>INVELCON SAS de acuerdo a lo reglamentado por el artículo 10 del Decreto 1377 de 2013, queda autorizada de manera expresa para tratar sus datos personales. Sin embargo, usted podrá revocar la presente autorización cuando lo estime conveniente.<br>
				</p>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</html>
<script type="text/javascript">
	$("#archivo").change(function(e){
		var fileName = this.files[0].name;
		var fileSize = this.files[0].size;
		var ext = fileName.split('.').pop();

		if(fileSize > 3000000){
			swal('Archivo muy grande','El archivo no debe superar los 3MB','error');
			this.files[0].name = '';
			this.value = '';
			$("#falbut").html('Click para buscar archivo');
		}
		switch(ext){
			case 'docx':
			case 'doc':
				$("#falbut").html('<i class="fa fa-file-word-o text-info"></i> '+fileName);
			break;
			case 'pdf':
				$("#falbut").html('<i class="fa fa-file-pdf-o text-danger"></i> '+fileName);
			break;
			default:
				swal('Tipo de archivo no permitido!','Solo se permiten archivos en formato Word (*.doc, *.docx) o PDF (*.pdf)','error');
				this.files[0].name = '';
				this.value = '';
				$("#falbut").html('Click para buscar archivo');
			break;
		}
	})
	$("#formtrab").submit(function(e){
		e.preventDefault();
		var form=$("#formtrab")[0];
		var formdata = new FormData(form);
		$("#btnSubmit").prop("disabled", true);
		$('#formtrab :input').attr('readonly','readonly');
		$('#cargo').attr('disabled','disabled');
		$('#archivo').attr('disabled','disabled');
		$("#btnSubmit").button('loading');
		$.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "/beauty/externo/trabproc.php",
            data: formdata,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 10000,
            success: function (data) {

              	if(data=='ok'){
	              	swal({
					    title: "Correcto!",
					    text: "Su hoja de vida fue enviada exitosamente!",
					    type: "success",
					    confirmButtonText: 'Ok',
					    closeOnConfirm: false
					 },
					 function(isConfirm){
					   if (isConfirm){
					     window.location.href = 'https://www.claudiachacon.com';
					    } 
					});
				}else{
					swal({
					    title: "Oh oh!",
					    text: "Ha ocurrido un error inesperado al enviar, pulse ok para recargar la página e intentelo nuevamente",
					    type: "error",
					    confirmButtonText: 'Ok',
					    closeOnConfirm: false
					 },
					 function(isConfirm){
					   if (isConfirm){
					     location.reload();
					    } 
					});
				}
            },
            error: function (e) {
               	swal({
				    title: "Oh oh!",
				    text: "Ha ocurrido un error inesperado al enviar, pulse ok para recargar la página e intentelo nuevamente",
				    type: "error",
				    confirmButtonText: 'Ok',
				    closeOnConfirm: false
				 },
				 function(isConfirm){
				   if (isConfirm){
				     location.reload();
				    } 
				});
            }
        });
	})
</script>
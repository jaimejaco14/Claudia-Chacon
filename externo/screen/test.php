<?php include 'headertest.php';?>
<head>
	<title></title>
	<link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css">
	<script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
	<script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
	<script src="marquee/jquery.marquee.js"></script>
	<!-- <script src="slider/js/jquery.bbslider.min.js"></script> -->
	<!-- <link type="text/css" href="slider/css/jquery.bbslider.css" rel="stylesheet" />
	<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" > </script> -->
	<script type="text/javascript" src="../../lib/vendor/video-js/nvideo.js?<?php echo rand();?>"></script>
	<link rel="stylesheet" href="../../lib/vendor/video-js/nvideo-js.css?<?php echo rand();?>" type="text/css" media="screen" title="Video JS" charset="utf-8">
</head>
<body style="overflow: hidden; font-family: tahoma;">
	<input type="hidden" id="slncod" value="<?php echo $slncod;?>">
	<input type="hidden" id="link" value="<?php echo $link;?>">
	<input type="hidden" id="hini" value="<?php echo $hini;?>">
	<input type="hidden" id="hfin" value="<?php echo $hfin;?>">
	<div class="content">
		<div class="row">
			<!-- contenido principal -->
			<div class="col-md-8" style="padding-right: 0px !important;">
				<!-- carrusel de imagenes -->
				<div id="" class="square auto" style="min-height: 500px;"></div>
				<!-- iframe YOUTUBE -->
				<div id="youtube" style="min-height: 450px;overflow: hidden;display:none;"></div>
				<!-- Div Datos del salón -->
				<div class="col-md-12" style="">
					<h2 class="text-center">
						<b><?php echo $slnnombre;?> - CITAS <?php echo $slntel;?> EXT <?php echo $slnext;?></b>
						<br><b><i class="fa fa-whatsapp"></i> <?php echo $slncel;?></b>
					</h2>
				</div>
			</div>
			<!-- Logo superior derecha -->
			<div class="col-md-4" style="">
				<center>
				<img src="contenidos/logocch.png" class="img-responsive" style="max-width: 100%;">
				</center>
			</div>
			<!-- SUBE Y BAJA -->			
			<div class="sb col-md-4" style=" min-height: 400px;"></div>
		</div>
		<!-- MARQUESINA -->		
		<div class="col-md-10" style="overflow-x: hidden; background-color: black; ">
			<div class="marquee">
				<h2 style="color:white;">
					<b>Somos una cadena de Salas de Belleza y Estética especializados en la Belleza y la Estética de una manera integral, empleando técnicas de vanguardia y personal altamente calificado. 
					Favor tener en cuenta las siguientes recomendaciones para un óptimo servicio: 
					1-	Solicite su turno en recepción.  
					2-	Cancele directamente en la caja.  
					3-	No permita la utilización de celulares mientras reciba la prestación de servicios.  
					4-	Suministre solo en recepción sus datos personales.  
					5-	En nuestros establecimientos se encuentra prohibida la realización de procedimientos estéticos invasivos.  
					6-	La empresa no asesora ni garantiza los resultados de aplicación de tintes, cuyos productos se haya adquirido fuera de nuestras instalaciones.  
					7-	Solicite los servicios a domicilio únicamente en recepción, para garantizarle puntualidad y calidad. 
					8-	La empresa no se responsabiliza por préstamos de dinero realizados por parte de particulares al personal de colaboradores.  
					9-	Exija la utilización de guantes, tapabocas, cambio de cuchillas y kit desechables para la prestación de nuestros servicios. Exija además las recomendaciones que debe tener en cuenta después de recibir un servicio especializado. 
					10-	La empresa no se responsabiliza por objetos y/o accesorios olvidados en nuestras instalaciones, ni por daños de los mismos por estar ubicados en las áreas de trabajo de los colaboradores.  
					</b>	
				</h2>
			</div>
		</div>
		<!-- RELOJ -->		
		<div class="col-md-2">
			<h2 id="reloj" class="text-center"></h2><h3 id="fecha" class="text-center"></h3>
		</div>
	</div>
</body>
</html>
<?php 
if($swc=='YT'){
	include 'videojs/youtube.php';
}else{
	include 'videojs/iframe.php';
}
?>


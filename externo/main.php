<?php include 'header.php';?>
<head>
	<title></title>
	<link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css">
	<script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
	<script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
	<script src="marquee/jquery.marquee.js"></script>
	<script src="slider/js/jquery.bbslider.min.js"></script>
	<link type="text/css" href="slider/css/jquery.bbslider.css" rel="stylesheet" />
	<script src = "https://cdn.pubnub.com/sdk/javascript/pubnub.4.21.6.js" > </script>
</head>
<body style="overflow: hidden; font-family: tahoma;">
	<input type="hidden" id="slncod" value="<?php echo $slncod;?>">
	<div class="content">
		<div class="row">
			<div class="col-md-8">
				<!-- carrusel de imagenes -->
				<div id="auto" class="square" style="min-height: 500px; display:none;"></div>
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
<script type="text/javascript">
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	var player;
	function onYouTubeIframeAPIReady() {
			player = new YT.Player('youtube', {
			height: '550px',
			width: '100%',
			videoId: '05K00cYTFO8',
			events: {
            'onReady': startTime
            }
		});
	} 
	$(document).ready(function() {
		var slncod=$("#slncod").val();
		//carrusel de imagenes
		loadimg();
		//carga del sube y baja
		$(".sb").load('subebaja.php?sln='+slncod);
		//marquesina
		$('.marquee').marquee({
			delayBeforeStart: 1000,
			direction: 'left',
			duration: 15000,
		});   
	});
	function startTime(){
		today=new Date();
		h=today.getHours();
		m=today.getMinutes();
		D=today.getDate();
		M=today.getMonth()+1;
		A=today.getFullYear();
		m=checkTime(m);
		$('#reloj').html('<b>'+h+':'+m+'</b>');
		$('#fecha').html('<b>'+D+'/'+M+'/'+A+'</b>');
		noticiero(h,m);
		t=setTimeout('startTime()',60000);
	}
	function checkTime(i){
		if (i<10) {
			i="0" + i;
		}
		return i;
	}
	function diaSemana(){
	    var dt = new Date();
	    return dt.getUTCDay();    
	}
	function noticiero(h,m){
		var ds=diaSemana();
		if((ds>0) && (ds<=5)){
			horafin='13:30';
		}else{
			horafin='13:30';
		}
		var hora=h+':'+m;
		if((hora >= "12:29") && (hora <= horafin)){
			//PLAY VIDEO
			player.playVideo();
			if(player.getPlayerState()==1){
				$(".square").hide();
				$("#youtube").show();
			}
		}else{
			//STOP VIDEO
			if(player.getPlayerState()==1){
				player.stopVideo();
			}
			$("#youtube").hide();
			$(".square").show();
		}
	}
	function loadimg(sln){
		var sln=$("#slncod").val();
		$.ajax({
			url:'imgcontent.php',
			type:'POST',
			data:{sln:sln},
			success:function(res){
				$("#auto").html(res);
				$("#auto").bbslider({
					auto:true,
					timer:7000,
					loop:true
				});
				$("#auto").show();
				//setTimeout('loadimg()',15000);
			},
			error:function(){
				//location.reload();
			}
		})
	}
</script>
 <script>
      
    </script>


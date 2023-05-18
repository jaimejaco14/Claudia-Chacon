<?php 
include '../../cnx_data.php';
function get_real_ip(){
    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}
$ipaddress= get_real_ip();
//$ipaddress='181.49.247.114';
$sql="SELECT s.slncodigo, s.slnnombre, s.slnextensiontelefonofijo, s.slntelefonomovil FROM btysalon s WHERE s.slnipaddress='$ipaddress'";
$res=$conn->query($sql);
$row=$res->fetch_array();
$slncod=$row['slncodigo'];
$slnnom=$row['slnnombre'];
$slnext=$row['slnextensiontelefonofijo'];
$slncel=$row['slntelefonomovil'];
?>
<?php include 'header.php';?>
<body style="overflow: hidden; font-family: tahoma;">
	<input type="hidden" id="slncod" value="<?php echo $slncod;?>">
	<div class="content">
		<div class="row">
			<div class="col-md-8" style="" >
				<!-- carrusel de imagenes -->
				<div id="auto" class="square" style="min-height: 450px;">
										
					<img src="contenidos/CONTENIDO-TV-5.jpg" class="img-responsive">

					<img src="contenidos/POST-5.png" class="img-responsive">
					
					
					<img src="contenidos/TV8.jpg" class="img-responsive">
					
					<img src="contenidos/ENE2.jpg" class="img-responsive">
					<img src="contenidos/ENE3.jpg" class="img-responsive">
					
					<img src="contenidos/POST-1.png" class="img-responsive">
					<img src="contenidos/POST-2.png" class="img-responsive">
					<img src="contenidos/POST-3.png" class="img-responsive">
					<img src="contenidos/POST-4.png" class="img-responsive">
					
					<img src="contenidos/ENE4.jpg" class="img-responsive">
					<img src="contenidos/ENE5.jpg" class="img-responsive">

					
					<img src="contenidos/POST-6.png" class="img-responsive">
					<img src="contenidos/POST-7.png" class="img-responsive"> 
					<img src="contenidos/DSC0060.jpg" class="img-responsive">
					<img src="contenidos/DSC0345.jpg" class="img-responsive">
					<img src="contenidos/DSC0377.jpg" class="img-responsive">
					<img src="contenidos/DSC5054.jpg" class="img-responsive">

					<img src="contenidos/ENE6.jpg" class="img-responsive">
					<img src="contenidos/ENE7.jpg" class="img-responsive">
					<!-- <iframe style="width:100%;height:600px;" src="https://canalesdeportivos.net/win.php" frameborder="0" allowfullscreen></iframe>  -->
				</div>
				<div id="youtube" style="min-height: 450px;overflow: hidden;display:none;"></div>
				<div class="col-md-12" style="">
					<h2 class="text-center"><b><?php echo $slnnom;?> - CITAS 385 49 55 EXT <?php echo $slnext;?></b><br><b><i class="fa fa-whatsapp"></i> <?php echo $slncel;?></b></h2>
				</div>
			</div>
			<div class="col-md-4" style="">
				<center>
				<img src="contenidos/logocch.png" class="img-responsive" style="max-width: 100%;">
				</center>
			</div>
			<div class="sb col-md-4" style=" min-height: 400px;"></div>
		</div>
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
		<div class="col-md-2">
			<h2 id="reloj" class="text-center"></h2><h3 id="fecha" class="text-center"></h3>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
		var salon=$("#slncod").val();
		startTime();
		$(".sb").load('subebaja.php?sln='+salon);
		$("#auto").bbslider({
			auto:true,
			timer:7000,
			loop:true
		});
		$('.marquee').marquee({
			delayBeforeStart: 1000,
			direction: 'left',
			duration: 20000,
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
			horafin='13:00';
		}else{
			horafin='13:00';
		}
		var hora=h+':'+m;
		if((hora >= "12:29") && (hora <= horafin)){
			if($("#youtube").children().length==0){
				$("#youtube").html('<iframe style="width:100%;height:500px;" src="https://www.youtube.com/embed/05K00cYTFO8?rel=0;&autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
				$(".square").hide();
				$("#youtube").show();
			}
		}else{
			$("#youtube").hide();
			$(".square").show();
			$("#youtube").empty();
		}
	}
</script>
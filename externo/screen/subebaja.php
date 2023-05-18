<?php 
include '../../cnx_data.php'; 
$sln=$_GET['sln'];
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css">
	<script src="../../lib/vendor/jquery/dist/jquery.min.js"></script>
	<script src="../../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="../../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
	<style type="text/css" media="screen">
		body{
			font-family: tahoma;
		}
		.con{
			background-color:red;
		}
		.coff{
			background-color:white;
		}
	</style>
</head>
<body>
	<input type="hidden" id="sln" value="<?php echo $sln;?>">
	<div class="row" id="grid">
		<h5 class="text-center"><b>COLABORADORES EN TURNO</b></h5>
		<?php 
		$sql="SELECT DISTINCT(cg.crgnombre),cg.crgcodigo
				FROM btyprogramacion_colaboradores pc
				JOIN btycolaborador col ON col.clbcodigo=pc.clbcodigo
				JOIN btycargo cg ON cg.crgcodigo=col.crgcodigo
				WHERE pc.slncodigo=$sln AND cg.crgcodigo IN (1,2,3) AND pc.prgfecha= CURDATE() ORDER BY cg.crgcodigo";
		$res=$conn->query($sql);
		$numcg=round(100/($res->num_rows));

		while($row=$res->fetch_array()){
			?>
			<div data-crg="<?php echo $row[1];?>" class="divcrg pull-left" style="font-size:0.8vw;width: <?php echo $numcg;?>%;">
				<div class="hpanel" style="border: 2px solid #FFCC99;min-height: 374px;">
					<div class="no-padding">
						<ul class="list-group">
							<li class="lbcargo-<?php echo $row[1];?> list-group-item text-center">
							<?php 
									switch($row[1]){
										case 1:$img='contenidos/C1.jpg';
										break;
										case 2:$img='contenidos/C2.jpg';
										break;
										case 3:$img='contenidos/C3.jpg';
										break;
									}
								?>
								<center>
									<img class="img-responsive" style="max-width:16%;" src="<?php echo $img;?>" alt="">
								</center>
								<b style="font-size: 1.1vw;"><?php echo $row[0]; ?></b>
							</li>
							<li class="list-group-item text-center" style=" font-size: 1.1vw; ">
								<b id="nom1-<?php echo $row[1];?>"></b>
							</li>
							<input type="hidden" id="clbcod-<?php echo $row[1];?>" value="0">
						</ul>
						<ul class="list-group">
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom2-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom3-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom4-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom5-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom6-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom7-<?php echo $row[1];?>"></li>
							<li class="list-group-item nom-<?php echo $row[1];?>" style="font-size: 0.8vw;" id="nom8-<?php echo $row[1];?>"></li>
						</ul>
						<audio id="audio">
						   <source src="timbre.mp3" type="audio/mp3" />
						</audio>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<div class="row">
		<a class="weatherwidget-io" href="https://forecast7.com/es/11d00n74d81/barranquilla/" data-label_1="BARRANQUILLA" data-label_2="Estado del Tiempo" data-font="Open Sans" data-icons="Climacons Animated" data-mode="Current" data-days="3" data-theme="weather_one" >BARRANQUILLA Estado del Tiempo</a>
		<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
		</script>
	</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
		var pubnub = new PubNub ({
		    subscribeKey: 'sub-c-26641974-edc9-11e8-a646-e235f910cd5d' , // siempre requerido
		    publishKey: 'pub-c-870e093a-6dbd-4a57-b231-a9a8be805b6d' // solo es necesario si se publica
		});
		var sln=$("#sln").val();
		pubnub.addListener({
		    message: function(data) {
		        //console.log(data.message);
			    if(data.message==1){
			    	loadsb();
			    }
		    }
		})
		pubnub.subscribe({
		    channels: ['bty00'+sln]
		});
		loadsb();
	});
	
	function loadsb(){
		$(".divcrg").each(function(){
			var crg=$(this).data('crg');
			var sln=$("#sln").val();
			var clb=$("#clbcod-"+crg).val();
			$.ajax({
				url:'process.php',
				type:'POST',
				data:'sln='+sln+'&crg='+crg+'&clb='+clb,
				success:function(res){
					var datos=JSON.parse(res);
					if(datos[0].codcol!=clb){
						$("#nom1-"+crg).html('');
						if(datos[0].codcol==0){
							$("#foto1-"+crg).attr('src', '');
							$("#nom1-"+crg).html('Atendiendo...');
						}else{
							$("#foto1-"+crg).attr('src', '../../contenidos/imagenes/colaborador/beauty_erp/'+datos[0].foto);
							$("#nom1-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[0].pto+'</span> '+datos[0].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[0].colr+';"></i>');
						}
						$("#clbcod-"+crg).val(datos[0].codcol);
						$("#audio")[0].play();
						var time=0;
						var int=setInterval(
							function pon(){
								elem=$(".lbcargo-"+crg);
								if(elem.hasClass('con')){
									elem.removeClass('con');
								}else{
									elem.addClass('con');
								}
								time++;
								if(time==8){
									clearInterval(int);
								}
							}
						,500);
					}
					$(".nom-"+crg).html('');
					if(datos[1]!=undefined){
						$("#nom2-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[1].pto+'</span> '+datos[1].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[1].colr+';"></i>');
					}
					if(datos[2]!=undefined){
						$("#nom3-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[2].pto+'</span> '+datos[2].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[2].colr+';"></i>');
					}
					if(datos[3]!=undefined){
						$("#nom4-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[3].pto+'</span> '+datos[3].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[3].colr+';"></i>');
					}
					if(datos[4]!=undefined){
						$("#nom5-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[4].pto+'</span> '+datos[4].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[4].colr+';"></i>');
					}
					if(datos[5]!=undefined){
						$("#nom6-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[5].pto+'</span> '+datos[5].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[5].colr+';"></i>');
					}
					if(datos[6]!=undefined){
						$("#nom7-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[6].pto+'</span> '+datos[6].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[6].colr+';"></i>');
					}
					if(datos[7]!=undefined){
						$("#nom8-"+crg).html('<span class="label" style="background-color:#c9ad7d;color:black;">'+datos[7].pto+'</span> '+datos[7].nomcol+'<i class="pull-right fa fa-circle" style="color:#'+datos[7].colr+';"></i>');
					}
				}
			})
		})
	}
	/*function movment() {
		//console.log('https://httprelay.io/link/bty-sln00'+sln);
		var sln=$("#sln").val();
	  	$.get('https://httprelay.io/link/bty-sln00'+sln).done(function(data) {
	    if(data==1){
	    	loadsb();
	    }
	    movment();
	  })
	}*/
</script> 
<?php 
	include("php/conexion.php");
	include 'librerias_js.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>LESS</title>
</head>
<body>
 	
<div id="load"></div>


 	<script>
 		$(document).ready(function() {
 			load ();
 		});
 		function load () {
 			$.ajax({
 				url: 'php/citas/prueba2.php',
 				method: 'POST',
 				success: function (data) {
 					var array = eval(data);
 					for (var i in array){
 						$('#load').append("<ul><li>"+array[i].titulo+"</li><li>"+array[i].inicio+"</li><<li>"+array[i].fin+"</li>/<li>"+array[i].color+"</li>ul> ");
 					}
 				}
 			});
 		}
 	</script>	


</body>
</html>
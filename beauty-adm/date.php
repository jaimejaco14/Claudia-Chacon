<?php 
	//date_default_timezone_set('UTC');
	//echo date('h:i:s', '18:31:55');
 //02/12/2017 8:31:55 p. m

$date = date_create('2000-01-01 7:45:00 pm');
echo date_format($date, 'Y-m-d H:i:s');
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 </head>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <body>

	<h2 id="elem1">Este elemento se llama elem1</h2>


 	<script>
 		$(document).ready(function() {
 		var $elem1 = $("#elem1");
 		$elem1.css("background-color", "lime");
 			
 		});
 	</script>

 </body>
 </html>

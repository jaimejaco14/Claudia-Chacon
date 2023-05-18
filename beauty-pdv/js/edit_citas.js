/*==================================
=            Edit Citas            =
==================================*/

$('#selCliente').select2();
$('#selServi').select2();
$('#selectEstado').select2();

$('.selcli').select2();
$('#selCol').select2();
$("#fechacita").datetimepicker({
	format: "YYYY-MM-DD HH:mm ",
	minDate: moment().format("YYYY-MM-DDTHH"),
	locale: "es",
});

/* $(document).on('change', '#selServi', function() 
 {
 	$('#selCol').select2('val', '');
 });*/


$(document).on('blur', '#fechacita',function() 
{
	var codsalon    = $('#txtcodsalon').val();
	var codservicio = $('#selServi').val();
	var fecha       = $('#fechacita').val();

	$.ajax({
		url: 'php/citas/checkcita.php',
		method: 'POST',
		data: {salon: codsalon, servicio: codservicio, fecha: fecha},
		success: function (data) 
		{
			$('#selCol').html(data);
		}
	});

	
});


$(document).on('click', '#btnguardarcambios', function() 
{
	var txtcodsalon = $('#txtcodsalon').val();
	var txtcodcita  = $('#txtcodcita').val();
	var selServi    = $('#selServi').val();
	var fechacita   = $('#fechacita').val();
	var selCol      = $('#selCol').val();
	var txtobsercacioncita = $('#txtobsercacioncita').val();
	//var cliente     = $('#txtcliente').val();

	$.ajax({
		url: 'php/citas/modificar_cita.php',
		method: 'POST',
		data: {sln: txtcodsalon, cita: txtcodcita, ser: selServi, fecha: fechacita, col:selCol, obser: txtobsercacioncita},
		success: function (data) 
		{
			
		}
	});
});







/*=====  End of Edit Citas  ======*/



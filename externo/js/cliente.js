/*================================
=            CLIENTES            =
================================*/

$(document).ready(function() {
	$("#selDepartamento").select2(); 
	$("#tipo_documento").select2(); 
	$("#sexo").select2(); 
	$("#ocupacion").select2(); 
	$("#selCiudad").select2(); 
	$("#selBarrio").select2(); 
});

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = {
    days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
    daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
    daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
    today: "Today",
    weekStart: 0
};
$('.input-group.date').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
       today: "Today",
});

toastr.options = {
    "debug": false,
    "newestOnTop": false,
    "positionClass": "toast-top-center",
    "closeButton": true,
    "toastClass": "animated fadeInDown",
};


$('.input-group.date').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});

$(document).on('click', '.next', function() 
{
	if ($('#tipo_documento').val() == 0) 
	{
		$.toast({
            heading: 'Información',
            text: 'Seleccione tipo de documento',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
	}
	else
	{
		if ($('#doc').val() == "") 
		{
		    $.toast({
                heading: 'Información',
                text: 'Ingrese su documento de identidad',
                position: 'bottom-center',
                stack: false,
                icon: 'info'
            });
		    $('#doc').focus();
		}
		else
		{
			if ($('#nombres').val() == "") 
			{
				$.toast({
                    heading: 'Información',
                    text: 'Ingrese sus nombres',
                    position: 'bottom-center',
                    stack: false,
                    icon: 'info'
                });
				$('#nombres').focus();
			}
			else
			{
				if ($('#apellidos').val() == "") 
				{
					$.toast({
                        heading: 'Información',
                        text: 'Ingrese sus apellidos',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });
					$('#apellidos').focus();
				}
				else
				{
					    $('#paso1').removeClass('btn-primary');
				    	$('#paso1').addClass('btn-default');
				    	$('#paso2').removeClass('btn-default');
				    	$('#paso2').removeClass('disabled');
				    	$('#paso2').addClass('btn-primary');
				    	$('#step1').removeClass('active');
				    	$('#step2').addClass('active');
				}
			}
		}
	}
   
});


$(document).on('click', '#paso1', function(event) 
{
    $('#paso2').removeClass('btn-primary');
    $('#paso2').removeClass('disabled');
    $('#paso2').addClass('btn-default');
    $('#paso1').removeClass('btn-default');
    $('#paso1').addClass('btn-primary');
    $('#paso2').addClass('disabled');
    $('#paso2').attr('disabled', true);
});

$(document).on('click', '.finish', function() 
{
	var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
	if ($('#movil').val() == "") 
	{
		$.toast({
            heading: 'Información',
            text: 'Ingrese su número móvil',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
		$('#movil').focus();
	}
	else
	{
        if ($('#movil').val().charAt(0) != 3) 
        {               
           $.toast({
                heading: 'Información',
                text: 'El móvil debe empezar por 3',
                position: 'bottom-center',
                stack: false,
                icon: 'info'
            });  
            $('#movil').focus();      
        }
        else
        {
    		if ($('#email').val() == "") 
    		{
    			         $.toast({
                            heading: 'Información',
                            text: 'Ingrese un email válido',
                            position: 'bottom-center',
                            stack: false,
                            icon: 'info'
                        });
    			$('#email').focus();
    		}
    		else
    		{
    			if (!regex.test($('#email').val().trim())) 
                	{
                     		$.toast({
                            heading: 'Información',
                            text: 'Ingrese un email válido',
                            position: 'bottom-center',
                            stack: false,
                            icon: 'info'
                        });
                      	$('#email').focus();
                	}
                	else
                	{
                		$('#paso2').removeClass('btn-primary').css("border-color", "#e4e5e7");
        	  			$('#paso3').removeClass('btn-default');
        	  			$('#paso3').addClass('btn-primary');
        	  			$('#step2').removeClass('active');
        	  			$('#step3').addClass('active');
        	  			$('#paso3').removeClass('disabled');
                	}

    			
    		}
        }
	}
	  
});


function validar(obj) 
{
    num=obj.value.charAt(0);
    if(num!='3') 
    {       
        $.toast({
            heading: 'Información',
            text: 'El móvil debe empezar por 3',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
        obj.focus();
    }
}

$(document).on('blur', '#doc', function(event) 
{
	var doc = $('#doc').val();

	$.ajax({
		url: 'clientes/process.php',
		method:'POST',
		data: {opcion: "dv", doc:doc},
		success: function (data) 
		{
		    $('#digitov').val(data);
		}
	});
});

$(document).on('blur', '#doc', function(event) 
{
	var doc = $('#doc').val();

	$.ajax({
		url: 'clientes/process.php',
		method:'POST',
		data: {opcion: "validar", doc:doc},
		success: function (data) 
		{
			$('#tipocliente').val(data);
			if (data == 1) 
			{
		    		$.toast({
                        heading: 'Información',
                        text: 'Ya se encuentra registrado',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });
		    		$('#doc').select().focus();				
			}
		    
		}
	});
});



$(document).on('click', '#btnRegistrarCli', function() 
{
    var tipodoc     = $('#tipo_documento').val();
    var doc         = $('#doc').val();
    var digitov     = $('#digitov').val();
    var nombres     = $('#nombres').val();
    var apellidos   = $('#apellidos').val();
    var sexo        = $('#sexo').val();
    var ocupacion   = $('#ocupacion').val();
    var fechana     = $('#fechaNac').val();
    var depto       = $('#selDepartamento').val();
    var ciudad      = $('#selCiudad').val();
    var barrio      = $('#selBarrio').val();
    var direccion   = $('#direccion').val();
    var movil       = $('#movil').val();
    var fijo        = $('#fijo').val();
    var email       = $('#email').val();
    var extranjero  = "";
    var nm          = '';
    var ne          = '';
    var tpcli       = $('#tipocliente').val();

    
        


    if ($('#nm').is(":checked")) 
    {
        nm = 'S';
    }
    else
    {
        nm = 'N';
    }

    if ($('#ne').is(":checked")) 
    {
        ne = 'S';
    }
    else
    {
        ne = 'N';
    } 

    if ($('#extranjero').is(":checked")) 
    {
        extranjero = 'S';
    }
    else
    {
        extranjero = 'N';
    }   

     var ser = $("#formCliente").serialize();

    if( $('#aprobar').is(':checked')) 
    {
        $.ajax({
            url: 'clientes/process.php',
            method: 'POST',
            data: {opcion: "newCli", tipodoc:tipodoc, tpcli:tpcli, doc:doc, digitov:digitov, nombres:nombres, apellidos:apellidos, sexo:sexo, ocupacion:ocupacion, fechana:fechana, depto:depto, ciudad:ciudad, barrio:barrio, direccion:direccion, movil:movil, fijo:fijo, email:email, extranjero:extranjero, nm:nm, ne:ne},
            success: function (data) 
            {

                if (data == '1') 
                {
                    $.toast({
                        heading: 'Información',
                        text: 'Registro Correcto',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'success'
                    });
    	            $('#tipo_documento option:contains("Seleccione")').prop('selected',true);
    			 	$('#doc').val('');
    				$('#digitov').val('');
    			 	$('#nombres').val('');
    				$('#apellidos').val('');
    				$('#sexo option:contains("Seleccione")').prop('selected',true);
    				$('#ocupacion option:contains("Seleccione")').prop('selected',true);
    				$('#fechaNac').val('');
    				$('#selDepartamento option:contains("Seleccione")').prop('selected',true);
    				$('#selCiudad option:contains("Seleccione")').prop('selected',true);
    				$('#selBarrio option:contains("Seleccione")').prop('selected',true);
    				$('#direccion').val('');
    				$('#movil').val('');
    				$('#fijo').val('');
    				$('#email').val('');
                	  	setTimeout(function(){
					           location.reload();                	  	
                	  	}, 1000);
                }
                else
                {
                	  if (data == "dupli") 
                	  {
                	  	$.toast({
                        heading: 'Información',
                        text: 'Ya se encuentra registrado',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });
                	  }
                }
            }
        });
    } 
    else 
    {
        swal("¿Está de acuerdo con las políticas establecidas?", "Marque la casilla de verificación", "warning");
    }
                    
});

/********************************/


 $("#extranjero").on( 'change', function() 
{
    if( $(this).is(':checked') ) 
    {
        $('#coldepto').css("display", "none");
        $('#colciudad').css("display", "none");
        $('#colbarrio').css("display", "none");
    } 
    else 
    {
        $('#coldepto').css("display", "block");
        $('#colciudad').css("display", "block");
        $('#colbarrio').css("display", "block");
    }
});


$(document).on('change', '#selDepartamento', function() 
{
    var depto = $('#selDepartamento').val();

    $.ajax({
        url: 'clientes/process.php',
        method: 'POST',
        data: {opcion: "depciu", depto: depto},
        success: function (data) 
        {
            $('#selCiudad').html('');
            $('#selCiudad').html(data);
        }
     });
});


$(document).on('change', '#selCiudad', function() 
{
    var barrio = $('#selCiudad').val();

    $.ajax({
        url: 'clientes/process.php',
        method: 'POST',
        data: {opcion: "barrio", barrio: barrio},
        success: function (data) 
        {
            $('#selBarrio').html('');
            $('#selBarrio').html(data);
        }
     });
});



/*=====  End of CLIENTES  ======*/

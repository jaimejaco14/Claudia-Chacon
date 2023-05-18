/**
 *
 * MAIN
 *
 */
 $(document).ready(function () 
 {
    //loadServicios ();
    $('.clockpicker').clockpicker({autoclose: true});
});


$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});


/**
 *
 * CITAS
 *
 */

$(document).on('click', '#btnGoCitas', function() 
{
    window.location="citas.php"; 
});

$(document).on('click', '#btnGoClientes', function() 
{
    window.location="registro.php"; 
});

$(document).on('click', '#btnPQRF', function() 
{
    window.location="pqrf.php"; 
});

$(document).on('click', '#btnAgendar', function() 
{
    window.location="agenda.php"; 
});




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


var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$.fn.datepicker.dates['es'] = 
{
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
        option: "defaultDate"
});

$('.input-group.date').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#hora_de').focus();

});




toastr.options = {
    "debug": false,
    "newestOnTop": false,
    "positionClass": "toast-top-center",
    "closeButton": true,
    "toastClass": "animated fadeInDown",
};


$(document).on('blur', '#txtValDoc', function() 
{
    var doc = $('#txtValDoc').val();

    $.ajax({
        url: 'citas/process.php',
        method: 'POST',
        data: {opcion: "validarDoc", doc:doc},
        success: function (data) 
        {
            if (data == 1) 
            {
                $('#paso1').removeClass('btn-primary');
                $('#paso1').addClass('btn-default');
                $('#paso2').removeClass('btn-default');
                $('#paso2').removeClass('disabled');
                $('#paso2').addClass('btn-primary');
                $('#step1').removeClass('active');
                $('#step2').addClass('active');
                $('#documCli').val(doc);
                //toastr.success("Usted ya se encuentra registrado. Agende su cita.");
                    $.toast({
                        heading: 'Información',
                        text: 'Ya se encuentra registrado',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });
            }
            else
            {
                if (data == 2) 
                {
                    $('#modalNuevoCli').modal("show");
                    $('#modalNuevoCli').on('shown.bs.modal', function () {
                        $('#nroDoc').val(doc).select();
                    });
                      
                }
                else
                {
                    $('#modalNuevoCli').modal("show");
                    $('#modalNuevoCli').on('shown.bs.modal', function () {
                        $('#nroDoc').val(doc).select();
                    });
                    
                }
            }
                 
        
        }
    });
});


/**
 *
 * LOAD SELECT2 SERVICIOS
 *
 */

$(document).ready(function() {
    $("#salon").select2(); 
    $("#servicioSel").select2(); 
    $("#tipodoc").select2(); 
    $("#tipoocupacion").select2(); 
    $("#selDepartamento").select2(); 
    //$("#selCiudad").select2(); 
    //$("#colbarrio").select2(); 

});


/**
 *
 * DIGITO VERIFICADOR
 *
 */


 $(document).on('blur', '#nroDoc', function() 
 {
     var documento = $('#nroDoc').val();

     $.ajax({
        url: 'citas/process.php',
        method: 'POST',
        data: {opcion: "dv", documento: documento},
        success: function (data) 
        {
           var jsonDv = JSON.parse(data);

           if (jsonDv.res == "full") 
           {
              $('#btnDv').html(jsonDv.dv);
           }
        }
     });
 });


 /*=====================================
 =            NUEVO CLIENTE            =
 =====================================*/

$(document).on('change', '#tipodoc', function(event) 
{
    $('#nroDoc').focus().select();
});
 
$(document).on('blur', '#nroDoc', function(event) 
{
    $('#nombres').focus().select();
});

$(document).on('blur', '#nombres', function(event) 
{
    $('#apellidos').focus().select();
});

$(document).on('blur', '#apellidos', function(event) 
{
    $('#sexo').focus().select();
});

$(document).on('change', '#sexo', function(event) 
{
    $('#tipoocupacion').focus().select();
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
 

 $(document).on('change', '#tipoocupacion', function() 
 {
    $('#tipodecliente').removeClass('btn-primary');
    $('#tipodecliente').addClass('btn-default');
    $('#datosregistro').removeClass('btn-default');
    $('#datosregistro').addClass('btn-primary');

    $('#data1').removeClass('active');
    $('#data2').addClass('active');


 });

$('.input-group.date').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
       today: "Today",
});

$('.input-group.date').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});

$(document).on('change', '#selDepartamento', function() 
{
    var depto = $('#selDepartamento').val();

    $.ajax({
        url: 'citas/process.php',
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
        url: 'citas/process.php',
        method: 'POST',
        data: {opcion: "barrio", barrio: barrio},
        success: function (data) 
        {
            $('#selBarrio').html('');
            $('#selBarrio').html(data);
        }
     });
});


$(document).on('click', '#btnNext', function() 
{
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if ($('#movil').val() == "") 
    {
        toastr.warning("Ingrese su móvil");
        $('#movil').focus();
    }
    else
    {
        if ($('#email').val() == "") 
        {
            toastr.warning("Ingrese su correo electrónico");
            $('#email').focus();
        }
        else
        {
            if (!regex.test($('#email').val().trim())) 
            {
                 toastr.warning("Ingrese un e-mail válido");
                  $('#email').focus();
            }
            else
            {
                 $('#datosregistro').removeClass('btn-primary');
                 $('#datosregistro').addClass('active');
                 $('#registrar').removeClass('btn-default');
                 $('#registrar').addClass('btn-primary');
                 $('#data2').removeClass('active');
                 $('#data3').addClass('active');                
            }
        }
    }

});

$(document).on('click', '#btnNext2', function() 
{
    $('#tipodecliente').removeClass('btn-primary');
    $('#tipodecliente').addClass('btn-default');
    $('#datosregistro').removeClass('btn-default');
    $('#datosregistro').addClass('btn-primary');
    $('#data1').removeClass('active');
    $('#data2').addClass('active');

});





$(document).on('click', '#btnRegistrarCli', function() 
{
    var tipodoc     = $('#tipodoc').val();
    var doc         = $('#nroDoc').val();
    var digitov     = $('#btnDv').html();
    var nombres     = $('#nombres').val();
    var apellidos   = $('#apellidos').val();
    var sexo        = $('#sexo').val();
    var ocupacion   = $('#tipoocupacion').val();
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

    


    if (tipodoc == 0) 
    {
        toastr.warning("Seleccione el tipo de documento");
    }
    else
    {
        if (doc == "") 
        {
            toastr.warning("Digite su documento de identidad");
        }
        else
        {
            if (nombres == "") 
            {
                toastr.warning("Digite sus nombres");
            }
            else
            {
                if (apellidos == "") 
                {
                    toastr.warning("Digite sus apellidos");
                }
                else
                {
                   if (movil == "") 
                   {
                       toastr("Digite su número móvil");
                       $('#registrar').removeClass('btn-primary');
                       $('#registrar').addClass('btn-default');
                       $('#registrar').removeClass('btn-default');
                       $('#datosregistro').addClass('btn-primary');
                       $('#data3').removeClass('active');
                       $('#data2').addClass('active');
                       $('#movil').focus();
                   }
                   else
                   {
                      if (email == "") 
                      {
                          toastr.warning("Digite su e-mail");
                      }
                      else
                      {
                            if( $('#aprobar').is(':checked')) 
                            {
                                $.ajax({
                                    url: 'citas/process.php',
                                    method: 'POST',
                                    data: {opcion: "newCli", tipodoc:tipodoc, doc:doc, digitov:digitov, nombres:nombres, apellidos:apellidos, sexo:sexo, ocupacion:ocupacion, fechana:fechana, depto:depto, ciudad:ciudad, barrio:barrio, direccion:direccion, movil:movil, fijo:fijo, email:email, extranjero:extranjero, nm:nm, ne:ne},
                                    success: function (data) 
                                    {
                                        var jsonTer = JSON.parse(data);

                                        if (jsonTer.res == '1') 
                                        {
                                           $.toast({
                                            heading: 'Información',
                                            text: 'Registro Correcto',
                                            position: 'bottom-center',
                                            stack: false,
                                            icon: 'info'
                                        });
                                            $('#modalNuevoCli').modal("hide");
                                            $('#txtValDoc').val('');
                                            $('#paso1').removeClass('btn-primary');
                                            $('#paso1').addClass('btn-default');
                                            $('#paso2').removeClass('btn-default');
                                            $('#paso2').addClass('btn-primary');
                                            $('#step1').removeClass('active');
                                            $('#step2').addClass('active');
                                            $('#codcli').val(jsonTer.codcli);
                                        }
                                    }
                                });
                            } 
                            else 
                            {
                                swal("¿Está de acuerdo con las políticas establecidas?", "Marque la casilla de verificación", "warning");
                            }
                      }
                   }
                   
                   
                }
            }
        }
    }
});


/*******/
///PROCESO DE VALIDACION PARA AGENDAR CITAS
/******/


$("#fechaCita").datetimepicker({
    format: "YYYY-MM-DD HH:mm ",
    minDate: moment().format("YYYY-MM-DDTHH"),
    locale: "es",
});


/*****************************************/


$(document).on('blur', '#hora_de', function() 
{
    var salon      = $('#salon').val();
    var servicio   = $('#servicioSel').val();
    var fecha      = $('#fecha_de').val();
    var hora       = $('#hora_de').val();

    $.ajax({
        url: 'citas/process.php',
        method: 'POST',
        data: {opcion: "validarServicio", salon:salon, servicio:servicio, fecha:fecha, hora:hora},
        success: function (data) 
        {
            $('#selCol').html('');
            $('#selCol').html(data);
        }
    });
});


$(document).on('click', '.finish', function() 
{
    if ($('#salon').val() == 0) 
    {
        $.toast({
            heading: 'Información',
            text: 'Seleccione el salón',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
    }
    else
    {
        if ($('#servicioSel').val() == 0) 
        {
            $.toast({
                heading: 'Información',
                text: 'Seleccione el servicio',
                position: 'bottom-center',
                stack: false,
                icon: 'info'
            });
        }
        else
        {
            if ($('#selCol').val() == "") 
            {
                $.toast({
                    heading: 'Información',
                    text: 'Ingrese fecha',
                    position: 'bottom-center',
                    stack: false,
                    icon: 'info'
                });
            }
            else
            {
                if ($('#hora_de').val() == '00:00') 
                {
                   $.toast({
                        heading: 'Información',
                        text: 'Seleccione hora',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });
                }
                else
                {
                    $('#paso2').removeClass('btn-primary').css("border-color", "#e4e5e7");
                    $('#paso3').removeClass('btn-default');
                    $('#paso3').addClass('btn-primary');
                    $('#step2').removeClass('active');
                    $('#step3').addClass('active');
                    $('#paso3').removeClass('disabled');

                    var ser = $("#formCliente").serialize();

                    $.ajax({
                            type: "POST",
                            url: "citas/processAppoinment.php",
                            data: {ser: ser}, 
                            success: function(data)
                            {
                               
                                var jsoncod = JSON.parse(data);

                                if (jsoncod.res == "success") 
                                {
                                    
                                    for(var i in jsoncod.cita)
                                    {
                                        $('#txtResumen').html("<i class='fa fa-pencil'></i> Resúmen de Cita N° " + jsoncod.cita[i].id);

                                        $('#lista').append('<button type="button" class="list-group-item bcli"> <b><span class="pull-left">CLIENTE:</span></b><span class="pull-right">'+jsoncod.cita[i].cliente+'</span> </button><button type="button" class="list-group-item bcli"><b>SALÓN:</b> <span class="pull-right">'+jsoncod.cita[i].salon+ '</span> </button><button type="button" class="list-group-item bcli"><b>DIRECCIÓN:</b> <span class="pull-right">'+jsoncod.cita[i].direccion+ '</span> </button><button type="button" class="list-group-item bcli"><b>MÓVIL:</b> <span class="pull-right">'+jsoncod.cita[i].movil+ '</span> </button><button type="button" class="list-group-item bcli"> <b><span class="pull-left">SERVICIO:</span></b> <span class="pull-right">'+jsoncod.cita[i].servicio+'</span> </button><button type="button" class="list-group-item bcli"><b><span class="pull-left">COLAB.:</span></b> <span class="pull-right">'+jsoncod.cita[i].colaborador+'</span> </button><button type="button" class="list-group-item bcli"><b>FECHA:</b> <span class="pull-right">'+jsoncod.cita[i].fecha+ '</span> </button><button type="button" class="list-group-item bcli"><b>HORA:</b> <span class="pull-right">'+jsoncod.cita[i].hora+ '</span> </button>');

                                        //$('#txtcliente').val(jsoncod.cita[i].cliente);
                                        //$('#txtservicio').html(jsoncod.cita[i].servicio);' + jsoncod.cita[i].hora +'
                                    }

                                    $('#txtValDoc').val('');
                                    $('#txtobser').val('');
                                    /*setTimeout(function(){
                                        location.reload();
                                    }, 2000);*/
                                    
                                }
                            }
                    });


                }
                
            }           
        }
    }
});
/**
 *
 * AGENDAR
 *
 */

$(document).on('change', '#servicioSel', function() 
{
    var ser = $('#servicioSel').val();

    $.ajax({
        url: 'citas/process.php',
        method: 'POST',
        data: {opcion: "serDescripcion", ser:ser},
        success: function (data) 
        {
            $('#descripcion').css("display", "block").html(data);
        }
    });
});


$(document).on('click', '#btnSI', function() 
{
    if ($('#fecha_de').val() == "") 
    {
       $.toast({
            heading: 'Información',
            text: 'Seleccione fecha para agendamiento',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
        $('#fecha_de').focus();
    }
    else
    {
        //$('#documCli').val()alert();
    }
});

$(document).on('click', '#btnAgendar', function() 
{
    var documento   = $('#documCli').val();
    var salon       = $('#salon').val();
    var fecha_de    = $('#fecha_de').val();
    var hora_de     = $('#hora_de').val();
    var txtobser    = $('#txtobser').val();

    if ($('#fecha_de').val() == "") 
    {
        $.toast({
            heading: 'Información',
            text: 'Seleccione fecha para agendamiento',
            position: 'bottom-center',
            stack: false,
            icon: 'info'
        });
        $('#fecha_de').focus();
    }
    else
    {
        $.ajax({
            url: "citas/processAgenda.php",
            method: 'POST',
            data: {opcion: "agendar", doc: documento, salon:salon, fecha: fecha_de, hora: hora_de, obser: txtobser},
            success: function (data) 
            {
               var jsonReserva = JSON.parse(data);

                if (jsonReserva.res == "full") 
                {                
                    toastr.success("Su reserva se ha realizado con éxito con el \n  consecutivo N° " + jsonReserva.reserva, "", "success"); 
                    $.toast({
                        heading: 'Información',
                        text: 'Su reserva se ha realizado con éxito con el \n  consecutivo N° ' + jsonReserva.reserva + ' ',
                        position: 'bottom-center',
                        stack: false,
                        icon: 'info'
                    });

                    setTimeout(function(){
                        location.reload();
                    }, 1500);              
                }
            }
        });
    }

        
});








 /*=====  End of NUEVO CLIENTE  ======*/
 


           


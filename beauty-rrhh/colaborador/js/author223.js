
$(document).ready(function() 
{
		$('[data-toggle="tooltip"]').tooltip();
        loadAuth ();
        fnLoadUlt ();
});


$(document).on('click', '#btnModalNuevaAut', function() 
{
	$('#modalNuevaAut').modal().show();
});


$('#selColaborador').selectpicker({
        liveSearch: true,
        showSubtext: true,
        width: '100%',
        noneSelectedText: ''
});

$('#selColaboradorReporte').selectpicker({
        liveSearch: true,
        showSubtext: true,
        width: '100%',
});



$(document).on('change', '#selTipo', function() 
{
    if ($('#selTipo').val() == 3) 
    {
        $('#porcentaje').show();
        $('#valor').hide();
        $('#labelValor').html('Digite Porcentaje');
        $('#sign').html('%');
    }
    else
    {
        $('#porcentaje').hide();
        $('#valor').show();
        $('#labelValor').html('Digite Valor');
        $('#sign').html('$');
    }
});


$(document).on('change', '#selTipo', function() 
{
    if ($('#selTipo').val() == 4) 
    {
        $('#groupCol').hide();
        $('#groupCli').show();
    }
    else
    {
        $('#groupCol').show();
        $('#groupCli').hide();
        $('#txtbeneficiario').val('');
    }
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




$('#fecha').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fecha').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});


/****************************/

$('#fechaUnoReporte').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaDosReporte').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaUnoReporte').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fechaDosReporte').focus();
});

$('#fechaDosReporte').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
});

$(document).ready(function() {
    $('#selSlnReporte').select2({placeholder: "SELECCIONE SALON(ES)",allowClear: true});
    $('#selTipoReporte').select2({placeholder: "SELECCIONE TIPO",allowClear: true});
});

/****************************/


/*========================================
=            NUEVO DESARROLLO            =
========================================*/


$(document).on('change', '#selTipo', function() 
{
     var tipo = $('#selTipo').val();

    if (tipo != 5) 
    {
        $('#btnNuevoBeneficiario').attr('disabled', true);
    }
    else
    {
        $('#btnNuevoBeneficiario').attr('disabled', false);
    }
});


$(document).on('change', '#selTipo', function() 
{
    var tipo = $('#selTipo').val();

    $.ajax({
        url: '../php/auth/loads2.php',
        method: 'POST',
        data: {opcion: "cargarSubtipo", tipo: tipo},
        success: function (data) 
        {
            $('#selSubtipo').html(data);
        }
    });
});


$(document).on('click', '#btnNuevoSubtipo', function() 
{
    var tipo = $('#selTipo').val();
    $('#modalNuevoSubtipo').modal("show");
    $('#tipo_new').val(tipo);
});


$(document).on('click', '#btnGuardarSubtipo', function() 
{
    var tipo_new    = $('#tipo_new').val();
    var subtipo_new = $('#subtipo_new').val();
    var desc        = $('#descripcion').val();

    if (subtipo_new == '') 
    {
         swal("Advertencia", "Ingrese el subtipo", "warning");
    }
    else 
    {
        $.ajax({
            url: '../php/auth/loads2.php',
            method: 'POST',
            data: {opcion: "newSubtipo", tipo: tipo_new, subtipo: subtipo_new, desc:desc},
            success: function (data) 
            {
                if (data == 1) 
                {
                    cargarNuevoSubtipo ();
                    $('#modalNuevoSubtipo').modal("hide");
                }
            }
        });
    }
});


$('#modalNuevoSubtipo').on('hidden.bs.modal', function (e) 
{
        $('#tipo_new').val('');
        $('#subtipo_new').val('');
        $('#descripcion').val('');
});


function cargarNuevoSubtipo () 
{
    var tipo = $('#selTipo').val();

    $.ajax({
        url: '../php/auth/loads2.php',
            method: 'POST',
            data: {opcion: "cargarNuevoSubtipo", tipo: tipo},
            success: function (data) 
            {
                $('#selSubtipo').html(data);
            }
    });
}



$(document).on('click', '#btnNuevoBeneficiario', function() 
{
    $('#modalNuevoBeneficiario').modal("show"); 
    //$('#modalNuevaAut').modal('hide');
});



$(document).on('change', '#selSalon', function(event)
{
     

});


$('#fechanuevaPersona').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechanuevaPersona').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});


function validar(obj) 
{
    num=obj.value.charAt(0);
    if(num!='3') 
    {       
        swal('El móvil debe empezar por 3','Advertencia', 'warning');
        obj.focus();
    }
}


$(document).on('blur', '#email', function(event) 
{
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (!regex.test($('#email').val().trim()))
    {
        swal("Ingrese un e-mail válido", "Advertencia", "warning");
    }
});


$(document).on('blur', '#documento', function() 
{
    var documento = $('#documento').val();

    $.ajax({
            url: '../php/auth/loads2.php',
            method: 'POST',
            data: {opcion: "validarDoc", documento:documento},
            success: function (data) 
            {
                var jsonDoc = JSON.parse(data);

                if (jsonDoc.res == "full") 
                {
                    for(var i in jsonDoc.json)
                    {
                        $('#tdicodigo').html('<option value="'+jsonDoc.json[i].tdicodigo+'">'+jsonDoc.json[i].tdinombre+'</option>').attr('disabled', true);
                        $('#documento').val(jsonDoc.json[i].trcdocumento).attr('disabled', true);
                        $('#nombres').val(jsonDoc.json[i].trcnombres).attr('disabled', true);
                        $('#apellidos').val(jsonDoc.json[i].trcapellidos).attr('disabled', true);
                        if(jsonDoc.json[i].trcdireccion!=''){
                            $('#direccion').val(jsonDoc.json[i].trcdireccion).attr('disabled', true);
                        }
                        if(jsonDoc.json[i].trctelefonofijo!=''){
                            $('#fijo').val(jsonDoc.json[i].trctelefonofijo).attr('disabled', true);
                        }
                        if(jsonDoc.json[i].trctelefonomovil!=''){
                            $('#movil').val(jsonDoc.json[i].trctelefonomovil).attr('disabled', true);
                        }
                        swal("Ingrese los datos faltantes", "Advertencia", "warning");
                    }
                }
                else
                {
                    for(var j in jsonDoc.json)
                    {
                        $('#docTer').val(jsonDoc.json[j].trcdocumento);
                        $('#modalNuevoBeneficiario').modal('hide');
                        $('#txtbeneficiario').val(jsonDoc.json[j].trcnombres + ' ' + jsonDoc.json[j].trcapellidos).attr('disabled', true);
                        $('#groupCol').hide();
                        $('#groupCli').show();                        
                    }

                    
                }
            }
        });

});


$(document).on('click', '#liper', function() 
{
    $('#btnGuardarProveedor').attr('id', 'btnGuardarPersona');
});

$(document).on('click', '#lipp ', function() 
{
    $('#btnGuardarPersona').attr('id', 'btnGuardarProveedor');
});






$(document).on('click', '#btnGuardarPersona', function(event) 
{
    var tdicodigo = $('#tdicodigo').val();
    var documento = $('#documento').val();
    var nombres   = $('#nombres').val();
    var apellidos = $('#apellidos').val();
    var direccion = $('#direccion').val();
    var movil     = $('#movil').val();
    var fijo      = $('#fijo').val();
    var email     = $('#email').val();
    var fecha     = $('#fechanuevaPersona').val();

    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if (documento == '') 
    {
        swal("Ingrese el documento de identidad", "Advertencia", "warning");
    }
    else if (nombres == '') 
    {
        swal("Ingrese el nombre", "Advertencia", "warning");
    }
    else if (apellidos == '')
    {
        swal("Ingrese el apellido", "Advertencia", "warning");
    }
    else if (direccion == '')
    {
        swal("Ingrese la dirección", "Advertencia", "warning");
    }
    else if (movil == '')
    {
        swal("Ingrese el móvil", "Advertencia", "warning");
    }
    else if (email == '')
    {
        swal("Ingrese el e-mail", "Advertencia", "warning");
    }
    else if (!regex.test($('#email').val().trim()))
    {
        swal("Ingrese un e-mail válido", "Advertencia", "warning");
    }
    else if (fecha == '')
    {
        swal("Ingrese la fecha de nacimiento", "Advertencia", "warning");
    }
    else
    {
        $.ajax({
            url: '../php/auth/loads2.php',
            method: 'POST',
            data: {opcion: "nuevaPersona", tdicodigo:tdicodigo, documento:documento, nombres:nombres, apellidos:apellidos, direccion:direccion, movil:movil, fijo:fijo, email:email, fecha:fecha},
            success: function (data) 
            {
                var jsonDoc = JSON.parse(data);

                if (jsonDoc.res == "fullname") 
                {

                    for(var j in jsonDoc.json)
                    {
                        $('#docTer').val(jsonDoc.json[j].trcdocumento);
                        $('#modalNuevoBeneficiario').modal('hide');
                        $('#txtbeneficiario').val(jsonDoc.json[j].trcnombres + ' ' + jsonDoc.json[j].trcapellidos).attr('disabled', true);
                        $('#groupCol').hide();
                        $('#groupCli').show(); 
                       // $('#modalNuevaAut').modal('show');                       
                    }                   
                }
               

            }
        });
    }



});




$(document).on('click', '#btnIngresarAut2', function() 
{
    var tipo    = $('#selTipo').val();
    var subtipo = $('#selSubtipo').val();
    var sln     = $('#selSalon').val();
    var col     = $('#selColaborador').val();
    var docTer  = $('#docTer').val();
    var cli     = $('#txtbeneficiario').val();
    var val     = $('#valor').val();
    var por     = $('#porcentaje').val();
    var obs     = $('#observacion').val();
    var fec     = $('#fecha').val();

    //  alert("Tipo: " + tipo + "\n" + "Subtipo: " + subtipo + "\n" + "Salon: " + sln + "\n" + "Colaborador: " + col + "\n" +  "Doctercero: " + docTer + "\n" + "ClienteBen: " + "\n" + "Valor: " + val + "\n" + "\n" + "Porcentaje: " + por + "\n" + "Observacion: " + obs + "\n" + "Fecha: " + fec + "\n" + "ClienteBono: " + cli );

    val = val.replace('.', '');


    switch (tipo) 
    {
        case '0':
            swal("Advertencia", "Seleccione el tipo de autorización", "warning");
            break;

        case '3':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if (col == 0) 
                {
                    swal("Advertencia", "Seleccione colaborador", "warning");
                }
                else if ($('#valor').is(":hidden") && $('#porcentaje').is(":visible")) 
                {
                    if ($('#porcentaje').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el porcentaje", "warning");
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads2.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                } 
            break;

        case '2':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if (col == 0) 
                {
                    swal("Advertencia", "Seleccione colaborador", "warning");
                }
                else if ($('#valor').is(":visible") && $('#porcentaje').is(":hidden")) 
                {
                    if ($('#valor').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads2.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;

            case '4':

                if (sln == '') 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if ($('#groupCol').is(":hidden") && $('#groupCli').is(":visible") && $('#selColaborador').is(':hidden')) 
                {
                    if ($('#txtbeneficiario').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el beneficiario", "warning");
                    }
                    else if(val == '')
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                        $('#valor').focus();
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads2.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;

        case '1':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if ($('#groupCol').is(":visible") && $('#groupCli').is(":hidden") && $('#selColaborador').is(':visible')) 
                {
                    if ($('#selColaborador').val() == 0) 
                    {
                        swal("Advertencia", "Seleccione el colaborador", "warning");
                    }
                    else if(val == '')
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                        $('#valor').focus();
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads2.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;



        case '5':
        case '6':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if ($('#groupCol').is(":visible") && $('#groupCli').is(":hidden") && $('#selColaborador').is(':visible')) 
                {
                    if ($('#selColaborador').val() == 0) 
                    {
                        swal("Advertencia", "Seleccione el colaborador", "warning");
                    }
                    else if(val == '')
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                        $('#valor').focus();
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads2.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }
                else
                {
                    if ($('#groupCol').is(":hidden") && $('#groupCli').is(":visible") && $('#selColaborador').is(':hidden')) 
                    {
                      
                        if(val == '')
                        {
                            swal("Advertencia", "Ingrese el valor", "warning");
                            $('#valor').focus();
                        }
                        else if(fec == '')
                        {
                            swal("Advertencia", "Ingrese la fecha", "warning");
                            $('#valor').focus();
                        }
                        else
                        {
                            $.ajax({
                                url: '../php/auth/loads2.php',
                                method: 'POST',
                                data: {opcion: "ingreso", tipo:tipo, subtipo:subtipo, docTer:docTer, sln:sln,col:col,val:val, por:por, obs:obs, fec:fec, cli:cli},
                                beforeSend: function () 
                                {
                                    $('.send').show();
                                },
                                success: function (data) 
                                {
                                    var jsonCod = JSON.parse(data);

                                    if (jsonCod.res == 1) 
                                    {
                                        loadAuth ();
                                        fnLoadUlt ();
                                        swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                        $('#modalNuevaAut').modal('hide');
                                        $('.send').hide();
                                    }
                                    else 
                                    {
                                        swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                        $('#modalNuevaAut').modal('hide');
                                        $('.send').hide();
                                    }
                                }
                            });
                        }
                    }
                }

            break;


        default:
            // statements_def
            break;
    }

   

});


$(document).ready(function() {
    loadColaborador () ;
});


$(document).on('change', '#selSalon', function(event) 
{
    var tipo = $('#selTipo').val(); 

    switch (tipo) 
    {
        case '5':
        case '6':
            loadColaboradorAdm ();
            break;

        case '2':
            loadColaboradorAux ();
            break;

        default:

            loadColaborador ();
            break;
    }
});


function loadColaboradorAdm () 
{
    var selColaborador  = $("#selColaborador");
    $.ajax({
        url: '../php/auth/loads2.php',
        type: 'POST',
        data: {opcion: "loadColaboradorAdm"},

        success: function(data){

            var json = JSON.parse(data);

            if(json.res == "full")
        

                var colaboradores = "";

                for(var i in json.json){

                     colaboradores += "<option value='"+json.json[i].clbcodigo+ ',' +json.json[i].incluir+ "'>"+json.json[i].colaborador+"</option>";
                }

                selColaborador.html(colaboradores);
                selColaborador.selectpicker('refresh');
        }
    }); 
}


function loadColaborador () 
{
    var selColaborador  = $("#selColaborador");
    $.ajax({
        url: '../php/auth/loads2.php',
        type: 'POST',
        data: {opcion: "loadColaborador"},

        success: function(data){

            var json = JSON.parse(data);

            if(json.res == "full")
        

                var colaboradores = "";

                    colaboradores += "<option value='0'>Seleccione beneficiario...</option>";

                for(var i in json.json){

                    colaboradores += "<option value='"+json.json[i].clbcodigo+"'>"+json.json[i].colaborador+"</option>";
                }

                selColaborador.html(colaboradores);
                selColaborador.selectpicker('refresh');
        }
    }); 
}


function loadColaboradorAux () 
{
    var selColaborador  = $("#selColaborador");
    $.ajax({
        url: '../php/auth/loads2.php',
        type: 'POST',
        data: {opcion: "loadColaboradorAux"},

        success: function(data){

            var json = JSON.parse(data);

            if(json.res == "full")
        

                var colaboradores = "";

                for(var i in json.json){

                    colaboradores += "<option value='"+json.json[i].clbcodigo+"'>"+json.json[i].colaborador+"</option>";
                }

                selColaborador.html(colaboradores);
                selColaborador.selectpicker('refresh');
        }
    }); 
}


$(document).on('change', '#tdicodigoPro', function() 
{
    var tdipro = $('#tdicodigoPro').val();

    if (tdipro == 1) 
    {
        $('#colmdrazonsocial').show();
        $('#colmdapellido').hide();
        $('#nombresPro').val('');
        $('#apellidosPro').val('');
    }
    else
    {
        $('#colmdrazonsocial').hide();
        $('#colmdapellido').show();
        $('#razonsocialPro').val('');
    }
});


/**
 *
 * NUEVO PROVEEDOR
 *
 */


 $(document).on('click', '#btnGuardarProveedor', function() 
 {
     var tdicodigoPro = $('#tdicodigoPro').val();
     var documentoPro = $('#documentoPro').val();
     var nombresPro   = $('#nombresPro').val();
     var razon        = $('#razonsocialPro').val();
     var apellidosPro = $('#apellidosPro').val();
     var razonsocialPro = $('#razonsocialPro').val();
     var direccionPro = $('#direccionPro').val();
     var movilPro     = $('#movilPro').val();
     var fijoPro      = $('#fijoPro').val();
     var emailPro     = $('#emailPro').val();
     var cumplePro    = $('#fechanuevaPersonaPro').val();

     //alert("Tipo: " + tdicodigoPro + "\n" + "documentoPro: " + documentoPro + "\n" + "nombresPro: " + nombresPro + "\n" + "apellidosPro: " + apellidosPro + "\n" +  "razonsocialPro: " + razonsocialPro + "\n" + "direccionPro: " + direccionPro + "\n" + "movilPro: " + movilPro + "\n" + "\n" + "fijoPro: " + fijoPro + "\n" + "emailPro: " + emailPro + "\n" + "cumplePro: " + cumplePro + "\n" + "Razon: " + razon );


   
        if (documentoPro == '') 
        {
            swal("Ingrese el documento de identidad ", "Advertencia", "warning");
        }
        else if (nombresPro == '') 
        {
            swal("Ingrese el nombre", "Advertencia", "warning");
        }
        else if (apellidosPro == '') 
        {
            swal("Ingrese el apellido", "Advertencia", "warning");
        }
        else if (direccionPro == '') 
        {
            swal("Ingrese la dirección", "Advertencia", "warning");
        }
        else if (movilPro == '') 
        {
            swal("Ingrese el número móvil", "Advertencia", "warning");
        }
        else
        {
            $.ajax({
                url: '../php/auth/loads2.php',
                type: 'POST',
                data: {opcion: "addProveedor", tdicodigoPro:tdicodigoPro, documentoPro:documentoPro, nombresPro:nombresPro, apellidosPro:apellidosPro, razon:razon, direccionPro:direccionPro, movilPro:movilPro, fijoPro:fijoPro, emailPro:emailPro, cumplePro:cumplePro},
                success: function (data) 
                {
                    var jsonPro = JSON.parse(data);

                    if (jsonPro.res == 'full') 
                    {
                        for(var i in jsonPro.json)
                        {
                            $('#docTer').val(jsonPro.json[i].doc);
                            $('#modalNuevoBeneficiario').modal('hide');
                            $('#groupCol').hide();
                            $('#groupCli').show();
                            $('#txtbeneficiario').val(jsonPro.json[i].nombre).attr('disabled', true);
                        }
                        
                    }
                }
            });
        }
        

 });

$("#modalNuevoBeneficiario").on("hidden.bs.modal", function () {
    $("#formnewbenef")[0].reset();
});

/*=====  End of NUEVO DESARROLLO  ======*/






























$(document).on('click', '#btnIngresarAut', function() 
{
	var tipo = $('#selTipo').val();
    var sln  = $('#selSalon').val();
    var col  = $('#selColaborador').val();
    var cli  = $('#txtbeneficiario').val();
    var val  = $('#valor').val();
    var val2  = $('#valor').val();
    var por  = $('#porcentaje').val();
    var obs  = $('#observacion').val();
    var fec  = $('#fecha').val();

    val = val.replace('.', '');


    switch (tipo) 
    {
        case '0':
            swal("Advertencia", "Seleccione el tipo de autorización", "warning");
            break;

        case '3':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if (col == 0) 
                {
                    swal("Advertencia", "Seleccione colaborador", "warning");
                }
                else if ($('#valor').is(":hidden") && $('#porcentaje').is(":visible")) 
                {
                    if ($('#porcentaje').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el porcentaje", "warning");
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, sln:sln,col:col,val:val, val2:val2, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                } 
            break;

        case '2':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if (col == 0) 
                {
                    swal("Advertencia", "Seleccione colaborador", "warning");
                }
                else if ($('#valor').is(":visible") && $('#porcentaje').is(":hidden")) 
                {
                    if ($('#valor').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, sln:sln,col:col,val:val, val2:val2, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;

            case '4':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if ($('#groupCol').is(":hidden") && $('#groupCli').is(":visible") && $('#selColaborador').is(':hidden')) 
                {
                    if ($('#txtbeneficiario').val() == '') 
                    {
                        swal("Advertencia", "Ingrese el beneficiario", "warning");
                    }
                    else if(val == '')
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                        $('#valor').focus();
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, sln:sln,col:col,val:val, val2:val2, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;

        case '1':

                if (sln == 0) 
                {
                    swal("Advertencia", "Seleccione salón", "warning");
                }
                else if ($('#groupCol').is(":visible") && $('#groupCli').is(":hidden") && $('#selColaborador').is(':visible')) 
                {
                    if ($('#selColaborador').val() == 0) 
                    {
                        swal("Advertencia", "Seleccione el colaborador", "warning");
                    }
                    else if(val == '')
                    {
                        swal("Advertencia", "Ingrese el valor", "warning");
                        $('#valor').focus();
                    }
                    else if(fec == '')
                    {
                        swal("Advertencia", "Ingrese la fecha", "warning");
                        $('#valor').focus();
                    }
                    else
                    {
                        $.ajax({
                            url: '../php/auth/loads.php',
                            method: 'POST',
                            data: {opcion: "ingreso", tipo:tipo, sln:sln,col:col,val:val, val2:val2, por:por, obs:obs, fec:fec, cli:cli},
                            beforeSend: function () 
                            {
                                $('.send').show();
                            },
                            success: function (data) 
                            {
                                var jsonCod = JSON.parse(data);

                                if (jsonCod.res == 1) 
                                {
                                    loadAuth ();
                                    fnLoadUlt ();
                                    swal("Exitoso", "Nueva autorización ingresada con código # " + jsonCod.codigo, "success");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                                else 
                                {
                                    swal("Error", "Hubo un error del servidor al ingresar la autorización", "error");
                                    $('#modalNuevaAut').modal('hide');
                                    $('.send').hide();
                                }
                            }
                        });
                    }
                }

            break;
        default:
            // statements_def
            break;
    }




    

});


$('#modalNuevaAut').on('hidden.bs.modal', function () 
{
    $('#selSalon option:contains("Seleccione")').prop('selected',true);
    $('#selTipo option:contains("Seleccione")').prop('selected',true);
    $('#selSubtipo').html('<option></option>');
    $('#valor').val('');
    $('#observacion').val('');
    $('#txtbeneficiario').val(''); 
    $('#fecha').val('');
});




function loadAuth () 
{
    $.ajax({
        url: '../php/auth/loads2.php',
        method: 'POST',
        data: {opcion: "load"},
        success: function (data) 
        {
            $('#notes').empty();
            var lista = JSON.parse(data);
            var beneficiario = '';
            if (lista.res == 'full') 
            {
                for(var i in lista.json)
                {

                    $('#notes').append('<div class="panel-body note-link"><a href="javascript:(void)" onclick="fnLoadAut('+lista.json[i].cod+')" data-toggle="tab"><small class="pull-right text-muted">'+lista.json[i].fec+'</small><h5>#'+lista.json[i].cod+'</h5><div class="small">'+lista.json[i].nom + ' <b>[' + lista.json[i].col +']</b></div></a></div>');

                    var valorAut = '';

                    if (lista.json[i].val != null) 
                    {
                        valorAut = lista.json[i].val;
                    }
                    else
                    {
                        valorAut = lista.json[i].por + '%';
                    }

                     
                }
            }
            else
            {
                $('#notes').append('<div class="panel-body note-link"><a href="javascript:(void)" data-toggle="tab"><small class="pull-right text-muted"></small><h5></h5><div class="small"><b>No hay autorizaciones registradas</b></div></a></div>');
            }
        } 
    });
}


function fnLoadAut (codigo) 
{

    $.ajax({
        url: '../php/auth/loads2.php',
        method: 'POST',
        data: {opcion: "loadCod", codigo: codigo},
        success: function (data) 
        {
            var lista = JSON.parse(data);
            var valorAut = '';
            var beneficiario = '';

            $('#tblContent tbody').empty();

            if (lista.res == 'full') 
            {
                for(var i in lista.json)
                {

                    if (lista.json[i].val != null) 
                    {
                        valorAut = lista.json[i].val;
                    }
                    else
                    {
                        valorAut = lista.json[i].por + '%';
                    }

                    $('#tblContent tbody').append('<tr><th colspan="2" style="text-align: center;">Beauty Soft | Autorizaciones</th></tr><tr class="success"><th colspan="2" style="text-align: center;">Autorización #'+lista.json[i].cod+'</th></tr><tr><th>Tipo</th><td>'+lista.json[i].nom+'</td></tr><tr><td><b>Subtipo</b></td><td>'+lista.json[i].sub+'</td></tr><tr><th>Fecha</th><td>'+lista.json[i].fec+'</td></tr><tr><th>Salón</th><td>'+lista.json[i].sln+'</td></tr><tr><th>Valor</th><td>'+valorAut+'</td></tr><tr><th>Beneficiario</th><td>'+lista.json[i].col+'</td></tr><tr><th>Por concepto de</th><td>'+lista.json[i].obs+'</td></tr><tr><th>Aprobado por</th><td>'+lista.json[i].usu+'</td></tr><tr><td colspan="2"><button class="btn btn-danger pull-right" id="btnAut" data-toggle="tooltip" data-placement="top" title="Se enviará un e-mail al salón anulando la autorización con el código #'+lista.json[i].cod+'" data-idaut="'+lista.json[i].cod+'"><i class="fa fa-minus-circle"></i></button><button class="btn btn-primary pull-right" id="btnReenvio" style="margin-right: 10px" data-toggle="tooltip" data-placement="top" title="Se reenviará un e-mail a los implicados" data-idaut="'+lista.json[i].cod+'"><i class="fa fa-envelope-o"></i> Reenviar Aut</button></td></tr>');
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        } 
    });
}


function fnLoadUlt () 
{

    $.ajax({
        url: '../php/auth/loads2.php',
        method: 'POST',
        data: {opcion: "loadUlt"},
        success: function (data) 
        {
            var lista = JSON.parse(data);
                    var valorAut = '';
                    var beneficiario = '';
                     $('#tblContent tbody').empty();

            if (lista.res == 'full') 
            {
                for(var i in lista.json)
                {


                    if (lista.json[i].col == null) 
                    {
                        beneficiario = lista.json[i].cli;
                    }
                    else
                    {
                        beneficiario = lista.json[i].col;
                    }


                    if (lista.json[i].val != null) 
                    {
                        valorAut = lista.json[i].val;
                    }
                    else
                    {
                        valorAut = 'PORCENTAJE:</b> '+lista.json[i].por + '%';
                    }

                    $('#tblContent tbody').append('<tr><th colspan="2" style="text-align: center;">Beauty Soft | Autorizaciones</th></tr><tr class="success"><th colspan="2" style="text-align: center;">Autorización #'+lista.json[i].cod+'</th></tr><tr><th>Tipo</th><td>'+lista.json[i].nom+'</td></tr><tr><td><b>Subtipo</b></td><td>'+lista.json[i].sub+'</td></tr><tr><th>Fecha</th><td>'+lista.json[i].fec+'</td></tr><tr><th>Salón</th><td>'+lista.json[i].sln+'</td></tr><tr><th>Valor</th><td>'+valorAut+'</td></tr><tr><th>Beneficiario</th><td>'+beneficiario+'</td></tr><tr><th>Por concepto de</th><td>'+lista.json[i].obs+'</td></tr><tr><th>Aprobado por</th><td>'+lista.json[i].usu+'</td></tr><tr><td colspan="2"><button class="btn btn-danger pull-right" id="btnAut" data-toggle="tooltip" data-placement="top" title="Se enviará un e-mail al salón anulando la autorización con el código #'+lista.json[i].cod+'" data-idaut="'+lista.json[i].cod+'"><i class="fa fa-minus-circle"></i></button><button class="btn btn-primary pull-right" id="btnReenvio" data-idaut="'+lista.json[i].cod+'" style="margin-right: 10px" data-toggle="tooltip" data-placement="top" title="Se reenviará la autorización a los implicados"><i class="fa fa-envelope-o" aria-hidden="true"></i> Reenviar Aut</button></td></tr>');
                }
            }
        } 
    });
}

/**
 *
 * BTN ANULAR
 *
 */

 $(document).on('click', '#btnAut', function() 
 {
     var idaut = $(this).data('idaut');

     swal({
           title: "¿Desea anular esta autorización?",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Anular",
           closeOnConfirm: false,
           cancelButtonText: "Cancelar"
        },
          function(){
		$(".confirm").attr('disabled', 'disabled');
                $.ajax({
                    url: '../php/auth/loads2.php',
                    method: 'POST',
                    data: {opcion: "anular",idaut:idaut},
                    success: function (data) 
                    {
			$(".confirm").removeAttr("disabled");
                        var aut = JSON.parse(data);
                        if (aut.res == '1') 
                        { 
                            swal("Anulado!", "Se ha anulado la autorización #"+ aut.codigo, "success");  
                            $('#contenido').empty(); 
                            fnLoadUlt ();
                            loadAuth ();           
                        }
                    }
                });
         });

 });



/*********************/


$(document).on('click', '#btnModalReporte', function() 
{
     window.location="reporteAut.php";
});


/*********************/

$(document).on('change', '#buscarTipo', function() 
{
    var tipo = $('#buscarTipo').val(); 

    $.ajax({
        type: "POST",
        url: "../php/auth/loads2.php",
        data: {opcion: 'searchtipo', tipo: tipo},
        success: function(data) {
            $('#notes').fadeIn(1000).html(data);
        }
    });   
});

$(document).ready(function() {
       $('#inputbuscar').keyup(function(){
            var username = $(this).val();        

            $.ajax({
                type: "POST",
                url: "../php/auth/loads2.php",
                data: {opcion: 'search', codigoBen: username},
                success: function(data) {
                    $('#notes').fadeIn(1000).html(data);
                }
            });
        });   
});



function paginar(id) 
{
    $.ajax({
        type: "POST",
        url: "../php/auth/loads2.php",
        data: {opcion: "search", page: id},
        success: function (data) 
        {
            $('#notes').fadeIn(1000).html(data);
        }
    
    });
}


/**
 *
 * Reportes
 *
 */

$(document).on('change', '#selTipoReporte', function() 
{
    if ($('#selTipoReporte').val() == '0' || $('#selTipoReporte').val() == '4') 
    {
        $('#selColaboradorReporte').prop('disabled', true);
    }
    else
    {
        $('#selColaboradorReporte').prop('disabled', false);
    }
});



$(document).on('click', '#btnReporte', function() 
{
    var fecha1 = $('#fechaUnoReporte').val(); 
    var fecha2 = $('#fechaDosReporte').val(); 
    var tipo   = $('#selTipoReporte').val(); 
    var sln    = $('#selSlnReporte').val();
    var col    = $('#selColaboradorReporte').val();
    var tipoU  = $('#selColaboradorReporte option:selected').data('tipo');

    //var datos = "opcion=reporte&fecha1="+fecha1+"&fecha2="+fecha2+"&tipo="+tipo+"&sln="+sln+"&col="+col;

    if (fecha1 == '') 
    {
        swal("Ingrese la fecha inicial", "Advertencia", "warning");
    }
    else if (fecha2 == '') 
    {
        swal("Ingrese la fecha final", "Advertencia", "warning");
    }
    else if (fecha2 < fecha1) 
    {
        swal("La fecha final es mayor que la fecha inicial", "Advertencia", "warning");
    }
    else
    {        
        tblReportes(fecha1,fecha2,tipo,sln,col, tipoU);
        //statistics(fecha1,fecha2,tipo,sln,col);
       
    }
});


var  tblReportes  = function() { 
    
    var tbl_rep = $('#tblReporte').DataTable({
    "ajax": {
      "method": "POST",
      "url": "../php/auth/loads2.php",
      "data": {opcion: "reporte", fecha1: $('#fechaUnoReporte').val(), fecha2:$('#fechaDosReporte').val(), tipo: $('#selTipoReporte').val(), sln: $('#selSlnReporte').val(), col: $('#selColaboradorReporte').val(), tipoU: $('#selColaboradorReporte option:selected').data('tipo') }
      },
      "columns":[
        {"data": "autcodigo"},
        {"data": "nombre"},
        {"data": "colaborador"},
        {"data": "cargo"},
        {"data": "autfecha_autorizacion"},
        {"data": "autoriza"},
        {"data": "autvalor"},
        {"data": "observacion"},
        {"data": "slnnombre"},
        {"data": "autestado_tramite",             
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                if (oData.autestado_tramite == 'RADICADO') 
                {
                    $(nTd).css({'background-color': '#5cb85c', 'color': '#fff', 'text-align': 'center'});
                    //$(oData).html('RADICADO');
                    //$('.estado').html('%');
                }
                else
                {
                     $(nTd).css({'background-color': '#d9534f', 'color': '#fff', 'text-align': 'center'});
                    //$(oData).html(oData.autvalor); 
                    //$('.valor').html('ANULADO');                             
                }
                
            }
        },
        /*{"defaultContent": "<button type='button' id='btn_ver_permiso' title='Click para ver los detalles' class='btn btn-link text-info'><i class='fa fa-search'></i></button><button type='button' id='btnDelete' title='Click para eliminar' class='btn btn-link text-danger' style='margin-left: 3px'><i class='fa fa-times'></i></button>"},*/
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar: ",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"idpermiso","targets":[0]},
              //{className:"valor","targets":[5]},
              {className:"estado","targets":[8]}
            ], 
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};


function statistics (fecha1,fecha2,tipo,sln,col) 
{
    $.ajax({
        url: '../php/auth/loads.php',
        method: 'POST',
        data: {opcion: "statistics", fecha1: fecha1, fecha2: fecha2, tipo: tipo, sln:sln, col:col},
        success: function (data) 
        {
            $('#statistics').empty();
            var jsonStatics = JSON.parse(data);

            if (jsonStatics.res == 'full') 
            {
                for(var i in jsonStatics.json)
                {
                    $('#statistics').append('<tbody><tr><th>Total</th><td>'+jsonStatics.tot+'</td></tr></tbody>');
                }
            }

        }
    });
}


$(document).on('click', '#btnExport', function() 
{
    var fecha1 = $('#fechaUnoReporte').val(); 
    var fecha2 = $('#fechaDosReporte').val(); 
    var tipo   = $('#selTipoReporte').val(); 
    var sln    = $('#selSlnReporte').val();
    var col    = $('#selColaboradorReporte').val();
    var tipoU  = $('#selColaboradorReporte option:selected').data('tipo');


    if (fecha1 == '') 
    {
        swal("No ha seleccionado fecha inicial", "Advertencia", "warning");
    }
    else if (fecha2 == '') 
    {
        swal("No ha seleccionado fecha final", "Advertencia", "warning");
    }
    else
    {
        window.open("exportarReporte.php?fecha1="+fecha1+"&fecha2="+fecha2+"&tipo="+tipo+"&sln="+sln+"&col="+col+"&tipoU="+tipoU+"", '_blank');
    }
});


$(document).on('click', '#btnBack', function() 
{

    window.location="author.php";
    
});


$(document).on('click', '#btnReenvio', function(event) 
{
     var idaut = $(this).data('idaut');

     swal({
           title: "¿Desea reenviar esta autorización?",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Reenviar",
           closeOnConfirm: false,
           cancelButtonText: "Cancelar"
        },
          function(){
                $.ajax({
                    url: '../php/auth/loads2.php',
                    method: 'POST',
                    data: {opcion: "reenviar",idaut:idaut},
                    success: function (data) 
                    {
                        var aut = JSON.parse(data);
                        if (aut.res == '1') 
                        { 
                            swal("Reenviado!", "Se ha reenviado la autorización #"+ aut.codigo, "success");  
                            $('#contenido').empty(); 
                            fnLoadUlt ();
                            loadAuth ();           
                        }
                        else
                        {
                             swal("Error!", "No se pudo enviar el e-mail por fallas en el servidor.", "error");
                        }
                    }
                });
         });
});

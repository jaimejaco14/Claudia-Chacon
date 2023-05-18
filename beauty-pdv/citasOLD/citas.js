/*=============================
=            CITAS            =
=============================*/


$(document).ready(function() 
{



	$(document).prop('title', 'Citas | Beauty SOFT - ERP'); 

	
    /*$('.selectpicker').selectpicker({
        liveSearch: true,
        showSubtext: true
    });*/

    $('#selectServicio').selectpicker({
        liveSearch: true,
        showSubtext: true,
        width: '100%'
    });

});


$('#selectClienteCitas').on('show.bs.select', function (e) 
{
    $('.bs-searchbox').addClass('newCliente');
    $('.newCliente .form-control').attr('id', 'newCliente');
});

var selectCliente  = $("#selectClienteCitas");

$(document).on('keyup', '#newCliente', function(event) 
{
    
	var cliente = $(this).val();
	$.ajax({
		url: 'clientesAgendamiento.php',
		type: 'POST',
		data: "datoCliente="+cliente,

		success: function(data)
        {

			var json = JSON.parse(data);
			if(json.result == "full")

				var clientes = "";

				for(var datos in json.data)
                {

					clientes += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombreCliente+" ("+json.data[datos].documento+")</option>";
				}

				//selectCliente.html(clientes);
                selectCliente.selectpicker('refresh');
		}
	});	
});


$('#selectServicio').on('show.bs.select', function (e) 
{
    $('.bs-searchbox').addClass('newServicio');
    $('.newServicio .form-control').attr('id', 'newServicio');
});

var selectServicio  = $("#selectServicio");

$(document).on('keyup', '#newServicio', function(event) 
{
    var servicio = $(this).val();
    $.ajax({
        url: 'php/citas/loads.php',
        type: 'POST',
        data: {datoServicio: servicio, opcion: "loadServicios"},

        success: function(data){

            var json = JSON.parse(data);

            if(json.res == "full")
        

                var servicios = "";

                for(var i in json.json){

                    servicios += "<option value='"+json.json[i].idservicio+"'>"+json.json[i].servicio+" ("+json.json[i].duracion+")</option>";
                }

                selectServicio.html(servicios);
                selectServicio.selectpicker('refresh');
        }
    }); 
});




$(document).on('change', '#selectClienteCitas', function() 
{
    var cliente = $('#selectClienteCitas').val();

    $.ajax({
        url: 'php/citas/validarEmailCli.php',
        method: 'POST',
        data: {cliente: cliente},
        success: function (data) 
        {
            var jsonValidar = JSON.parse(data);

            if(jsonValidar.res == "incompleto")
            {               

                $('#codCliente').val(jsonValidar.codigo);
                $('#docCliente').val(jsonValidar.doc);
                $('#emailEditCli').val(jsonValidar.email);
                $('#movilEditCli').val(jsonValidar.movil);            
                $('#modalEditarCliente').modal("show");
            }            
            
        }
    });
});

 $(function ()
 {
    var info = $('.info');
    $('#email').mailtip({
      onselected: function (mail){
      }
    });
});


/******************************/


$(document).on('click', '#btnGuardarEdicion', function() 
{
    var codCli = $('#codCliente').val();
    var docCli = $('#docCliente').val();
    var emailC = $('#emailEditCli').val();
    var movilC = $('#movilEditCli').val(); 

     var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;



    if (emailC == "") 
    {
        swal("Ingrese el e-mail", "", "warning");
    }
    else
    {
        if (!regex.test($('#emailEditCli').val().trim())) 
        {
            swal("Ingrese un e-mail válido", "", "warning");
        }
        else
        {
            if (movilC == "") 
            {
               swal("Ingrese el número del móvil", "", "warning"); 
            }
            else
            {
                $.ajax({
                    url: 'php/citas/edicionCliente.php',
                    method: 'POST',
                    data: {codCli: codCli, doc:docCli, email:emailC, movil:movilC},
                    success: function (data) 
                    {
                        if (data == 1) 
                        {
                            swal("Modificación Exitosa", "", "success");
                            $('#modalEditarCliente').modal("hide");
                        }
                    }
                });
            }
        }
    }
});




/******************************/

	$('#datapicker2').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");
	$('#datapicker3').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");

    $("#datepicker").on("changeDate", function(event) 
    {
        $("#my_hidden_input").val(
                $("#datepicker").datepicker('getFormattedDate')
        )
        dateFormat: "yy-mm-dd"
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
    startDate: '-0d',
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fecha').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#hora').focus();

});





/******************************/


$(document).on('click', '.nextStep', function() 
{
    if ($('#selectMedios').val() == 0 || $('#selectClienteCitas').val() == 0 || $('#selectServicio').val() == 0) 
    {
        swal("Faltan campos por llenar.", "", "warning");
    }
    else
    {

        $.ajax({
            url: 'php/citas/validarEmailCli.php',
            method: 'POST',
            data: {cliente: $('#selectClienteCitas').val(), doc: $('#docCli').val()},
            success: function (data) 
            {
               var jsonCliente = JSON.parse(data);

               if (jsonCliente.res == "incompleto")
               {
                   for(var i in jsonCliente.res)
                   {
                        $('#emailEditCli').val(jsonCliente.email);
                        $('#movilEditCli').val(jsonCliente.movil);            
                        $('#modalEditarCliente').modal("show");
                    }
               }
               else
               {
                  $('#step1').removeClass('active');
                  $('#step2').addClass('active');
                  $('.paso_1').removeClass('btn-primary');
                  $('.paso_1').addClass('btn-default');
                  $('.paso_2').removeClass('btn-default disabled');
                  $('.paso_2').addClass('btn-primary');
                }
            }
        });
    }   
    
});

/***************************************/


$('.paso_1').click(function() 
{
    $('.paso_2').addClass('btn-default');
    $('.paso_1').removeClass('btn-default');
    $('.paso_1').addClass('btn-primary');
});

$('.paso_2').click(function() 
{
    $('.paso_1').addClass('btn-default');
    $('.paso_2').removeClass('btn-default');
    $('.paso_2').addClass('btn-primary');
});




/*************************************/


$(document).on('blur', '#hora', function() 
{
    var salon      = $('#cod_salon').val();
    var servicio   = $('#selectServicio').val();
    var fecha      = $('#fecha').val();
    var hora       = $('#hora').val();

    $.ajax({
        url: 'php/citas/process.php',
        method: 'POST',
        data: {opcion: "validarServicio", salon:salon, servicio:servicio, fecha:fecha, hora:hora},
        success: function (data) 
        {
            
            $("#selectColaborador").html("");
            $('#selectColaborador').html(data);
        }
    });
});


/*************************************/








/**
 *
 * DIGITO VERIFICADOR
 *
 */


 $(document).on('blur', '#nroDoc', function() 
 {
     var documento = $('#nroDoc').val();

    $.ajax({
        url: 'citasNewCliente.php',
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



$(document).on('blur', '#nroDoc', function() 
{
    var doc = $('#nroDoc').val();

    $.ajax({
        url: 'citasNewCliente.php',
        method: 'POST',
        data: {opcion: "validarDoc", doc:doc},
        success: function (data) 
        {

            var datajson = JSON.parse(data);

            if (datajson.res == "full") 
            {

                for(var i in datajson.json)
                {
                    swal("El cliente ya se encuentra registrado. Agende su cita.", "", "success");
                    $('#modalNuevoCliente').modal("hide");
                    $('#nroDoc').val('');
                    $('#modalNuevoCliente').modal("hide");
                    $('#containerCli').empty();
                    $('.containerCli').css('display', 'block');
                    $('#docCli').val(doc);
                    $('#nomCli').css('display', 'block');
                    $('#nomCli').val(datajson.json[i].nombre + ' ('+ doc +')');
                    $('#nomCli').attr('disabled', true);

                }
            }
            else
            {
                if (datajson.res == 2) 
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


$(document).ready(function() 
{
    
    $('#modalNuevoCliente').on('hide.bs.modal', function () 
    {
         $('#docReadonly').val('').hide();
         $('#nroDoc').val('').attr('readonly', false);
         $('#nombres').val('').attr('readonly', false);
         $('#apellidos').val('').attr('readonly', false);
         $('#email').val('');
         $('#movil').val('');
         $('#mesReadonly').hide();
         $('#diaReadonly').hide();
         $('#tipodoc').show();
         $('#dia').show();
         $('#mes').show();
         $('.btnNext2').removeAttr('disabled').removeClass('disabled');
         $('#tipodoc').show();

    });
});






function validar(obj) 
{
    num=obj.value.charAt(0);
    if(num!='3') 
    {       
        alert('El móvil debe empezar por 3');
        obj.focus();
    }
}

$(document).on('click', '.btnNext2', function() 
{

    var regex = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
    var tipodoc     = $('#tipodoc').val();
    var doc         = $('#nroDoc').val();
    var digitov     = $('#btnDv').html();
    var nombres     = $('#nombres').val();
    var apellidos   = $('#apellidos').val();
    var sexo        = $('#txtSexo').val();
    var ocupacion   = $('#tipoocupacion').val();
    //var dia         = $('#dia').val();
    //var mes         = $('#mes').val();
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
    var tiposangre  = $('#txtTipoS').val();
    var txtFechaN   = $('#txtFechaN').val();
    var salon       = $("#slncod").val();
    var usuario        = $("#usucod").val();

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

    


    if (txtFechaN == "") 
    {
        var anio = '1900'; 
        var dia  = $('#dia').val();
        var mes  = $('#mes').val();
    }
    else
    {
        var anio = txtFechaN.substring(0, 4);
        var mes  = txtFechaN.substring(5, 7);
        var dia  = txtFechaN.substring(8, 10);
        console.log(dia + "//" + mes);
    }
    


    if (tipodoc == 0) 
    {
        swal("Seleccione el tipo de documento", "", "warning");
    }
    else
    {
        if (doc == "") 
        {
            swal("Digite documento de identidad", "", "warning");
        }
        else
        {
            if (nombres == "") 
            {
                swal("Digite nombres", "", "warning");
            }
            else
            {
                if (apellidos == "") 
                {
                    swal("Digite apellidos", "", "warning");
                }
                else
                {

                    if (email == "") 
                    {
                        swal("Digite correo electrónico", "", "warning");
                    }
                    else
                    {
                            if (!regex.test($('#email').val().trim())) 
                            {
                                 swal("Ingrese un e-mail válido", "", "warning");
                            }
                            else
                            {

                                if (movil.charAt(0) != 3) 
                                {               
                                    $.notify('El móvil debe empezar por 3');        
                                }
                                else
                                {
                                
                                    $.ajax({
                                        url: 'citasNewCliente.php',
                                        method: 'POST',
                                        data: {opcion: "newCli", 
                                        tipodoc:tipodoc, 
                                        doc:doc, 
                                        digitov:digitov, 
                                        nombres:nombres, 
                                        apellidos:apellidos, 
                                        sexo:sexo, 
                                        ocupacion:ocupacion, 
                                        dia:dia, 
                                        mes:mes, 
                                        anio:anio, 
                                        depto:depto, 
                                        ciudad:ciudad, 
                                        barrio:barrio, 
                                        direccion:direccion, 
                                        movil:movil, 
                                        fijo:fijo, 
                                        email:email, 
                                        extranjero:extranjero, 
                                        nm:nm, 
                                        ne:ne, 
                                        tiposangre:tiposangre,
                                        salon:salon,
                                        user:usuario},
                                        success: function (data) 
                                        {

                                             var jsonTer = JSON.parse(data);

                                            if (jsonTer.res == '1') 
                                            {
                                                swal("Registro Correcto", "", "success");
                                                $('#modalNuevoCliente').modal("hide");
                                                //$('#clienteCed').empty();
                                                $('.containerSel').remove();
                                                //$('#clienteCed').css('display', 'block');
                                                //$('#clienteCed').val(nombres + " " + apellidos + " ("+doc+")");
                                                $('#IdclienteCed').val(doc);
                                               
                                            }
                                            else
                                            {                                               
                                                swal("El usuario se ha actualizado", "", "success");
                                                $('#modalNuevoCliente').modal("hide");
                                                $('#containerCli').empty();
                                                $('.containerCli').css('display', 'block');
                                                $('#docCli').val(doc);
                                                $('.containerSel').remove();
                                                //$('#clienteCed').css('display', 'block');
                                                //$('#clienteCed').val(nombres + " " + apellidos + " ("+doc+")");
                                                $('#IdclienteCed').val(doc);
                                                $('#nomCli').attr('disabled', true);
                                            }
                                        }
                                        
                                    }); 
                                }
                            }                                                      
                            
                    }                
                      
                }                 
                   
                
            }
        }
    }


});

$("#modalNuevoCliente").on("hidden.bs.modal", function () { 
$('#nroDoc').val('');
$('#dataCapture').val('');
$('#nombres').val('');
$('#nombres').val('');
$('#email').val('');
$('#movil').val('');
$('#apellidos').val('');
$('#nombres').removeAttr('readonly');
$('#apellidos').removeAttr('readonly');
$('#nroDoc').removeAttr('readonly');
$('#txtFechaN').val('');
$('#txtTipoS').val('');
$('#txtSexo').val('');
$('#fijo').val('');

$('#mesReadonly').css("display", "none");
$('#mesReadonly').removeAttr('readonly');


$('#diaReadonly').css("display", "none");
$('#diaReadonly').removeAttr('readonly');


$('#docReadonly').css("display", "none");
$('#docReadonly').removeAttr('readonly');   


$('#mes').css("display", "block");
$('#dia').css("display", "block");
$('#tipodoc').css("display", "block");

$('#mes option:contains("SELECCIONE MES")').prop('selected',true);
$('#dia option:contains("SELECCIONE DÍA")').prop('selected',true);
$('#btnDv').html('<i class="fa fa-check"></i>');
});

/*=====================================
=            NUEVO CLIENTE            =
=====================================*/


/*******************************/


$(document).on('click', '#btnBarcode', function() 
{
    $('#dataCapture').focus();
    $('#spin').show();
    $('#nroDoc').val('');
    $('#dataCapture').val('');
    $('#nombres').val('');
    $('#nombres').val('');
    $('#email').val('');
    $('#movil').val('');
    $('#apellidos').val('');
    $('#nombres').removeAttr('readonly');
    $('#apellidos').removeAttr('readonly');
    $('#nroDoc').removeAttr('readonly');
    $('#txtFechaN').val('');
    $('#txtTipoS').val('');
    $('#txtSexo').val('');

    $('#mesReadonly').css("display", "none");
    $('#mesReadonly').removeAttr('readonly');


    $('#diaReadonly').css("display", "none");
    $('#diaReadonly').removeAttr('readonly');


    $('#docReadonly').css("display", "none");
    $('#docReadonly').removeAttr('readonly');   


    $('#mes').css("display", "block");
    $('#dia').css("display", "block");
    $('#tipodoc').css("display", "block");

    $('#mes option:contains("SELECCIONE MES")').prop('selected',true);
    $('#dia option:contains("SELECCIONE DÍA")').prop('selected',true);
});


$(document).on('blur', '#dataCapture', function() 
{
    $('#spin').removeClass('fa-spin');
    $('#spin').hide();
});




$('#modalNuevoCliente').on('shown.bs.modal', function () {
    $('#dataCapture').focus();
}); 


$(document).on('keydown','#dataCapture',function (e) {
var code = (e.which);
    if(code===13)
    {
        var meses = ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

        var str = $('#dataCapture').val();

        var co=0;
        var j=0;
        var c=str.length;


        for(i=0;i<c;i++)
        {
            j=i+1;
            if(str.substring(i,j)=='@')
            {
                co++;
            }
        }

    

        if (co != 8 || co != '8') 
        {
           swal("Para leer el documento haga click sobre el icono de código de barras. ", "", "warning");    
        }
        else
        {
            
        



            var rese = str.split("@");

            var doc = parseInt(rese[1]);
            var anio = rese[7].substring(0, 4);
            var mes  = rese[7].substring(4, 6);
            var dia  = rese[7].substring(6, 8);
            var cumple = anio + "-"+ mes + "-" + dia;

            $('#nroDoc').val(doc);
            $('#nroDoc').attr('readonly', true);
            $('#nombres').val(rese[4].trim() + " " + rese[5].trim());
            $('#nombres').attr('readonly', true);
            $('#apellidos').val(rese[2].trim() + " " + rese[3].trim());
            $('#apellidos').attr('readonly', true);
            $('#txtSexo').val(rese[6].trim());
            $('#txtTipoS').val(rese[8].trim());
            $('#txtFechaN').val(cumple);

            if (rese[0] == 'CC') 
            {
                $('#docReadonly').val(rese[0]);
            }


            $('#mesReadonly').css("display", "block");
            $('#mesReadonly').attr('readonly', true);


            $('#diaReadonly').css("display", "block");
            $('#diaReadonly').attr('readonly', true);


            $('#docReadonly').css("display", "block");
            $('#docReadonly').attr('readonly', true);   


            $('#mes').css("display", "none");
            $('#dia').css("display", "none");
            $('#tipodoc').css("display", "none");


            $('#diaReadonly').val(dia);


            for (var i = 0; i <= meses.length; i++) 
            {
                  
                if (i == mes) 
                {
                    $('#mesReadonly').val(meses[i-1]);           
                }
                  
            }


            $('#email').focus();
            $('#txtAlertEmail').css("display", "block");
            $('#txtAlertMovil').css("display", "block");

   }

}
});                                                       


  

/*=====  End of CITAS  ======*/


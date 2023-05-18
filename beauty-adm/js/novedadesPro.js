/*==================================
=            NOVEDADES            =
==================================*/

$(document).ready(function() {
  $(document).prop('title', 'Novedades | Beauty SOFT - ERP');
  $('[data-toggle="tooltip"]').tooltip();	
});

/**
 *
 * CALENDARIO
 *
 */
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

$('#fecha').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#fecha_hasta').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});



$('#fechaHasta').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#txtFechaEdit').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#txtFechaIni').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});


$('#txtFechaFin').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});


$('#fechaI').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#fechaF').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});

$('#txtFechaHastaEdit').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});


$('#txtFechaEdit').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});

$('#txtFechaHastaEdit').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});




$('#fecha').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fechaHasta').focus();

});


$('#fechaHasta').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});

$('.input-group.date').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fecha_hasta').focus();

});

$('#fecha_hasta').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});

$('#txtFechaIni').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#txtFechaFin').focus();

});

//fn

$('#txtFechaFin').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#tblProgCol').show();
    funcionProgramacion () ;

});


$('#fechaI').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fechaF').focus();

});

$('#fechaF').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

});






function funcionProgramacion () 
{
    var col = $('#selectClienteCitas').val()
    var f1  = $('#txtFechaIni').val();
    var f2  = $('#txtFechaFin').val();

    $.ajax({
        url: 'novedades/funcionProgramacion.php',
        method: 'POST',
        data: {opcion: "fnProg", col: col, f1:f1, f2:f2},
        success: function (data) 
        {
            var jsonPro = JSON.parse(data);
            $('#tblProgCol tbody').empty();
            if (jsonPro.res == "full") 
            {
                for(var i in jsonPro.json)
                {
                    $('#tblProgCol tbody').append('<tr><td>'+jsonPro.json[i].fecha+'</td><td>'+jsonPro.json[i].turno+  " DE " + jsonPro.json[i].horario+'</td><td>'+jsonPro.json[i].tipo+'</td><td>'+jsonPro.json[i].salon+'</td><td><center><button type="button" class="btn btn-info btn-xs" data-clbcodigo="'+ jsonPro.json[i].clbcodigo+'" data-fecha="'+ jsonPro.json[i].fecha+'" id="btnVerNovedad" data-toggle="tooltip" data-placement="top" title="Ver Novedades del día"><i class="fa fa-search"></i></button></center></td></tr>');
                }
                    $('[data-toggle="tooltip"]').tooltip();
            }
            else
            {
                $('#tblProgCol tbody').append('<tr><td colspan="4"><center><b>NO HAY PROGRAMACIÓN EXISTENTE</b></center></td></tr>');
            }
        }
    });
}




/**
 *
 * RELOJ
 *
 */


$('.clockpicker').clockpicker({autoclose: true});
$('.clockpickerHD').clockpicker({autoclose: true});
$('.clockpickerHA').clockpicker({autoclose: true});


/**
 *
 * PROCESO
 *
 */

$(document).on('change', '#selectSalon', function() 
{
	//$('#selectTipo').focus();
    //$('#selectTipo').first().focus();
    $("#selectTipo:first").focus();
});

$(document).on('change', '#selectTipo', function() 
{
    $('#fecha_de').focus();
});

$(document).on('blur', '#hora_de', function() 
{
 	 $('#hora_hasta').focus();
});

$(document).on('click', '#allday', function() 
{
        if ($('#selectSalon').val() == "0" ) 
        {
            swal("Seleccione Salón", "", "warning");
            return false;
        }
        else
        {
            if ($('#selectTipo').val() == "0") 
            {
                swal("Seleccione Tipo de Novedad", "", "warning");
                return false;
            }
        }

});
$(document).on('change', '#allday', function() 
{
    if( $(this).is(':checked')) 
    {
       
        $('#hora_de').attr("disabled", true).val("00:00");
        $('#hora_hasta').attr("disabled", true).val("23:59");
        $('#fecha_de').attr("disabled", true); 
        $('#selectSalon').attr('disabled', 'disabled');
        $('#selectTipo').attr('disabled', 'disabled');
        $('#fecha_hasta').attr("disabled", true);        
        


    } 
    else 
    {
        $('#hora_de').attr("disabled", false).val("00:00");
        $('#hora_hasta').attr("disabled", false).val("00:00");
        $('#fecha_de').attr("disabled", false); 
        $('#selectSalon').removeAttr('disabled');
        $('#selectTipo').removeAttr('disabled');
        $('#fecha_hasta').attr("disabled", false); 
           
    }
});

$(document).on('change', '#alldayedit', function() 
{
    if( $(this).is(':checked')) 
    {
        $('#hora_deEdit').attr("disabled", true).val("00:00");
        $('#hora_hastaEdit').attr("disabled", true).val("23:59");
    }
    else
    {
        $('#hora_deEdit').attr("disabled", false).val("00:00");
        $('#hora_hastaEdit').attr("disabled", false).val("00:00");
    }

});


$(document).on('blur', '#fecha_hasta', function() 
{
    var fechades       =  $('#fecha_de').val();
    var fechahas       =  $('#fecha_hasta').val();

    if (fechades  < fechahas) 
    {
        swal("La fecha desde es mayor que la fecha final.", "Intente de nuevo", "warning");
        $('#fecha_hasta').select();
    }

});





$(document).on('blur', '#hora_hasta', function() 
{
    var horade       =  $('#hora_de').val();
    var horahasta    =  $('#hora_hasta').val();

    if (horahasta < horade) 
    {
        swal("La hora desde es mayor que la hora final.", "Intente de nuevo", "warning");
        $('#hora_hasta').focus();
    }

});


$(document).on('blur', '#hora_hastaEdit', function() 
{
    var horade       =  $('#hora_deEdit').val();
    var horahasta    =  $('#hora_hastaEdit').val();

    if (horahasta < horade) 
    {
        swal("La hora desde es mayor que la hora final.", "Intente de nuevo", "warning");
        $('#hora_hastaEdit').focus();
    }

});






/**********************************/

$(document).on('change', '#selectSalonBus', function() 
{
    $('#fecha').focus();
});


//$('#fecha').on('changeDate');

function fnTabla () {
    $('#tblBusqueda tbody').empty();
    if ($('#selectSalonBus').val() == 0) 
    {
        swal("Seleccione Salón", "Advertencia", "warning");
    }
    else
    {
        $.ajax({
            url: 'novedadesProcess.php',
            method: 'POST',
            data: {salon: $('#selectSalonBus').val(), fecha: $('#fecha').val(), fechaHasta: $('#fechaHasta').val(), opcion: "buscar"},
            success: function (data) 
            {
                var jsonBuscar = JSON.parse(data);

                if (jsonBuscar.res == "full") 
                {
                    $('#tblBusqueda tbody').empty();
                    for(var i in jsonBuscar.json)
                    {
                        $('#tblBusqueda').append('<tr><td style="text-align: right">'+jsonBuscar.json[i].codnovedad+'</td><td>'+jsonBuscar.json[i].novedad+'</td><td>'+jsonBuscar.json[i].fechareg+'</td><td>'+jsonBuscar.json[i].fecha+'</td><td>'+jsonBuscar.json[i].fechah+'</td><td>'+jsonBuscar.json[i].rango+'</td><td>'+jsonBuscar.json[i].observac+'</td><td>'+jsonBuscar.json[i].salon+'</td><td>'+jsonBuscar.json[i].usuadmin+'</td><td><center><button class="btn btn-xs btn-info" onclick="fnVerNov('+jsonBuscar.json[i].codnovedad+')"  title="VER NOVEDAD"><i class="fa fa-search"></i></button><button style="margin-left: 5px" class="btn btn-xs btn-danger" onclick="fnEliminarNov('+jsonBuscar.json[i].codnovedad+')"  title="CANCELAR NOVEDAD"><i class="fa fa-times"></i></button><button style="margin-left: 5px" class="btn btn-xs btn-warning" id="btnEditar" data-id="'+jsonBuscar.json[i].codnovedad+'" title="EDITAR NOVEDAD"><i class="fa fa-edit"></i></button></center></td></tr>');
                    }
                }
                else
                {
                     $('#tblBusqueda').append('<tr><td colspan="9"><center><b>NO HAY NOVEDADES SEGÚN LA FECHA</b></center></td></tr>');
                }
            }
        });
    }
}


$('#fechaHasta').on('changeDate', function ()
{
    fnTabla ();
});

/**
 *
 * ELIMINAR
 *
 */

 /*function fnEliminarNov (idnovedad) 
 {
     $.ajax({
            url: 'eliminarNovedad.php',
            method: 'POST',
            data: {idnovedad:idnovedad},
            success: function (data) 
            {
                if (data == 1) 
                {
                    swal("Se ha eliminado la novedad", "", "success");
                }
            }
     });
 }*/


 function fnEliminarNov (idnovedad) 
 {
    swal({
        title: "¿Seguro que desea eliminar novedad?",
        type: "warning",
        showCancelButton:  true,
        cancelButtonText:"No",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí"  
        },function () 
        {
            $.ajax({
                type: "POST",
                url: 'eliminarNovedad.php',
                data: {idnovedad:idnovedad},
                success: function (data) 
                {                
                    if (data == 1) 
                    {
                        fnTabla ();
                        swal("Se ha eliminado la novedad", "", "success");
                    }                
                }

            });
        });
}


/***************************/






/**
 *
 * BOTON BUSCAR
 *
 */


$(document).on('click', '#btnSearch', function() 
{

    var salon  = $('#selectSalon').val();
    var fecha  = $('#fecha_de').val();
    var fechah = $('#fecha_hasta').val();
    var horad  = $('#hora_de').val();
    var horah  = $('#hora_hasta').val();
    var obser  = $('#observaciones').val();
    var tipo   = $('#selectTipo').val();
    
    if (salon == 0) 
    {
    	swal("Seleccione el salón", "", "warning");
    }
    else
    {

        if (tipo == 0) 
        {
            swal("Seleccione el tipo de novedad.", "Advertencia", "warning");
        }
        else
        {
                if (fecha == "") 
                {
                     swal("Ingrese la fecha inicial", "Advertencia", "warning");
                }
                else
                {

                    if (fechah == "") 
                    {
                        swal("Ingrese la fecha final", "", "warning");
                    }
                    else
                    {
                        if (horad == '00:00' && horah == '00:00') 
                        {
                            swal("Seleccione la hora de la novedad.", "Advertencia", "warning");
                        }
                        else
                        {
                            if (fecha > fechah) 
                            {
                                swal("La fecha desde es mayor que la fecha final.", "Intente de nuevo", "warning");
                                //$('#fecha_hasta').focus();
                            }
                            else
                            {

                                $.ajax({
                                    url: 'novedadesProcess.php',
                                    method: 'POST',
                                    data: {salon:salon, fecha:fecha, fechah:fechah, horad:horad, horah:horah,opcion: "colaboradores"},
                                    success: function (data) 
                                    {
                                        //alert(data);
                                        var jsonCol = JSON.parse(data);
                                        $('#tblColab tbody').empty();

                                        if (jsonCol.res == "full") 
                                        {
                                            $('#modalColabordores').modal("show");
                                            for(var i in jsonCol.json)
                                            {

                                                $('[data-toggle="tooltip"]').tooltip();
                                               if (jsonCol.json[i].nombre2 == jsonCol.json[i].nombre)
                                                {
                                                    $('#tblColab').append('<tr class="active"><td data-toggle="tooltip" data-placement="top" title="'+jsonCol.json[i].tipopro+'" data-container="body" class="excluir">'+jsonCol.json[i].nombre+'</td><td data-toggle="tooltip" data-placement="top" title="'+jsonCol.json[i].tipopro+'" data-container="body">'+jsonCol.json[i].cargo+'</td><td class="but"><center><button data-toggle="tooltip" data-placement="top" title="'+jsonCol.json[i].tipopro+'" disabled class="btn btn-danger btn-xs" id="btnAdd" data-id="'+jsonCol.json[i].id+'" data-nombre="'+jsonCol.json[i].nombre+'" data-cargo="'+jsonCol.json[i].cargo+'" data-fecha="'+fecha+'"><i class="fa fa-minus"></i></button></center></td></tr>');
                                                        //$('.check').prop('disabled', true);
                                                }
                                                else
                                                {
                                                  $('#tblColab').append('<tr><td>'+jsonCol.json[i].nombre+'</td><td>'+jsonCol.json[i].cargo+'</td><td class="but"><center><button title="Añadir colaborador a la tabla" class="btn btn-info btn-xs" id="btnAdd" data-id="'+jsonCol.json[i].id+'" data-nombre="'+jsonCol.json[i].nombre+'" data-cargo="'+jsonCol.json[i].cargo+'" data-fecha="'+fecha+'"><i class="fa fa-plus"></i></button></center></td></tr>');                              
                                                }
                                            }
                                        }
                                        else
                                        {
                                           swal("No se encontraron colaboradores en el rango", "Advertencia", "error");
                                        }
                                    }
                                }); 
                            }
                        }
                    }
                	
                }
        }
    }
});



$(document).on('click', '.check', function(event) 
{

    var salon = $('#selectSalon').val();
    var fecha = $('#fecha_de').val();
    var fechah = $('#fecha_hasta').val();
    var horad = $('#hora_de').val();
    var horah = $('#hora_hasta').val();
    var obser = $('#observaciones').val();

        $.ajax({
            url: 'novedadesProcess.php',
            method: 'POST',
            data: {salon:salon, fecha:fecha, horad:horad, fechah:fechah,  horah:horah, opcion: "colaboradores"},
            success: function (data) 
            {
                var jsonCol = JSON.parse(data);
              $('#tblColabAdd tbody').empty();

                if (jsonCol.res == "full") 
                {
                    $('#modalColabordores').modal("hide");
                    for(var i in jsonCol.json)
                    {


                                if (jsonCol.json[i].nombre2 != jsonCol.json[i].nombre) 
                                {                                    
                                       
                                    $('#tblColabAdd').append('<tr><td>'+jsonCol.json[i].id+'</td><td>'+jsonCol.json[i].nombre+'</td><td>'+jsonCol.json[i].cargo+'</td><td class="but"><center><button title="Remover colaborador a la tabla" class="btn btn-danger btn-xs" id="btnRem" ><i class="fa fa-minus"></i></button></center></td></tr>');                              
                                }
                                


                    }
                }
                else
                {
                   swal("No se encontraron colaboradores en el rango", "Advertencia", "error");
                }
            }
        }); 
        
});



$(document).on('click', '#btnAdd', function() 
{
    var codClb = $(this).data("id");
    var nombre = $(this).data('nombre');
    var cargo  = $(this).data('cargo');
    var fecha  = $(this).data('fecha');

    var i = 0;

    $(this).closest('tr').remove();

    $("#tblColabAdd tr").each(function(index)
    {
        var cod = $(this).find(".cod").eq(0).html();

        if (cod == codClb) 
        {
           i++;           
            swal("Ya se ha añadido este colaborador", "", "warning");        
        }                     
        
    }); 
    if(i==0)
    {
        $('#tblColabAdd').append('<tr><td class="cod '+codClb+'">'+codClb+'</td><td>'+nombre+'</td><td>'+cargo+'</td><td><center><button style="margin-left: 5px" class="btn btn-xs btn-danger" id="removCol"  title="REMOVER COLABORADOR"><i class="fa fa-times"></i></button></center></td></tr>'); 

    }
});


$(document).on('click', '#btdAddEdit', function() 
{
	var codClb = $(this).data("id");
    var nombre = $(this).data('nombre');
    var cargo  = $(this).data('cargo');
    var fecha  = $(this).data('fecha');

    var i = 0;

    $(this).closest('tr').remove();

    $("#tblEdit tr").each(function(index)
    {
        var cod = $(this).find(".cod").eq(0).html();

        if (cod == codClb) 
        {
           i++;           
            swal("Ya se ha añadido este colaborador", "", "warning");        
        }                     
        
    }); 
    if(i==0)
    {
        $('#tblEdit').append('<tr><td>'+codClb+'</td><td>'+nombre+'</td><td>'+cargo+'</td><td><center><button class="btn btn-xs btn-danger" id="removCol"><i class="fa fa-minus"></i></button></center></td></tr>'); 

    }
});

/************************************************************/


$(document).on('click', '#btnAddNov', function(event) 
{
        var observaciones   = $('#observaciones').val();
        var tipo            = $('#selectTipo').val();
        var fecha           = $('#fecha_de').val();
        var fechah          = $('#fecha_hasta').val();
        var horad           = $('#hora_de').val();
        var horah           = $('#hora_hasta').val(); 
        var salon           = $('#selectSalon').val();


        var tbody = $("#tblColabAdd tbody");

            if (tbody.children().length == 0) 
            {
                swal("Añada los colaboradores para gestionar la novedad", "", "warning");
            }
            else
            {
                var itemDetalle = [];
                $('#tblColabAdd tbody tr').each(function()
                {
                    var itemCom = {};
                    var tds = $(this).find("td");
                      itemCom.codCol        = tds.filter(":eq(0)").text();
                      itemDetalle.push(itemCom);
                });


                var art = {};

                art.itemDetalle = itemDetalle;

                var datos = JSON.stringify(itemDetalle); 

                $.ajax({
                      url : 'proccessNovedad.php',
                      type: 'post',
                      data:  {datos:datos, fecha:fecha, fechah:fechah, horad:horad, horah:horah, salon:salon, tipo:tipo, obser:observaciones},  
                        success: function(data)
                        {
                           var jsonRes = JSON.parse(data);

                            if (jsonRes.res == "ok") 
                            {
                                $('#selectSalon option:contains("SELECCIONE SALÓN")').prop('selected',true);
                                $('#selectTipo option:contains("SELECCIONE TIPO")').prop('selected',true);
                                $('#observaciones').val('');
                                $('#tblColabAdd tbody').empty();
                                $('#allday').removeAttr("disabled").prop('checked', false);;
                                $('#hora_de').attr("disabled", false).val("00:00");
                                $('#hora_hasta').attr("disabled", false).val("00:00");
                                $('#fecha_de').attr("disabled", false).val('0000-00-00');
                                $('#fecha_hasta').attr("disabled", false).val('0000-00-00'); 
                                $('#selectSalon').attr('disabled', false);
                                $('#selectTipo').attr('disabled', false);
                                swal("Se ha ingresado la novedad con el consecutivo \n N° " + jsonRes.consecutivo, "", "success");
                            }
                        }
                });
                
            }
});


/**
 *
 * REMOVER COLABORADOR
 *
 */

$(document).on('click', '#btnRemoverCol', function() 
{
    $(this).closest('tr').remove();
});


$(document).on('click', '#removCol', function() 
{
    $(this).closest('tr').remove();
});

$(document).on('click', '#btnRem', function() 
{
    $(this).closest('tr').remove();
});

$(document).on('click', '#btnRemoverEdit', function() 
{
    $(this).closest('tr').remove();
});





/**
 *
 * VER DETALLES NOVEDADES
 *
 */

 function fnVerNov (codNovedad) 
 {
    $('.buscar').removeClass('active');
    $('.panelDet').css('display', 'block');
    $('.panelDet').addClass('active');
    $('#VerNovedad').addClass('active');
    $('#tab-2').removeClass('active');
    $.ajax({
        url: 'novedadesProcess.php',
        method: 'POST',
        data: {novedad: codNovedad, opcion: "vernovedad"},
        success: function (data) 
        {
           var  jsonVerNov = JSON.parse(data);

           if (jsonVerNov.res == "full") 
           {    
                $('#tblDetallesNov tbody').empty();
                for(var i in jsonVerNov.json)
                {
                    $('#tblDetallesNov').append('<tr title="'+jsonVerNov.json[i].colaborador+'"><td>'+jsonVerNov.json[i].colaborador+'</td><td>'+jsonVerNov.json[i].cargo+'</td></tr>');
                    $('#usu').val(jsonVerNov.json[i].usuadmin);
                    $('#regis').html(jsonVerNov.json[i].usuadmin);
                    $('#lblnovedad').html("NOVEDAD N° " + jsonVerNov.json[i].codnovedad);
                    $('#txtFecha').val(jsonVerNov.json[i].fecha);
                    $('#txtFechaHasta').val(jsonVerNov.json[i].fechah);                    
                    $('#idNovedad').val(jsonVerNov.json[i].codnovedad);
                    $('#txtRango').val(jsonVerNov.json[i].rango);
                    $('#txtTipoNovedad').val(jsonVerNov.json[i].tipo);
                    $('#txtObser').val(jsonVerNov.json[i].observac);
                    $('#txtSalon').val(jsonVerNov.json[i].salon);
                    $('#txtUsuario').val("POR " + jsonVerNov.json[i].usuadmin + " EL " + jsonVerNov.json[i].fechareg + " A LAS " + jsonVerNov.json[i].horareg);


                }
           } 
        }
    });
 }


/**
 *
 * EDITAR NOVEDAD
 *
 */

$(document).on('click', '#btnEditar', function() 
{

    $('.buscar').removeClass('active');
    $('.panelEdit').css('display', 'block');
    $('.panelEdit').addClass('active');
    $('#tab-2').removeClass('active').css("display", "none");
    $('#EditarNov').addClass('active');

    var codnovedad = $(this).data("id");

    $.ajax({
        url: 'novedadesProcess.php',
        method: 'POST',
        data: {novedad: codnovedad, opcion: "editar"},
        success: function (data) 
        {
            
            var jsonEditar = JSON.parse(data);

            if (jsonEditar.res == "full") 
            {
                 $('#tblEdit tbody').empty();
                for(var i in jsonEditar.json)
                {
                    $('#lblnovedadEdit').html("NOVEDAD N° " + jsonEditar.json[i].idnovedad);
                    $('#txtidnovedad').val(jsonEditar.json[i].idnovedad);
                    $('#txtFechaEdit').val(jsonEditar.json[i].fecha);
                    $('#txtFechaHastaEdit').val(jsonEditar.json[i].fechaH);
                    $('#oldfecha').val(jsonEditar.json[i].fecha);
                    $('#txtTiponov').val(jsonEditar.json[i].tipo);
                    $('#txtSalonEdit').val(jsonEditar.json[i].salon);
                    $('#txtObserEdit').val(jsonEditar.json[i].observac);
                    $('#txtcodsalon').val(jsonEditar.json[i].codsalon);
                    $('#hora_deEdit').val(jsonEditar.json[i].desde);
                    $('#olddesde').val(jsonEditar.json[i].desde);
                    $('#hora_hastaEdit').val(jsonEditar.json[i].hasta);
                    $('#oldhasta').val(jsonEditar.json[i].hasta);
                    $('#oldtipo').val(jsonEditar.json[i].idtiponovedad);
                    $('#txtUsuarioEdit').val("POR " + jsonEditar.json[i].usuario + " EL " + jsonEditar.json[i].fechareg + " A LAS " + jsonEditar.json[i].horareg);
                    $('#tblEdit').append('<tr><td>'+jsonEditar.json[i].idcol+'</td><td>'+jsonEditar.json[i].colaborador+'</td><td>'+jsonEditar.json[i].cargo+'</td><td><center><button class="btn btn-danger btn-xs" id="btnRemoverEdit"><i class="fa fa-minus"></i></button></center></td></tr>');

                }
                $('#selTipo').empty();
                for(var j in jsonEditar.tipo)
                {      
                    $('#selTipo').append('<option value="'+jsonEditar.tipo[j].cod+'" selected>'+jsonEditar.tipo[j].nom+'</option>');
                }
            }
            //var $('#lblnovedadEdit').html("NOVEDAD N° " + jsonVerNov.json[i].codnovedad);  
        }
    });
});

$(document).on('click', '#btnEdit', function() 
{
   $('#txtTiponov').css("display", "none");
   $('#btnEdit').css("display", "none");
   $('#selTipo').css("display", "block");
});


$(document).on('click', '#btnEditSalon', function() 
{
   $('#txtSalon').css("display", "none");
   $('#btnEditSalon').css("display", "none");
   $('#selSalonEdit').css("display", "block");
   $('#txtSalonEdit').css("display", "none");
});


$(document).on('click', '#btnAddCola', function() 
{

    if ($('#hora_deEdit').val() == "00:00" && $('#hora_hastaEdit').val() == "00:00") 
    {
        swal("Seleccione el rango", "", "warning");
    }
    else
    {


            $.ajax({
                url: 'novedadesProcess.php',
                method: 'POST',
                data: {opcion: "colaboradores", salon: $('#txtcodsalon').val(), fecha: $('#txtFechaEdit').val(), fechah: $('#txtFechaHastaEdit').val(), horad: $('#hora_deEdit').val(), horah: $('#hora_hastaEdit').val()},
                success: function (data) 
                {
                   var jsonCol = JSON.parse(data);
                    $('#tblColabEdit tbody').empty();
                    $('#modalColabordoresEdit').modal("show");//btnAdd

                        if (jsonCol.res == "full") 
                        {
                             
                            for(var i in jsonCol.json)
                            {

                               if (jsonCol.json[i].nombre2 == jsonCol.json[i].nombre) 
                                {
                                    $('#tblColabEdit').append('<tr class="active"><td title="Este colaborador ya cuenta con una novedad dentro del rango de horas asignado." class="excluir">'+jsonCol.json[i].nombre+'</td><td title="Este colaborador ya cuenta con una novedad dentro del rango de horas asignado.">'+jsonCol.json[i].cargo+'</td><td class="but"><center><button title="Este colaborador ya cuenta con una novedad dentro del rango de horas asignado." disabled class="btn btn-danger btn-xs" id="btdAddEdit" data-id="'+jsonCol.json[i].id+'" data-nombre="'+jsonCol.json[i].nombre+'" data-cargo="'+jsonCol.json[i].cargo+'" data-fecha="'+fecha+'"><i class="fa fa-minus"></i></button></center></td></tr>');
                                        //$('.check').prop('disabled', true);
                                }
                                else
                                {
                                  $('#tblColabEdit').append('<tr><td>'+jsonCol.json[i].nombre+'</td><td>'+jsonCol.json[i].cargo+'</td><td class="but"><center><button title="Añadir colaborador a la tabla" class="btn btn-info btn-xs" id="btdAddEdit" data-id="'+jsonCol.json[i].id+'" data-nombre="'+jsonCol.json[i].nombre+'" data-cargo="'+jsonCol.json[i].cargo+'" data-fecha="'+fecha+'"><i class="fa fa-plus"></i></button></center></td></tr>');                              
                                }
                            }
                        }
                        else
                        {
                           swal("No se encontraron colaboradores en el rango", "Advertencia", "error");
                        }
                }
            });
        }

});

/**
 *
 * MODIFICAR
 *
 */

$(document).on('click', '#btdModificar', function() 
{

        var observaciones   = $('#txtObserEdit').val();
        var oldtipo         = $('#oldtipo').val();
        var newtipo         = $('#selTipo').val();
        var oldfecha        = $('#oldfecha').val();
        var newfecha        = $('#txtFechaEdit').val();

        var oldfechah       = $('#oldfechahasta').val();
        var newfechah       = $('#txtFechaHastaEdit').val();


        var olddesde        = $('#olddesde').val();
        var horad           = $('#hora_deEdit').val();
        var oldhasta        = $('#oldhasta').val();
        var horah           = $('#hora_hastaEdit').val();
        var oldsalon        = $('#txtcodsalon').val(); 
        var salon           = $('#selectSalon').val();
        var idnovedad       = $('#txtidnovedad').val();
        var tbody           = $("#tblEdit tbody");


           if (tbody.children().length == 0) 
            {
                swal("Añada los colaboradores para gestionar la novedad", "", "warning");
            }
            else
            {
                var itemDetalle = [];
                $('#tblEdit tbody tr').each(function()
                {
                    var itemCom = {};
                    var tds = $(this).find("td");
                      itemCom.codCol = tds.filter(":eq(0)").text();
                      itemDetalle.push(itemCom);
                });


                var art = {};

                art.itemDetalle = itemDetalle;

                var datos = JSON.stringify(itemDetalle); 

                console.log(datos);

                $.ajax({
                      url : 'proccessNovedadEdit.php',
                      method: 'post',
                      data:  {datos:datos, horad:horad, horah:horah, oldhasta:oldhasta, oldsalon:oldsalon, salon:salon, olddesde:olddesde, newfecha:newfecha, oldfecha:oldfecha, oldfechah:oldfechah, newfechah:newfechah, oldtipo:oldtipo, newtipo:newtipo, obser:observaciones, idnovedad:idnovedad},  
                        success: function(data)
                        {
                           var jsonRes = JSON.parse(data);

                            if (jsonRes.res == "ok") 
                            {                                
                                swal("Se ha modificado la novedad", "", "success");

                                $('.panelEdit').removeClass('active').css("display", "none");
                                $('#EditarNov').removeClass('active').empty();
                                $('.buscar').addClass('active');
                                $('#tab-2').addClass('active').css("display", "block");
                                location.reload();
                            }
                        }
                });
                
            }
});


/**
 *
 * CANCELAR EDICION
 *
 */


 $(document).on('click', '#btnCancelar', function() 
 {
    $('#EditarNov').removeClass('active'); 
    $('.panelEdit').removeClass('active');
    $('.buscar').addClass('active');
    $('#tab-2').addClass('active');
 });


/**
 *
 * REPORTE PDF
 *
 */


$("#btnReportePdf").on("click", function(){

    window.open("./generarReporteNovedades.php?idnovedad="+$('#idNovedad').val()+" ");
});


/**
 *
 * REMOVER TODOS
 *
 */

 $(document).on('click', '#btnRemoveAll', function() 
{
    $("#tblColabAdd tbody").empty();
});

$(document).on('click', '#btnRemoveAllEdit', function() 
{
    $("#tblEdit tbody").empty();
});


 /**
  *
  * NOVEDADESINDIVIDUALES
  *
  */

$('#selectClienteCitas').on('show.bs.select', function (e) {
    $('.bs-searchbox').addClass('col');
    $('.col .form-control').attr('id', 'col');
});

var selectCliente  = $("#selectClienteCitas");
 
$(document).on('keyup', '#col', function(event) 
{
    
    var colaborador = $(this).val();
    $.ajax({
        url: 'novedades/cargarColaborador.php',
        type: 'POST',
        data: "colaborador="+colaborador,

        success: function(data){

            var json = JSON.parse(data);

            if(json.result == "full")
            //{

                var colaborador = "";

                for(var datos in json.data){

                    colaborador += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombre+"</option>";
                }

                selectCliente.html(colaborador);
                selectCliente.selectpicker('refresh');
            //}
            //else{

                //selectCliente.val("");
            //}
        }
    }); 
});


$("#btnCheck").on( 'change', function() {
    if( $(this).is(':checked') ) 
    {
        //$('#fechaI').attr('disabled', true);
        //$('#fechaF').attr('disabled', true);
        $('#horaDesde').val('00:00:00');
        $('#horaHasta').val('23:59:00');
        $('#horaDesde').attr('disabled', true);
        $('#horaHasta').attr('disabled', true);
    } 
    else 
    {
        //$('#fechaI').attr('disabled', false);
        //$('#fechaF').attr('disabled', false);
        $('#horaDesde').attr('disabled', false);
        $('#horaHasta').attr('disabled', false);   
    }
});


$(document).on('change', '#fechaF', function() 
{
        if ($('#fechaF').val() <  $('#fechaI').val() ) 
        {
            swal("La fecha fin es menor que la inicial", "", "warning"); 
        }
});



$(document).on('click', '.grp', function(event) 
{
   $('.panelDet').hide();
   $('#tblBusqueda tbody').empty();
   $('#fecha').val('');
   $('#fechaHasta').val('');
   $('#selectSalonBus').prop('selectedIndex',0);
});

$(document).on('click', '.buscar', function(event) 
{
   $('.panelDet').hide();
   $('#tblBusqueda tbody').empty();
   $('#fecha').val('');
   $('#fechaHasta').val('');
   $('#selectSalonBus').prop('selectedIndex',0);
});




$(document).on('change', '#horaHasta', function() 
{
    if ($('#horaHasta').val() <  $('#horaDesde').val() ) 
    {
        swal("La hora fin es menor que la inicial", "", "warning"); 
    }
});

$(document).on('click', '#btnGuardarNov', function() 
{
    var col = $('#selectClienteCitas').val();
    var fi  = $('#fechaI').val();
    var ff  = $('#fechaF').val();
    var hd  = $('#horaDesde').val();
    var hh  = $('#horaHasta').val();
    var tn  = $('#selectTipoNovedad').val();
    var sl  = $('#selectSalonNov').val(); 
    var obs = $('#observacionNov').val(); 

    if (col == '0') 
    {
        swal("Seleccione el colaborador", "", "warning");
    }
    else if (fi == "") 
    {
        swal("Seleccione la fecha inicial", "", "warning");
    }
    else if (ff == "") 
    {
        swal("Seleccione la fecha final", "", "warning");
    }
    else if (tn == '0') 
    {
        swal("Seleccione el tipo de novedad", "", "warning");
    }
    else if (hd == "") 
    {
        swal("Seleccione la hora desde", "", "warning");    
    }
    else if (hh == "") 
    {
        swal("Seleccione la fecha final", "", "warning");
    }
    else if (sl == '0') 
    {
        swal("Seleccione el salón", "", "warning");    
    }
    else if (obs == '') 
    {
        swal("Ingrese la observación", "", "warning");    
    }
    else if ($('#fechaF').val() <  $('#fechaI').val()) 
    {
         swal("La fecha fin es menor que la inicial", "", "warning");    
    }
    else if ($('#horaHasta').val() <  $('#horaDesde').val()) 
    {
        swal("La hora fin es menor que la inicial", "", "warning");  
    }
    else
    {
        $.ajax({
            url: 'novedadesProcess.php',
            method: 'POST',
            data: {opcion: "individual", col:col, fecha:fi, fechah:ff, horad:hd, horah:hh, tipo: tn, obs:obs, salon:sl},
            success: function (data) 
            {
                //alert(data);
                var t = JSON.parse(data);
                if (t.res == '1') 
                {
                    $('#observacionNov').val('');
                    $('#fechaI').val('');
                    $('#fechaF').val('');
                    $('#horaDesde').val('');
                    $('#horaHasta').val('');
                    $('#txtFechaIni').val('');
                    $('#txtFechaFin').val('');                    
                    $('#selectTipoNovedad').prop('selectedIndex',0);
                    $('#selectSalonNov').prop('selectedIndex',0);
                    $('#selectClienteCitas').val(null).trigger('change');
                    $('#tblProgCol tbody').empty();
                    $('#tblProgCol').hide();
                    $('#horaDesde').attr('disabled', false);
                    $('#horaHasta').attr('disabled', false);
                    swal("Ingreso correcto", "","success");

                }
                else
                {
                    swal("Ya tiene una novedad en el rango de fecha y hora solicitados", "","warning");
                }
            }
        });
    }
});



$(document).on('click', '#btnVerNovedad', function() 
{
    $('#modalNovedades').modal("show");

    var fecha     = $(this).data("fecha");
    var clbcodigo = $(this).data("clbcodigo");

    $.ajax({
        url: 'novedades/funcionProgramacion.php',
        method: 'POST',
        data: {fecha: fecha, clbcodigo:clbcodigo, opcion: "verNovedad"},
        success: function (data) 
        {
            var jsonNovedad = JSON.parse(data);
            $('#tblNovedad tbody').empty();
            if (jsonNovedad.res == "full") 
            {
                for(var i in jsonNovedad.json)
                {
                    $('#tblNovedad tbody').append('<tr><td>'+jsonNovedad.json[i].novedad+'</td><td>'+jsonNovedad.json[i].desde+'</td><td>'+jsonNovedad.json[i].hasta+'</td></tr>');
                    $('#tituloNov').html('<i class="fa fa-search"></i> NOVEDADES DEL DÍA ' + jsonNovedad.json[i].fecha);
                }
            }
            else
            {
                $('#tblNovedad tbody').append('<tr><td colspan="3"><center><b>NO HAY NOVEDADES</b></center></td></tr>');
            }
        }
    });
});

/*=====  End of NOVEDADES  ======*/


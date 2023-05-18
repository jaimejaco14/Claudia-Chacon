
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
        noneSelectedText: '',
        title:'Buscar beneficiario...'
});

$('#selColaboradorReporte').selectpicker({
        liveSearch: true,
        showSubtext: true,
        width: '100%',
        noneSelectedText: ''
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




$('#selColaborador').on('show.bs.select', function (e) 
{
    $('.bs-searchbox').addClass('newServicio');
    $('.newServicio .form-control').attr('id', 'newServicio');
});

var selColaborador  = $("#selColaborador");

$(document).on('keyup', '#newServicio', function(event) 
{
    var colaborador = $(this).val();
    $.ajax({
        url: '../php/auth/loads.php',
        type: 'POST',
        data: {datoColaborador: colaborador, opcion: "loadColaborador"},

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
});


$("#valor").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {
            return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{3})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
        });
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
    $('#selSalon option:contains("SELECCIONE")').prop('selected',true);
    $('#selTipo option:contains("SELECCIONE")').prop('selected',true);
    $('#valor').val('');
    $('#observacion').val('');
    $('#txtbeneficiario').val(''); 
    $('#fecha').val('');
});




function loadAuth () 
{
    $.ajax({
        url: '../php/auth/loads.php',
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

                    if (lista.json[i].cli == null) 
                    {
                        beneficiario = lista.json[i].col;
                    }
                    else
                    {
                        beneficiario = lista.json[i].cli;
                    }

                    $('#notes').append('<div class="panel-body note-link"><a href="javascript:(void)" onclick="fnLoadAut('+lista.json[i].cod+')" data-toggle="tab"><small class="pull-right text-muted">'+lista.json[i].fec+'</small><h5>#'+lista.json[i].cod+'</h5><div class="small">'+lista.json[i].nom + ' <b>[' + beneficiario +']</b></div></a></div>');

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
        url: '../php/auth/loads.php',
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
                        valorAut = lista.json[i].por + '%';
                    }

                    $('#tblContent tbody').append('<tr><th colspan="2" style="text-align: center;">Beauty Soft | Autorizaciones</th></tr><tr class="success"><th colspan="2" style="text-align: center;">Autorización #'+lista.json[i].cod+'</th></tr><tr><th>Tipo</th><td>'+lista.json[i].nom+'</td></tr><tr><th>Fecha</th><td>'+lista.json[i].fec+'</td></tr><tr><th>Salón</th><td>'+lista.json[i].sln+'</td></tr><tr><th>Valor</th><td>'+valorAut+'</td></tr><tr><th>Beneficiario</th><td>'+beneficiario+'</td></tr><tr><th>Por concepto de</th><td>'+lista.json[i].obs+'</td></tr><tr><th>Aprobado por</th><td>'+lista.json[i].usu+'</td></tr><tr><td colspan="2"><button class="btn btn-danger pull-right" id="btnAut" data-toggle="tooltip" data-placement="top" title="Se enviará un e-mail al salón anulando la autorización con el código #'+lista.json[i].cod+'" data-idaut="'+lista.json[i].cod+'"><i class="fa fa-minus-circle"></i></button></td></tr>');
                    $('[data-toggle="tooltip"]').tooltip();
                }
            }
        } 
    });
}


function fnLoadUlt () 
{

    $.ajax({
        url: '../php/auth/loads.php',
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

                    $('#tblContent tbody').append('<tr><th colspan="2" style="text-align: center;">Beauty Soft | Autorizaciones</th></tr><tr class="success"><th colspan="2" style="text-align: center;">Autorización #'+lista.json[i].cod+'</th></tr><tr><th>Tipo</th><td>'+lista.json[i].nom+'</td></tr><tr><th>Fecha</th><td>'+lista.json[i].fec+'</td></tr><tr><th>Salón</th><td>'+lista.json[i].sln+'</td></tr><tr><th>Valor</th><td>'+valorAut+'</td></tr><tr><th>Beneficiario</th><td>'+beneficiario+'</td></tr><tr><th>Por concepto de</th><td>'+lista.json[i].obs+'</td></tr><tr><th>Aprobado por</th><td>'+lista.json[i].usu+'</td></tr><tr><td colspan="2"><button class="btn btn-danger pull-right" id="btnAut" data-toggle="tooltip" data-placement="top" title="Se enviará un e-mail al salón anulando la autorización con el código #'+lista.json[i].cod+'" data-idaut="'+lista.json[i].cod+'"><i class="fa fa-minus-circle"></i></button></td></tr>');
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
                $.ajax({
                    url: '../php/auth/loads.php',
                    method: 'POST',
                    data: {opcion: "anular",idaut:idaut},
                    success: function (data) 
                    {
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
        url: "../php/auth/loads.php",
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
                url: "../php/auth/loads.php",
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
        url: "../php/auth/loads.php",
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

/*$(document).on('click', '#btnReporte', function() 
{
    var fecha1 = $('#fechaUnoReporte').val(); 
    var fecha2 = $('#fechaDosReporte').val(); 
    var tipo   = $('#selTipoReporte').val(); 
    var sln    = $('#selSlnReporte').val();
    var col    = $('#selColaboradorReporte').val();

    var datos = "opcion=reporte&fecha1="+fecha1+"&fecha2="+fecha2+"&tipo="+tipo+"&sln="+sln+"&col="+col;

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
        $.ajax({
            url: '../php/auth/loads.php',
            method: 'POST',
            data: datos,
            success: function (data) 
            {
                var jsonReporte = JSON.parse(data);
                $('#tblReporte tbody').empty();

                if (jsonReporte.res == 'full') 
                {
                    for(var i in jsonReporte.json)
                    {
                        $('#tblReporte tbody').append('<tr><td>'+jsonReporte.json[i].ben+'</td><td>'+jsonReporte.json[i].crg+'</td><td>'+jsonReporte.json[i].nom+'</td><td>'+jsonReporte.json[i].por+'</td><td>'+jsonReporte.json[i].sln+'</td><td>'+jsonReporte.conteo+'</td></tr>');
                    }
                }
                else
                {
                    $('#tblReporte tbody').append('<tr><td>No hay datos</td></tr>');
                }
            }
        });
    }
});*/


$(document).on('click', '#btnReporte', function() 
{
    var fecha1 = $('#fechaUnoReporte').val(); 
    var fecha2 = $('#fechaDosReporte').val(); 
    var tipo   = $('#selTipoReporte').val(); 
    var sln    = $('#selSlnReporte').val();
    var col    = $('#selColaboradorReporte').val();

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
        tblReportes(fecha1,fecha2,tipo,sln,col);
        //statistics(fecha1,fecha2,tipo,sln,col);
       
    }
});


var  tblReportes  = function() { 
   var tbl_rep = $('#tblReporte').DataTable({
    "ajax": {
      "method": "POST",
      "url": "../php/auth/loads.php",
      "data": {opcion: "reporte", fecha1: $('#fechaUnoReporte').val(), fecha2:$('#fechaDosReporte').val(), tipo: $('#selTipoReporte').val(), sln: $('#selSlnReporte').val(), col: $('#selColaboradorReporte').val()}
      },
      "columns":[
        {"data": "autcodigo"},
        {"data": "beneficiario",             
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                if (oData.beneficiario == null) 
                {
                    $(nTd).html(oData.cliente);
                }
                else
                {

                    $(nTd).html(oData.beneficiario);                              
                }
                
            }
        },
        {"data": "crgnombre"},
        {"data": "autfecha_autorizacion"},
        {"data": "usuarioaprueba"},
        {"data": "autvalor",             
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                if (oData.autvalor == null) 
                {
                    $(nTd).html(oData.autporcentaje);
                    $('.valor').html('%');
                }
                else
                {

                    $(nTd).html(oData.autvalor); 
                    $('.valor').html('$');                             
                }
                
            }
        },
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
              {className:"valor","targets":[5]},
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
        window.open("exportarReporte.php?fecha1="+fecha1+"&fecha2="+fecha2+"&tipo="+tipo+"&sln="+sln+"&col="+col+"", '_blank');
    }
});
/*================================
=            REPORTES            =
================================*/

$(document).ready(function() {
    //$("#selCargo").select2({placeholder:"Todos los cargos"});
    $('#selCargo').selectpicker();
    $('#selColaborador').selectpicker({title: "Seleccione Colaborador"});
    
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

$('#fechaDesde').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaHasta').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});


$(document).on('change', '#selTipo', function() 
{
    $('#fechaDesde').attr("disabled", false);
});



$('#fechaDesde').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fechaHasta').attr("disabled", false);
    $('#fechaHasta').focus();

});

$('#fechaHasta').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

    if ($('#selTipo').val() == 0) 
    {
        swal("Seleccione el tipo de reporte", "", "warning");
    }
    else
    {
        if ($('#fechaHasta').val() < $('#fechaDesde').val()) 
        {
            swal("Corrobore las fechas.", "", "warning"); 
        }
        else
        {
             $('#selCargo').attr("disabled", false);
             selCargos (1);
        }
    }

});

$('#selCargo').on('changed.bs.select', function () 
{
        var desde = $('#fechaDesde').val();
        var hasta = $('#fechaHasta').val();
        if ($('#selCargo').val() == 0) 
        {
            $('#chkTodos').attr("checked", true);
        }
        else
        {
               var cargo = $('#selCargo').val();
               $('#selColaborador').prop('disabled', false);
               $('#selColaborador').selectpicker('refresh');  
            
        }

       selColaborador (cargo, desde, hasta);      
});


/**
 *
 * BOTON FILTRO
 *
 */


$(document).on('click', '#btnFiltrar', function() 
{
        if( $('#chkTodos').is(':checked') ) 
        {
            var todos = 1;
        }
        else
        {
            todos = 0;
        }


        var col = $('#selColaborador').val();

        if ($('#fechaDesde').val() == "") 
        {
            swal("Seleccione la fecha inicial", "", "warning");
        }
        else
        {
            if ($('#fechaHasta').val() == "") 
            {
                swal("Seleccione la fecha final", "", "warning");
            }
            else
            {
                
                if ($('#fechaHasta').val() < $('#fechaDesde').val()) 
                {
                    swal("Corrobore las fechas.", "", "warning"); 
                }
                else
                {
                    var itemDetalle = [];
                    $("#selColaborador option").each(function()
                    {
                         var itemCom = {};
                         itemCom.codigo = $(this).val();
                         itemDetalle.push(itemCom);
                    });


                    var datos = JSON.stringify(itemDetalle); 


                     $.ajax({
                        url: 'php/reporte/process.php',
                        method: 'POST',
                        data: {opcion: "reporteAgenda", desde: $('#fechaDesde').val(), hasta: $('#fechaHasta').val(), cargos: $('#selCargo').val(), colaborador: datos, todos:todos,col: col},
                        success: function (data) 
                        {
                            var jsonCitas = JSON.parse(data);
                            $('#tblListado tbody').empty();
                            for(var i in jsonCitas.json)
                            {
                                if (jsonCitas.json[i].nombre != null) 
                                {
                                    $('#tblListado tbody').append('<tr><td>'+jsonCitas.json[i].nombre+'</td><td>'+jsonCitas.json[i].cargo+'</td><td>'+jsonCitas.json[i].agendaFuncio+'</td><td>'+jsonCitas.json[i].agendaClie+'</td><td>'+jsonCitas.json[i].canceladas+'</td><td>'+jsonCitas.json[i].atendidas+'</td><td>'+jsonCitas.json[i].inasistencias+'</td><td>'+jsonCitas.json[i].reprogramadas+'</td><td><center><button class="btn btn-info btn-xs" id="btnVerDetalles" data-clbcodigo="'+jsonCitas.json[i].clbcodigo+'" data-desde="'+jsonCitas.json[i].desde+'" data-hasta="'+jsonCitas.json[i].hasta+'"><i class="fa fa-search"></i></button></center></td></tr>');

                                    $('#nm').html(" REPORTE COMPRENDIDO ENTRE " + jsonCitas.json[i].desde + " Y " + jsonCitas.json[i].hasta);
                                }
                            }
                        }
                     });               
                }

            }
        }
        
 });


 function selCargos (tipo) 
 {
    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "selCargos", tipo: tipo},
        success: function (data) 
        {
            $('#selCargo').html(data);
            $('#selCargo').selectpicker('refresh');
        }
    });
 }


 function selColaborador (tipoCol, desde, hasta) 
 {
    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "selCol", tipo: tipoCol, desde:desde, hasta:hasta},
        success: function (data) 
        {
            $('#selColaborador').html(data);
            $('#selColaborador').selectpicker('refresh');
        }
    });
 }




$('#selColaborador').on('show.bs.select', function (e) {
    $('.bs-searchbox').addClass('colaborador');
    $('.colaborador .form-control').attr('id', 'colaborador');
});

var selectCliente  = $("#selColaborador");

$(document).on('keyup', '#colaborador', function(event) 
{
    
    var colaborador = $(this).val();
    $.ajax({
        url: 'php/reporte/process.php',
        type: 'POST',
        data: {opcion: "colaborador", colaborador:colaborador},

        success: function(data){

            var json = JSON.parse(data);

            if(json.result == "full")
            //{

                var clientes = "";

                for(var datos in json.data){

                    clientes += "<option value='"+json.data[datos].codigo+"'>"+json.data[datos].nombreCol+"</option>";
                }

                selectCliente.html(clientes);
                selectCliente.selectpicker('refresh');
            //}
            //else{

                //selectCliente.val("");
            //}
        }
    }); 
});


$(document).on('click', '#btnVerDetalles', function() 
{
    var clbcodigo = $(this).data("clbcodigo");
    var desde     = $(this).data("desde");
    var hasta     = $(this).data("hasta");


    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "detalles", clbcodigo:clbcodigo, desde: desde, hasta:hasta},
         beforeSend:function(request) {
                  $.blockUI({ css: {
                     border: 'none',
                     padding: '15px',
                     backgroundColor: '#000',
                       '-webkit-border-radius': '10px',
                       '-moz-border-radius': '10px',
                     opacity: .5,
                     color: '#fff',

                  },
                  message: 'Procesando...'});
},
        success: function (data) 
        {
            $('#modalDetalles').modal("show");
            var jsonDetalles = JSON.parse(data);
            $('#tblListadoDetalles tbody').empty();
            var estado; var usunovedad;
            if (jsonDetalles.res == "full") 
            {
                for(var i in jsonDetalles.json)
                {
                    switch (jsonDetalles.json[i].estado) 
                    {
                        case 'CANCELADA':
                            estado = '<td style="background-color: #f36345; color: #fff">'+jsonDetalles.json[i].estado+'</td>';
                            usunovedad = jsonDetalles.json[i].usuNovedad;
                            break;

                        case 'ATENDIDA':
                            estado = '<td style="background-color: #81ef68; color: #222">'+jsonDetalles.json[i].estado+'</td>';
                            usunovedad = jsonDetalles.json[i].usuNovedad;
                            break;

                        case 'INASISTENCIA':
                            estado = '<td style="background-color: #a368ef; color: #eee"">'+jsonDetalles.json[i].estado+'</td>';
                            usunovedad = jsonDetalles.json[i].usuNovedad;
                            break;

                        case 'REPROGRAMADA':
                            estado = '<td style="background-color: #bcf6f1; color: #333"">'+jsonDetalles.json[i].estado+'</td>';
                             usunovedad = jsonDetalles.json[i].usuNovedad;
                            break;

                        case 'AGENDADA POR FUNCIONARIO':
                            estado = '<td>NO SE GESTIONÓ</td>';
                            usunovedad = '';
                            break;
                        default:
                            // statements_def
                            break;
                    }

                   /* if (jsonDetalles.json[i].usuNovedad == 'AGENDADA POR FUNCIONARIO') 
                    {
                        usunovedad = '';
                    }
                    else
                    {
                        usunovedad = jsonDetalles.json[i].usuNovedad;
                    }*/

                    $('#tblListadoDetalles tbody').append('<tr><td>'+jsonDetalles.json[i].sernombre+'</td><td>'+jsonDetalles.json[i].cliente+'</td><td>'+jsonDetalles.json[i].usuario+'</td><td>'+jsonDetalles.json[i].citfecha+'</td><td>'+jsonDetalles.json[i].cithora+'</td><td>'+jsonDetalles.json[i].fechaReg+'</td><td>'+jsonDetalles.json[i].horaReg+'</td>'+estado+'<td>'+usunovedad+'</td></tr>');
                    $('#nombreP').html("<i class='fa fa-user'></i> DETALLE DE CITAS " + jsonDetalles.json[i].colaborador);
                }
            }
             $.unblockUI();
        }
    });
});



/*=====  End of REPORTES  ======*/




/*=============================================
=            REPORTE DE BIOMETRICO            =
=============================================*/

$(document).ready(function() 
{
    $('#selCargoBio').selectpicker();
    $('#selColaboradorBio').selectpicker({title: "Seleccione Colaborador"});
    
});


var date  = new Date();
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

$('#fechaDesdeBio').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});

$('#fechaHastaBio').datepicker({ 
    format: "yyyy-mm-dd",
    setDate: "today",
    language: 'es',
});


$(document).on('change', '#selTipo', function() 
{
    $('#fechaDesdeBio').attr("disabled", false);
});



$('#fechaDesdeBio').on('changeDate', function(ev)
{
    $(this).datepicker('hide');
    $('#fechaHastaBio').attr("disabled", false);
    $('#fechaHastaBio').focus();

});

$('#fechaHastaBio').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

    if ($('#selTipoBio').val() == 0) 
    {
        swal("Seleccione el tipo de reporte", "", "warning");
    }
    else
    {
        if ($('#fechaHastaBio').val() < $('#fechaDesdeBio').val()) 
        {
            swal("Corrobore las fechas.", "", "warning"); 
        }
        else
        {
             $('#selCargoBio').attr("disabled", false);
             //selCargosBio ();
        }
    }

});

$('#selCargoBio').on('changed.bs.select', function () 
{
        var desde = $('#fechaDesdeBio').val();
        var hasta = $('#fechaHastaBio').val();
        if ($('#selCargoBio').val() == 0) 
        {
            $('#chkTodos').attr("checked", true);
        }
        else
        {
               var cargo = $('#selCargoBio').val();
               $('#selColaboradorBio').prop('disabled', false);
               $('#selColaboradorBio').selectpicker('refresh');  
            
        }

       selColaboradorBio (cargo, desde, hasta);      
});


$(document).on('change', '#selTipo', function() 
{
    $('#fechaDesde').attr("disabled", false);
});



$('#fechaHastaBio').on('changeDate', function(ev)
{
    $(this).datepicker('hide');

    
        if ($('#fechaHastaBio').val() < $('#fechaDesdeBio').val()) 
        {
            swal("Corrobore las fechas.", "", "warning"); 
        }
        else
        {
             $('#selCargoBio').attr("disabled", false);
             $('#selCargoBio').selectpicker('refresh');
             //selCargosBio();
        }

});



$('#selCargo').on('changed.bs.select', function () 
{
        var cargo = $('#selCargoBio').val();
        var desde = $('#fechaDesdeBio').val();
        var hasta = $('#fechaHastaBio').val();
        if ($('#selCargo').val() == 0) 
        {
            $('#chkTodos').attr("checked", true);
        }
        else
        {
               $('#selColaboradorBio').prop('disabled', false);
               $('#selColaboradorBio').selectpicker('refresh');  
            
        }

       selColaboradorBio (cargo, desde, hasta);      
});

/*function selCargosBio () 
 {
    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "selCargosBio"},
        success: function (data) 
        {
            $('#selCargoBio').html(data);
            $('#selCargoBio').selectpicker('refresh');
        }
    });
 }*/


 function selColaboradorBio (cargo, desde, hasta) 
 {
    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "selColBio", cargo: cargo, desde:desde, hasta:hasta},
        success: function (data) 
        {
            $('#selColaboradorBio').html(data);
            $('#selColaboradorBio').selectpicker('refresh');
        }
    });
 }



$(document).on('click', '#btnFiltrarBio', function() 
{
        if( $('#chkTodosBio').is(':checked') ) 
        {
            var todos = 1;
        }
        else
        {
            todos = 0;
        }


        var col = $('#selColaboradorBio').val();

        if ($('#fechaDesdeBio').val() == "") 
        {
            swal("Seleccione la fecha inicial", "", "warning");
        }
        else
        {
            if ($('#fechaHastaBio').val() == "") 
            {
                swal("Seleccione la fecha final", "", "warning");
            }
            else
            {
                
                if ($('#fechaHastaBio').val() < $('#fechaDesdeBio').val()) 
                {
                    swal("Corrobore las fechas.", "", "warning"); 
                }
                else
                {
                    var itemDetalle = [];
                    $("#selColaboradorBio option").each(function()
                    {
                         var itemCom = {};
                         itemCom.codigo = $(this).val();
                         itemDetalle.push(itemCom);
                    });


                    var datos = JSON.stringify(itemDetalle); 


                     $.ajax({
                        url: 'php/reporte/process.php',
                        method: 'POST',
                        data: {opcion: "reporteBiometrico", desde: $('#fechaDesdeBio').val(), hasta: $('#fechaHastaBio').val(), cargos: $('#selCargoBio').val(), colaborador: datos, col:col},
                        success: function (data) 
                        {
                            var jsonCitas = JSON.parse(data);
                            $('#tblListadoBio tbody').empty();
                            for(var i in jsonCitas.json)
                            {
                                if (jsonCitas.json[i].nombre != null) 
                                {
                                    $('#tblListadoBio tbody').append('<tr><td>'+jsonCitas.json[i].nombre+'</td><td>'+jsonCitas.json[i].cargo+'</td><td>'+jsonCitas.json[i].categoria+'</td><td>'+jsonCitas.json[i].apcvalorizacion+'</td><td><center><button class="btn btn-info btn-xs" id="btnVerDetallesBio" data-clbcodigo="'+jsonCitas.json[i].clbcodigo+'" data-desde="'+jsonCitas.json[i].desde+'" data-hasta="'+jsonCitas.json[i].hasta+'"><i class="fa fa-search"></i></button></center></td></tr>');

                                    $('#nm').html(" REPORTE COMPRENDIDO ENTRE " + jsonCitas.json[i].desde + " Y " + jsonCitas.json[i].hasta);
                                }
                            }


                        }
                     });               
                }

            }
        }
        
 });



/********************************/


$(document).on('click', '#btnVerDetallesBio', function() 
{
    var clbcodigo = $(this).data("clbcodigo");
    var desde     = $(this).data("desde");
    var hasta     = $(this).data("hasta");


    $.ajax({
        url: 'php/reporte/process.php',
        method: 'POST',
        data: {opcion: "detallesBio", clbcodigo:clbcodigo, desde: desde, hasta:hasta},
         beforeSend:function(request) {
                  $.blockUI({ css: {
                     border: 'none',
                     padding: '15px',
                     backgroundColor: '#000',
                       '-webkit-border-radius': '10px',
                       '-moz-border-radius': '10px',
                     opacity: .5,
                     color: '#fff',

                  },
                  message: 'Procesando...'});
},
        success: function (data) 
        {
            $('#modalDetallesBio').modal("show");
            var jsonDetalles = JSON.parse(data);
            $('#tblListadoDetallesBio tbody').empty();
            var fecha; var turno; var valor; var dif; var hora; var tipo;
            if (jsonDetalles.res == "full") 
            {
                for(var i in jsonDetalles.json)
                {
                    if (jsonDetalles.json[i].prgfecha == null) 
                    {
                        fecha = "";
                    }
                    else
                    {
                        fecha = jsonDetalles.json[i].prgfecha;
                    }

                    if (jsonDetalles.json[i].turno == null) 
                    {
                        turno = "";
                    }
                    else
                    {
                        turno = jsonDetalles.json[i].turno;
                    }

                    if (jsonDetalles.json[i].apcvalorizacion == null) 
                    {
                        valor = "";
                    }
                    else
                    {
                        valor = jsonDetalles.json[i].apcvalorizacion;
                    }

                    if (jsonDetalles.json[i].dif == null) 
                    {
                        dif = "";
                    }
                    else
                    {
                        dif = jsonDetalles.json[i].dif;
                    }

                    if (jsonDetalles.json[i].hora == null) 
                    {
                        hora = "";
                    }
                    else
                    {
                        hora = jsonDetalles.json[i].hora;
                    }

                    if (jsonDetalles.json[i].tipo == null) 
                    {
                        tipo = "";
                    }
                    else
                    {
                        tipo = jsonDetalles.json[i].tipo;
                    }
                    
                    $('#tblListadoDetallesBio tbody').append('<tr><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+fecha+'</td><td>'+turno+'</td><td>'+hora+'</td><td>'+dif+'</td><td>'+tipo+'</td><td>'+valor+'</td></tr>');
                    $('#nombrePBio').html("<i class='fa fa-user'></i> DETALLE DE NOVEDADES " + jsonDetalles.json[i].trcrazonsocial);
                }
                $('#tblListadoDetallesBio tbody').append('<tr><td colspan="6" class="danger"><b>TOTAL</b></td><td  class="danger"><b>'+jsonDetalles.json[i].total+'</b></td></tr>');
            }
             $.unblockUI();
        }
    });
}); 

/*=====  End of REPORTE DE BIOMETRICO  ======*/


$(document).on('click', '#btn_ver_servicios', function() {
     var cod_col  = $(this).data("id_col");
     var img      = $(this).data("img");
     var cargo_   = $(this).data("cargo");
     var nom_col  = $(this).data("nombrecol");

     load_service (cod_col);
     $.ajax({
        url: 'php/sube_baja/mostrar_servicios.php',
        method: 'POST',
        data: {cod_col:cod_col, buscar:"no"},
        success: function (data) 
        {


            var jsonServicios = JSON.parse(data);

                var imagen   =  "";
                var cod      =  "";
                var nombre   =  "";
                var cargo    =  "";
                    var servicio =  "";
                    var duracion =    "";
            
                $('#tbl_servicios tbody').empty();
                $('#nombreColaboradorServicio').empty();
                $('#cargoColaboradorServicio').empty(); 


                    if (jsonServicios.res == "full") 
                    {

                        for(var i in jsonServicios.json)
                        {

                            

                              

                        $('#listaData').empty();

                        if(jsonServicios.json[i].img_servici == "default.jpg" || jsonServicios.json[i].img_servici == null )
                        {
                        imagen = "contenidos/imagenes/default.jpg";
                    }
                    else
                    {
                        imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios.json[i].img_servici+"";
                    }

                    $('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
                        $('#imagenColaboradorServicio').attr('title', jsonServicios.json[i].nom_colabor);
                        $('#txtCodigoColaborador').val(jsonServicios.json[i].cod_colabor);
                        $('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios.json[i].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios.json[i].nom_colabor+'</button><button type="button" title="'+jsonServicios.json[i].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios.json[i].cargo_colab+'</button><button type="button" title="'+jsonServicios.json[i].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios.json[i].salon_base+'</button><button type="button" title="'+jsonServicios.json[i].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios.json[i].categoria+'</button></div>');

                        }
                    }
                    else
                    {

                        var jsonServicios2 = JSON.parse(data);

                        for(var j in jsonServicios2.json)
                        {

                            

                              

                        $('#listaData').empty();

                        if(jsonServicios2.json[j].img_servici == "default.jpg" || jsonServicios2.json[j].img_servici == null )
                        {
                        imagen = "contenidos/imagenes/default.jpg";
                    }
                    else
                    {
                        imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+jsonServicios2.json[j].img_servici+"";
                    }

                    $('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
                        $('#imagenColaboradorServicio').attr('title', jsonServicios2.json[j].nom_colabor);
                        $('#listaData').html('<div class="list-group"><button type="button" title="'+jsonServicios2.json[j].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+jsonServicios2.json[j].nom_colabor+'</button><button type="button" title="'+jsonServicios2.json[j].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+jsonServicios2.json[j].cargo_colab+'</button><button type="button" title="'+jsonServicios2.json[j].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+jsonServicios2.json[j].salon_base+'</button><button type="button" title="'+jsonServicios2.json[j].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+jsonServicios2.json[j].categoria+'</button></div>');

                        }

                    }               
                        
            

      }
        
    });

});


$(document).on('click', '.btnModalReporte', function(event) 
{
    $('#modalReporte').modal("show");
});

$(document).on('click', '#btnIr', function(event) 
{
    var sel = $('#selReport').val();

    switch (sel) 
    {
        case '1':
            window.location="reporteAgenda.php";
            break;

        case '2':
            window.location="reporteBiometrico.php";
            break;
        default:
            // statements_def
            break;
    }
});










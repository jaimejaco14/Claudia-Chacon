/*=============================
=            READY            =
=============================*/

setInterval(function(){MensajeCierreSyB ();}, 255500);

$(document).ready(function() {
    MetasCargoSln ();
    conteoNovHead ();
});


/*=====  End of READY  ======*/


$(document).on('click', '#btnModalCumple', function() 
{
        $.ajax({
            url: 'php/indicadores/process.php',
            method: 'POST',
            success: function(data) 
            {              

                var jsonCumple = JSON.parse(data);
              

                    $('#tblcumple tbody').empty();
                    $('#tblcumplecli tbody').empty();

                    if (jsonCumple.json.length>0) 
                    {
                        for(var i in jsonCumple.json)
                        {
                        
                            $('#modalCumple').modal("show");
                            $('body').removeClass("modal-open");
                            $('body').removeAttr("style");
                            $('#tblcumple tbody').append('<tr><td>'+jsonCumple.json[i].nombre+'</td><td class="issue-info">'+jsonCumple.json[i].cargo+'</td><td>'+jsonCumple.json[i].salon+'</td></tr>');
                        }                        
                    }
                    else
                    {
                        $('#modalCumple').modal("show");
                        $('body').removeClass("modal-open");
                        $('body').removeAttr("style");
                        $('#tblcumple tbody').append('<tr><td colspan="3"><center>NINGÚN COLABORADOR CUMPLE AÑOS EN ESTE DIA</center></td></tr>');
                    }

                    if (jsonCumple.cli.length>0) 
                    {
                        for(var j in jsonCumple.cli)
                        {

                        
                            $('#modalCumple').modal("show");
                            $('body').removeClass("modal-open");
                            $('body').removeAttr("style");
                            $('#tblcumplecli tbody').append('<tr><td>'+jsonCumple.cli[j].nombre+'</td><td class="issue-info">'+jsonCumple.cli[j].movil+'</td><td>'+jsonCumple.cli[j].email+'</td></tr>');
                        }
                    }
                    else
                    {
                        $('#modalCumple').modal("show");
                        $('body').removeClass("modal-open");
                        $('body').removeAttr("style");
                        $('#tblcumplecli tbody').append('<tr><td colspan="3"><center>NINGÚN CLIENTE CUMPLE AÑOS EN ESTE DIA</center></td></tr>');
                    }              
                
        }
    });      
                            
});


$(document).on('click', '#btnModalCumpleSig', function() 
{
    $('#modalCumpleClientes').modal("show");
    //$('body').removeClass("modal-open");
    //$('body').removeAttr("style");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "cumpleclientes"},
        success: function(data) 
        {
            var jsonCumpleCli = JSON.parse(data);
             $('#tblcumpleCliente tbody').empty();
            if (jsonCumpleCli.res == "full") 
            {
                for(var i in jsonCumpleCli.json)
                {
                    $('#modalCumpleClientes').modal("show");
                    //$('body').removeClass("modal-open");
                    //$('body').removeAttr("style");
                    $('#tblcumpleCliente tbody').append('<tr><td>'+jsonCumpleCli.json[i].nombre+'</td><td class="issue-info">'+jsonCumpleCli.json[i].movil+'</td><td>'+jsonCumpleCli.json[i].email+'</td></tr>');
                }
            }
            else
            {
                $('#modalCumpleClientes').modal("show");
                //$('body').removeClass("modal-open");
                //$('body').removeAttr("style");
                $('#tblcumpleCliente tbody').append('<tr><td colspan="3"><center>NINGÚN CLIENTE CUMPLE AÑOS EN ESTE DIA</center></td></tr>');
            }
        }

    });

});

                      


//modalCumpleClientes




$(document).on('click', '#btnModalCitas', function() 
{
    $('#modalcitas').modal("show");
    //$('body').removeClass("modal-open");
    //$('body').removeAttr("style");
   $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "citas"},
        success: function(data) 
        {
            var citas = JSON.parse(data);

            if (citas.res == "full") 
            {
                $('#tblcitas tbody').empty();
                var estado = "";
                for(var i in citas.json)
                {
                    switch (citas.json[i].estado) 
                    {
                        case "AGENDADA POR FUNCIONARIO":
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success" style="color: #67f617"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                        case "AGENDADA POR CLIENTE":
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success" style="color: #67f617"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                        case "CANCELADA":
                            estado = '<i class="fa fa-minus-circle" style="color: #f8312a" title="CITA CANCELADA"></i';
                            break;

                         case "RECORDADA VIA SMS":
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                        case "RECORDADA VIA EMAIL":
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                         case "CONFIRMADA TELEFONICAMENTE":
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button>';
                            break;

                         case "REPROGRAMADA":
                            estado = '<i class="fa fa-clock-o" style="color:#ff3de7" title="CITA REPROGRAMADA"></i>';
                            break;

                         case "ATENDIDA":
                            estado = '<i class="fa fa-check" style="color:#30f925" title="CITA ATENDIDA"></i>';
                            break;

                         case "INASISTENCIA":
                            estado = '<i class="fa fa-frown-o text-info" title="EL CLIENTE NO SE PRESENTÓ A LA CITA"></i>';
                            break;
                        default:
                            // statements_def
                            break;
                    }
                    $('#tblcitas tbody').append('<tr><td>'+citas.json[i].citcodigo+'</td><td>'+citas.json[i].cliente+'</td><td>'+citas.json[i].movil+'</td><td>'+citas.json[i].sernombre+'</td><td>'+citas.json[i].cithora+'</td><td>'+citas.json[i].colaborador+'</td><td>'+citas.json[i].estado+'</td><td><center>'+estado+'</center></td></tr>');
                }
            }
            else
            {
                $('#tblcitas tbody').empty();
                $('#tblcitas tbody').append('<tr><td colspan="8"><center>NO HAY CITAS REGISTRADAS PARA ESTE DÍA</center></td></tr>');
            }
        }
    });  
});


$(document).on('click', '#btnVerPermisos', function() 
{
    $('#modalPermisos').modal("show");

    $('body').removeClass("modal-open");
    $('body').removeAttr("style");
    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "permisos"},
        success: function(data) 
        {
            var permisos = JSON.parse(data);

            if (permisos.res == "full") 
            {
                $('#tblpermisos tbody').empty();
                for(var i in permisos.json)
                {
                    var tbody = $("#tblpermisos");
                    if (tbody.length > 3)
                    {
                        $('#styleTbl').css({"height":"400px", "overflow-y": "auto"});
                    }
                    else
                    {

                        $('#tblpermisos tbody').append('<tr><td>'+permisos.json[i].idpermiso+'</td><td>'+permisos.json[i].colaborador+'</td><td>'+permisos.json[i].fechades+'</td><td>'+permisos.json[i].horades+'</td><td>'+permisos.json[i].fechahas+'</td><td>'+permisos.json[i].horahas+'</td><td>'+permisos.json[i].estado+'</td></tr>');
                    }
                   
                }
            }
            else
            {
                $('#tblpermisos tbody').empty();
                $('#tblpermisos tbody').append('<tr><td colspan="8"><center>NO HAY PERMISOS AUTORIZADOS PARA ESTE DÍA</center></td></tr>');
            }
        }
    });
});


/*if (oData.estado == 'Activo') {
                $(nTd).html("<span class='label label-success'>"+ oData.estado +" </span>");
            }else{
                $(nTd).html("<span class='label label-danger'>"+ oData.estado +" </span>");
            }
*/
/************************************************************/

var  tbl_categorias  = function() { 
   var tbl_est = $('#tblcolaboradores').DataTable({
    "ajax": {
      "method": "POST",
      "url": "php/indicadores/loadColaborador.php",
      },
      "columns":[
        {"data": "trcrazonsocial"},
        {"data": "crgnombre"},
        {"data": "trnnombre"},
        {"data": "ctcnombre"},
        {"data": "disponible",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                switch (sData) 
                {
                    case "DISPONIBLE":
                        $(nTd).html('<center><i class="fa fa-check" style="color:#30f925" title="Colaborador Disponible"></i></center>');
                        break;

                    case "OCUPADO":
                        $(nTd).html('<center><i class="fa fa-minus-circle" style="color: #f8312a" title="Colaborador Ocupado"></i></center>');
                        break;

                    case "SIN INCLUIR":
                         $(nTd).html('<center><i class="fa fa-tasks" style="color: #2551f9" title="Colaborador Sin Incluir en Cola"></i></center>');
                         break;
                    default:
                        
                        break;
                }
            }
                
        },

      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
             
        "order": [[0, "desc"]],
         "bDestroy": true,
         "pageLength": 5
  });
};


$(document).on('click', '#btnVerColab', function() 
{
     $('#modalColaboradores').modal("show");
     tbl_categorias();
});


/*$(document).on('click', '#btnVerColab', function() 
{
    $('#modalColaboradores').modal("show");
    //$('body').removeClass("modal-open");
    //$('body').removeAttr("style");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "colaborador"},
        success: function(data) 
        {
            var permisos = JSON.parse(data);

            if (permisos.res == "full") 
            {
                $('#tblcolaboradores tbody').empty();

                var td = "";

                for(var i in permisos.json)
                {
                    switch (permisos.json[i].dis) 
                    {
                        case 'DISPONIBLE':
                             td = '<td title="Colaborador Disponible"><center><i class="fa fa-check" style="color:#30f925" title="Colaborador Disponible"></i></center></td>';                        
                            break;

                        case 'OCUPADO':
                             td = '<td title="Colaborador Ocupado"><center><i class="fa fa-minus-circle" style="color: #f8312a" title="Colaborador Ocupado"></i></center></td>';                      
                            break;

                        case 'SIN INCLUIR':
                             td = '<td title="Colaborador Sin Incluir en Cola"><center><i class="fa fa-tasks" style="color: #2551f9" title="Colaborador Sin Incluir en Cola"></i></center></td>';                       
                            break;

                        default:
                            td = "";
                            break;
                    }
            
                    $('#tblcolaboradores tbody').append('<tr><td>'+permisos.json[i].colaborador+'</td><td>'+permisos.json[i].cargo+'</td><td>'+permisos.json[i].turno+'</td><td>'+permisos.json[i].categoria+'</td>'+td+'</tr>');
                }
            }
            else
            {
                $('#tblcolaboradores tbody').empty();
                $('#tblcolaboradores tbody').append('<tr><td colspan="5"><center>NO HAY COLABORADORES PROGRAMADOS EN ESTE DÍA</center></td></tr>');
            }
        }
    });
});*/



$(document).on('click', '#btnasistida', function() 
{
    var idcita = $(this).data("id");
    var estado = $(this).data("estado");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {idcita:idcita, estado:estado, opcion: "cambiarEstadoCita"},
        success: function (data) 
        {            
            fnLoadestado ();                             
        }
    });

});

/*function cancelarCita () 
{
    // body...
}*/


$(document).on('click', '#btninasistencia', function() 
{
    var idcita = $(this).data("id");
    var estado = $(this).data("estado");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {idcita:idcita, estado:estado, opcion: "cambiarEstadoCita"},
        success: function (data) 
        {
            fnLoadestado ();
            
        }
    });

});


$(document).on('click', '#btnicancelarcita', function() 
{
    var idcita = $(this).data("id");
    var estado = $(this).data("estado");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {idcita:idcita, estado:estado, opcion: "cambiarEstadoCita"},
        success: function (data) 
        {
            fnLoadestado ();
        }
    });

});


$(document).on('click', '#btniconfirmadatel', function() 
{
    var idcita = $(this).data("id");
    var estado = $(this).data("estado");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {idcita:idcita, estado:estado, opcion: "cambiarEstadoCita"},
        success: function (data) 
        {
            fnLoadestado ();
        }
    });

});


$(document).on('click', '#btnCitasSig', function() 
{
    $('#modalcitasSig').modal("show");
    //$('body').removeClass("modal-open");
    //$('body').removeAttr("style");

    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "sigcitas"},
        success: function(data) 
        {
            var citas = JSON.parse(data);

            if (citas.res == "full") 
            {
                $('#tblcitassig tbody').empty();
                for(var i in citas.json)
                {                    
                    $('#tblcitassig tbody').append('<tr><td>'+citas.json[i].citcodigo+'</td><td>'+citas.json[i].cliente+'</td><td>'+citas.json[i].movil+'</td><td>'+citas.json[i].sernombre+'</td><td>'+citas.json[i].cithora+'</td><td>'+citas.json[i].colaborador+'</td><td>'+citas.json[i].estado+'</td><td><center><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button></td></center></tr>');
                }
            }
            else
            {
                $('#tblcitassig tbody').empty();
                $('#tblcitassig tbody').append('<tr><td colspan="8"><center>NO HAY CITAS REGISTRADAS PARA ESTE DÍA</center></td></tr>');
            } 
        }
    });

});

function lol () 
{
   $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "sigcitas"},
        success: function(data) 
        {
            var citas = JSON.parse(data);

            if (citas.res == "full") 
            {
                $('#tblcitassig tbody').empty();
                for(var i in citas.json)
                {
                    $('#tblcitassig tbody').append('<tr><td>'+citas.json[i].citcodigo+'</td><td>'+citas.json[i].cliente+'</td><td>'+citas.json[i].movil+'</td><td>'+citas.json[i].sernombre+'</td><td>'+citas.json[i].cithora+'</td><td>'+citas.json[i].colaborador+'</td><td>'+citas.json[i].estado+'</td><td><center><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button></td></center></tr>');
                }
            }
            else
            {
                $('#tblcitassig tbody').empty();
                $('#tblcitassig tbody').append('<tr><td colspan="8"><center>NO HAY CITAS REGISTRADAS PARA ESTE DÍA</center></td></tr>');
            } 
        }
    });
}

function fnLoadestado () 
{
   $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "citas"},
        success: function(data) 
        {
            var citas = JSON.parse(data);

            if (citas.res == "full") 
            {
                $('#tblcitas tbody').empty();
                var estado = "";
                for(var i in citas.json)
                {
                    switch (citas.json[i].estado) 
                    {
                        case 'ATENDIDA':
                            estado = '<i class="fa fa-check" style="color: #67f617"></i>';
                            break;

                        case 'AGENDADA POR FUNCIONARIO':
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success" style="color: #67f617"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                        case 'INASISTENCIA':
                            estado = '<i class="fa fa-frown-o text-info"></i>';
                            break;

                        case 'CANCELADA':
                            estado = '<i class="fa fa-minus-circle text-danger"></i>';
                            break;

                        case 'AGENDADA POR CLIENTE':
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success" style="color: #67f617"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button>';
                            break;

                        case 'REPROGRAMADA':
                            estado = '<i class="fa fa-clock-o" style="color:#ff3de7" title="CITA REPROGRAMADA"></i>';
                            break;

                        case 'CONFIRMADA TELEFONICAMENTE':
                            estado = '<button type="button" class="btn btn-default btn-xs" id="btnasistida" data-id="'+citas.json[i].citcodigo+'" data-estado="8" title="Asistida"><i class="fa fa-check text-success" style="color: #67f617"></i></button><button type="button" class="btn btn-default btn-xs" id="btninasistencia" data-id="'+citas.json[i].citcodigo+'" data-estado="9" title="Inasistencia"><i class="fa fa-frown-o text-info"></i></button><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button>';
                            break;


                        default:

                            break;
                    }
                    $('#tblcitas tbody').append('<tr><td>'+citas.json[i].citcodigo+'</td><td>'+citas.json[i].cliente+'</td><td>'+citas.json[i].movil+'</td><td>'+citas.json[i].sernombre+'</td><td>'+citas.json[i].cithora+'</td><td>'+citas.json[i].colaborador+'</td><td>'+citas.json[i].estado+'</td><td><center>'+estado+'</center></td></tr>');

                    // $('#tblcitas tbody').append('<tr><td>'+citas.json[i].citcodigo+'</td><td>'+citas.json[i].cliente+'</td><td>'+citas.json[i].movil+'</td><td>'+citas.json[i].sernombre+'</td><td>'+citas.json[i].cithora+'</td><td>'+citas.json[i].colaborador+'</td><td>'+citas.json[i].estado+'</td><td><center><button type="button" class="btn btn-default btn-xs" title="Cancelar cita"  id="btnicancelarcita" data-id="'+citas.json[i].citcodigo+'" data-estado="3"><i class="fa fa-times text-danger"></i></button><button type="button" class="btn btn-default btn-xs" id="btniconfirmadatel" data-id="'+citas.json[i].citcodigo+'" data-estado="6" title="Confirmada telefónicamente"><i class="fa fa-phone text-warning"></i></button></td></center></tr>');
                }
            }
            else
            {
                $('#tblcitas tbody').empty();
                $('#tblcitas tbody').append('<tr><td colspan="8"><center>NO HAY CITAS REGISTRADAS PARA ESTE DÍA</center></td></tr>');
            } 
        }
    });
}


function MetasCargoSln () 
{
    $.ajax({
        url: 'php/indicadores/processIndicador.php',
        method: 'POST',
        data: {opcion: "meta"},
        success: function(data) 
        {
            var jsonmetas = JSON.parse(data);
            $('#tblmetascargo tbody').empty();

            if (jsonmetas.res == "full") 
            {
                for(var i in jsonmetas.json)
                {
                    $('#tblmetascargo tbody').append('<tr><td><span class="text-danger font-bold">'+jsonmetas.json[i].cargo+'</span></td><td style="text-align: right">'+jsonmetas.json[i].valor+'</td></tr>');
                }
            }
            else
            {
                $('#tblmetascargo tbody').append('<tr><td colspan="3"><center>No hay metas asignadas</center></td></tr>');
            }
        }
    });

}



function MensajeCierreSyB () 
{
    $.ajax({
        url: 'php/indicadores/alertasyb.php',
        method: 'POST',
        success: function(data) 
        {
            
            if (data == 1) 
            {
               swal("Se recuerda que en 5 minutos se termina el horario. No olvide cerrar el sube y baja", "Advertencia", "warning");
                //alert("Se recuerda que en 5 minutos se termina el horario. No olvide cerrar el sube y baja");
            }
        }
    });
}


 //$('#example2').dataTable();

 function conteoNovHead () 
 {
    $.ajax({
        url: 'php/biometrico/processFn.php',
        method: 'POST',
        data: {opcion: "conteoNovHead"},
        success: function (data) 
        {
            $('#conteoNoved').html(data);
            $('#novdect').html("NOVEDADES DETECTADAS " + data);
        }
    });
 }

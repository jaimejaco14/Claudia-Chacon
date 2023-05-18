$(document).ready(function() {
   // actualizarCalendario();
    crear_calendario();
      

     //var moment = $('#calendar').fullCalendar('getDate');
     

    /*$('#my_modal').on('shown.bs.modal', function () {
         $('body').removeClass("modal-open").css("margin-right: 0px");
    });*/
});

function crear_calendario () {
    var p = "salon";
    if (p == "salon"){
        var a = $("#cod_salon").val();
    } 
    if (p== "clb") {
        var a = $("#cola").val();
    }

    var m="";
    $('#calendar').fullCalendar({

         dayClick: function(date, jsEvent, view) {
            //$('body').removeClass("modal-open");  


            window.open("php/programacion_pdv/generarReporteTurnos.php?salon="+$("#cod_salon").val()+"&fecha="+date.format()+"  ");
            //$('body').removeClass("modal-open");
            console.log(date.format());

            $("#programacion").attr("hidden", false);
            $("#nueva_programacion").attr("hidden", true);
            

           /* var fecha = date.format();
            var codigo = $('#selectSalon').val();
            var salon = $('#selectSalon option[value='+codigo+']').html();
            $.ajax({
                type: "POST",
                url: "listar_programacion.php",
                data: {fecha: fecha, salon: salon, codigo: codigo},
                success: function (res) {
                    $('#prg_dia').html(res);
                }
            });*/

            // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

            // alert('Current view: ' + view.name);

            // change the day's background color just for fun
            // $('#calendar').children().css('background-color', "#c8a7");
            // $(this).css('background-color', '#c9ad7d');
        },

        eventClick: function(calEvent, jsEvent, view) {
           
            
            var trn = calEvent.id;
            var fecha = new Date(calEvent.start);
            y = fecha.getFullYear();
            m = fecha.getMonth();
            m++;
            d = fecha.getDate();

            var fecha_turno = y+"-"+m+"-"+d;
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            $('#lista').empty();
            $('#lista').html('<i class="fa fa-spin fa-spinner"></i> Cargando, por favor espere...');
            $.ajax({
                type: "POST",
                url: "php/programacion_pdv/find_col_on_turn.php",
                data: {id_turno: trn, fch: fecha_turno, salon:$("#cod_salon").val()},
                success: function(data) {
                    $('#lista').html(data);
                    //console.log(data);
                }
            });
            $('#my_modal').modal('show');
            //$('body').removeClass("modal-open");
            $('body').removeAttr("style");
            $('#fec_prg').html("Fecha: " +fecha_turno);
            // change the border color just for fun <= 'Idiots'
            $(this).css('border-color', 'red');
        },
        eventRender: function(event, element){
                $(element).tooltip({title: event.title, container: "body"});
        },
        dayRender: function(event, cell, date) {
                          
            cell.prepend("<i class='fa fa-print'></i>");
                 
        },
       
        textColor : "#0c0c0c",
        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar
        drop: function() {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
      
        events: "php/programacion_pdv/find_progra.php?p="+p+"&codigo="+a //carga las programaciones existentes

    });
}
 crear_calendario();
 //$('#panelCalendario').attr('hidden', true);

function restablecerCalendario(){

    $("#calendar").fullCalendar("destroy");
    $("#calendar").fullCalendar({

        lang: 'es',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        eventLimit: true,
        droppable: false,
        timeFormat: "h:mm a"
    });
}

function cambiar_tipo (idSelect, tipoActual) {
    $('#'+idSelect).attr('hidden', false);
}

function actualizar_tipo (codigoColaborador, fecha) {
    var nuevoTipo = $('#'+codigoColaborador).val();
    $.ajax({
        type: "POST",
        url: "../../beauty/update_tipoProgramacion.php",
        data: {colaborador: codigoColaborador, fecha: fecha, nuevo: nuevoTipo},
        success: function (res) {
            if (res == "TRUE") {
                 $('#'+codigoColaborador).attr('hidden', true);
                 $('#a'+codigoColaborador).attr('hidden', false);
                 $('#a'+codigoColaborador).html($('#'+codigoColaborador+' option[value='+nuevoTipo+']').html());
            } else {

            }
        }

    });

}
function eliminar (colaborador, fech, este) {
        swal({
            title: "¿Seguro que desea quitar este colaborador?",
            text: "",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"
        },
        function () {
            $.ajax({
                type: "POST",
                url: "delete_progra.php",
                data: {fecha: fech, col: colaborador},
                success: function (res) {
                    if (res == "TRUE") {
                        $(este).parent().parent().remove();
                    }
                }
            });
        });
}

/*function copiar (fechaProgramacion) {
        $('#copy').modal("show");
   }
*/


function GetCurrentDisplayedMonth() { 
var date = new Date($('#calendar').fullCalendar('getDate'));
var month_int = date.getMonth();
return month_int+1; 
}

GetCurrentDisplayedMonth();


$(document).ready(function() {

    $(document).on('click', '#btnReportePdf', function() {
        window.open("php/programacion_pdv/generarReporteTurnos.php?salon="+$("#cod_salon").val()+"&turno="+$("#turnop").text()+"&fecha="+$('#fechap').text()+"  ");        
    });

     $(document).on('click', '#btnReportePdfdia', function() {
        window.open("php/programacion_pdv/generarReporteTurnos.php?tipo=comp&salon="+$("#cod_salon").val()+"&turno="+$("#turnop").text()+"&fecha="+$('#fechap').text()+"  ");        
    });

    $(document).on('click', '#btnReporte', function() {
        window.open("php/programacion_pdv/generarReporteTurnosMes.php?salon="+$("#cod_salon").val()+"&fecha="+GetCurrentDisplayedMonth()+"&nomsalon="+$('.sln').val()+"");        
    });

   /* 
     $(document).on('click', '#btnReporteMes', function() {
        var nomsalon = $('#selectSalon option:selected').text();
        window.open("php/programacion/generarReporteTurnosMes.php?salon="+$("#selectSalon").val()+"&fecha="+$('#fecha').val()+"&nomsalon="+nomsalon+"");        
    });
    
*/

     
    
});


$(document).on('click', '#btn_fr', function() {
    var id = $(this).data("id");

    alert(id);
});











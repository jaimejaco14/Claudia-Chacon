/*==============================
=            PROGRAMACION      =
==============================*/

$(document).ready(paginacion_art(1, $('#codColaborador').val()));

function paginacion_art(partida, codCol) {
    var url = 'php/programacion/listado.php';
    $.ajax({
        type: 'POST',
        url: url,
        data: {partida: partida, codColaborador: codCol, opcion: "listado"},
        success: function(data) {
            var array = eval(data);
            $('#listadoProg').html(array[0]);
            $('#paginacion').html(array[1]);
        }
    });
    return false;
}

toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-center",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};



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

$('#fecha').datepicker({ 
        format: "yyyy-mm-dd",
        setDate: "0",
        language: 'es',
        today: "Today",
        option: "defaultDate"
});
jQuery(function() {
    jQuery( "#fecha" ).datepicker({ }).attr('readonly','readonly');
});
$('#fecha').on('changeDate', function(ev){
    
    $(this).datepicker('hide');
    //$('#paginacion').empty();
        $('#listadoProg').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando, por favor espere...</center>');
        $.ajax({
            url: 'php/programacion/listado.php',
            method: 'POST',
            data: {opcion: "searchApp", fecha: $('#fecha').val(), partida: 1, codColaborador: $('#codColaborador').val()},
            success: function (data) 
            {
                var array = eval(data);
                $('#listadoProg').html(array[0]);
                $('#paginacion').html(array[1]);
            }
        });

});


$(document).on('click', '#alerta', function() 
{
    toastr.error("No tienes agenda asignada");
});

$(document).on('click', '#alerta2', function() 
{
    toastr.error("No tienes servicios autorizados");
});   


/*=====  End of PROGRAMACION  ======*/

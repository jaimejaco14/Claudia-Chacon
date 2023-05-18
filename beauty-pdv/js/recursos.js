/*================================
=            RECURSOS            =
================================*/

beforeSend: function() 
{
	$.blockUI({ message: '<h1> Espere un momento...</h1>' }); 
}


//Response

$(document).ajaxStop($.unblockUI); 

/***********************************/



$(document).prop('title', 'Citas | Beauty SOFT - ERP'); 



/**********************************/

$('#selectServicio').selectpicker({
        liveSearch: true,
        showSubtext: true
});


/**********************************/


toastr.options = {
    "debug": false,
    "newestOnTop": false,
    "positionClass": "toast-top-center",
    "closeButton": true,
    "toastClass": "animated fadeInDown",
};


/**********************************/



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


/**********************************/








/*=====  End of RECURSOS  ======*/

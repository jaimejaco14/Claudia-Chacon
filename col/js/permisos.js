/*================================
=            PERMISOS            =
================================*/

$('#datapicker2').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");
	$('#datapicker3').datepicker({ format: "yyyy-mm-dd"}).datepicker("setDate", "0");

            $("#datepicker").on("changeDate", function(event) 
            {
                $("#my_hidden_input").val(
                        $("#datepicker").datepicker('getFormattedDate')
                )
                dateFormat: "yy-mm-dd"
            });

    $('.clockpicker').clockpicker({autoclose: true});
    $('.clockpicker2').clockpicker({autoclose: true});

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



    $('.input-group.date').datepicker({ 
    	format: "yyyy-mm-dd",
    	setDate: "0",
        language: 'es',
       today: "Today",
    });



    $('.input-group2.date2').datepicker({ format: "yyyy-mm-dd"});

    $(document).on('click', '#btn-registar', function(event) 
    {
    		var fecde 	= $('#fecha_de').val();
    		var horade 	= $('#hora_de').val();
    		var fhasta  = $('#fecha_hasta').val();
    		var hhasta  = $('#hora_hasta').val();
    		var observ  = $('#observaciones').val();


        		if (fecde > fhasta) 
        		{
        			swal("Las fecha de inicio es mayor que la fecha final", "", "warning");
        		}
        		else
        		{
    	    		if (fecde == fhasta && horade >= hhasta) 
    	    		{
    	    			swal("La hora inicial es mayor o igual a la hora final", "", "warning");
    	    		}
    	    		else
    	    		{    	    			
        				
    				 	$.ajax({
    						url: 'php/permisos/registropermiso.php',
    						method: 'POST',
    						data: {fecde:fecde, horade:horade, fhasta:fhasta, hhasta:hhasta, observ:observ},
    						success: function (data) 
    						{
    							if (data) 
    							{
    								toastr.warning("Permiso registrado. \n Consecutivo N° "+data+" ");
    								$('#col').val('');
    					    			$('#fecha_de').val('');
    					    			$('#hora_de').val('');
    					    			$('#fecha_hasta').val('');
    					    			$('#hora_hasta').val('');
    					    			$('#observaciones').val('');
    							}
    						}
    					});
        				 
    	    			  			
    	    		} 

        		}

    });

$(document).ready(function() {
    tbl_permisos();
});


var  tbl_permisos  = function() { 
   var tbl_est = $('#tbl_permisos').DataTable({
    "searching": false,
    "ajax": {
      "method": "POST",
      "url": "php/permisos/buscar_permisos.php",
      "data": {codColaborador: $('#codColaborador').val() }
      },
      "columns":[
        {"data": "percodigo"},
        {"data": "fecha_desde"},
        {"data": "fecha_hasta"},
        {"data": "usu_reg"},
        {"data": "usu_aut"},
        {"data": "estado_tramite"},
      ],"language":{
        "lengthMenu": '',
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar Colaborador:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"id","targets":[0]},
            ],
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};

/*=====  End of PERMISOS  ======*/

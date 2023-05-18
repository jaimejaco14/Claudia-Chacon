$(document).ready(function() {
	tbl_listado ();
	conteoNovHead ();
});

/**

 * TABLA LISTADO 
 *
 */


/***********************************************************/

//          NUEVA ESTRUCTURA LISTADO DE BIOMETRICO        //


var  tbl_listado  = function() { 
   var a = $('#tblBiometricoDet').DataTable({
    "ajax": {
      "method": "POST",
      "url": "php/biometrico/processNew.php"
      },
      "columns":[
        {"data": "clbcodigo"},
        {"data": "trcrazonsocial"},
        {"data": "crgnombre"},
        {"data": "ctcnombre"}, 
        {"data": "total"},       
        {"data": "cantidad",             
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
                if (oData.cantidad == "0") 
                {
                    $(nTd).html("<center><button type='button' class='btn btn-info btn-xs button' title='SIN NOVEDADES'>"+oData.cantidad+"</button></center>");
                }
                else
                {

                    $(nTd).html("<center><button type='button' class='btn btn-danger btn-xs button_det' title='NOVEDADES SIN OBSERVACIONES "+oData.cantidad+"' data-toggle='modal' data-target='#modalDetalleCol' id='btnVerDetalle'>"+oData.cantidad+"</button></center>");                              
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
        "search": " Buscar: ",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        }
        },  
         "columnDefs":[
              {className:"codcol","targets":[0]},
              {className:"total","targets":[4]}
            ],
             
        "order": [[1, "asc"]],
        "bDestroy": true,
        //"bStateSave": true
  });
};



/***********************************************************/



$('#tblBiometricoDet tbody').on('click', '#btn_edit', function() {
    var $row = $(this).closest("tr");    
    var $codcol = $row.find(".codcol").text();
    var codcol = $codcol;

    var $codhor = $row.find(".codhor").text();
    var codhor = $codhor;

    var $codtur = $row.find(".codtur").text();
    var codtur = $codtur;

    var $codsln = $row.find(".codsln").text();
    var codsln = $codsln;

    var $fechaCod = $row.find(".fechaCod").text();
    var fechaCod = $fechaCod;

    var $aptcod = $row.find(".aptcod").text();
    var aptcod = $aptcod;

    var $abmcodigo = $row.find(".abmcodigo").text();
    var abmcodigo = $abmcodigo;

    var $nombre = $row.find(".sorting_1").text();
    var nombre = $nombre;

    
    $.ajax({
        url: 'php/biometrico/processObser.php',
        method: 'POST',
        data: {codcol: codcol, codhor:codhor, codtur:codtur, codsln:codsln, fechaCod:fechaCod, aptcod:aptcod, abmcodigo:abmcodigo},
        success: function (data) 
        {
        	var jsonArray = JSON.parse(data);

        	if (jsonArray.res == "full") 
        	{
        		for(var i in jsonArray.json)
        		{
        			$('#clbcodigo').val(jsonArray.json[i].clbcodigo);
        			$('#trncodigo').val(jsonArray.json[i].trncodigo);
        			$('#horcodigo').val(jsonArray.json[i].horcodigo);
        			$('#slncodigo').val(jsonArray.json[i].slncodigo);
        			$('#prgfecha').val(jsonArray.json[i].prgfecha);
        			$('#abmcodigo').val(jsonArray.json[i].abmcodigo);
        			$('#aptcodigo').val(jsonArray.json[i].aptcodigo);
        		}
        			$('#h5obs').html("<i class='fa fa-comment'></i> <b> Observaciones de " + nombre + "</b>");
        	}
        }
 	
	});

});


$(document).on('click', '#btnIngObser', function() 
{
	var clbcodigo = $('#clbcodigo').val();
	var trncodigo = $('#trncodigo').val();
	var horcodigo = $('#horcodigo').val();
	var slncodigo = $('#slncodigo').val();
	var prgfecha  = $('#prgfecha').val();
	var abmcodigo = $('#abmcodigo').val();
	var aptcodigo = $('#aptcodigo').val();	
	var observac  = $('#obs').val();

	if (observac == "") 
	{
		swal("Ingrese la observación.", "Advertencia", "warning");
	}
	else
	{		
		$.ajax({
			url: 'php/biometrico/insertObs.php',
			method: 'POST',
			data: {clbcodigo: clbcodigo, trncodigo:trncodigo, horcodigo:horcodigo, slncodigo:slncodigo, prgfecha:prgfecha,abmcodigo:abmcodigo, aptcodigo:aptcodigo, observac:observac},
			success: function (data) 
			{
				if (data == 1) 
				{
					//swal("Se ha ingresado la observación", "Exitoso", "success");
					$('#obs').val('');
					$('#modalObservaciones').modal("hide");
					conteoNovHead ();
					tbl_listado();
				}
			}
		});
	}	


});



$('#tblBiometricoDet tbody').on('click', '#btnVerObservacion', function() 
{
    var $row = $(this).closest("tr");    
    var $codcol = $row.find(".codcol").text();
    var codcol = $codcol;

    var $codhor = $row.find(".codhor").text();
    var codhor = $codhor;

    var $codtur = $row.find(".codtur").text();
    var codtur = $codtur;

    var $codsln = $row.find(".codsln").text();
    var codsln = $codsln;

    var $fechaCod = $row.find(".fechaCod").text();
    var fechaCod = $fechaCod;

    var $aptcod = $row.find(".aptcod").text();
    var aptcod = $aptcod;

    var $abmcodigo = $row.find(".abmcodigo").text();
    var abmcodigo = $abmcodigo;

    
    $.ajax({
        url: 'php/biometrico/verObservacion.php',
        method: 'POST',
        data: {codcol: codcol, codhor:codhor, codtur:codtur, codsln:codsln, fechaCod:fechaCod, aptcod:aptcod, abmcodigo:abmcodigo},
        success: function (data) 
        {
        	var jsonVerObser = JSON.parse(data);

        	for(var i in jsonVerObser.obs)
        	{
        		$('#verObser').html('');
        		$('#colaboradorObs').html();
        		$('#verObser').html(jsonVerObser.obs[i].observacion);
        		$('#colaboradorObs').html('<i class="fa fa-user"></i> ' +jsonVerObser.obs[i].nombre);        		        		
        	}
        }

    });

});


/**
 *
 * CONTEO NOVEDADES HEAD
 *
 */

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




$(document).on('click', '#btnReportePDF', function() 
{
	window.open("php/biometrico/reportePDF.php");
});


/**
 *
 * FUNCION MODAL DETALLES DE COLABORADOR
 *
 */

 function cargarTabla (codcol) 
 {
     $.ajax({
        url: 'php/biometrico/processVerDetallesCol.php',
        method: 'POST',
        data: {codcol: codcol},
        success: function (data) 
        {
            var jsonDetalles = JSON.parse(data);
            $('#tblDetalles tbody').empty();
            if (jsonDetalles.res == "full") 
            {
                for(var i in jsonDetalles.json)
                {
                    if (jsonDetalles.json[i].abmhora == null) 
                    {
                        jsonDetalles.json[i].abmhora = '';
                    }

                    $('#tblDetalles').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].desde+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].valor+'</td><td><center><button class="btn btn-warning btn-xs" id="btnModalObser" data-abmcodigo="'+jsonDetalles.json[i].abmcodigo+'" data-col="'+jsonDetalles.json[i].clbcodigo+'" data-turno="'+jsonDetalles.json[i].trncodigo+'" data-horario="'+jsonDetalles.json[i].horcodigo+'" data-salon="'+jsonDetalles.json[i].slncodigo+'" data-fecha="'+jsonDetalles.json[i].fecha+'" data-aptcodigo="'+jsonDetalles.json[i].aptcodigo+'"><i class="fa fa-comment"></i></button></center></td></tr>');

                    $('#nombreCol').html('<i class="fa fa-user"></i>' + jsonDetalles.json[i].nombre);                  
                }
            }
            else
            {
                $('#tblDetalles').append('<tr><td colspan="8"><b><center>NO REPORTA NOVEDADES</center></b></td></tr>');
            }
        }
    
    });
 }


 $('#tblBiometricoDet tbody').on('click', '#btnVerDetalle', function() {
    var $row = $(this).closest("tr");    
    var $codcol = $row.find(".codcol").text();
    var codcol = $codcol;
    $('#tblDetalles tbody').html('<i class="fa fa-spin fa-spinner"></i> Cargando detalles...');
    $('#nombreCol').html('<i class="fa fa-spin fa-spinner"></i> Cargando detalles...');
    $.ajax({
        url: 'php/biometrico/processVerDetallesCol.php',
        method: 'POST',
        data: {codcol: codcol},
        success: function (data) 
        {
            var jsonDetalles = JSON.parse(data);
            $('#tblDetalles tbody').empty();
            if (jsonDetalles.res == "full") 
            {
                for(var i in jsonDetalles.json)
                {
                    if (jsonDetalles.json[i].abmhora == null) 
                    {
                        jsonDetalles.json[i].abmhora = '';
                    }
                    $('#tblDetalles tbody').append('<tr><td>'+jsonDetalles.json[i].fecha+'</td><td>'+jsonDetalles.json[i].desde+'</td><td>'+jsonDetalles.json[i].salon+'</td><td>'+jsonDetalles.json[i].abmtipo+'</td><td>'+jsonDetalles.json[i].abmhora+'</td><td>'+jsonDetalles.json[i].aptnombre+'</td><td>'+jsonDetalles.json[i].valor+'</td><td><center><button class="btn btn-warning btn-xs" id="btnModalObser" data-abmcodigo="'+jsonDetalles.json[i].abmcodigo+'" data-col="'+jsonDetalles.json[i].clbcodigo+'" data-turno="'+jsonDetalles.json[i].trncodigo+'" data-horario="'+jsonDetalles.json[i].horcodigo+'" data-salon="'+jsonDetalles.json[i].slncodigo+'" data-fecha="'+jsonDetalles.json[i].fecha+'" data-aptcodigo="'+jsonDetalles.json[i].aptcodigo+'"><i class="fa fa-comment"></i></button></center></td></tr>');

                    $('#nombreCol').html('<i class="fa fa-user"></i>' + jsonDetalles.json[i].nombre);                  
                }
            }
        }
    
    });

});



$(document).on('click', '#btnModalObser', function() 
{
    var abmcodigo = $(this).data("abmcodigo");
    var clbcodigo = $(this).data("col");
    var trncodigo = $(this).data("turno");
    var horcodigo = $(this).data("horario");
    var slncodigo = $(this).data("salon");
    var fecha     = $(this).data("fecha");
    var aptcodigo = $(this).data("aptcodigo");
    $('#modalObserInd').on('shown.bs.modal', function () 
    {
        $('#clbcodigo_').val(clbcodigo);
        $('#trncodigo_').val(trncodigo);
        $('#horcodigo_').val(horcodigo);
        $('#slncodigo_').val(slncodigo);
        $('#prgfecha_').val(fecha);
        $('#abmcodigo_').val(abmcodigo);
        $('#aptcodigo_').val(aptcodigo);

    });
    $('#modalObserInd').modal("show");
    
});

$(document).on('click', '#btnGuardarObs', function() 
{
    var clb = $('#clbcodigo_').val();
    var trn = $('#trncodigo_').val();
    var hor = $('#horcodigo_').val();
    var sln = $('#slncodigo_').val();
    var fec = $('#prgfecha_').val();
    var abm = $('#abmcodigo_').val();
    var apt = $('#aptcodigo_').val(); 
    var obs = $('#textObervacion').val();

    if (obs == "") 
    {
        swal("Ingrese la observación.", "Advertencia", "warning");
    }
    else
    {       
        $.ajax({
            url: 'php/biometrico/insertObs.php',
            method: 'POST',
            data: {clbcodigo: clb, trncodigo:trn, horcodigo:hor, slncodigo:sln, prgfecha:fec,abmcodigo:abm, aptcodigo:apt, observac:obs},
            success: function (data) 
            {
                if (data == 1) 
                {
                    //swal("Se ha ingresado la observación", "Exitoso", "success");
                    $('#textObervacion').val('');
                    $('#modalObserInd').modal("hide");
                    conteoNovHead ();
                    tbl_listado();
                    cargarTabla(clb);
                }
            }
        });
    }   
});


function load_service (cod_col) {

    $.ajax({
        url: 'php/sube_baja/lista_servicios.php',
        method: 'POST',
        data: {cod:cod_col},
        success: function (data) {
            $('#list').html(data);
        }
    }); 
}

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
        success: function (data) {
            
            var array = eval(data);
            $('#tbl_servicios tbody').empty();
            $('#nombreColaboradorServicio').empty();
            $('#cargoColaboradorServicio').empty();

            if (array === null) {
                console.log("Valor nulo " +array);
                $('#tbl_servicios tbody').empty();
                $('#tbl_servicios tbody').append('<tr><td colspan="3">No tiene servicios autorizados888</td></tr>');
                $('#imagenColaboradorServicio').attr("src", "contenidos/imagenes/colaborador/beauty_erp/"+img +"").addClass('img-responsive, img-thumbnail');
                $('#txtCodigoColaborador').val(cod_col);
                $('#nombreColaboradorServicio').html(nom_col);
                $('#cargoColaboradorServicio').html(cargo_);
                $('#inputbuscar').val("");

            }else{
                if (array.length > 0) {
                    console.log(array);
                        for(var i in array){ 

                            var imagen   =  "";
                            var cod      =  "";
                            var nombre   =  "";
                            var cargo    =  "";
                            var servicio =  "";
                            var duracion =  "";

                            if(array[i].img_servici == "default.jpg" || array[i].img_servici == null ){
                                imagen = "contenidos/imagenes/default.jpg";
                            }else{
                                imagen = "../contenidos/imagenes/colaborador/beauty_erp/"+array[i].img_servici+"";
                            }

                            $('#imagenColaboradorServicio').attr("src", ""+imagen+"").addClass('img-responsive, img-thumbnail');
                            $('#imagenColaboradorServicio').attr('title', array[i].nom_colabor);
                            $('#txtCodigoColaborador').val(array[i].cod_colabor);
                            $('#nombreColaboradorServicio').html(array[i].nom_colabor);
                            $('#cargoColaboradorServicio').html(array[i].cargo_colab);
                            //$('#tbl_servicios tbody').append('<tr><td>'+array[i].nom_servicio+'</td><td>'+array[i].nomb_caract+'</td><td>'+array[i].dur_servicio+' min</td></tr>');
                            $('#listaData').html('<div class="list-group"><button type="button" title="'+array[i].nom_colabor+'" class="list-group-item success"><b>NOMBRE:</b> '+array[i].nom_colabor+'</button><button type="button" title="'+array[i].cargo_colab+'" class="list-group-item"><b>CARGO:</b> '+array[i].cargo_colab+'</button><button type="button" title="'+array[i].salon_base+'" class="list-group-item"><b>SALÓN BASE:</b> '+array[i].salon_base+'</button><button type="button" title="'+array[i].categoria+'" class="list-group-item"><b>CATEGORÍA:</b> '+array[i].categoria+'</button></div>');

                        }
                }

                
            }
        }
     });

});

$(document).ready(function() {
    
$('#inputbuscar').keyup(function(){
        var servicio = $(this).val();     
        
        $.ajax({
            type: "POST",
            url: "php/sube_baja/buscar_servicios.php",
            data: {servicio:servicio, cod:$('#txtCodigoColaborador').val()},
            success: function(data) {
                $('#list').html(data);
            }
        });

}); 
});

$(document).ready(function() {
    
    $(document).on('click', '#btn_paginar', function() {
              var data = $(this).data("id");
              $.ajax({
              type: "POST",
              url: "php/sube_baja/lista_servicios.php",
              data: {page: data, cod: $('#txtCodigoColaborador').val()},
              success: function (data) {
                 $('#list').html(data);
              }
          });
    });
});






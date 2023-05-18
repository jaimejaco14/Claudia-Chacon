$(document).ready(function() {
	$('.lieditar').attr("disabled", true);
    LoadCounter ();
    ListarCola();
    conteoNovHead ();
});

/*==================================
=            Paginación            =
==================================*/

$(document).ready(paginacion_art(1));
    function paginacion_art(partida){
        var url = 'php/directorio/listado.php';
        $.ajax({
            type:'POST',
            url:url,
            data:'partida='+partida,
            success:function(data){
                var array = eval(data);
                $('#contactos_lista').html(array[0]);
                $('#paginacion_contacto').html(array[1]);
            }
        });
        return false;
}


$(document).ready(function() {    
    $('#txt_buscar').keyup(function(){
            var contacto = $(this).val();       

            $.ajax({
                type: "POST",
                url: "php/directorio/listado.php",
                data: {contacto:contacto},
                success: function(data) {
                   var array = eval(data);
                    $('#contactos_lista').html(array[0]);
                    //$('#paginacion_art').css("display", "none");
                 
                }
            });
    });
});

/*=====  End of Paginación  ======*/


/*===============================================
=            Ingresar Nuevo Contacto            =
===============================================*/

$(document).on('click', '#btneviar', function() 
{
	var nombre = $('#nombre').val();
	var movil  = $('#movil').val();
	var fijo   = $('#fijo').val();
	var email  = $('#email').val();
    
    if (nombre == "") 
    {
    	swal("Ingrese el nombre del contacto", "Advertencia", "warning");
    	$('#nombre').focus();
    }
    else
    {
    	if (movil == "") 
        {
            swal("Ingrese el móvil", "", "warning");
        }
        else
        {
            $.ajax({
                url: 'php/directorio/process.php',
                method: 'POST',
                data: {nombre:nombre, movil:movil, fijo:fijo, email:email, opcion: 'nuevo'},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                       swal("Ingreso Correcto", "Enhorabuena", "success");
                       paginacion_art(1);
                        $('#listado').addClass("active");
                        $('#nuevo').removeClass("active");
                        $('.list').addClass('active');
                        $('.nuevo').removeClass("active");
                        //$('.panel-edit').addClass("active");
                    }
                    else
                    {
                        swal("Hubo un error al ingresar el contacto.", "Error", "error");
                    }
                }
            });
        }    	
    }
});

/*=====  End of Ingresar Nuevo Contacto  ======*/


/*=======================================
=            Editar Contacto            =
=======================================*/

$(document).on('click', '.btneditar', function() 
{
	var codcontacto = $(this).data("codcontacto");

    //$('#editar').addClass('active');
    $('#listado').removeClass("active");
    $('.list').removeClass("active");
    $('.new').addClass("active");
    $('.panel-edit').addClass("active");
    
    $.ajax({
    	url: 'php/directorio/process.php',
    	method: 'POST',
    	data: {codigo: codcontacto, opcion: 'editar'},
    	success: function (data) 
    	{
    		var array = eval(data);
    		for (var i in array)
    		{
                $('#id').val(array[i].id);
    			$('#editnombre').val(array[i].nom);
    			$('#editmovil').val(array[i].mov);
    			$('#editfijo').val(array[i].fij);
    			$('#editemail').val(array[i].mai);   			
				
				
    		}
    	}
    });

});


$(document).on('click', '#btnmodificar', function() 
{
    var id     = $('#id').val();
    var nombre = $('#editnombre').val();
    var movil  = $('#editmovil').val();
    var fijo   = $('#editfijo').val();
    var email  = $('#editemail').val();

    if (nombre == "") 
    {
        swal("Ingrese el nombre del contacto", "", "warning");
    }
    else
    {
        if (movil == "") 
        {
            swal("Ingrese el móvil", "", "warning"); 
        }
        else
        {
            $.ajax({
                url: 'php/directorio/process.php',
                method: 'POST',
                data: {id:id, nombre:nombre, movil:movil, fijo:fijo, email:email, opcion: 'guardar_cambios'},
                success: function (data) 
                {
                   if (data == 1) 
                   {
                        swal("Se ha modificado el contacto", "", "success");
                        paginacion_art(1);
                        LoadCounter ();
                        $('#editar').removeClass('active');
                        $('#listado').addClass('active');
                        $('.list').addClass('active');
                        //$('.new').removeClass('active');
                   }
                }
            });
        }
    }
});

/*=====  End of Editar Contacto  ======*/

/*=========================================
=            Eliminar Contacto            =
=========================================*/

$(document).on('click', '.btneliminar', function() 
{
    var id = $(this).data("codcontacto");

   swal({
          title: "¿Desea eliminar contacto?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
            $.ajax({
                url: 'php/directorio/process.php',
                method: 'POST',
                data: {id:id, opcion: 'eliminar'},
                success: function (data) {
                    if (data == 1) {
                        swal("Eliminado!", "Se ha eliminado el contacto.", "success");
                        paginacion_art(1);
                        LoadCounter ();
                    }
                }
            });
          }else{
            swal("Cancelado");
          } 
        });
});
/*=====  End of Eliminar Contacto  ======*/

/*====================================
=            Load Counter            =
====================================*/

function LoadCounter () 
{
   $.ajax({
    url: 'php/directorio/process.php',
    method: 'POST',
    data: {opcion: 'counter'},
    success: function (data) 
    {
        $('#spanCount').html("N° Contactos "+ data);
    }
   });
}

/*=====  End of Load Counter  ======*/



$(document).on('click', '.sln_nombre', function() {
    var id = $('#cod_salon').val();
    $('#modalVerSalon').modal("show");
    $('body').removeClass("modal-open");
    $('body').removeAttr("style");

   $.ajax({
        url: 'php/sube_baja/cargar_imagen_sln.php',
        method: 'POST',
        data: {id:id},
        success: function (data) {
            var array = eval(data);
            for(var i in array){
                $('#title_imagen').html("Salón "+array[i].nombre);
                $("#imagen_salon").removeAttr("src");        
                $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
            }
        }
   });
});





/*$(document).on('click', '.new', function() 
{
    $('#editar').removeClass('active');
    $('#listado').addClass('active');
    $('.list').addClass('active');
    $('.new').removeClass('active');
});*/

/*$(document).on('click', '.new', function() 
{
    if (($('#editar').hasClass('active')) && ($('.new').hasClass('active'))) 
    {
        $('.list').removeClass('active');
        //$('#listado').removeClass('active');
        $('#editar').addClass('active');
        //alert("OK");
    }
    else
    {
       if (($('.list').addClass('active')) && ($('#listado').hasClass('active'))) 
       {
            $('#editar').removeClass('active');
            $('#listado').addClass('active');
            $('.list').addClass('active');
            $('.new').removeClass('active');
       }
    }
});*/


 /*$('#editar').removeClass('active');
        $('#listado').addClass('active');
        $('.list').addClass('active');
        $('.new').removeClass('active');
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
/*====================================================
=            AUTORIZACIONES MANTENIMIENTO            =
====================================================*/

$(document).on('change', '#selTipo', function() 
{
    if ($('#selTipo').val() == 5) 
    {
        $('#divfoto').show();
        $('#btnIngresarAut2').attr('id', 'btnSendManten');
        $('#btnSendManten').attr('type', 'submit');
    }
    else
    {
        $('#divfoto').hide();
        $('#btnSendManten').attr('id', 'btnIngresarAut2');
    }
});




/*$("#form_confer").on("submit", function(e) 
{
	var selTipo    = $('#selTipo').val();
	var selSubtipo = $('#selSubtipo').val();
	var selSalon   = $('#selSalon').val();
	var selColaborador = $('#selColaborador').val();
	var valor      = $('#valor').val();
	var foto       = $('#foto').val();
	var observacion = $('#observacion').val();
	var fecha      = $('#fecha').val();

	if (selSalon == '0') 
	{
		swal("Seleccione el salón", "Advertencia", "warning");
	}
	else if (valor == '')
	{
           swal("Ingrese el valor", "Advertencia", "warning");
	}
	else if (fecha == '')
	{
           swal("Ingrese la fecha", "Advertencia", "warning");
	}
	else
	{
		$.ajax({
                 url: '../php/auth/loads2.php',
                 method: 'POST',
                 data: {opcion: "mantenimiento", selTipo:selTipo, selSubtipo:selSubtipo, selSalon:selSalon, selColaborador:selColaborador, valor:valor, foto:foto, observacion:observacion, fecha:fecha},
                 success: function (data) 
                 {
                 	     
                 }
		});
	}

});*/


$(function(){
        $("#formNuevaAut").on("submit", function(e){
            e.preventDefault();
            var f = $(this);

            var formData = new FormData(document.getElementById("formNuevaAut"));
            formData.append("opcion","mantenimiento");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "../php/auth/authmantenimiento.php",
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function(res){
                   alert("Respuesta: " + res);
                });
        });
  });

/*=====  End of AUTORIZACIONES MANTENIMIENTO  ======*/

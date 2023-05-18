 /*====================================
 =            Activar Menu            =
 ====================================*/
 
 	$("#side-menu").children('.active').removeClass('active');  
  	$("#CONTABILIDAD").addClass("active");
  	$("#IVA").addClass("active"); 
 
 /*=====  End of Activar Menu  ======*/


 /*====================================
 =            Input Buscar            =
 ====================================*/
 
 
 $(document).ready(function() {
   $('#inputbuscar').keyup(function(){
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "imp_buscar.php",
            data: dataString,
            success: function(data) {
                $('#contenido').html(data);
            }
        });
    });

    $("#btnReporteExcel").on("click", function(){

        window.open("./generarReporteSalones.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=excel");
    });

    $("#btnReportePdf").on("click", function(){

        window.open("./generarReporteSalones.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=pdf");
    });
});
 
 /*=====  End of Input Buscar  ======*/



 /*===============================
 =            Paginar            =
 ===============================*/
 
 function paginar(id) {
    $.ajax({
        type: "POST",
        url: "imp_buscar.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
 
 /*=====  End of Paginar  ======*/

   var inable=0;
   var arr1 = [];
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('#btn_usuarios').click(function () {
        $.ajax({
            url: "usuarios.php"
        }).done(function (html) {
            $('#contenido').html(html);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    });
});
function editar(id) {
    $.ajax({
        type: "POST",
        url: "update_impuesto.php",
        data: {id_mede: id}
    }).done(function (html) {
        $('#contenido').html(html);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
function eliminar(id, este) {
    swal({
                        title: "¿Seguro que desea eliminar este impuesto?",
                        text: "",
                        type: "warning",
                        showCancelButton:  true,
                        cancelButtonText:"No",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sí"

                        
                    },
                    function () {   
                       $.ajax({
                             async: false,
                             type: "POST",
                             url: "update_impuesto.php",
                             data: {
                                id_med: id
                             },
                             success: function(data) {
                              console.log(data);
                              location.reload();
                             }
                            });
                                        
                                });

}



$(document).ready(function () {
    $('#alerta').hide();
    $('#guardar').click(function (event) {
        event.preventDefault();

        var ope = 'insert';
        var id_u = '';
        if ($('#id_usuario').length > 0) {
            if ($('#id_usuario').val() !== '') {
                ope = 'update';
                id_u = $('#id_usuario').val();
            }
        }
        $.ajax({
            type: "POST",
            url: "Cud_usuario.php",
            data: {nombre: $('#nombre').val(), descripcion: $('#descripcion').val(),
                alias: $('#alias').val(), imagen: $('#imagen').val(), nivel:$('#nivel').val(), operacion: ope, id_usuario: id_u}
        }).done(function (msg) {
            if (msg == 'Usuario Actualizado') {
                $.ajax({
                    url: "usuarios.php"
                }).done(function (html) {
                    $('#contenido').html(html);
                }).fail(function () {
                    alert('Error al cargar modulo');
                });
            } else {
                $('#alerta').hide();
                $('#nombre').val('');
                $('#direccion').val('');
                $('#telefono').val('');
                $('#email').val('');
                $('#pwd').val('');
                $('#pwd2').val('');
            }
        }).fail(function () {
            alert("Error enviando los datos. Intente nuevamente");
        });
    });
});


 function adcc () {
  
    if (i<=4) {

        arr1[i]=($('#emailr').val());
       var table = document.getElementById("tbcorreo");
            {
              var row = table.insertRow(0);
              var cell1 = row.insertCell(0);
              cell1.innerHTML = arr1[i];

  }
  $('#qtcr').show();
  $('#emailr').val('');
     i++;
 }else{

    swal("¡Los sentimos solo son adminitidos 5 Correos!")
 }
 
 }
 function env () {
    i=0;
    var tipey
    var tipex
    $('#qtcr').hide();
    $('#tbcorreo').empty();
    $('#emailr').val('');
    $('#rptx').removeAttr('checked');
    $('#rptf').removeAttr('checked');
 $.ajax({
 async: false,
 type: "POST",
 url: "enviar_por_correo_salon.php",
 data: {
     correos: arr1
 },
 success: function(data) {
  swal("Mensaje", data+"!")
 }
});
 arr1=[];
 } 
 function delet() {
   
            swal({
      title: "Estas seguro?",
      text: "Desea remover el ultimo correo adicionado ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, Borrar!",
      closeOnConfirm: false
  
    },

    function(){
        var quit=arr1.pop();
        if (quit!=null) {  
      swal("Deleted!", "El Correo "+quit+" fue removido", "success");
      document.getElementById("tbcorreo").deleteRow(0);
      i--;
        }else{
            $('#qtcr').hide();
            ver=0;
            swal("Error", "No hay correos por Remover");
            showCancelButton: false;
              }
    });
 }  
 $('#rptf').on("click", function(){
             $.ajax({
                 async: false,
                 type: "POST",
                 url: "generarReporteSalones.php",
                 data: {
                     envio: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
           
        }); 
      $('#rptx').on("click", function(){
          
           $.ajax({
                 async: false,
                 type: "POST",
                 url: "generarReporteSalones.php",
                 data: {
                     enviox: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
        }); 


	

	$(document).on('click', '#btnenv', function() {
		var cod   = $('#consec').val();
        var nom   = $('#nmunidad').val();
        var alias = $('#aliass').val();
        var tipo  = $('#tipo_imp').val();
        var valor = $('#val_imp').val();

        if (cod=="" || nom=="" || alias=="" || valor =="") {
	   	console.log("Codigo: "+cod + ", Nombre: " + nom + ", Alias: " + alias + ", Tipo: " + tipo + ", Valor:" + valor);
	        swal("¡Campos vacios!");
	   }else{
	        $.ajax({
	                 async: false,
	                 type: "POST",
	                 url: "imp_adicionar.php",
	                 data: {
	                     cod: cod, nom: nom, alias:alias, tipo:tipo, valor:valor
	                 },
	                 success: function(data) {
	                                swal({
	                                  title: "Mensaje",
	                                  text: data,
	                                  type: "info",
	                                  confirmButtonClass: "btn-success",
	                                  confirmButtonText: "OK",
	                                  confirmButtonColor: "#c9ad7d",
	                                  closeOnConfirm: false
	                              
	                                },

	                                function(){
	                                	/*$.ajax({
	                                     async: false,
	                                     type: "POST",
	                                     url: "update_impuesto.php",
	                                     data: {
	                                         id_mede: 'si', nomb: nom, alia: aliass
	                                     },
	                                     success: function(data) {
	                                      console.log(data);
	                                     location.reload();
	                                     }
	                                    });*/
	                                     location.reload();
	                                  
	                                });
	                    
	                    
	                 }
	                });
	    }  

	});	

 

$('#nmunidad').blur(function(){
        this.value=this.value.toUpperCase();
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "verificar_eliminados.php",
            data: dataString,
            success: function(data) {
                console.log(data);
            }
        });
    });

$('#aliass').blur(function(){
        this.value=this.value.toUpperCase();
        var username = $(this).val();        
        var dataString = 'nomb='+username;

        $.ajax({
            type: "POST",
            url: "verificar_eliminados.php",
            data: dataString,
            success: function(data) {
                console.log(data);
            }
        });
    });
$('#btnenv').click(function  () {
   $.ajax({
    url:"verificar_eliminados.php",
    dataType: 'jsonp',
    success:function(datos){
        inable=1;
        swal("Success");
        $.each(datos, function(indice, valor){
            swal(indice+" : "+valor);
        });
    },
    error:function(){
        inable=0;
    }
});
    // body... 
});
 
 
 


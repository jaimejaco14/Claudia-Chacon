$(document).ready(function() {
    //load_lista_permisos () ;
    tbl_permisos();
});


var  tbl_permisos  = function() { 
   var tbl_est = $('#tbl_permisos_lista').DataTable({
    "ajax": {
      "method": "POST",
      "url": "buscar_permisos.php",
      },
      "columns":[
        {"data": "percodigo"},
        {"data": "trcrazonsocial"},
        {"data": "slnnombre"},
        {"data": "fecha_desde"},
        {"data": "fecha_hasta"},
        {"data": "usu_reg"},
        {"data": "fecha"},
        {"data": "usu_aut"},
        {"data": "estado_tramite"},
        {"defaultContent": "<button type='button' id='btn_ver_permiso' title='Click para ver los detalles' class='btn btn-link text-info'><i class='fa fa-search'></i></button><button type='button' id='btnDelete' title='Click para eliminar' class='btn btn-link text-danger' style='margin-left: 3px'><i class='fa fa-times'></i></button>"},
      ],"language":{
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrada de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search": "Buscar: ",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
          "next":       "Siguiente",
          "previous":   "Anterior"
        } 
        },  
         "columnDefs":[
              {className:"idpermiso","targets":[0]}
            ], 
             
        "order": [[0, "desc"]],
         "bDestroy": true,
  });
};


$(document).ready(function() {
    
     $('#tbl_permisos_lista tbody').on('click', '#btn_ver_permiso', function() 
     {
           $('#modal_ver_permisos').modal("show");
           var $row = $(this).closest("tr");    // Find the row
           var $id = $row.find(".sorting_1").text(); // Find the text
           var cod = $id;
              $.ajax({
                url: 'listar_detalle_permiso.php',
                method: 'POST',
                data: {cod: cod},
                success: function (data) 
                {
                    var array = eval(data);
                    $('#radio_aut').empty();
                        $('#btn_autorizar').removeClass('disabled');
                    for(var i in array)
                    {
                        $('#txt_codigo').val(array[i].id);
                        $('#txt_colaborador').val(array[i].colaborador);
                        $('#cod_col').val(array[i].codcolab);
                        $('#txt_fecha').val(array[i].fecha);
                        $('#txt_perdesde').val(array[i].desde);
                        $('#txt_perhasta').val(array[i].hasta);
                        $('#txt_usureg').val(array[i].usu_reg);
                        $('#txt_usuaut').val(array[i].usu_aut);
                        $('#txt_comentario').val(array[i].observacion); 
                        $('#txt_fecha_aut').val(array[i].fecha_aut); 

                        var permiso = "";

                        switch (array[i].estado) 
                        {
                            case 'REGISTRADO':
                                permiso = '<label><input type="radio" name="autorizar" id="aut" value="Autorizado">Autorizar</label><div class="radio" id="aut"><label><input type="radio" name="autorizar" id="aut" value="Noautorizado">No autorizar</label></div>';
                               
                                break;

                            case 'AUTORIZADO':
                                $('#btn_autorizar').addClass('disabled');

                                break;

                            case 'NO AUTORIZADO':
                                  $('#btn_autorizar').addClass('disabled');
                                break;
                            default:
                                // statements_def
                                break;
                        }                       

                        $('#radio_aut').append(permiso);                        
                    }
                    
                }
              });
     });
});


$(document).on('click', '#btn_autorizar', function() 
{
    var idpermiso  = $('#txt_codigo').val();
    var comentario = $('#comen_autor').val();
    var aut        = $("input[name='autorizar']:checked").val();

    if ($("input[name='autorizar']:checked").length<=0) 
    {
        swal("No ha seleccionado una opción", "", "warning");
    }
    else
    {

        $.ajax({
            url: 'autorizar_permiso.php',
            method: 'POST',
            data: {idpermiso:idpermiso, comentario:comentario, aut:aut},
            success: function (data) 
            {
                if (data == 1) 
                {
                    swal("Permiso otorgado", "", "success");
                    tbl_permisos();
                    $('#modal_ver_permisos').modal("hide");
                }
                else
                {
                    swal("Permiso denegado", "", "success");
                    tbl_permisos();
                    $('#modal_ver_permisos').modal("hide");
                }
            }
        });
    }

  
        
});

//ELiminar Permiso
//


$('#tbl_permisos_lista tbody').on('click', '#btnDelete', function() 
{
           var $row = $(this).closest("tr");    // Find the row
           var $id = $row.find(".sorting_1").text(); // Find the text
           var cod = $id;

           swal({
          title: "¿Desea eliminar permiso?",
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
                url: 'eliminarPermiso.php',
                method: 'POST',
                data: {cod:cod},
                success: function (data) {
                    if (data == 1) {
                        swal("Eliminado!", "Se ha eliminado el permiso.", "success");
                        tbl_permisos();
                    }
                }
            });
          }else{
            swal("Cancelado");
          } 
        });

           

           

});


/*function load_lista_permisos () {
        $.ajax({
            url: 'buscar_permisos.php',
            method: 'POST',
            data: {opcion: 'lista'},
            success: function (data) 
            {
                var array = eval(data);
                if (array != 1) 
                {
                    $('#tbl_permisos tbody').empty();
                    for(var i in array)
                    {

                         switch (array[i].estado_per) 
                        {
                            case '0':
                                estado_permiso = '<center><div class="checkbox checkbox-inline"><input type="checkbox" data-idpermiso="'+array[i].idpermiso+'" id="check_autorizar" value="1" ><label for="inlineCheckbox1"></label></div></center>';
                                break;

                            case '1':
                                estado_permiso = '<center><div class="checkbox checkbox-inline"><input type="checkbox" data-idpermiso="'+array[i].idpermiso+'" checked id="check_autorizar" value="0"><label for="inlineCheckbox1"></label></div></center>';
                                break;
                            default:
                                estado_permiso;
                                break;
                        }

                        $('#tbl_permisos tbody').append('<tr id="rows"><td>'+array[i].idpermiso+'</td><td>'+array[i].fecha_reg+'</td><td>'+array[i].observacion+'</td><td>'+array[i].colaborador+'</td><td>'+array[i].fecha_desde+'</td><td>'+array[i].fecha_hasta+'</td><td>'+array[i].usuario_reg+'</td><td>'+array[i].usuario_aut+'</td><td>'+array[i].fecha_aut+'</td><td>'+estado_permiso+'</td></tr>');
                    }

                }
                else
                {
                    $('#tbl_permisos tbody').empty();
                    $('#tbl_permisos tbody').append('<tr><td colspan="10"><center><b>No hay permisos asignados</b></center></td></tr>');
                }
            }
         });
    }


    $(document).on('click', '#check_autorizar', function()
    {
        if( $(this).is(':checked') ) 
        {
            
            var idpermiso = $(this).data("idpermiso");

            $.ajax({
                url: 'buscar_permisos.php',
                method: 'POST',
                data: {aut: '1', idpermiso:idpermiso, opcion: 'autorizar'},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                        swal("Permiso autorizado", "", "success");
                        load_lista_permisos () ;
                    }
                }
            });
        }
        else 
        {
            
            var idpermiso = $(this).data("idpermiso");
            $.ajax({
                url: 'buscar_permisos.php',
                method: 'POST',
                data: {aut:'0', idpermiso:idpermiso, opcion: 'autorizar'},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                        swal("Permiso revocado", "", "success");
                        load_lista_permisos () ;
                    }
                }
            });
        }
    });*/


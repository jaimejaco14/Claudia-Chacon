 /*====================================
 =            Activar Menu            =
 ====================================*/
 
 	$("#side-menu").children('.active').removeClass('active');  
  	$("#INVENTARIO").addClass("active");
  	$("#PRODUCTOS").addClass("active"); 
 
 /*=====  End of Activar Menu  ======*/


 /*==================================================
 =            THU LISTADO DE PRODUCTOS            =
 ==================================================*/


  $(document).ready(function() {
    var no_reg = $('#no_reg').val();
    if (no_reg > 0)  {      
    }else{
      $('#btn_enviar_correo').css("display", "none");
      $('#btn_reporte_pdf').css("display", "none");
      $('#btn_reporte_excel').css("display", "none");
    }
    cargar_productos ();
    $('.edit').attr('disabled', true); //add

    function cargar_productos () {
       $.ajax({
         url: 'listado_productos.php',
         success: function (data) {
          $('#tumb_productos').empty();                       
          if (data != ".") {
            $('#tumb_productos').html(data);
          }else{
              swal({
                title: "Aún no hay productos registrados.",
                text: "Ingrese Producto",
                type: "error",
              },                                
              function () {                                  
                 $('.lista').removeClass("active"); 
                 $('.nuevo').addClass("active");
                 $('.panel_nuevo').removeClass("active"); 
                 $('.panel_n').addClass("active");  
                 $('#tumb_productos').remove();
                 $('.lista').addClass("disabled");
                 $('.tab_lista').addClass("disabled");
                 $('.tab_lista').click(function(e) { return false; }); 
                 $('#edit_prod').click(function(e) { return false; }); 
              }); 
          }
              
         }
       });
     }


function load_impuesto_edit (cod_prod) {
  var cod_prod = $("#tabla_edit_prod tbody tr #id_prod").data("id_prod");

    $.ajax({
        url: 'cargar_impuestos.php',
        method: 'POST',
        data: {cod_prod:cod_prod},
        success: function (data) {
            $('#impuesto').html(data);
        }
    });
}

function load_unimedida_edit (cod_prod) {
  var cod_prod = $("#tabla_edit_prod tbody tr #id_prod").data("id_prod");

    $.ajax({
        url: 'cargar_unidadmedida.php',
        method: 'POST',
        data: {cod_prod:cod_prod},
        success: function (data) {
            $('#unimedida').html(data);
        }
    });
}



$(document).on('click', '#btn_edit_prod', function() {
    var cod_prod = $(this).data("id");
    $('.tab-pane').removeClass("active");
    $('.lista').removeClass("active");
    $('.edit').addClass("active");
    $('.panel-edit').addClass("active");
    $('#stn_info').css("display", "none");
    

    $.ajax({
        url: 'edit_producto.php',
        method: 'POST',
        data: {cod_prod:cod_prod},
        success: function (data) {
          
            var array = eval(data);
            for(var i in array){

              switch (array[i].porcionado) {
                case "1":
                  porcionado = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='porcionado' name='porcionado' value='"+array[i].porcionado+"' checked> Porcionado</label></div></div></div>";
                  break;
                case "0":
                   porcionado = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='porcionado' name='porcionado' value='"+array[i].porcionado+"'> Porcionado</label></div></div></div>";
                  break;

                default:
                  porcionado="";
                  break;
              }

              switch (array[i].ctrl_venc) {
                case "1":
                  control_ven = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='control_ven' name='control_ven' value='"+array[i].ctrl_venc+"' checked> Ctrl Venc</label></div></div></div>";
                  break;
                case "0":
                   control_ven = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='control_ven' name='control_ven' value='"+array[i].ctrl_venc+"'> Ctrl Venc</label></div></div></div>";
                  break;

                default:
                  control_ven="";
                  break;
              }

              switch (array[i].preciof) {
                case "1":
                  precio_fijo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='precio_fijo' name='precio_fijo' value='"+array[i].preciof+"' checked> Precio Fijo</label></div></div></div>";
                  break;
                case "0":
                   precio_fijo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='precio_fijo' name='precio_fijo' value='"+array[i].preciof+"'> Precio Fijo</label></div></div></div>";
                  break;

                default:
                  precio_fijo="";
                  break;
              }

              switch (array[i].activo) {
                case "1":
                  activo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='activo_chk' name='activo' value='"+array[i].activo+"' checked> Activo</label></div></div></div>";
                  break;
                case "0":
                   activo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='activo_chk' name='activo' value='"+array[i].activo+"'> Activo</label></div></div></div>";
                  break;

                default:
                  activo="";
                  break;
              }

              switch (array[i].tipo_comis) {
                case "FIJO":
                  tipo_comision = "<div class='col-md-6'><div class='form-group'><label>Tipo Comisión</label><select name='tipo_comision' id='tipo_comision' class='form-control'><option value='FIJO' selected>VALOR FIJO</option><option value='PORCENTUAL'>PORCENTUAL</option></select></div></div>";
                  break;
                case "PORCENTUAL":
                    tipo_comision = "<div class='col-md-6'><div class='form-group'><label>Tipo Comisión</label><select name='tipo_comision' id='tipo_comision' class='form-control'><option value='PORCENTUAL' selected>PORCENTUAL</option><option value='FIJO'>VALOR FIJO</option></select></div></div>";
                  break;

                default:
                  tipo_comision="";
                  break;
              }

              switch (array[i].actualiz) {
                case null:
                   actualizacion = "<div class='panel-footer'> Creación: "+array[i].creacion+"</div>";
                  break;
                    
                default:
                 actualizacion = "<div class='panel-footer'> Creación: "+array[i].creacion+" <span  class='pull-right'>Últ. Actualización:  "+array[i].actualiz+"</span></div>";
                  break;
              }


                $('#edicion').empty();
                $('#edicion').append('<div class="col-lg-4"><div class="hpanel"><div class="panel-heading hbuilt"><a href="javascript:void(0)" type="button" id="btn_remove_img" data-toggle="tooltip" data-placement="top" title="Remover imagen"><span class="pull-right"><i class="fa fa-trash"></i></span>'+array[i].producto+'</div><div class="panel-body no-padding"><center><a href="javascript:void(0)" type="button" id="" data-id="codigo "><img class="img-responsive img-thumbnail img-rounded" id="img_prod" src="'+array[i].imagen+' " style="width: 250px; height: 250px"></a></center><ul class="list-group"><li class="list-group-item"><span class="pull-right">'+array[i].alias+'</span><b>ALIAS</b></li><li class="list-group-item "><span class="pull-right">'+array[i].grupo+'</span><b>GRUPO</b></li><li class="list-group-item"><span class="pull-right">'+array[i].pro_codigo+'</span><b>CÓDIGO</b></li></ul></div>'+actualizacion+'</div></div><div class="col-lg-8"><form id="formulario_edicion_prod" name="formulario_edicion_prod" enctype="multipart/form-data"><div class="col-md-6"><div class="form-group"><label for="">Nombre del Producto</label><input type="text" name="txt_nombre" class="form-control" id="producto" value="'+array[i].producto+'" placeholder="Nombre del Producto"></div></div><div class="col-md-6"><div class="form-group"><label for="">Código Anterior</label><input type="number" name="txt_cod_anterior" class="form-control" value="'+array[i].cod_anter+'" id="cod_anterior2" placeholder="Código Anterior"></div></div><div class="col-md-6"><div class="form-group"><label for="">Alias</label><input type="text" maxlength="10" name="txt_alias" class="form-control" value="'+array[i].alias+'" id="" placeholder="Alias"></div></div><div class="col-md-6"><div class="form-group"><label for="">Seleccione Imagen</label><input type="file" name="file_edit" id="file_edit" class="form-control file_edit" title=""></div></div><div class="col-md-6"><div class="form-group"><label for="">Impuesto</label><select name="impuesto" id="impuesto" class="form-control" title=""><option value="'+array[i].cod_impue+'" selected>'+array[i].impuesto+'</option></select></div></div><div class="col-md-6"><div class="form-group"><label for="">Unidad de Medida</label><select name="unimedida" id="unimedida" class="form-control" title=""><option value="'+array[i].cod_unimed+'" selected>'+ array[i].unimedida +' </option></select></div></div>'+tipo_comision+'<div class="col-md-6"><div class="form-group"><label for=""> Comisión </label><input type="number" class="form-control" name="comision" id="comision" value="'+array[i].comision+'"></div></div><div class="col-md-6"><div class="form-group"><label for=""> Costo Inicial </label><input type="number" class="form-control" name="costo_inicial" id="costo_inicial" value="'+array[i].costo_ini+'"></div></div><div class="col-md-12"><textarea name="txt_descripcion" id="input" class="form-control" rows="3">'+array[i].descripcion+'</textarea></div><div class="col-md-12">'+porcionado+' '+control_ven+' '+precio_fijo+' '+activo+'<hr><button class="btn btn-link" id="btn_edit_cat" type="button"><i class="fa fa-edit"></i> Editar categorías </button><div class="row"><div class="col-md-12" style="display: none" id="categorias"><div class="col-md-6"><div class="form-group"><label class="control-label">Grupo</label><div class="input-group"><select name="sel_grupo_" id="sel_grupo_" required class="form-control"></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" disabled data-toggle="modal" data-target="#modal" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default"><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Sub-grupo</label><div class="input-group"><select name="subgrupo_edit" id="subgrupo_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Línea</label><div class="input-group"><select name="linea_edit" id="linea_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modal" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Sub-Línea</label><div class="input-group"><select name="sublinea_edit" id="sublinea_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Características</label><div class="input-group"><select name="caract_edit" id="caract_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><hr></div><div class="table-responsive"><table class="table table-hover table-bordered" id="tabla_edit_prod"><thead><tr><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th>Grupo</th><th>Subgrupo</th><th>Línea</th><th>Sublínea</th><th>Característica</th></tr></thead><tbody><tr><td data-id_grupo="'+array[i].cod_grupo+'" style="display:none" id="id_grupo"></td><td data-id_prod="'+array[i].pro_codigo+'" style="display:none" id="id_prod"></td><td data-id_subgr="'+array[i].cod_subgru+'" style="display:none" id="id_subgr"></td><td data-id_linea="'+array[i].cod_line+'" style="display:none" id="id_linea"></td><td data-id_sublinea="'+array[i].cod_subline+'" style="display:none" id="id_sublinea"></td><td data-id_categoria="'+array[i].cod_carac+'" style="display:none" id="id_categoria"></td><td>'+array[i].grupo+'</td><td>'+array[i].subgrupo+'</td><td>'+array[i].linea+'</td><td>'+array[i].sublinea+'</td><td data-idcar="'+array[i].cod_carac+'" id="idcar">'+array[i].caract+'</td></tr></tbody></table></div></div><hr><button type="button" name="button_edit" id="button_edit" class="btn btn-success pull-right">Modificar</button><button type="button" name="button_elim" data-id="'+array[i].pro_codigo+'" id="button_elim" class="btn btn-default pull-right" style="margin-right: 18px">Eliminar</button></form></div>');

                        /******* FORMULARIO PARA EDITAR *********/



            }
            load_impuesto_edit ();
            load_unimedida_edit();
        }
    });


    //$('#pol').html("Codigo del prod "+ cod_prod);

});

$(document).on('click', '#edit_prod', function() {
  $('.edit').removeClass('active');
  $('.lista').addClass("active");
     //$('#data_prod').empty();
     //$('#stn_info').html("No ha seleccionado ningún producto");
});


/************************************************/
load_sel_grupo ();
function load_sel_grupo () {
    $.ajax({
        url: 'grupo_sel_grupo.php',
        success: function (data) {
            $('#sel_grupo').html(data);
        }
    });
}

function load_subsel_grupo () {
  var grupo = $('#sel_grupo').val();
    $.ajax({
        url: 'cargar_subgrupo_sel_load.php',
        method: 'POST',
        data: {grupo:grupo},
        success: function (data) {
            $('#sel_subgrupo').html(data);
        }
    });
}

function load_sel_linea () {
  var subgrupo = $('#sel_subgrupo').val(); 
    $.ajax({
        url: 'cargar_linea_sel.php',
        method: 'POST',
        data: {subgrupo:subgrupo},
        success: function (data) {
            $('#linea').html(data);
        }
    });
}


function load_sel_sub_linea () {
  var linea = $('#linea').val();
    $.ajax({
        url: 'cargar_sublinea_sel.php',
        method: 'POST',
        data: {linea:linea},
        success: function (data) {
            $('#sublinea').html(data);
        }
    });
}


function load_sel_caracteristica () {
  var sublinea = $('#sublinea').val();
    $.ajax({
        url: 'cargar_caracteristicas_sel.php',
        method: 'POST',
        data: {sublinea:sublinea},
        success: function (data) {
            $('#caracteristicas').html(data);
        }
    });
}


/*cascada de select********************************************************/
$(document).on('change', '#sel_grupo', function() {
      var grupo = $('#sel_grupo').val(); 
      $.ajax({
          url: 'cargar_subgrupo_sel.php',
          method: 'POST',
          data: {grupo: grupo},
          success: function (data) {
              $('#sel_subgrupo').html(data);
              $('#sel_subgrupo').prop("disabled", false);
              $('.btn_grp').prop("disabled", false);
              $("#linea").empty();
              $("#sublinea").empty();
              $("#caracteristicas").empty();
          }
      }); 
});

$(document).on('change', '#sel_subgrupo', function() {
      var subgrupo = $('#sel_subgrupo').val(); 
      $.ajax({
          url: 'cargar_linea_sel.php',
          method: 'POST',
          data: {subgrupo: subgrupo},
          success: function (data) {
              $('#linea').html(data);
              $('#linea').prop("disabled", false);
              $('.btn_lin').prop("disabled", false);
              $("#sublinea").empty();
              $("#caracteristicas").empty();

          }
      }); 
});

$(document).on('change', '#linea', function() {
      var linea = $('#linea').val(); 
      $.ajax({
          url: 'cargar_sublinea_sel.php',
          method: 'POST',
          data: {linea: linea},
          success: function (data) {
              $('#sublinea').html(data);
              $('#sublinea').prop("disabled", false);
              $('.btn_sublin').prop("disabled", false);
          }
      }); 
});

$(document).on('change', '#sublinea', function() {
      var sublinea = $('#sublinea').val(); 
      $.ajax({
          url: 'cargar_caracteristicas_sel.php',
          method: 'POST',
          data: {sublinea: sublinea},
          success: function (data) {
              $('#caracteristicas').html(data);
              $('#caracteristicas').prop("disabled", false);
              $('.btn_car').prop("disabled", false);
          }
      }); 
});


/*Fin cascada select*******************************************************/


$(function(){
  $("#form_nuevo_grupo").on("submit", function(e){
     var grupo      = $('#txt_grupo').val();
     var alias      = $('#txt_alias').val();
     var descr      = $('#txt_descripcion').val();

      //formData.append(grupo, cat, tit, sub);
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("form_nuevo_grupo"));

      //formData.append(f.attr("name"), $(this)[0].files[0]);
      $.ajax({
          url: "prod_nuevo_grupo.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
            $('#file').val("");
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error'
                }).then(function () {
                    /*$('#file').val(""); 
                    $('#sel_categ').val("");
                    $('#txt_titulo').val("");
                    $('#txt_post').val("");
                    $('#subtitulo').val("");  */                 
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{
                     
                        if (data == 4) {
                                swal({
                                  title: "Ingreso correcto.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {                                  
                                   load_sel_grupo ();
                                     $('#modalGrupo').modal("hide");
                                     $('#txt_grupo').val("");
                                     $('#txt_alias').val("");
                                     $('#txt_descripcion').val("");   
                                     $('#modalGrupo').on('shown.bs.modal', function () {
                                        $('#file').val("");
                                      });                             

                                });                        
                        }
                 }
             }
          }
      });
 });          
});


/************************************************/

$(function(){
  $("#form_nuevo_subgrupo").on("submit", function(e){
     var grupo         = $('#sel_grupo').val();
     var subgrupo      = $('#txt_subgrupo').val();
     var subalias      = $('#txt_subalias').val();
     var subdescr      = $('#txt_subdescripcion').val();

     //formData.append(grupo, cat, tit, sub);
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("form_nuevo_subgrupo"));
      formData.append('grupo', grupo);

      //formData.append(f.attr("name"), $(this)[0].files[0]);
      $.ajax({
          url: "prod_nuevo_subgrupo.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error',
                }).then(function () {              
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{                     
                        if (data == 4) {
                                swal({
                                  title: "Ingreso correcto.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {
                                   load_subsel_grupo ();
                                       $('#modalSubgrupo').modal("hide");
                                       $('#txt_subgrupo').val("");
                                       $('#txt_subalias').val("");
                                       $('#txt_subdescripcion').val("");   
                                       $('#modalSubgrupo').on('shown.bs.modal', function () {
                                          $('#subfile').val("");
                                       });                             

                                });
                        }
                 }
             }
          }
      });
 });          
});

/****************************************/

$(function(){
  $("#form_nueva_linea").on("submit", function(e){
     var subgrupo         = $('#sel_subgrupo').val();
     var linea            = $('#txt_linea').val();
     var linalias         = $('#txt_lin_alias').val();
     var lindescr         = $('#txt_lin_descricpion').val();

      //formData.append(grupo, cat, tit, sub);
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("form_nueva_linea"));
      formData.append('subgrupo', subgrupo);

      //formData.append(f.attr("name"), $(this)[0].files[0]);
      $.ajax({
          url: "prod_nueva_linea.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error'
                }).then(function () {              
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{
                     
                        if (data == 4) {
                                swal({
                                  title: "Ingreso correcto.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {
                                   load_sel_linea ();
                                       $('#modalLinea').modal("hide");
                                       $('#txt_linea').val("");
                                       $('#txt_lin_alias').val("");
                                       $('#txt_lin_descricpion').val("");   
                                       $('#modalLinea').on('shown.bs.modal', function () {
                                          $('#lin_file').val("");
                                       });                             

                                });
                        }
                 }
             }
          }
      });
 });          
});


/****************************************/

$(function(){
  $("#form_nueva_sublinea").on("submit", function(e){
     var linea                = $('#linea').val();
     var sublinea             = $('#txt_sublinea').val();
     var sublinalias          = $('#txt_sublin_alias').val();
     var sublindescr          = $('#txt_sublin_descricpion').val();

      //formData.append(grupo, cat, tit, sub);
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("form_nueva_sublinea"));
      formData.append('linea', linea);

      //formData.append(f.attr("name"), $(this)[0].files[0]);
      $.ajax({
          url: "prod_nueva_sublinea.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error'
                }).then(function () {              
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{
                     
                        if (data == 4) {
                                swal({
                                  title: "Ingreso correcto.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {
                                   load_sel_sub_linea ();
                                       $('#modalSublinea').modal("hide");
                                       $('#txt_sublinea').val("");
                                       $('#txt_sublin_alias').val("");
                                       $('#txt_sublin_descricpion').val("");   
                                       $('#modalSublinea').on('shown.bs.modal', function () {
                                          $('#sublin_file').val("");
                                       });                             

                                });
                        }
                 }
             }
          }
      });
 });          
});


/****************************************/

$(function(){
  $("#form_nueva_caracteristica").on("submit", function(e){
     var sublinea             = $('#sublinea').val();
     var caracter             = $('#txt_caracteristica').val();
     var car_alias            = $('#txt_car_alias').val();
     var car_descri           = $('#txt_car_descp').val();

      //formData.append(grupo, cat, tit, sub);
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("form_nueva_caracteristica"));
      formData.append('sublinea', sublinea);

      //formData.append(f.attr("name"), $(this)[0].files[0]);
      $.ajax({
          url: "prod_nueva_caracteristica.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error'
                }).then(function () {              
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{
                    
                        if (data == 4) {
                                swal({
                                  title: "Ingreso correcto.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {
                                   load_sel_caracteristica ();
                                       $('#modalCarac').modal("hide");
                                       $('#txt_caracteristica').val("");
                                       $('#txt_car_alias').val("");
                                       $('#txt_car_descp').val("");   
                                       $('#modalCarac').on('shown.bs.modal', function () {
                                          $('#car_file').val("");
                                       });                             

                                });
                        }
                 }
             }
          }
      });
 });          
});


/**********************************************/

load_impuesto ();
function load_impuesto () {
    $.ajax({
        url: 'cargar_impuesto_sel.php',
        success: function (data) {
            $('#sel_impuesto').html(data);
        }
    });
}


load_unimedida ();
function load_unimedida () {
    $.ajax({
        url: 'cargar_medida_sel.php',
        success: function (data) {
            $('#sel_unimedida').html(data);
        }
    });
}


$(document).on('blur', '#cod_anterior', function() {
    var cod_ant = $('#cod_anterior').val();
    $.ajax({
        url: 'validar_cod_anterior.php',
        method: 'POST',
        data: {cod_ant: cod_ant, caso: 1},
        success: function (data) {
            if (data == 1) {
                swal("Este código ya está registrado.", ""+cod_ant+"", "error");
            }
        }
    });
});

$(document).on('blur', '#cod_anterior2', function() {
    var cod_ant = $('#cod_anterior2').val();
    $.ajax({
        url: 'validar_cod_anterior.php',
        method: 'POST',
        data: {cod_ant: cod_ant, caso: 2},
        success: function (data) {
            if (data == 1) {
                swal("Este código ya está registrado.", ""+cod_ant+"", "error");
            }
        }
    });
});




$(function(){
  $("#nuevo_producto").on("submit", function(e){
      e.preventDefault();
      var f = $(this);
      var formData = new FormData(document.getElementById("nuevo_producto"));
      console.log(formData);

      $.ajax({
          url: "prod_add_nuevo_producto.php",
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          //beforeSend: function() { },
          //complete: function()   { },
          success: function (data) {
            console.log(data);
            if(data==0){
              console.log('cero');
            }
             if (data == 1) {
              swal({
                  title: 'Solo se permiten formatos JPG.',
                  type: 'error'
                }).then(function () {              
                    
                });
             }else{
                 if (data == 2) {
                    swal({
                        title: 'Se ha excedido el tamaño.',
                        type: 'error',
                        text: 'Solo se permite tamaño xxx por xxx'
                      }).then(function () {                      
                          
                      });
                 }else{
                        if (data == 4) {
                                swal({
                                  title: "Producto Guardado.",
                                  text: "",
                                  type: "success",
                                },                                
                                function () {
                                  location.reload();


                                });
                        }
                     }
             }
          }
      });
 });          
});

function prod (id) {

    $('.tab-pane').removeClass("active");
    $('.lista').removeClass("active");
    $('.edit').addClass("active");
    $('.panel-edit').addClass("active");
    $('#stn_info').css("display", "none");
    $('.nuevo').removeClass('active');
    //$('.nuevo').removeClass("active");
    console.log(id);
    

    $.ajax({
        url: 'edit_producto.php',
        method: 'POST',
        data: {cod_prod:id},
        success: function (data) { 
        console.log(data);         
            var array = eval(data);
            for(var i in array){


              switch (array[i].porcionado) {
                case "1":
                  porcionado = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='porcionado' name='porcionado' value='"+array[i].porcionado+"' checked> Porcionado</label></div></div></div>";
                  break;
                case "0":
                   porcionado = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='porcionado' name='porcionado' value='"+array[i].porcionado+"'> Porcionado</label></div></div></div>";
                  break;

                default:
                  porcionado="";
                  break;
              }

              switch (array[i].ctrl_venc) {
                case "1":
                  control_ven = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='control_ven' name='control_ven' value='"+array[i].ctrl_venc+"' checked> Ctrl Venc</label></div></div></div>";
                  break;
                case "0":
                   control_ven = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='control_ven' name='control_ven' value='"+array[i].ctrl_venc+"'> Ctrl Venc</label></div></div></div>";
                  break;

                default:
                  control_ven="";
                  break;
              }

              switch (array[i].preciof) {
                case "1":
                  precio_fijo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='precio_fijo' name='precio_fijo' value='"+array[i].preciof+"' checked> Precio Fijo</label></div></div></div>";
                  break;
                case "0":
                   precio_fijo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='precio_fijo' name='precio_fijo' value='"+array[i].preciof+"'> Precio Fijo</label></div></div></div>";
                  break;

                default:
                  precio_fijo="";
                  break;
              }

              switch (array[i].activo) {
                case "1":
                  activo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='activo_chk' name='activo' value='"+array[i].activo+"' checked> Activo</label></div></div></div>";
                  break;
                case "0":
                   activo = "<div class='col-md-3'><div class='form-group' style='float:left; margin-right: 8px'><div class='checkbox'><label><input type='checkbox' id='activo_chk' name='activo' value='"+array[i].activo+"'> Activo</label></div></div></div>";
                  break;

                default:
                  activo="";
                  break;
              }

            switch (array[i].tipo_comis) {
                case "FIJO":
                  tipo_comision = "<div class='col-md-6'><div class='form-group'><label>Tipo Comisión</label><select name='tipo_comision' id='tipo_comision' class='form-control'><option value='FIJO' selected>VALOR FIJO</option><option value='PORCENTUAL'>PORCENTUAL</option></select></div></div>";
                  break;
                case "PORCENTUAL":
                    tipo_comision = "<div class='col-md-6'><div class='form-group'><label>Tipo Comisión</label><select name='tipo_comision' id='tipo_comision' class='form-control'><option value='PORCENTUAL' selected>PORCENTUAL</option><option value='FIJO'>VALOR FIJO</option></select></div></div>";
                  break;

                default:
                  tipo_comision="";
                  break;
              }
                

              switch (array[i].actualiz) {
                case null:
                   actualizacion = "<div class='panel-footer'> Creación: "+array[i].creacion+"</div>";
                  break;
                    
                default:
                 actualizacion = "<div class='panel-footer'> Creación: "+array[i].creacion+" <span  class='pull-right'>Últ. Actualización:  "+array[i].actualiz+"</span></div>";
                  break;
              }


                $('#edicion').empty();
                $('#edicion').append('<div class="col-lg-4"><div class="hpanel"><div class="panel-heading hbuilt"><span class="pull-right" id="btn_remove_img" data-toggle="tooltip" title="Remover imagen" data-placement="top"><i class="fa fa-trash"></i></span>'+array[i].producto+'</div><div class="panel-body no-padding"><center><a href="javascript:void(0)" type="button" id="btn_edit_prod" data-id="codigo "><img class="img-responsive img-thumbnail img-rounded" id="img_prod" src="'+array[i].imagen+'" style="width: 250px; height: 250px"></a></center><ul class="list-group"><li class="list-group-item"><span class="pull-right">'+array[i].alias+'</span><b>ALIAS</b></li><li class="list-group-item "><span class="pull-right">'+array[i].grupo+'</span><b>GRUPO</b></li><li class="list-group-item"><span class="pull-right">'+array[i].pro_codigo+'</span><b>CÓDIGO</b></li></ul></div>'+actualizacion+'</div></div><div class="col-lg-8"><form id="formulario_edicion_prod" name="formulario_edicion_prod" enctype="multipart/form-data"><div class="col-md-6"><div class="form-group"><label for="">Nombre del Producto</label><input type="text" name="txt_nombre" class="form-control" id="producto" value="'+array[i].producto+'" placeholder="Nombre del Producto"></div></div><div class="col-md-6"><div class="form-group"><label for="">Código Anterior</label><input type="number" name="txt_cod_anterior" class="form-control" value="'+array[i].cod_anter+'" id="cod_anterior2" placeholder="Código Anterior"></div></div><div class="col-md-6"><div class="form-group"><label for="">Alias</label><input type="text" maxlength="10" name="txt_alias" class="form-control" value="'+array[i].alias+'" id="" placeholder="Alias"></div></div><div class="col-md-6"><div class="form-group"><label for="">Seleccione Imagen</label><input type="file" name="file_edit" id="file_edit" class="form-control file_edit" title=""></div></div><div class="col-md-6"><div class="form-group"><label for="">Impuesto</label><select name="impuesto" id="impuesto" class="form-control" title=""><option value="'+array[i].cod_impue+'" selected>'+array[i].impuesto+'</option></select></div></div><div class="col-md-6"><div class="form-group"><label for="">Unidad de Medida</label><select name="unimedida" id="unimedida" class="form-control" title=""><option value="'+array[i].cod_unimed+'" selected>'+ array[i].unimedida +' </option></select></div></div>'+tipo_comision+'<div class="col-md-6"><div class="form-group"><label for=""> Comisión </label><input type="number" class="form-control" name="comision" id="comision" value="'+array[i].comision+'"></div></div><div class="col-md-6"><div class="form-group"><label for=""> Costo Inicial </label><input type="number" class="form-control" name="costo_inicial" id="costo_inicial" value="'+array[i].costo_ini+'"></div></div><div class="col-md-12"><textarea name="txt_descripcion" id="input" class="form-control" rows="3">'+array[i].descripcion+'</textarea></div><div class="col-md-12">'+porcionado+' '+control_ven+' '+precio_fijo+' '+activo+'<hr><button class="btn btn-link" id="btn_edit_cat" type="button"><i class="fa fa-edit"></i> Editar categorías </button><div class="row"><div class="col-md-12" style="display: none" id="categorias"><div class="col-md-6"><div class="form-group"><label class="control-label">Grupo</label><div class="input-group"><select name="sel_grupo_" id="sel_grupo_" required class="form-control"></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" disabled data-toggle="modal" data-target="#modal" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default"><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Sub-grupo</label><div class="input-group"><select name="subgrupo_edit" id="subgrupo_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Línea</label><div class="input-group"><select name="linea_edit" id="linea_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modal" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Sub-Línea</label><div class="input-group"><select name="sublinea_edit" id="sublinea_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><div class="col-md-6"><div class="form-group"><label class="control-label">Características</label><div class="input-group"><select name="caract_edit" id="caract_edit" required class="form-control"><option></option></select><div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo"><button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled><span class="fa fa-plus-square text-info"></span></button></div></div></div></div><hr></div><div class="table-responsive"><table class="table table-hover table-bordered" id="tabla_edit_prod"><thead><tr><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th>Grupo</th><th>Subgrupo</th><th>Línea</th><th>Sublínea</th><th>Característica</th></tr></thead><tbody><tr><td data-id_grupo="'+array[i].cod_grupo+'" style="display:none" id="id_grupo"></td><td data-id_prod="'+array[i].pro_codigo+'" style="display:none" id="id_prod"></td><td data-id_subgr="'+array[i].cod_subgru+'" style="display:none" id="id_subgr"></td><td data-id_linea="'+array[i].cod_line+'" style="display:none" id="id_linea"></td><td data-id_sublinea="'+array[i].cod_subline+'" style="display:none" id="id_sublinea"></td><td data-id_categoria="'+array[i].cod_carac+'" style="display:none" id="id_categoria"></td><td>'+array[i].grupo+'</td><td>'+array[i].subgrupo+'</td><td>'+array[i].linea+'</td><td>'+array[i].sublinea+'</td><td data-idcar="'+array[i].cod_carac+'" id="idcar">'+array[i].caract+'</td></tr></tbody></table></div></div><hr><button type="button" name="button_edit" id="button_edit" class="btn btn-success pull-right">Modificar</button><button type="button" name="button_elim" data-id="'+array[i].pro_codigo+'" id="button_elim" class="btn btn-default pull-right" style="margin-right: 18px">Eliminar</button></form></div>');

                        /******* FORMULARIO PARA EDITAR *********/



            }
            load_impuesto_edit ();
            load_unimedida_edit();
        }
    });



}




  $(document).on('click', '#btn_edit_cat', function() {
        $("#categorias").toggle("slow");
        var id_prod = $('#tabla_edit_prod tbody tr').find("#id_prod").data("id_prod");
        var idgrupo = $('#tabla_edit_prod tbody tr').find("#id_grupo").data("id_grupo");

        $.ajax({
            url: 'grupo_edit_prod.php',
            method: 'POST',
            data: {idgrupo:idgrupo, id_prod:id_prod},
            success: function (data) {
                $('#sel_grupo_').html(data);
                load_subsel_grupo_ ();
                load_subsel_linea_();
                load_subsel_sublinea_();
                load_subsel_categoria_();
            }
        });
  });

  

  function load_subsel_grupo_ (id_subgr) {
    id_subgr = $('#tabla_edit_prod tbody tr').find("#id_subgr").data("id_subgr");

    $.ajax({
        url: 'cargar_subgrupo_sel_load_edit.php',
        method: 'POST',
        data: {id_subgr:id_subgr},
        success: function (data) {
            $('#subgrupo_edit').html(data);
        }
    });
  }

  function load_subsel_linea_ (id_linea) {
    id_linea = $('#tabla_edit_prod tbody tr').find("#id_linea").data("id_linea");


    $.ajax({
        url: 'cargar_linea_sel_load_edit.php',
        method: 'POST',
        data: {id_linea:id_linea},
        success: function (data) {
            $('#linea_edit').html(data);
        }
    });
  }

  function load_subsel_sublinea_ (id_sublinea) {
    id_sublinea = $('#tabla_edit_prod tbody tr').find("#id_sublinea").data("id_sublinea");

    $.ajax({
        url: 'cargar_sublinea_load_edit.php',
        method: 'POST',
        data: {id_sublinea:id_sublinea},
        success: function (data) {
            $('#sublinea_edit').html(data);
        }
    });
  }

  function load_subsel_categoria_ (id_categoria) {
    id_categoria = $('#tabla_edit_prod tbody tr').find("#id_categoria").data("id_categoria");

    $.ajax({
        url: 'cargar_caracteristica_load_edit.php',
        method: 'POST',
        data: {id_categoria:id_categoria},
        success: function (data) {
            $('#caract_edit').html(data);
        }
    });
  }


  /*************************************/

  $(document).on('change', '#sel_grupo_', function() {
        var gru = $('#sel_grupo_').val();

        $.ajax({
            url: 'cargar_grupo_edit.php',
            method: 'POST',
            data: {gru:gru},
            success: function (data) {
               $('#subgrupo_edit').html(data);
               $("#linea_edit").empty();
               $("#sublinea_edit").empty();
               $("#caract_edit").empty();

            }
        });
  });

  $(document).on('change', '#subgrupo_edit', function() {
        var subgru = $('#subgrupo_edit').val();

        $.ajax({
            url: 'cargar_subgrupo_edit.php',
            method: 'POST',
            data: {subgru:subgru},
            success: function (data) {
               $('#linea_edit').html(data);
               $("#sublinea_edit").empty();
               $("#caract_edit").empty();
            }
        });
  });

  $(document).on('change', '#linea_edit', function() {
        var linea = $('#linea_edit').val();

        $.ajax({
            url: 'cargar_linea_edit.php',
            method: 'POST',
            data: {linea:linea},
            success: function (data) {
               $('#sublinea_edit').html(data);
               $("#caract_edit").empty();
            }
        });
  });

  $(document).on('change', '#sublinea_edit', function() {
        var car = $('#sublinea_edit').val();

        $.ajax({
            url: 'cargar_sublinea_edit.php',
            method: 'POST',
            data: {car:car},
            success: function (data) {
               $('#caract_edit').html(data);
            }
        });
  });


$(document).on('change', '#porcionado', function() {
   if( $(this).is(':checked') ) {
        $('#porcionado').val('1').attr('checked', true);
    } else {
        $('#porcionado').val('0').attr('checked', false);
        //$("#porcionado").prop('checked', false); 
    }
});

$(document).on('change', '#control_ven', function() {
   if( $(this).is(':checked') ) {
        $('#control_ven').val('1').attr('checked', true);
    } else {
       $('#control_ven').val('0').attr('checked', false);
       //$("#control_ven").prop('checked', false);
    }
});

$(document).on('change', '#precio_fijo', function() {
   if( $(this).is(':checked') ) {
        $('#precio_fijo').val('1').attr('checked', true);
    } else {
        $('#precio_fijo').val('0').attr('checked', false);
        //$("#precio_fijo").prop('checked', false);
    }
});

$(document).on('change', '#activo_chk', function() {
   if( $(this).is(':checked') ) {
        $('#activo_chk').val('1').attr('checked', true);
    } else {
       $('#activo_chk').val('0').attr('checked', false);
       //$("#activo_chk").prop('checked', false);
    }
});



$(document).on('click', '#button_edit', function() {
  var id        = $("#tabla_edit_prod tbody tr #id_prod").data("id_prod");
  var idgrupo   = $("#tabla_edit_prod tbody tr #id_grupo").data("id_grupo");
  var idcarac   = $("#tabla_edit_prod tbody tr #idcar").data("idcar");

  var formData  = new FormData($("#formulario_edicion_prod")[0]);

  formData.append('idprod', id);
  formData.append('idgrupo', idgrupo);
  formData.append('idcarac', idcarac);


   var ruta = "prod_edicion_producto.php";
      $.ajax({
          url: ruta,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function(datos){  
          if(datos==1){
            swal('Error!','Imagen no soportada. Asegurese que la imagen tenga extension .jpg','error');
          }else if(datos==2){
            swal('Error!','La imagen supera el tamaño permitido','error');
          }else if(datos==4){

              swal({
                      title: "Se ha modificado el producto.",
                      type: "success",
              },
                function(){
                  location.reload();
                });
          }   

          }
      });
    
});

$('[data-toggle="tooltip"][title]').tooltip();

$("#btn_reporte_pdf").on("click", function(){
    window.open("reporte_productos.php?tiporeporte=pdf ");    
});

$("#btn_reporte_excel").on("click", function(){
    window.open("reporte_productos.php?tiporeporte=excel");    
});



$(document).on('click', '#button_elim', function() {
    var id_producto = $(this).data("id");

    swal({
        title: "¿Seguro que desea eliminar este producto?",
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
               url: "eliminar_producto.php",
               data: {
                  id_producto: id_producto
               },
               success: function(data) {
                if (data == 1) {
                    location.reload();
                }
               }
              });
                          
                  });
});


$('#txt_buscar').keyup(function(){
      var username = $(this).val();        
      var dataString = 'nombre='+username;

      $.ajax({
          type: "POST",
          url: "buscar_producto.php",
          data: dataString,
          success: function(data) {
              $('#tumb_productos').html(data);
          }
      });
  });    


function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#img_prod').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}



$(document).on('change', '.file_edit', function(event) {
    readURL(this);
});

$(document).on('click', '#btn_remove_img', function() {
    $('.file_edit').val("");
    $('#img_prod').attr("src", "../contenidos/imagenes/default.jpg");
});




$(document).on('click', '#btn_guardar_unimedida', function() {
      var medida = $('#txt_unidad_med').val();
      var alias  = $('#txt_alias_uni').val();

      if (medida == "") {
          swal("Ingrese la unidad de medida", "", "warning");
          $('#txt_unidad_med').focus();
      }else{
          if (alias == "") {
              swal("Ingrese el alias", "", "warning");
              $('#txt_alias_uni').focus();
          }else{
             $.ajax({
                url: 'add_unimedida.php',
                method: 'POST',
                data: {medida: medida, alias: alias},
                success: function (data) {
                   if (data == 1) {
                      swal("Ingreso correcto", "", "success");
                      load_unimedida ();
                      $('#txt_unidad_med').val("");
                      $('#txt_alias_uni').val("");
                      $('#modalunimedi').modal("hide");
                   }
                }
             });
          }
      }
});

$(document).on('change', '#sel_impuesto_nuevo', function() {
    var tpi = $('#sel_impuesto_nuevo').val();
    if (tpi == 0) {
        $('#tpi').html('<i class="fa fa-usd"></i>');
    }else{
      if (tpi == 1) {
          $('#tpi').html('<i class="fa fa-percent"></i>');          
      }else{
          if (tpi == "sel") {
            $('#tpi').html('<i class="fa fa-ellipsis-h"></i>');
          }
      }
    }
    
});


$(document).on('click', '#btn_guardar_impuesto', function() {
      var impuesto = $('#txt_impuesto').val();
      var alias    = $('#txt_alias_imp').val();
      var tipo     = $('#sel_impuesto_nuevo').val();
      var valor    = $('#valor').val();

      if (impuesto == "") {
          swal("Ingrese el impuesto", "", "warning");
      }else{
         if (alias == "") {
              swal("Ingrese el alias", "", "warning");
         }else{
            if (tipo == "sel") {
               swal("Seleccione un tipo", "", "warning");
            }else{
                if (valor == "") {
                    swal("Ingrese valor", "", "warning");
                }else{

                    $.ajax({
                    url: 'add_impuesto.php',
                    method: 'POST',
                    data: {impuesto: impuesto, alias: alias, tipo: tipo, valor: valor},
                    success: function (data) {
                       if (data == 1) {
                          swal("Ingreso correcto", "", "success");
                          load_impuesto ();
                          $('#txt_impuesto').val("");
                          $('#txt_alias_imp').val("");
                          $('#sel_impuesto_nuevo option:contains("Seleccione tipo")').prop('selected',true); 
                          $('#modalimpuesto').modal("hide");
                       }
                    }
                });
                }
            }
         }
      }
});


$(document).on('click', '#tab_lista', function() {
   $('#edicion').empty();
});

});//fin ready
 

 /*=====  End of TABLA LISTADO DE PRODUCTOS  ======*/
 
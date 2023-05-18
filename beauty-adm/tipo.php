<?php
    include("./head.php");
include "../cnx_data.php";

    VerificarPrivilegio("TIPO", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
    include "librerias_js.php";
?>
<div class="normalheader transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>Inventario</span>
                    </li>
                    <li class="active">
                        <a href="tipo.php"><span>Tipo</span></a>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <form id="form_tipo" method="post">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title">Nuevo tipo</h4>
                                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                </div>
                                <div class="modal-body">
                                    <div class="form-gruop">
                                        <label>Nombre</label>
                                        <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre del tipo" onkeyup="this.value=this.value.toUpperCase();" required>
                                        <div id="nom"></div>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Alias</label>
                                        <input class="form-control" type="text" name="alias" id="alias" maxlength="15" placeholder="Alias del tipo" onkeyup="this.value=this.value.toUpperCase();" required>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Descripción del tipo</label>
                                        <textarea name="desc" id="desc" class="form-control" placeholder="Descripción tipo" required></textarea>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Imagen</label>
                                        <input class="form-control" type="file" name="Imagen" id="Imagen">
                                        <div id="InfoImg"></div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="reset()" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit"  class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <form id="upform_tipo" method="post">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title">Editar tipo</h4>
                                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                </div>
                                <div class="modal-body">
                                    <div class="form-gruop">
                                    <input type="hidden" name="cod" id="cod">
                                        <label>Nombre</label>
                                        <input class="form-control" type="text" name="upnombre" id="upnombre" maxlength="50" placeholder="Nombre del tipo" onkeyup="this.value=this.value.toUpperCase();" required>
                                        <div id="upnom"></div>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Alias</label>
                                        <input class="form-control" type="text" name="upalias" id="upalias" maxlength="15" placeholder="Alias del tipo" onkeyup="this.value=this.value.toUpperCase();" required>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Descripción del tipo</label>
                                        <textarea name="updesc" id="updesc" class="form-control" placeholder="Descripción tipo" required></textarea>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Imagen</label>
                                        <input class="form-control" type="file" name="upImagen" id="upImagen">
                                        <div id="upInfoImg"></div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="reset()" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit"  class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre del TIPO">
                                <div class="input-group-btn">
                                    
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <a ><button class="btn btn-default" id="btn_tipo" data-toggle="modal" data-placement="right" title="Nuevo tipo" data-target="#myModal"><i class="fa fa-plus-square-o text-info"></i>
                                        </button></a>
                                </div>
                                <div class="input-group">
                                
                                </div>
                                
                            </div>
                    
                        </div>

            </div>
        </div>

    </div>
        
</div>
<div id="find" class="content animate-panel">
	<?php include "tipoview.php"; ?>
</div>
</div>
<script>
$(document).ready(function() {
    $(document).on('click', '#btn_tipo', function() {
        $('#body').removeClass("modal-open").removeAttr('style');
    });
});


function reset () {
    $("#form_tipo")[0].reset();
}
function ok(a) {
    swal({
        title: a,
        text: "Ir a lista de tipos",
        type: "success",
        confirmButtonText: "Aceptar"
    },
    function () {
        window.location = "tipo.php";
    });
}
function ko() {
    swal({
        title: "Vaya, algo ha salido mal.",
        text: "Por favor intente una vez mas",
        type: "warning",
        confirmButtonText: "Aceptar"
    });
}
function editar (id) {
    var formData = "cod="+id;
    $.ajax({
       url : 'get_tipo.php',
       type : 'POST',
       data : formData,
        success : function(data) {
           $('#upnombre').val(data.split(",")[0]);
           $('#upalias').val(data.split(",")[1]);
           $("#updesc").val(data.split(",")[2]);
           $("#cod").val(data.split(",")[3]);
           $('#update').modal('show');
        }
    });
    
}
function Eliminar(id, este) {
    swal({
        title: "¿Seguro que desea eliminar este Tipo?",
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
        url: "delete_tipo.php",
        data: {id_tipo: id, operacion: "delete"}
    }).done(function (msg) {
        window.location = "tipo.php";
    }).fail(function () {
        alert("Error enviando los datos. Intente nuevamente");
    });

    swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
}
$('#Imagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#Imagen')[0].files[0]);
    $.ajax({
       url : 'check_img.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           $('#InfoImg').html(data);
        }
    });
});
$('#upImagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#upImagen')[0].files[0]);
    $.ajax({
       url : 'check_img.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           $('#upInfoImg').html(data);
        }
    });
});
$('#nombre').blur(function (){

    var formData = "cod="+$(this).val();
    $.ajax({
        url : 'check_tipo.php',
        type : 'POST',
        data : formData,
    success : function(data) {
           if (data != "") {
                $('#nom').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Este Tipo ya existe, intente con uno diferente.</font></div>')
           } else { 
                $('#nom').html('')
           }
        }
    });
});
$('#upnombre').blur(function (){

    var formData = "cod="+$(this).val();
    $.ajax({
        url : 'check_tipo.php',
        type : 'POST',
        data : formData,
    success : function(data) {
           if (data != "") {
                $('#upnom').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Este Tipo ya existe, intente con uno diferente.</font></div>')
           } else { 
                $('#upnom').html('')
           }
        }
    });
});
$("#form_tipo").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_tipo"));
    $.ajax({
        type: "POST",
        url: "insert_tipo.php",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
        if (res == "TRUE"){
            ok ("Nuevo tipo guardado correctamente.");
        } else {
            ko ();
        }
    });
});
$("#upform_tipo").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("upform_tipo"));
    $.ajax({
        type: "POST",
        url: "update_tipo.php",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
        if (res == "TRUE"){
            ok ("Tipo actualizado correctamente");
        } else {
            ko ();
        }
    });
});
$('#inputbuscar').keyup(function (){
	var a = "nombre="+$(this).val();
	$.ajax({
        type: "POST",
        url: "tipoview.php",
        data: a,
        success: function(data) {
            $('#find').fadeIn(1000).html(data);
        }
    });
});
function paginar(id) {
    var name  = $('#inputbuscar'). val();
    $.ajax({
        type: "POST",
        url: "caractview.php",
        data: {nombre: name, page: id}
    }).done(function (a) {
        $('#find').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
$('#side-menu').children(".active").removeClass("active");
$('#TIPO').addClass("active");
$('#INVENTARIO').addClass("active");

 $(document).ready(function() {
    conteoPermisos ();
});
</script>
</body>
</html>
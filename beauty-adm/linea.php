<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("LINEA", $_SESSION['tipo_u'], $conn);
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
                        <a href="linea.php"><span>L&iacute;nea</span></a>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <form id="form_tipo" method="post">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title">Nueva l&iacute;nea</h4>
                                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                </div>
                                <div class="modal-body">
                                    <div class="form-gruop">
                                        <label>Nombre</label>
                                        <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre de la L&iacute;nea" onkeyup="this.value=this.value.toUpperCase();" required>
                                        <div id="nom"></div>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Alias</label>
                                        <input class="form-control" type="text" name="alias" id="alias" maxlength="15" placeholder="Alias de la L&iacute;nea" onkeyup="this.value=this.value.toUpperCase();" required>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Descripción de la L&iacute;nea</label>
                                        <textarea name="desc" id="desc" class="form-control" placeholder="Descripción de la L&iacute;nea" required></textarea>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Imagen</label>
                                        <input class="form-control" type="file" name="Imagen" id="Imagen">
                                        <div id="InfoImg"></div>
                                    </div>
                                    <br>    
                                    <div class="form-gruop">
                                        <label>Tipo</label>
                                        <select id="tipo" name="tipo" class="form-control" required>
                                            <?php
                                            $sql = "select tponombre, tpocodigo from btytipo where tpoestado = 1";
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $tipo = $row['tpocodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['tpocodigo']."'> ".$row['tponombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             } 
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Grupo</label>
                                        <select id="grupo" name="grupo" class="form-control" required>
                                            <?php
                                            $sql = "select grunombre, grucodigo from btygrupo where gruestado = 1 and tpocodigo = $tipo";
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $gru = $row['grucodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['grucodigo']."'> ".$row['grunombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             }  
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Subgrupo</label>
                                        <select id="Subgrupo" name="Subgrupo" class="form-control"  required>
                                            <?php
                                            $sql = "select sbgnombre, sbgcodigo from btysubgrupo where sbgestado = 1 and grucodigo = $gru";
                                        
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $sbg = $row['sbgcodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['sbgcodigo']."'> ".$row['sbgnombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             }  
                                            ?>
                                        </select>
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
                                    <h4 class="modal-title">Editar l&iacute;nea</h4>
                                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                </div>
                                <div class="modal-body">
                                    <div class="form-gruop">
                                    <input type="hidden" name="cod" id="cod">
                                        <label>Nombre</label>
                                        <input class="form-control" type="text" name="upnombre" id="upnombre" maxlength="50" placeholder="Nombre de la L&iacute;nea" onkeyup="this.value=this.value.toUpperCase();" required>
                                        <div id="upnom"></div>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Alias</label>
                                        <input class="form-control" type="text" name="upalias" id="upalias" maxlength="15" placeholder="Alias de la L&iacute;nea" onkeyup="this.value=this.value.toUpperCase();" required>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Descripción de la L&iacute;nea</label>
                                        <textarea name="updesc" id="updesc" class="form-control" placeholder="Descripción de la L&iacute;nea" required></textarea>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Imagen</label>
                                        <input class="form-control" type="file" name="upImagen" id="upImagen">
                                        <div id="upInfoImg"></div>
                                    </div>
                                    <br>
                                    <div id="fil" hidden>
                                    <div class="form-gruop">
                                        <label>Tipo</label>
                                        <select id="uptipo" name="uptipo" class="form-control">
                                            <?php
                                            $sql = "select tponombre, tpocodigo from btytipo where tpoestado = 1";
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $tipo = $row['tpocodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['tpocodigo']."'> ".$row['tponombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             }  
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Grupo</label>
                                        <select id="upgrupo" name="upgrupo" class="form-control">
                                            <?php
                                            $sql = "select grunombre, grucodigo from btygrupo where gruestado = 1 and tpocodigo = $tipo";
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $gru = $row['grucodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['grucodigo']."'> ".$row['grunombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             } 
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="form-gruop">
                                        <label>Subgrupo</label>
                                        <select id="upSubgrupo" name="upSubgrupo" class="form-control" >
                                            <?php
                                            $sql = "select sbgnombre, sbgcodigo from btysubgrupo where sbgestado = 1 and grucodigo = $gru";
                                        
                                            $result = $conn->query($sql);
                                            $sw = 0;
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($sw == 0) {
                                                        $sbg = $row['sbgcodigo'];
                                                        $sw = 1;
                                                    }
                                                    echo "<option value='".$row['sbgcodigo']."'> ".$row['sbgnombre']."</option>";
                                                }
                                             } else {
                                                echo "<option value=''>--No hay resultados--</option>";
                                             } 
                                            ?>
                                        </select>
                                    </div>
                                </div> <!-- FIN hidden -->
                                <div id="pre" class="form-gruop">
                                    <label>Subgrupo <a title="Editar clasificacion" onclick="$('#fil').attr('hidden',false); $('#uptipo').attr('required',true); $('#upgrupo').attr('required',true); $('#upSubgrupo').attr('required',true); $('#pre').attr('hidden',true);"><i class="fa fa-edit"></i></a></label>
                                    <input type="text" name="sblnombre" id="sblnombre" class="form-control" disabled>
                                    <input type="hidden" name="sblcodigo" id="sblcodigo">
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
                                <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre de la l&iacute;nea">
                                <div class="input-group-btn">
                                    
                                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                    <a ><button class="btn btn-default" data-toggle="modal" data-placement="right" title="Nueva l&iacute;nea" data-target="#myModal"><i class="fa fa-plus-square-o text-info"></i>
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
    <?php include "lineaview.php"; ?>
</div>
</div>
<script>
function reset () {
    $("#form_tipo")[0].reset();
}
$('#update').on('hidden', function () {
    $("#upform_tipo")[0].reset();
})
function ok(a) {
    swal({
        title: a,
        text: "Ir a lista de lineas",
        type: "success",
        confirmButtonText: "Aceptar"
    },
    function () {
        window.location = "linea.php";
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
       url : 'get_lin.php',
       type : 'POST',
       data : formData,
        success : function(data) {
           $('#upnombre').val(data.split(",")[0]);
           $('#upalias').val(data.split(",")[1]);
           $("#updesc").val(data.split(",")[2]);
           $("#cod").val(data.split(",")[3]);
           $("#sblcodigo").val(data.split(",")[4]);
           $("#sblnombre").val(data.split(",")[5]);
           $('#fil').attr('hidden',true); 
           $('#pre').attr('hidden',false);
           $('#update').modal('show');
        }
    });
    
}
function Eliminar(id, este) {
    swal({
        title: "¿Seguro que desea eliminar esta linea?",
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
        url: "delete_lin.php",
        data: {id_tipo: id, operacion: "delete"}
    }).done(function (msg) {
        window.location = "linea.php";
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
        url : 'check_lin.php',
        type : 'POST',
        data : formData,
    success : function(data) {
           if (data != "") {
                $('#nom').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Esta l&iacute;nea ya existe, intente con uno diferente.</font></div>');
           } else { 
                $('#nom').html('');
           }
        }
    });
});
$('#upnombre').blur(function (){
    var formData = "cod="+$(this).val();
    $.ajax({
        url : 'check_lin.php',
        type : 'POST',
        data : formData,
    success : function(data) {
           if (data != "") {
                $('#upnom').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Esta l&iacute;nea ya existe, intente con uno diferente.</font></div>');
           } else { 
                $('#upnom').html('');
           }
        }
    });
});
function find_sbg (op) {
    if (op == 1) {
        var formData = "cod="+$('#grupo').val();
    } else { 
        var formData = "cod="+$('#upgrupo').val();
    }
     
     $.ajax({
            type: "POST",
            url: "list_sbg.php",
            data: formData,
        }).done(function (html) {
            if (op == 1) {
                $('#Subgrupo').html(html);
            } else { 
                 $('#upSubgrupo').html(html);
            }  
           
                find_lin(op);
        }).false(function () {
            alert('Error al cargar modulo');
        });
}


$('#grupo').change(function (){
    find_sbg(1);
});
$('#Subgrupo').change(function (){
    find_lin(1);
});
$('#Linea').change(function (){
    find_sbl(1);
});
$('#tipo').change(function () {
    var formData = "cod="+$(this).val();
    $.ajax({
            type: "POST",
            url: "list_gru.php",
            data: formData,
        }).done(function (html) {
            $('#grupo').html(html);
            find_sbg(1);
        }).false(function () {
            alert('Error al cargar modulo');
        });
});
$("#form_tipo").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("form_tipo"));
    $.ajax({
        type: "POST",
        url: "insert_linea.php",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){
        if (res == "TRUE"){
            ok ("Nueva Línea guardada correctamente.");
        } else {
            ko ();
        }
    });
});
$('#upgrupo').change(function (){
    find_sbg(2);
});
$('#upSubgrupo').change(function (){
     $("#sblcodigo").val($(this).val());
});

$('#uptipo').change(function () {
    var formData = "cod="+$(this).val();
    $.ajax({
            type: "POST",
            url: "list_gru.php",
            data: formData,
        }).done(function (html) {
            $('#upgrupo').html(html);
            find_sbg(2);
        }).false(function () {
            alert('Error al cargar modulo');
        });
});
$("#upform_tipo").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("upform_tipo"));
    $.ajax({
        type: "POST",
        url: "update_lin.php",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    })
    .done(function(res){    
        if (res == "TRUE"){
            ok ("Linea actualizada correctamente");
        } else {
            ko ();
        }
    });
});
$('#inputbuscar').keyup(function (){
    var a = "nombre="+$(this).val();
    $.ajax({
        type: "POST",
        url: "lineaview.php",
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
        url: "lineaview.php",
        data: {nombre: name, page: id}
    }).done(function (a) {
        $('#find').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}
$('#side-menu').children(".active").removeClass("active");
$('#LINEA').addClass("active");
$('#INVENTARIO').addClass("active");
$(".js-example-basic-single").select2();

 $(document).ready(function() {
    conteoPermisos ();
});
</script>
</body>
</html>
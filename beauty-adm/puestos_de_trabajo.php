<?php
    include 'head.php';
?>

<div class="content animated-panel">
    <!-- Modal nuevo puesto de trabajo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_ptr">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title">Nuevo puesto de trabajo</h4>
                </div>
                <form id="form_puesto" name="form_puesto" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-gruop">
                            <label>
                                Nombre
                            </label>
                            <input class="form-control" id="name" name="name" maxlength="50" type="text" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Nombre" required>
                            <div id="Info" class="help-block with-errors"></div>
                        </div>
                        <div class="form-gruop">
                            <label>
                                Ubicaci&oacute;n 
                            </label>
                            <input class="form-control" placeholder="Ubicacion" id="Ubicacion" name="Ubicacion" type="text" onKeyUp="this.value=this.value.toUpperCase();" onblur="this.value=this.value.toUpperCase();" maxlength="50" required>
                        </div>
                        <div class="form-gruop">
                            <label>
                                Tipo puesto de trabajo
                            </label>
                            <select class="form-control" id="tipo" name="tipo" type="text" required>
                                <?php
                                    $sql = "SELECT `tptcodigo`, `tptnombre` FROM `btytipo_puesto` WHERE tptestado = 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0){
                                        $sw = 0;
                                            while ($row=$result->fetch_assoc()) {
                                                if ($sw == 0) {
                                                    $id = $row['slncodigo'];
                                                    $sw = 1;
                                                }
                                                    echo "<option value='".$row['tptcodigo']."'>".$row['tptnombre']."</option>";
                                            }
                                    }
                                ?>
                            </select>
                            <input type="hidden" name="sln" id="sln" value=" ">
                        </div><br>
                        <div class="form-group"><label class=""> Múltiple</label>
                            <label class="checkbox-inline"> <input type="checkbox" name="chk_mult" value="1" class="chk_mult"> &nbsp;  </label>         
                        </div>
                        <div class="form-gruop">
                            <label>Planta</label>
                            <input type="number" name="planta" id="planta" placeholder="No. planta" class="form-control">
                        </div>
                        <div class="form-gruop">
                            <label>Imagen</label>
                            <input type="file" name="imagen" id="imagen" class="form-control">
                            <div id="info_planta"></div>
                        </div>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_img">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title modaltitle"> </h4>
                </div>
                <div class="modal-body">
                    <div>
                        <center><img id="photo" class="img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';" src="../contenidos/imagenes/default.jpg"></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <span>Salones</span>
                    </li>
                    <li class="active">
                        <span>Puestos Trabajo</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <select class="form-control" type="text" id="salon" name="salon"> 
                                <?php
                                    $sql = "SELECT `slncodigo`, `slnnombre`, `slnalias` FROM `btysalon` WHERE slnestado = 1";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0){
                                        $sw = 0;
                                        while ($row=$result->fetch_assoc()) {                                   
                                            if ($sw == 0) {
                                                $sln = $row['slncodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value='".$row['slncodigo']."'>".$row['slnnombre']."</option>";
                                        }
                                    }
                                    ?>
                            </select>
                            <div class="input-group-btn">
                                <a><button id="btn" class="btn btn-default" title="Nuevo puesto"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                <a><button id="btnReporteExcel"  class="btn btn-default" title="Exportar a Excel"><i class="fa fa-file-excel-o text-info"></i></button></a>
                                <a><button id="btnReportePdf"  class="btn btn-default" title="Exportar a PDF"><i class="fa fa-file-pdf-o text-info"></i></button></a>
                            </div>
                            <div class="input-group">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    <div id="contenido" class="content animated-panel">
        <?php include "find_ptr.php"; ?>
    </div>
</div>


<!-- Vendor scripts -->
    <?php include "librerias_js.php"; ?>
        <script>
            $('#side-menu').children('.active').removeClass('active');  
            $("#SALONES").addClass("active");
            $("#PUESTOS").addClass("active");
        </script>
        <script type="text/javascript">
            function eliminar(id, este) {
                swal({
                    title: "¿Seguro que desea eliminar este puesto de trabajo?",
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
                        url: "delete_puesto.php",
                        data: {id_puesto: id, operacion: "delete"}
                    }).done(function (msg) {
                        $(este).parent().parent().remove();
                    }).fail(function () {
                        alert("Error enviando los datos. Intente nuevamente");
                    });

                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                });
            }



            function editar(id) {
                $.ajax({
                    type: "POST",
                    url: "update_puesto.php",
                    data: {operacion: 'update', id_puesto: id}
                    }).done(function (html) {
                        $('#contenido').html(html);
                    }).fail(function () {
                        alert('Error al cargar modulo');
                    });
            }


            $('#planta').change(function () {
                $('#info_planta').html();
                    var valor = $(this).val();
                    var sln  = $('#salon').val();
                    $.ajax({
                        url : "check_planta.php",
                        type : "POST",
                        data : {planta : valor, sln_cod : sln},
                        success: function (data) {
                            $('#info_planta').html(data);
                        }
                    });
            });

            $('#imagen').change(function(){  
                var formData = new FormData();
                formData.append('imagen', $('#imagen')[0].files[0]);

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

            $(function(){
                    $("#form_puesto").on("submit", function(e){
                            e.preventDefault();
                            var f = $(this);
                            var formData = new FormData(document.getElementById("form_puesto"));
                              $.ajax({
                                  url: "insert_puesto.php",
                                  type: "POST",
                                  dataType: "html",
                                  data: formData,
                                  cache: false,
                                  contentType: false,
                                  processData: false,

                                  success: function (data) {
                                     if (data == "TRUE") {
                                        $("#form_puesto")[0].reset();
                                        swal("Puesto ingresado correctamente." ,"", "success");
                                        var sln=$("#salon").val();
                                        $('#modal_ptr').modal('toggle');
                                        $("#contenido").html('');
                                        var dataString = 'sln_cod='+sln;
                                        $.ajax({
                                            type: "POST",
                                            url: "find_ptr.php",
                                            data: dataString,
                                            success: function(data) {
                                                $('#contenido').html(data);

                                            }
                                        });
                                     }
                                  }
                              });
                         });          
              });


            $('#name').blur(function(){
               $('#Info').html('').fadeOut(1000);
               this.value=this.value.toUpperCase();
               var nom=$(this).val();
               var sln=$("#salon").val();
               var formData="name="+nom+"&sln="+sln;
               $.ajax({
                type: "POST",
                url: "check_puesto.php",
                data: formData,
                    success: function(data) {
                        if(data=="TRUE"){
                            $("#form_puesto")[0].reset();
                            $("#modal_ptr").modal('toggle');
                            swal("Ya existe el puesto '"+nom+"' en éste salón." ,"Por favor verifique.", "error");
                        }
                        else if(data=="INAC"){
                            $("#form_puesto")[0].reset();
                            swal({
                              title: "Ya existe el puesto '"+nom+"' en éste salón, pero inactivo.",
                              text: "¿Desea reactivarlo?",
                              type: "warning",
                              showCancelButton: true,
                              confirmButtonClass: "btn-warning",
                              confirmButtonText: "Reactivar",
                              closeOnConfirm: false
                            },
                            function(){
                                $("#modal_ptr").modal('toggle');
                                $.ajax({
                                    type: "POST",
                                    url: "reactivar_puesto.php",
                                    data: formData,
                                    success: function(data) {
                                        if(data=="TRUE"){
                                            swal("Reactivado!", "", "success");
                                        }else{
                                            swal("Boom!", "El sistema ha fallado!", "error");
                                        }
                                        
                                    }
                                });
                                
                                $("#contenido").html('');
                                var dataString = 'sln_cod='+sln;
                                $.ajax({
                                    type: "POST",
                                    url: "find_ptr.php",
                                    data: dataString,
                                    success: function(data) {
                                        $('#contenido').html(data);
                                    }
                                });
                            });
                        }
                    }
                });
           });


            $('#btn').click(function(){
            var titulo = "Nuevo puesto para el salón "+ $('#salon option:selected').html();
                $('#title').html(titulo);
                $('#sln').val($('#salon').val());
                $('#modal_ptr').modal('show'); 
            }); 

            function img (a,id){
                if (a != "default.jpg") {
                    $('#photo').attr("src", "../contenidos/imagenes/puesto_trabajo/"+a);
                } else {
                    $('#photo').attr("src", "imagenes/default.jpg");
                }
                    $('#modal_img').modal('show');
                     $(".modaltitle").html('');
                    $(".modaltitle").append("Imagen del puesto "+id);

            };

            $('#salon').change(function(){
                var cod = $(this).val();        
                var dataString = 'sln_cod='+cod;
                $.ajax({
                    type: "POST",
                    url: "find_ptr.php",
                    data: dataString,
                    success: function(data) {
                        $('#contenido').html(data);
                    }
                });
            });

            function paginar(id) {
                var cod = $('#salon').val();
                $.ajax({
                    type: "POST",
                    url: "find_ptr.php",
                    data: {sln_cod: cod, page: id}
                }).done(function (a) {
                        $('#contenido').html(a);
                    }).fail(function () {
                        alert('Error al cargar modulo');
                    });
            }



$("#btnReporteExcel").on("click", function(){
    var cod = $('#salon').val();
    var slnnom=$('#salon option:selected').text();
    window.open("reportePuestotrabajoExcel.php?tipoReporte=excel&salon="+cod+"&nomsalon="+slnnom+"");    
});

$("#btnReportePdf").on("click", function(){
    var cod = $('#salon').val();
    var slnnom=$('#salon option:selected').text();
    window.open("reportePuestotrabajoExcel.php?tipoReporte=pdf&salon="+cod+"&nomsalon="+slnnom+"");   
});

 $(document).ready(function() {
        conteoPermisos ();
});
</script>

</body>
</html>

<style type="text/css" media="screen">
.icheckbox_square-green, .iradio_square-green {
    display: inline-block!important;
    *display: inline!important;
    vertical-align: middle!important;
    margin: 0!important;
    padding: 0!important;
    width: 22px!important;
    height: 22px!important;
    background: url("img/green.png") no-repeat!important;
    border: 0!important;
    cursor: pointer!important;
}
</style>
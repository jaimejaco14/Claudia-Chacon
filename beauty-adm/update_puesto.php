<?php
include '../cnx_data.php';
$cod = $_POST['id_puesto'];
$sql = "SELECT p.tptcodigo, p.ptrnombre, p.ptrubicacion, p.slncodigo, s.slnnombre, t.tptnombre, p.ptrplanta, p.ptrmultiple FROM btypuesto_trabajo p INNER JOIN btysalon s ON p.slncodigo = s.slncodigo INNER JOIN btytipo_puesto t ON t.tptcodigo = p.tptcodigo WHERE ptrcodigo = $cod";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombre = $row['ptrnombre'];
        $ubica = $row['ptrubicacion'];
        $tipo = $row['tptcodigo'];
        $sln = $row['slncodigo'];
        $sln_name = $row['slnnombre'];
        $tipo_name = $row['tptnombre'];
        $chk_mult = $row['ptrmultiple'];
        $planta = $row['ptrplanta'];
    }
}
?>
<div class="row col-lg-7">
    <div class="hpanel">
        <div class="panel-heading">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
            </div>
            Actualizar Puesto    
            <div class="panel-body">
            <!-- <button class="btn btn-warning" onclick="location.reload();">Regresar</button> -->
            <button class="btn btn-warning" id="goback">Regresar</button>
                <div class="col-lg-12">
                    <form id="form_puesto1" name="form_puesto1" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-gruop">
                                <label>
                                    Nombre
                                </label>
                                <input type="hidden" name="cod" value="<?php echo $cod; ?>">
                                <input class="form-control" id="name" name="name" maxlength="50" type="text" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo $nombre; ?>" required>
                                <div id="InfoLinea" class="help-block with-errors"></div>
                            </div>
                            <div class="form-gruop">
                                <label>
                                     Ubicaci&oacute;n 
                                </label>
                                <input class="form-control" id="Ubicacion" name="Ubicacion" type="text" maxlength="50" value="<?php echo $ubica; ?>" required>
                            </div>
                            <div class="form-gruop">
                                <label>
                                    Tipo puesto de trabajo
                                </label>
                                <select class="form-control" id="tipo" name="tipo" type="text" required>
                                    <?php
                                        $sql = "SELECT `tptcodigo`, `tptnombre` FROM `btytipo_puesto` WHERE NOT tptcodigo = $tipo AND  tptestado = 1";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0){
                                            $sw = 0;
                                           echo "<option value='".$tipo."'>".$tipo_name."</option>";
                                            while ($row=$result->fetch_assoc()) {
                                                # code...
                                                if ($sw == 0) {
                                                    $id = $row['slncodigo'];
                                                    $sw = 1;
                                                }
                                                echo "<option value='".$row['tptcodigo']."'>".$row['tptnombre']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                                <input type="hidden" name="sln" id="sln" value="2">
                            </div>
                            <br>
                             <div class="form-group"><label class="">Múltiple</label>                          
                                <label class="checkbox-inline">
                                <?php 
                                    if ($chk_mult == 0) {
                                        echo '<input type="checkbox" name="chk_mult" value="1" class="chk_mult"> &nbsp;';
                                    }else{
                                         echo '<input type="checkbox" name="chk_mult" value="0" class="chk_mult" checked> &nbsp;';
                                    }
                                 ?>                                    
                                 </label>         
                            </div>
                             <div class="form-gruop">
                                <label>Planta</label>
                                 <input type="number" name="planta" id="planta" value="<?php echo $planta;?>" class="form-control">
                            </div>
                            <div class="form-gruop">
                                <label>
                                    Salon
                                </label>
                                <select class="form-control" id="sln" name="sln" type="text" required>
                                    <?php
                                        $sql = "SELECT `slncodigo`, `slnnombre` FROM `btysalon` WHERE NOT slncodigo = $sln AND  slnestado = 1";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0){
                                            $sw = 0;
                                           echo "<option value='".$sln."'>".$sln_name."</option>";
                                            while ($row=$result->fetch_assoc()) {
                                                # code...
                                                if ($sw == 0) {
                                                    $id = $row['slncodigo'];
                                                    $sw = 1;
                                                }
                                                echo "<option value='".$row['slncodigo']."'>".$row['slnnombre']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-gruop">
                                <label>Imagen</label>
                                <input type="file" name="up_imagen" id="up_imagen" class="form-control">
                                <div id="up_InfoImg"></div>
                            </div> 
                        </div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function ok() {
    swal({
        title: "Puesto actualizado correctamente",
        text: "",
        type: "success",
        confirmButtonText: "Aceptar"
        },
        function () {
            $("#contenido").html('');
            var dataString = 'sln_cod='+<?php echo $sln?>;
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
$('#up_imagen').change(function(){
var formData = new FormData();
formData.append('imagen', $('#up_imagen')[0].files[0]);
$.ajax({
       url : 'check_img.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           $('#up_InfoImg').html(data);
       }
});
});
$("#form_puesto1").on("submit", function(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("form_puesto1"));
            $.ajax({
                url: "insert_puesto.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){
               
                if (res == "TRUE"){
                    ok ();
                }
            });
});
$("#goback").click(function(e){
    $("#contenido").html('');
    var dataString = 'sln_cod='+<?php echo $sln?>;
    $.ajax({
        type: "POST",
        url: "find_ptr.php",
        data: dataString,
        success: function(data) {
            $('#contenido').html(data);
        }
    });
});
</script>
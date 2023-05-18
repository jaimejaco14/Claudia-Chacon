<?php
include '../../cnx_data.php';
$cod = $_POST['codigo'];
// echo $cod;
$sql = "SELECT  `trnnombre`, `trndesde`, `trnhasta`, `trncolor`, `trninicioalmuerzo`, `trnfinalmuerzo` FROM `btyturno` WHERE trncodigo = '$cod'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombre = $row['trnnombre'];
        $desde = $row['trndesde'];
        $hasta = $row['trnhasta'];
        $trncolor = $row['trncolor'];
        $start = $row['trninicioalmuerzo'];
        $end = $row['trnfinalmuerzo'];

    }
}
?>

                        <div class="modal-body">
		              <div class="form-gruop">
                      <input type="hidden" name="codigo" value="<?php echo $cod ?>" placeholder="">
                        <label>Nombre</label>
                        <input type="text" name="upturno_name" id="upturno_name" value="<?php echo $nombre ?>" placeholder="Nombre del turno" class="form-control text-uppercase" onchange="this.value = this.value.toUpperCase();" maxlength="50">
                    </div>
                    <div class="form-gruop">
                        <label>
                            Hora de inicio 
                        </label>
                        <input class="form-control" id="updesde" name="updesde" value="<?php echo $desde ?>" type="text" required>
                    </div>
                    <div id="uphoras"> </div>
                     <div class="form-gruop">
                        <label>
                            Hora de fin 
                        </label>
                        <input class="form-control" id="uphasta" name="uphasta" type="text" value="<?php echo $hasta ?>" required>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <label>Espacio de almuerzo</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control fecha" id="upstart" name="upstart" value="<?php echo $start ?>" required />
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control fecha" id="upend" name="upend" value="<?php echo $end ?>" required />
                            </div>    
                        </div>
                        <div class="col-lg-12 help-block" id="upinfoRangoAlmuerzo">
                            
                        </div>
                        </br>
                    </div>
                    <div class="form-gruop">
                        <label>Color :</label>
                        <input type="color" class="btn-success" id="upcolor" name="upcolor" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $trncolor ?>" style="width:50px;">
                        <div class="help-block">Click para seleccionar un color</div>
                        <div id="Info_color" class="help-block with-type-errors"></div>
                    </div> 
                        </div>
                        

<script type="text/javascript">
    $('#uphasta').datetimepicker({
    format: "HH:mm ",
  });
      $('#updesde').datetimepicker({
    format: "HH:mm ",
  });
$('#upstart').datetimepicker({
    format: "HH:mm ",
});
$('#upend').datetimepicker({
    format: "HH:mm ",
});
function ok() {
    swal({
        title: "Turno actualizado correctamente.",
        text: "",
        type: "success",
        confirmButtonText: "Aceptar"
        },
        function () {
            window.location = "tipo_turno.php";
        });
}
$("#form_update_hora").on("submit", function(event) {
    event.preventDefault();
    if ($('#updesde').val() < $('#uphasta').val()){
         if ($('#updesde').val() < $('#upstart').val() && $('#upstart').val() < $('#upend').val() && $('#upend').val() < $('#uphasta').val()){
            var formData = new FormData(document.getElementById("form_update_hora"));
             $.ajax({
                url: "check_turno.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res){
                if (res == "TRUE") {
                    $.ajax({
                        url: "insert_turno.php",
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
                        } else if (res == "FALSE") {
                            rep();

                        }
                    });
                } else {
                    $(horas).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Ya existe un turno igual a este</font></div>');
                }
            });
        } else {
            $('#upinfoRangoAlmuerzo').html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red">Rango no valido</font></div>');
        }
    } else {
        $(horas).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> La hora de inicio debe ser anterior a la hora de fin</font></div>');
    }
           

            });
$('#uphasta').change(function(){
    $(uphoras).html('');
});
$('#updesde').change(function(){
    $(uphoras).html('');
});
$('#uphasta').click(function(){
    $(uphoras).html('');
});
$('#updesde').click(function(){
    $(uphoras).html('');
});
$('#upstart').click(function(){
    $('#upinfoRangoAlmuerzo').html('');
});
$('#upend').click(function(){
    $('#upinfoRangoAlmuerzo').html('');
});
</script>
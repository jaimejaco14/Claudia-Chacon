<?php
include '../cnx_data.php';
$cod = $_POST['horario_cod'];
// echo $cod;
$sql = "SELECT h.`hordia`, h.`horcodigo`, h.`hordesde`, h.`horhasta` FROM `btyhorario` h WHERE h.horcodigo = '$cod'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dia = $row['hordia'];
        $hasta = $row['horhasta'];
        $desde = $row['hordesde'];
    }
}
?>

                        <div class="modal-body">
		                    <div class="form-gruop">
		                        <label>
		                            Día
		                        </label>
		                        <select class="form-control" id="up_dia" name="up_dia" type="text" readonly required>
		                            <?php echo "<option value='".$dia."'>$dia</option>"; ?>
		                        </select>
		                        <div id="Info" class="help-block with-errors"></div>
		                    </div>
		                    <div class="form-gruop">
		                        <label>
		                            Hora de apertura 
		                        </label>
		                        <input class="form-control" id="up_desde" name="up_desde" type="time" maxlength="10" value="<?php echo $desde ?>" required>
	                    	</div>
		                    <div id="up_horas"> </div>
		                    <div class="form-gruop">
		                        <label>
		                            Hora de cierre 
		                        </label>
		                        <input class="form-control" id="up_hasta" name="up_hasta" type="time" maxlength="10" value="<?php echo $hasta ?>" required>
		                    </div> 
		                    <input type="hidden" name="hor_cod" value="<?php echo $cod; ?>" >
                        </div>
                        

<script type="text/javascript">
$('#up_hasta').datetimepicker({
    format: "HH:mm ",
  });
$('#up_desde').datetimepicker({
    format: "HH:mm ",
  });
function ok() {
    swal({
        title: "Horario actualizado correctamente.",
        text: "",
        type: "success",
        confirmButtonText: "Aceptar"
        },
        function () {
            window.location = "horarios_salon.php";
        });
}
$("#form_update_hora").on("submit", function(event) {
    event.preventDefault();
    if ($('#up_desde').val() < $('#up_hasta').val()){
    var formData = new FormData(document.getElementById("form_update_hora"));
            $.ajax({
                url: "mod_horario.php",
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
                } else {
                    alert("nop");
                }
            });
        } else {
            $(up_horas).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> La hora de apertura debe ser anterior a la hora de cierre</font></div>');
        }
});
$('#up_hasta').change(function(){
    $(up_horas).html('');
});
$('#up_desde').change(function(){
    $(up_horas).html('');
});
$('#up_hasta').click(function(){
    $(up_horas).html('');
});
$('#up_desde').click(function(){
    $(up_horas).html('');
});
</script>
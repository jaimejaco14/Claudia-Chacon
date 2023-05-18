<?php 
include '../cnx_data.php';

 $today = date("Y-m-d");

$id = $_POST['id'];

if ($_POST['opcion'] == "editar") {
    $html='';
    $sql = mysqli_query($conn, "SELECT fescodigo, festipo, fesfecha, DATE_FORMAT(fesfecha, '%d de %M de %Y') as fecha, fesobservacion, fesestado FROM btyfechas_especiales WHERE fesestado = 1 AND fescodigo = $id ");

    $row = mysqli_fetch_array($sql);

    $html.='   
          <input type="hidden" id="codigo" value=" '.$row['fescodigo'].' ">
          <div class="form-group">
                <label for="">Tipo de Fecha</label>
                <select name="" id="sel_tipo" class="form-control">                    
    ';

        if ($row['festipo'] == "FESTIVO") {
            $html.='
                    <option value="FESTIVO" selected>FESTIVO</option>
                    <option value="ESPECIAL">ESPECIAL</option>
            ';
        }else{

            $html.='
                    <option value="ESPECIAL" selected>ESPECIAL</option>
                    <option value="FESTIVO">FESTIVO</option>
            ';
        }

            $html.='
                 </select>  
          </div>

          <div class="form-group">
               <label for="">Fecha</label>
               <input type="text" class="form-control fecha" id="fecha" name="copyOnfecha" value=" '.$row['fesfecha'].' ">
          </div>

           <div class="form-group">
               <label for="">Observaciones</label>
              <textarea name="" id="observaciones" class="form-control" rows="3">'.utf8_encode($row['fesobservacion']).'</textarea>
          </div>
            ';
   
                       


}else{
   $sql = mysqli_query($conn, "UPDATE btyfechas_especiales SET fesestado = 0 WHERE fescodigo = $id ");
   if ($sql) {
       echo 1;
   }
}


echo $html;

mysqli_close($conn);

?>
  
<script>
   $('.fecha').datetimepicker({
    format: "YYYY-MM-DD",
    locale: "es",
  });
   $(document).on('blur', '#fecha', function() {
    var fecha_validar = $('#fecha').val();

    $.ajax({
        url: 'validar_fecha_especial.php',
        method: 'POST',
        data: {fecha: fecha_validar},
        success: function (data) {
            if (data == 1) {
               swal("Esta fecha ya se encuentra registrada. Intente con otra.", "", "warning");
              // $('.fecha_').focus();
            }
        }
    });
});
</script>



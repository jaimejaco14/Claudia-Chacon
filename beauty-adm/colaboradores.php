<?php
session_start();
include '../cnx_data.php';
$sql = "SELECT usucodigo FROM btyusuario u INNER JOIN btyprivilegioperfil p ON u.tiucodigo = p.tiucodigo AND p.pricodigo = 5 WHERE u.trcdocumento = ".$_SESSION['documento'];
$result =$conn->query($sql);
$sw = $result->num_rows;
if ($sw != 0) {
       // Aceptado
} else {
    echo "string";
    header("Location: error_privilegio.php"); 
}
include 'head.php';
$today = date("Y-m-d");
?>
<div class="content animate-panel">

    <div>

        
        <!-- form here-->
        <div class="row">
            <form id="form_col" role="form" name="form" method="post" enctype="multipart/form-data">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="hpanel">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                <a class="closebox"><i class="fa fa-times"></i></a>
                            </div>
                            Datos del colaborador
                        </div>
                        <div class="panel-body">
                            <div class="form-group" name='tipo' >
                                <div class="form-group">
                                    <label>Tipo de Documento</label>
                                    <select style="width: 99px" class="form-control" name="tipo_documento" id="tipo_documento">
                                        <?php
                                        
                                        $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {                
                                                echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                            }
                                        } 
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div> <!-- TIPO DE DOCUMENTO -->
                                
                                <div class="form-group ">
                                    <label>Numero de documento</label>
                                    <div class="input-group" readonly>
                                        <input type="number" class="form-control" name="no_documento" id="no_documento" placeholder="Numero de documento">
                                        <div class="input-group-btn"><input  style="width: 70px"  type="text" class="form-control" pattern="[0-9]" readonly maxlength="15" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" required >
                                        </div>
                                        
                                    </div>
                                    <div id="Info" class="help-block with-errors"></div> 
                                </div>
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="form-control" id="Categoria" name="Categoria">
                                        <?php
                                        $sql = "SELECT `ctccodigo`, `ctcnombre`, `ctccolor`, `ctcalias` FROM `btycategoria_colaborador` WHERE ctcestado =1";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='".$row['ctccodigo']."'>".$row['ctcnombre']."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Cargo</label>
                                    <select class="form-control" name="cargo" id="cargo" data-error="Escoja una opcion" required>
                                        <?php
                                        
                                        $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {                
                                                echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                            }
                                        }
                                        
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group" id="divnombre">
                                    <label>Nombres</label>
                                    <input  class="form-control text-uppercase" name="nombres" id="nombres" onchange="this.value = this.value.toUpperCase()" placeholder="Digite nombres">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group" id="divapellido">
                                    <label>Apellidos</label>
                                    <input  class="form-control text-uppercase" name="apellidos" onchange="this.value = this.value.toUpperCase()" id="apellidos" data-error="Campo obligatorio" placeholder="digite apellidos" required>
                                    <div class="help-block with-errors"></div>
                                </div>                               
                                <div class="form-group" id="divsexo">
                                    <label>Sexo</label>
                                    <select style="width: 200px" class="form-control" name="sexo" id="sexo">
                                        <option value="M">Hombre</option>
                                        <option value="F">Mujer</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div> <!-- SEXO -->                            
                            </div> 

                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <div class="input-group">
                                    <input  type="text" class="form-control fecha" name="fecha" id="datetimepicker" placeholder="AAAA-MM-DD" max="<?php echo $today;?>" format="YYYY-MM-DD" data-error="campo obligatorio" required><div class="input-group-btn"><input style="width: 50px" type="text" class="form-control" id="edad" name="edad" readonly>
                                    
                                </div></div>
                                <div class="help-block with-errors text-danger" id="infoEdad"></div>
                                <p class="help-block"></p>
                            </div>
                            
                            <div class="form-group">
                                <label>Fecha de ingreso</label>
                                
                                <input  type="text" class="form-control fecha_in" name="fecha_in" id="datetimepicker_in" placeholder="AAAA-MM-DD" format="YYYY-MM-DD" data-error="campo obligatorio" required>
                                <div class="help-block with-errors"></div>
                                <p class="help-block"></p>
                            </div>
                            <div class="form-group">
                                <label>Departamento</label>
                                <select class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                                    <?php
                                    
                                    $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento WHERE depstado = 1 AND NOT depcodigo = 0 ORDER BY depombre");
                                    if ($result->num_rows > 0) {
                                        $sw = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            if ($sw == 0) {
                                                $depa = $row['depcodigo'];
                                                $sw = 1;
                                            }  
                                            echo '<option value="'.$row['depcodigo'].'">'.$row['depombre'].'</option>';
                                        }
                                    }
                                    
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label> Ciudad </label>
                                <select class="form-control" name="ciudad" id="ciudad">
                                    <?php
                                    
                                    $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $depa");
                                    if ($result->num_rows > 0) {
                                        $sw = 0;
                                        while ($row = $result->fetch_assoc()) { 
                                            if ($sw == 0) {
                                                $ciu = $row['loccodigo'];
                                                $sw = 1;
                                            }                 
                                            echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
                                        }
                                    }
                                    
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label> Barrio </label>
                                <select class="form-control" name="barrio" id="barrio">
                                    <?php
                                    
                                    $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciu");
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) { 
                                            echo '<option value="'.$row['brrcodigo'].'">'.$row['brrnombre'].'</option>';
                                        }
                                    }
                                    
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Direccion</label>
                                <input  class="form-control" type="text" name="direccion" id="direccion" onchange="this.value=this.value.toUpperCase();"  placeholder="Ejemplo: CALLE 94 CARRERA 42 - 03">
                                <div class="help-block with-errors"></div>
                            </div>                    
                            <div class="form-group">
                                <label>Telefono movil</label>
                                <input  class="form-control" type="number" name="telefono_movil" id="telefono_movil" placeholder="Ingrese móvil">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label>Telefono fijo</label>
                                <input  class="form-control" type="number" name="telefono_fijo" id="telefono_fijo" placeholder="Ingrese número de teléfono">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="control-label">Email</label>
                                <input  type="email" class="form-control text-uppercase" name="email" id="email" placeholder="Email">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group"> 
                                <label for="telefono">Foto:</label><!--0<span><img src="images/galeria_servicios/?php echo $img; ?>" WIDTH="70" HEIGHT="70"></span>-->
                                <input id="imagen" name="imagen" type="file" class="form-control" placeholder="Imagen"  value=""/>
                                <div id="InfoImg" class="help-block with-errors"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="help-block"> 
                                            <input type="checkbox" name="notif[]"  value="movil" aria-label="..." checked="checked" >
                                            <label>
                                                Recibir notificaciones a mi movil
                                            </label> 
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <div class="help-block"> 
                                            <input type="checkbox" name="notif[]"  value="email" aria-label="..." checked="checked" > 
                                            <label>
                                                Recibir notificaciones a mi email
                                            </label> 
                                        </div>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->
                            
                            
                            <button type="submit" id="guardar" name="guardar" class="btn btn-success">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
                

            </form>
            
        </div>
        
        




    </div>

    <!-- Right sidebar -->
    
    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>
<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>

<script type="text/javascript">
  $('#side-menu').children('.active').removeClass("active");  
  $("#COLABORADORES").addClass("active");
  $("#COLABORADOR").addClass("active");
  $(".fecha").datetimepicker({
    format: "YYYY-MM-DD",
    maxDate: moment().format("YYYY-MM-DDTHH"),
    locale: "es",
});
  $(".fecha_in").datetimepicker({
    format: "YYYY-MM-DD",
    locale: "es",
});
</script>




<script type="text/javascript">
    function calcularEdad(fecha) {
    // var hoy = new Date();
    // var cumpleanos = new Date(fecha);
    // var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    // var m = hoy.getMonth() - cumpleanos.getMonth();

    // if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
    //     edad--;
    // }
    // $('#edad').val(edad);
    if (typeof fecha != "string" && fecha && esNumero(fecha.getTime())) {
        fecha = formatDate(fecha, "yyyy-MM-dd");
    }

    var values = fecha.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth() + 1;
        var ahora_dia = fecha_hoy.getDate();

        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if (ahora_mes < mes) {
            edad--;
        }
        if ((mes == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }

        // calculamos los meses
        var meses = 0;

        if (ahora_mes > mes && dia > ahora_dia)
            meses = ahora_mes - mes - 1;
        else if (ahora_mes > mes)
            meses = ahora_mes - mes
        if (ahora_mes < mes && dia < ahora_dia)
            meses = 12 - (mes - ahora_mes);
        else if (ahora_mes < mes)
            meses = 12 - (mes - ahora_mes + 1);
        if (ahora_mes == mes && dia > ahora_dia)
            meses = 11;

        // calculamos los dias
        var dias = 0;
        if (ahora_dia > dia)
            dias = ahora_dia - dia;
        if (ahora_dia < dia) {
            ultimoDiaMes = new Date(ahora_ano, ahora_mes - 1, 0);
            dias = ultimoDiaMes.getDate() - (dia - ahora_dia);
        }
        $('#edad').val(edad);

        //return edad + " años, " + meses + " meses y " + dias + " días";
        if (edad < 18) {
            $('#infoEdad').html('Edad minima es de 18 a&ntilde;os<input type="hidden" name="" value="" required>');
        } else {
            $('#infoEdad').html('');
        }
    }
    $('#datetimepicker').change(function() {
        var e = $('#datetimepicker').val();
        calcularEdad(e);
    });
    $('#datetimepicker').blur(function() {
        var e = $('#datetimepicker').val();
        calcularEdad(e);
    });

    $('#dep').change(function(){
        var depa = $(this).val();
        var depart = 'ciudad='+depa;
        $.ajax({
            type: "POST",
            url: "buscar_ciudad.php",
            data: depart,
            success: function(data) {
                $('#ciudad').html(data);
                brr ();
            }
        });
    });
    $('#ciudad').change(function(){
        brr ();
    });
    function brr () {
        var cod_brr = $('#ciudad').val();
        var brr = 'barrio='+cod_brr;
        $.ajax({
            type: "POST",
            url: "buscar_barrio.php",
            data: brr,
            success: function(data) {
                $('#barrio').html(data);
            }
        });
    }
    $(document).ready(function() {    
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
      $('#no_documento').blur(function(){

        $('#Info').html('').fadeOut(1000);

        var username = $(this).val();        
        var dataString = 'no_documento='+username;

        $.ajax({
            type: "POST",
            url: "check_colaborador.php",
            data: dataString,
            success: function(data) {
                    if (data == "TRUE") {
                        $('#Info').fadeIn(1000).html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Usuario ya esta registrado </font></div>');
                    } else if (data[0] > 0) {
                        $('#nombres').val(data.split(",")[3]);
                        $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                        $('#apellidos').val(data.split(",")[4]); //
                        $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                        $('#tipo_documento').attr('disabled', true);
                        $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                        $('#barrio').attr('disabled', true);
                        $('#ciudad').attr('disabled', true);
                        $('#dep').attr('disabled', true);
                        $('#direccion').attr('readonly', true);
                        $('#direccion').val(data.split(",")[6]);
                        $('#telefono_movil').val(data.split(",")[8]);
                        $('#telefono_fijo').val(data.split(",")[7]);
                        $('#telefono_movil').attr('readonly', true);
                        $('#telefono_fijo').attr('readonly', true);
                    } else if (data == "FALSE") {
                        $('#nombres').attr('readonly', false);
                        $('#apellidos').attr('readonly', false);
                        $('#barrio').attr('disabled', false);
                        $('#ciudad').attr('disabled', false);
                        $('#dep').attr('disabled', false);
                        $('#telefono_movil').attr('readonly', false);
                        $('#telefono_fijo').attr('readonly', false);
                        $('#direccion').attr('readonly', false);
                        $('#tipo_documento').attr('disabled', false);

                    }
                    
                }
            });
        var dataString = 'user_cod='+username;
        $.ajax({
            type: "POST",
            url: "dv.php",
            data: dataString,
            success: function(data) {
                $('#dv').val(data);
            }
        });
    });  
      function ok() {
        swal({
            title: "Colaborador Guardado correctamente",
            text: "Ir a vista de colaborador",
            type: "success",
            confirmButtonText: "Aceptar"
        },
        function () {
            window.location = "colview.php";
        });
        

    }

    $("#form_col").on("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(document.getElementById("form_col"));
        $.ajax({
            type: "POST",
            url: "insert_trc.php",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
        .done(function(res){
          if (res == "TRUE"){
              ok ();
          } else {
           alert("Error enviando el modulo, favor verifique su informacion.");
       }
   });
    });
}); 



$(document).on('blur', '#cod_biometric', function() 
{
    var codbio = $('#cod_biometric').val();
    $.ajax({
        url: 'valcodbiometrico.php',
        method: 'POST',
        data: {codbio:codbio},
        success: function (data) 
        {
            if (data == 1) 
            {
                swal("Este código ya se ha asignado a un colaborador.", "", "warning");
            }
        }
    });
});

 $(document).ready(function() {
    conteoPermisos ();
});

</script>


</body>
</html>
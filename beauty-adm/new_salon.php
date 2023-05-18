<?php
include '../cnx_data.php';
include 'head.php';
VerificarPrivilegio("SALONES", $_SESSION['tipo_u'], $conn);
include "librerias_js.php";

?>

<div class="content animate-panel">

  <div>


    <!-- form here-->

    <div class="row">
      <div class="hpanel">
        <div class="panel-heading">
          <div class="panel-tools">
            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
          </div>
          Nuevo salon

          <div class="panel-body">
            <div class="col-lg-7">
              <?php


              $nombre = '';
              $direccion = '';
              $telefono = '';
              $email = '';
              $pwd = '';

              if (!empty($_POST)) {



                $operacion = $_POST['operacion'];
                if ($operacion == 'update') {


                  $id_usuario = $_POST['id_usuario'];

                  $result1 = $conn->query("SELECT sernombre, sercodigo, serimagen, seralias FROM btyservicio WHERE serstado = 1 and sercodigo =".$id_usuario);
                  if ($result1->num_rows > 0) {
                    while ($row = $result1->fetch_assoc()) { 

                      $id = row['sercodigo'];
                      $sername =$row['sernombre'];

                      $descripcion = $row['serdescripcion'];
                      $img = $row['serimagen'];
                      $alias = $row['seralias']; 

                    }
                  }


                }
    //$msg = '';
              }
             // $conn->close();
              ?>
              <!-- <link href="../CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>
               -->



              <div class="div_usu">
                <form id="formulario" class="form-horizontal" method="post" role="form" enctype="multipart/form-data" >
                  <!--<div id="alerta" class="alert alert-danger" role="alert"></div>-->
                  <?php if ($operacion == 'update') {
                    ?>
                    <label for="id_usuario" >ID</label>
                    <input id="id_usuario" name="id_usuario" type="text" class="form-control" disabled value="<?php echo $id_usuario; ?>"/>
                    <?php
                  }
                  ?>
                  <div class="form-group">                       
                    <label for="nombre" >Nombre</label>
                    <input id="nombre" name="nombre" type="text"  class="form-control text-uppercase" placeholder="Nombre" maxlength="50" required onchange="this.value=this.value.toUpperCase();"  value="<?php echo $sername; ?>"/>
                    <div id="Info" class="help-block with-errors"></div> 
                  </div>
                  <div class="form-group">
                    <label for="pwd" >Nombre corto</label>
                    <input id="alias" name="alias" type="text" class="form-control" maxlength="4" placeholder="ingrese un alias para el salon" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" required value="<?php echo $alias; ?>"/>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group col-lg-3">
                      <label for="direccion" >Indicativo</label>
                      <input id="ind" name="ind" type="text" class="form-control" placeholder="5" pattern="[0-9]" maxlength="1" required ></input>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="form-group col-lg-5 ">
                      <label for="direccion" >Tel&eacute;fono fijo</label>
                      <input id="tel_fijo" name="tel_fijo" type="number" class="form-control" min="0"  placeholder="Numero de telefono" required ></input>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="form-group col-lg-3">
                      <label for="direccion" >Extenci&oacute;n</label>
                      <input id="ext" name="ext" type="text" class="form-control" placeholder="230" pattern="[0-9]+[0-9]" maxlength="4" required ></input>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="direccion" >Tel&eacute;fono m&oacute;vil</label>
                    <input id="tel_movil" name="tel_movil" type="number" class="form-control" min="0" placeholder="Numero de telefono" required ></input>
                  </div>
                  <div class="form-group">
                    <label for="direccion" >Email</label>
                    <input id="sln_email" name="sln_email" type="email" class="form-control" placeholder="Email" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" required ></input>
                  </div>
                  <div class="form-group">
                    <label for="tam" >Tamaño</label>
                    <input id="tam" name="tam" type="number" step="0.1" class="form-control" min="1" onchange="formatoDecimal();" placeholder="tamaño en metros cuadrados" required ></input>
                  </div>
                  <div class="form-group">
                    <label>Plantas</label>
                    <input type="number" name="planta" id="planta" min="1" class="form-control" placeholder="Numero de plantas" required>
                  </div>
                  <div class="form-group">
                    <label>Departamento</label>
                    <select  zize="30" class="form-control" name="Departamento" id="Departamento" data-error="Escoja una opcion" required>
                     <?php
         
                     $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where NOT depcodigo  = 0");
                     if ($result->num_rows > 0) {
                       $sw = 0;
                       while ($row = $result->fetch_assoc()) {
                         if ($sw == 0) {
                          $sw = $row['depcodigo'];
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
                  <select  zize="30" class="form-control" name="ciudad" id="ciudad" onchange="" data-error="Escoja una opcion" required>
                    <?php
                  
                    $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad WHERE depcodigo = $sw");
                    if ($result->num_rows > 0) {

                      while ($row = $result->fetch_assoc()) {             
                        echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
                      }
                    }
                  
                    ?>
                  </select>
                  <div class="help-block with-errors"></div>
                </div>


                <div class="form-group">
                  <label for="direccion" >Direccion del Salon</label>
                  <input id="direccion" name="direccion" type="text" class="form-control" placeholder="CRA 1 CLL 1 14" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" required value="<?php echo $descripcion; ?>"></input>
                </div>

                <div class="form-group">
                  <label>Fecha apertura</label>
                  <input id="fecha_apert" name="fecha_apert" type="date" class="form-control" max="<?=$today?>" required ></input>
                </div> 

                <div class="form-group"> 
                  <label for="telefono">Imagen</label><!--0<span><img src="images/galeria_servicios/?php echo $img; ?>" WIDTH="70" HEIGHT="70"></span>-->
                  <input id="imagen" name="imagen" type="file" class="form-control" placeholder="imagen"  value=""/>
                  <div id="InfoImg" class="help-block with-errors"></div>
                </div>





                <br/>
                <input id="guardar" type="submit" value="Guardar" class="btn btn-success"/>
              </form>
            </div>  
          </div>
        </div>
      </div>
      <br>


    </div>
  </div>
</div>
</div>


<!-- Footer-->
<?php include "footer.php"; ?>

<script>  
  $('#side-menu').children('.active').removeClass('active');
  $("#SALONES").addClass("active");
  $("#SALON").addClass("active");
  $("fecha_apert").datetimepicker({
    format: "YYYY-MM-DD",
    locale: "es",
  })
</script>

<script type="text/javascript">
  function formatoDecimal(){
   var value = $('#tam').val(); // value = 9.61 use $("#text").text() if you are not on select box...
value = value.replace(",", "."); // value = 9:61
$("#tam").val(value);
}
$(document).ready(function() {  
  $('#nombre').blur(function(){
    $('#Info').html('').fadeOut(1000);

    var username = $(this).val();        
    var dataString = 'nombre='+username;

    $.ajax({
      type: "POST",
      url: "check_salon.php",
      data: dataString,
      success: function(data) {
        $('#Info').fadeIn(1000).html(data);
      }
    });
  });
  function ok() {
    swal({
      title: "Salón guardado correctamente",
      text: "Ir a lista de salónes",
      type: "success",
      confirmButtonText: "Aceptar"
    },
    function () {
      window.location = "salon.php";
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

  $("#formulario").on("submit", function(event) {
    event.preventDefault();
    var f = $(this);
    var formData = new FormData(document.getElementById("formulario"));
    formData.append("dato", "valor");
    $.ajax({
      type: "POST",
      url: "insert_salon.php",
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
        ko ();
      }
    });
  });

  $('#grupo_name').blur(function(){

    $('#InfoGrupo').html('<img src="loader.gif" alt="" />').fadeOut(1000);

    var username = $(this).val();        
    var dataString = 'nombre='+username;

    $.ajax({
      type: "POST",
      url: "check_grupo.php",
      data: dataString,
      success: function(data) {
        $('#InfoGrupo').fadeIn(1000).html(data);
      }
    });
  });
  $('#Departamento').change(function(){
    var cod = $(this).val();        
    var dataString = 'ciudad='+cod;

    $.ajax({
      type: "POST",
      url: "buscar_ciudad.php",
      data: dataString,
      success: function(data) {
        $('#ciudad').html(data);
      }
    });
  });
  $('#subgrupo_name').blur(function(){

    $('#InfoSubGrupo').html('<img src="loader.gif" alt="" />').fadeOut(1000);

    var username = $(this).val();        
    var dataString = 'nombre='+username;

    $.ajax({
      type: "POST",
      url: "check_subgrupo.php",
      data: dataString,
      success: function(data) {
        $('#InfoSubGrupo').fadeIn(1000).html(data);
      }
    });
  });

  $('#sublineaname').blur(function(){

    $('#InfoSublinea').html('<img src="loader.gif" alt="" />').fadeOut(1000);

    var username = $(this).val();        
    var dataString = 'nombre='+username;

    $.ajax({
      type: "POST",
      url: "check_sublinea.php",
      data: dataString,
      success: function(data) {
        $('#InfoSublinea').fadeIn(1000).html(data);
      }
    });
  });
  $('#lineaname').blur(function(){

    $('#InfoLinea').html('<img src="loader.gif" alt="" />').fadeOut(1000);

    var username = $(this).val();        
    var dataString = 'nombre='+username;

    $.ajax({
      type: "POST",
      url: "check_linea.php",
      data: dataString,
      success: function(data) {
        $('#InfoLinea').fadeIn(1000).html(data);
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

  $('#linea_imagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#linea_imagen')[0].files[0]);

    $.ajax({
     url : 'check_img.php',
     type : 'POST',
     data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
         console.log(data);
         $('#checkimg').html(data);
       }
     });
  });
  $('#sublinea_imagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#sublinea_imagen')[0].files[0]);
    $.ajax({
     url : 'check_img.php',
     type : 'POST',
     data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
         console.log(data);
         $('#checkimgsub').html(data);
       }
     });
  });

  $('#grupo_imagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#grupo_imagen')[0].files[0]);

    $.ajax({
     url : 'check_img.php',
     type : 'POST',
     data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
         console.log(data);
         $('#checkimggrup').html(data);
       }
     });
  });
  $('#subgrupo_imagen').change(function(){  
    var formData = new FormData();
    formData.append('imagen', $('#subgrupo_imagen')[0].files[0]);

    $.ajax({
     url : 'check_img.php',
     type : 'POST',
     data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
         console.log(data);
         $('#checkimgsubg').html(data);
       }
     });
  });
})   
</script>
</body>
</html>
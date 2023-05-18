    <div class="row">
    <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                                  Actualizar salon
                
                    <div class="panel-body">
                        <div class="col-lg-7">
<?php
include '../cnx_data.php';

$nombre = '';
$direccion = '';
$telefono = '';
$email = '';
$pwd = '';

if (!empty($_POST)) {



    $operacion = $_POST['operacion'];
    if ($operacion == 'update') {

        echo $id_usuario;
        
        $id_usuario = $_POST['id_usuario'];

        $result1 = $conn->query("SELECT slnnombre, slncodigo, slnimagen, slnalias, slnfechaapertura, slndireccion, slntelefonofijo, slntelefonomovil, slnemail, slntamano , `slnextensiontelefonofijo`, `slnindicativotelefonofijo`, slnplantas  FROM btysalon WHERE slnestado = 1 and slncodigo =".$id_usuario);
                                            if ($result1->num_rows > 0) {
                                                while ($row = $result1->fetch_assoc()) { 
                                                    
                                                    $id = $row['slncodigo'];
                                                    $sername =$row['slnnombre'];
                                                    
                                                    $descripcion = $row['slndireccion'];
                                                        $img = $row['serimagen'];
                                                        $alias = $row['slnalias']; 
                                                        $tfijo = $row['slntelefonofijo'];
                                                        $tmovil = $row['slntelefonomovil'];
                                                        $email = $row['slnemail'];
                                                        $tam = $row['slntamano'];
                                                        $fecha = $row['slnfechaapertura'];
                                                        $ind = $row['slnindicativotelefonofijo'];
                                                        $ext = $row['slnextensiontelefonofijo'];
                                                        $plantas = $row['slnplantas'];

                                                        
                                                }
                                            }   
    }
    //$msg = '';
}
$conn->close();
?>
<link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>




<div class="div_usu">
    <form id="formulario" class="form-horizontal" method="post" role="form" enctype="multipart/form-data" action="insert_salon.php" >
        <!--<div id="alerta" class="alert alert-danger" role="alert"></div>-->
        <?php if ($operacion == 'update') {
            ?>
            <div hidden>
            <label for="id_usuario" >ID:</label>
            <input id="id_usuario" name="id_usuario" type="text" class="form-control" readonly="" value="<?php echo $id_usuario; ?>"/>
            </div>
            <?php
        }
        ?>
             <div class="form-group">                       
        <label for="nombre" >Nombre</label>
        <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" maxlength="50" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo $sername; ?>"/>
        <div id="Info" class="help-block with-errors"></div> 
        </div>
        <div class="form-group">
        <label for="pwd" >Nombre corto</label>
        <input id="alias" name="alias" type="text" class="form-control" maxlength="4" placeholder="ingrese un alias para el salon" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" required value="<?php echo $alias; ?>"/>
        </div> 
        <div class="col-lg-12">
          <div class="form-group col-lg-3">
            <label for="direccion" >Indicativo</label>
            <input id="ind" name="ind" type="text" class="form-control" placeholder="5" pattern="[0-9]" value="<?php echo $ind; ?>" maxlength="4" required ></input>
          </div>
          <div class="col-lg-1"></div>
          <div class="form-group col-lg-5 ">
            <label for="direccion" >Tel&eacute;fono fijo</label>
            <input id="tel_fijo" name="tel_fijo" type="number" class="form-control"  placeholder="Numero de telefono" min="0" value="<?php echo $tfijo; ?>" required ></input>
          </div>
          <div class="col-lg-1"></div>
          <div class="form-group col-lg-3">
            <label for="direccion" >Extenci&oacute;n</label>
            <input id="ext" name="ext" type="text" class="form-control" placeholder="230" pattern="[0-9]+[0-9]" value="<?php echo $ext; ?>" maxlength="4" required ></input>
          </div>
        </div>
        <div class="form-group">
        <label for="direccion" >Tel&eacute;fono m&oacute;vil</label>
        <input id="tel_movil" name="tel_movil" type="number" class="form-control" placeholder="Numero de telefono" min="0" value="<?php echo $tmovil; ?>" required ></input>
        </div>
        <div class="form-group">
        <label for="direccion" >Email</label>
        <input id="sln_email" name="sln_email" type="email" class="form-control" placeholder="Email" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo $email; ?>" required ></input>
        </div>

        <div class="form-group">
        <label for="tam" >Tamaño</label>
        <input id="tam" name="tam" type="number" step="any" class="form-control" placeholder="tamaño en metros cuadrados" value="<?php echo $tam; ?>" required ></input>
        </div>

        <div class="form-group">
            <label>Planta</label>
            <input type="number" name="planta" id="planta" value="<?php echo $plantas; ?>" class="form-control" placeholder="Numero plantas" required>
        </div>

        <div class="form-group">
            <label>Departamento</label>
            <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                 <?php

                  $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento WHERE NOT depcodigo = 0");
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
        <label for="direccion" >Fecha apertura</label>
        <input id="fecha_apert" name="fecha_apert" type="date" class="form-control" value="<?php echo $fecha; ?>" max="<?=date('Y-m-d'); ?>" required></input>
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

<script type="text/javascript">
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
        title: "Salon Guardado correctamente",
        text: "Ir a lista de salones",
        type: "success",
        confirmButtonText: "Aceptar"
      },
      function () {
        window.location = "salon.php";
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
        }).done(function(res){
          if (res == "TRUE"){
            ok ();
          } else {
            ko ();
          }
        });
    });
    $('#dep').change(function(){
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
});    


</script>
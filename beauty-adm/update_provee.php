<div class="row">

    <div class="hpanel col-lg-10 col-lg-offset-1">

                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                                  Actualizar proveedor
                     
                    <div class="panel-body " >
                       <div class="col-lg-10 col-lg-offset-1">
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

        
        
        $id_usuario = $_POST['id_usuario'];
  

        $result1 = $conn->query("SELECT t.tdialias, p.prvemail, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo, b.brrnombre, c.loccodigo, d.depcodigo FROM btytercero u INNER JOIN  btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btyproveedor p on p.trcdocumento=u.trcdocumento INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo WHERE p.prvestado=1 and u.trcdocumento =".$id_usuario);
                                            if ($result1->num_rows > 0) {
                                                while ($row = $result1->fetch_assoc()) { 
                                                    
                                                    $mail= $row['prvemail'];
                                                    $tipo=$row['tdicodigo'];
                                                    $alias=$row['tdialias'];
                                                    $nombret= $row["trcnombres"];
                                                    $apellidot=$row["trcapellidos"];
                                                    $direccion=$row["trcdireccion"];
                                                    $telff=$row['trctelefonofijo'];
                                                    $telfm=$row['trctelefonomovil'];
                                                    $barrio=$row['brrcodigo'];
                                                    $ciud=$row['loccodigo'];
                                                    $depto=$row['depcodigo'];
                                                    $razon=$row['trcrazonsocial'];
                                                    $barrioalias=$row['brrnombre'];

                                                        
                                                }
                                            }   
    }
    //$msg = '';
}
 $ver="display:none";
                if ($tipo==1) {
                    $muestre="none";
                    $ver="";
                }


?>
<link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>




<div class="div_usu">
    <form id="formulario" class="form-horizontal" method="post" role="form" enctype="multipart/form-data" action="update_prv.php" >
        <!--<div id="alerta" class="alert alert-danger" role="alert"></div>-->

              
                    
                        
                           <div id="contenidoedit">
                                                     
                                             <div class="form-group ">
                                              <br> 
                                              <label>Documento</label>
                                              <input  type="number"  id="idbq" class="form-control" readonly="" value="<?php echo $id_usuario; ?>"> 
                                            </div>
                                             <div class="form-group ">
                                               <label>Tipo Documento</label>      
                                               <select disabled="" style="width: 99px" class="form-control" name="tipo_doc" id="tipo_doc" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
                                            <?php
                                            
                                             if ( $tipo!="") {
                                                echo '<option value="'.$tipo.'">'.$alias.'</option>';
                                              
                                             }
                                              
                                            ?>
                                        </select>
                                        </div>
                                        <div class="form-group ">
                                             <label>Tipo de Tercero</label>  
                                                <div class="input-group col-lg-4 ">
                                                    <span class="input-group-addon">
                                                         
                                                    </span>
                                                    <input id="tipot" type="text" class="form-control" readonly="" aria-label="..." value="<?php if ($tipo>1) {
                                                       echo"Persona";
                                                    }else if ($tipo==1){
                                                        echo "Empresa";
                                                        } ?>" style="width: 100px" >
                                                </div>
                                                
                                              
                                        
                                        </div>
                                        <div class="form-group" >
                                            <label>E-mail</label>
                                            <input  class="form-control text-uppercase" name="correoprv" id="correoprv"  placeholder="Correo Electronico" data-error="Campo obligatorio" required value="<?php echo $mail; ?>" >
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                        <div class="form-group" style="display: <?php echo $muestre ?>" id="divnom">
                                            <label>Nombre</label>
                                            <input  class="form-control text-uppercase" name="nombre" id="nombre"  placeholder="Nombre" data-error="Campo obligatorio" required value=" <?php echo $nombret; ?> " readonly>
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                            <div class="form-group" style="display:<?php echo $muestre ?>" id="divape">
                                            <label>Apellido</label>
                                            <input  class="form-control text-uppercase" name="apellido" id="apellido"  placeholder="Apellido" data-error="Campo obligatorio" required value="  <?php echo $apellidot; ?> " readonly>
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                        <div class="form-group" style="<?php echo $ver ?>" id="divrz">
                                            <label>Reazon Social</label>
                                            <input  class="form-control text-uppercase" name="rzscl" id="rzscl"  placeholder="Razon social" data-error="Campo obligatorio" required value="  <?php echo $razon; ?> " readonly>
                                            <div class="help-block with-errors"></div>
                                        </div>               
                                        <div class="form-group">
                                            <label>Tel&eacute;fono m&oacute;vil</label>
                                            <input  class="form-control" type="number" id="telefono_movil" min="0" name="telefono_movil" placeholder="NUMERO DE TELEFONO MOVIL" data-error="camp obligatorio" required value="<?php      echo $telfm; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tel&eacute;fono fijo</label>
                                            <input  class="form-control" type="number" id="telefono_fijo" min="0" name="telefono_fijo" placeholder="NUMERO DE TELEFONO FIJO" value="<?php echo $telff; ?>">
                                            <div class="help-block">
                                      </div>
                                      </div>
                          <br>
                          </div>
                              </div>
                          


                  
        <br/>
        <input onclick="insertprv($('#correoprv').val(), $('#telefono_movil').val(), $('#telefono_fijo').val(), $('#idbq').val())" id="guardar" type="submit" value="Guardar" class="btn btn-success"/>
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
function insertprv(email, telmovi, telfijo,doc){
    $.ajax({
            type: "POST",
            url: "update_prv.php",
            data: {crr: email, movil: telmovi,  fijo: telfijo, docu:doc},
            success: function(data) {
               if (data=='TRUETRUE') {
                  swal('Editado correctamente');
                  location.reload();
               }
            }
        });

}

</script>
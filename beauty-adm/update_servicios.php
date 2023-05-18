
<div class="row">
    <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                                  Nuevo servicio
                
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

        
        $id_usuario = $_POST['id_usuario'];

        $result1 = $conn->query("SELECT sernombre, sercodigo, serimagen, seralias, serdescripcion FROM btyservicio WHERE serstado = 1 and sercodigo =".$id_usuario);
                                            if ($result1->num_rows > 0) {
                                                while ($row = $result1->fetch_assoc()) { 
                                                    
                                                    $id = $row['sercodigo'];
                                                    $sername =$row['sernombre'];
                                                    
                                                    $descripcion = $row['serdescripcion'];
                                                        $img = $row['serimagen'];
                                                        $alias = $row['seralias']; 
                                                        
                                                }
                                            }
       
        
    }
    //$msg = '';
}
$conn->close();
?>
<link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>




<div class="div_usu">
    <form id="formulario" action="guardar_nuevas_opciones.php" class="form-horizontal" method="post" role="form" enctype="multipart/form-data">
        <!--<div id="alerta" class="alert alert-danger" role="alert"></div>-->
        <?php if ($operacion == 'update') {
            ?>
            <div hidden>
            <label for="id_usuario" >ID:</label>
            <input id="id_usuario" name="id_usuario" type="text" class="form-control"  value="<?php echo $id_usuario; ?>"/>
            </div>
            <?php
        }
        ?>
             <div class="form-group">                       
        <label for="nombre">Nombre del servicio:</label>
        <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" onKeyUp="this.value=this.value.toUpperCase();" maxlength="50" required value="<?php echo $sername; ?>"/>
        <div id="Info" class="help-block with-errors"></div> 
        </div>
        <div class="form-group">
        <label for="direccion" >Descripcion del servicio:</label>
        <textarea id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Ingrese una nueva descripcion del servicio" required value="<?php echo $descripcion; ?>"><?php echo $descripcion; ?></textarea>
        </div>
        <div class="form-group"> 
        <label for="telefono">Imagen:</label><!--0<span><img src="images/galeria_servicios/?php echo $img; ?>" WIDTH="70" HEIGHT="70"></span>-->
        <input id="imagen" name="imagen" type="file" class="form-control" placeholder="imagen"  value=""/>
        <div id="InfoImg" class="help-block with-errors"></div>
        </div>
        <div class="form-group">
        <label for="pwd" >Alias:</label>
        <input id="alias" name="alias" type="text" class="form-control" maxlength="10" placeholder="ingrese un alias para el servicio" required value="<?php echo $alias; ?>"/>
        </div>
        <div class="form-group">
                                        <label>Linea  </label> 
                                        <select  zize="30" class="form-control" name="linea" id="linea" data-error="Escoja una opcion" required>
                                            <option value="">--Escoja una opcion--</option>
                                            <?php
                                     
                                            $result = $conn->query("SELECT lincodigo, linnombre FROM btylinea");
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {                
                                                    echo '<option value="'.$row['lincodigo'].'">'.$row['linnombre'].'</option>';
                                                }
                                            }
                                      
                                            ?>
                                        </select>
                                        <!--<div class="help-block with-errors"></div>-->
                                    </div>
                                    <div class="form-group">
                                        <label>Sublinea</label>
                                        <select  zize="30" class="form-control" name="sublinea" id="sublinea" data-error="Escoja una opcion" required>
                                            <option value="">--Escoja una linea primero--</option>
                                            
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                     <div class="form-group">
                                        <label>Grupo</label> 
                                        <select  zize="30" class="form-control" name="grupo" id="grupo" data-error="Escoja una opcion" required>
                                            <option value="">--Escoja una sublinea primero--</option>
                                            
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                     <div class="form-group">
                                        <label>Subgrupo</label> 
                                        <select  zize="30" class="form-control" name="subgrupo" id="subgrupo" data-error="Escoja una opcion" required>
                                            <option value="">--Escoja un grupo primero--</option>
                                            
                                        </select>
                                        <div class="help-block with-errors"></div>
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

    <script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script type="text/javascript">
$(document).ready(function() {    
    $('#linea').change(function(){

        var username = $(this).val();        
        var dataString = 'linea='+username;
        var selector = 'linea';
        var p = 'puntero='+selector;
        $.ajax({
            type: "POST",
            url: "datos_combos.php",
            data:dataString,
            success: function(data) {
                $('#sublinea').html(data);
            }
        });
    }); 
    
    $('#sublinea').change(function(){
        var username = $(this).val();        
        var dataString = 'sublinea='+username;
        var selector = 'linea';
        var p = 'puntero='+selector;
        $.ajax({
            type: "POST",
            url: "buscar_grupo.php",
            data:dataString,
            success: function(data) {
                $('#grupo').html(data);
            }
        });
    });
    $('#grupo').change(function(){

        var username = $(this).val();        
        var dataString = 'grupo='+username;
        var selector = 'linea';
        var p = 'puntero='+selector;
        $.ajax({
            type: "POST",
            url: "buscar_subgrupo.php",
            data:dataString,
            success: function(data) {
                $('#subgrupo').html(data);
            }
        });
    });
    
        $('#nombre').blur(function(){

        $('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);
        this.value=this.value.toUpperCase();
        var username = $(this).val();        
        var dataString = 'nombre='+username;

        $.ajax({
            type: "POST",
            url: "check_servicio.php",
            data: dataString,
            success: function(data) {
                $('#Info').fadeIn(1000).html(data);
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
             function ok() {
            swal({
              title: "Servicio actualizado correctamente",
              text: "Ir a lista de servicios",
              type: "success",
              confirmButtonText: "Aceptar"
            },
            function () {
              window.location = "servicios.php";
            });
}
 $("#formulario").on("submit", function(event) {
       
                event.preventDefault();
               var f = $(this);
            var formData = new FormData(document.getElementById("formulario"));
            formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "guardar_nuevas_opciones.php",
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
 
 
    
});    


</script>
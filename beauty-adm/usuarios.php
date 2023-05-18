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
        $result1 = $conn->query("SELECT * FROM btyservicio WHERE serstado = 1 and sercodigo =".$id_usuario);
        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) { 
                $id = row['sercodigo'];
                $name =$row['sernombre'];
                $descripcion = $row['serdescripcion'];
                $img = $row['serimagen'];
                $alias = $row['seralias'];                                     
            }
        }   
    }
    //$msg = '';
}

?>
<link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>

<div class="row">


<div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de servicios</h3>
                </div>
                <div class="panel-body">
                    <form id="formulario" method="post" action="guardar_nuevas_opciones.php" enctype="multipart/form-data" class="form-horizontal" role="form" >
        <?php if ($operacion == 'update') {
            ?>
            <label for="id_usuario" >ID:</label>
            <input id="id_usuario" name="id_usuario" type="text" class="form-control" readonly value="<?php echo $id_usuario; ?>"/>
            <?php
        }
        ?>
                                    <div class="form-group">
                                        <label>Linea</label>
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
                                        <div class="help-block with-errors"></div>
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

                                    <div class="form-group">          
                                        <label for="nombre" >Nombre del servicio:</label>
                                    <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required value="<?php echo $name; ?>"/>
        </div>
        <div class="form-group">
        <label for="direccion" >Descripcion del servicio:</label>
        <textarea id="descripcion" name="descripcion" type="text" class="form-control" placeholder="Ingrese una nueva descripcion si lo desea" value="<?php echo $descripcion; ?>"><?php echo $descripcion; ?></textarea> 
        </div>
        <div class="form-group">
        <label for="telefono">Imagen:</label><!--0<span><img src="images/galeria_servicios/?php echo $img; ?>" WIDTH="70" HEIGHT="70"></span>-->
        <input id="imagen" name="imagen" type="file" class="form-control" placeholder="imagen" required value=""/>
        </div>
        <div class="form-group">
        <label for="pwd" >Alias:</label>
        <input id="alias" name="alias" type="text" class="form-control" placeholder="ingrese un alias para el servicio" required value="<?php echo $alias; ?>"/>
        </div>
        <br/>
        <input id="guardar" type="submit" value="Guardar" class="btn btn-success"/>
    </form>


                </div> 
                </div>
</div>
</div>



<script type="text/javascript">
$(document).ready(function() {    
    $('#linea').change(function(){

        var username = $(this).val();        
        var dataString = 'linea='+username;
          
        $.ajax({
            type: "POST",
            url: "datos_combos.php",
            data: dataString,
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
    
    
});    


</script>
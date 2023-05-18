<?php

    include '../../cnx_data.php';

    if (!empty($_POST)) 
    {
        $today              = date('Y-m-d');
        $id_colaborador     = $_POST['id_colaborador'];


        $result1 = $conn->query("SELECT c.trcdocumento, c.tdicodigo, c.clbcodigo, tdi.tdinombre, tdi.tdialias, trc.trcdigitoverificacion, trc.trcdireccion, trc.brrcodigo, brr.brrnombre, trc.trctelefonofijo, trc.trctelefonomovil, trc.trcnombres, trc.trcapellidos, car.crgnombre, c.clbsexo, c.crgcodigo, c.ctccodigo, ctc.ctcnombre, c.clbemail, c.clbfechanacimiento, c.clbfechaingreso, c.clbnotificacionemail, c.clbnotificacionmovil, car.crgincluircolaturnos, brr.loccodigo
            FROM btycolaborador c 
            INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento 
            INNER JOIN btycargo car ON car.crgcodigo = c.crgcodigo 
            INNER JOIN btycategoria_colaborador ctc ON ctc.ctccodigo = c.ctccodigo 
            INNER JOIN btytipodocumento tdi ON tdi.tdicodigo = c.tdicodigo 
            INNER JOIN btybarrio brr ON trc.brrcodigo = brr.brrcodigo 
            where c.trcdocumento =".$id_colaborador);


                if ($result1->num_rows > 0) 
                {
                    while ($row = $result1->fetch_assoc()) 
                    { 
                            
                        $id             = $row['trcdocumento'];
                        $clbcodigo      = $row['clbcodigo'];
                        $name           = utf8_encode($row['trcnombres']);
                        $tdi_codigo     = $row['tdicodigo'];
                        $alias          = $row['tdialias'];
                        $cargo          = $row['crgnombre'];
                        $categoria          = $row['ctccodigo'];
                        $sexo           = $row['clbsexo'];
                        $id_cargo       = $row['crgcodigo'];
                        $apellidos      = utf8_encode($row['trcapellidos']);
                        $dv             = $row['trcdigitoverificacion'];
                        $fecha          = $row['clbfechanacimiento'];
                        $fecha_in       = $row['clbfechaingreso'];
                        $barrio         = $row['brrnombre'];
                        $id_barrio      = $row['brrcodigo'];
                        $ciudad         = $row['loccodigo'];
                        $direccion      = $row['trcdireccion'];
                        $telefono_movil = $row['trctelefonomovil'];
                        $telefono_fijo  = $row['trctelefonofijo'];
                        $email          = $row['clbemail'];
                        $swcargo        = $row['crgincluircolaturnos'];

                        $n_movil        = "false";
                        $n_email        = "false";
                        $m1             = $row['clbnotificacionmovil'];
                        $e1             = $row['clbnotificacionemail'];
                        


                        if ( $m1 == "S")
                        {
                            $n_movil = "checked";
                        }

                        if ( $e1 == "S")
                        {
                            $n_fijo = "checked";
                        }
                                
                    }
                }   
    }
   

    
?>
<!-- <link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>         -->

<input type="hidden" id="swcargo" name="swcargo" value="<?php echo  $swcargo;?>">
<input type="hidden" id="city" name="city" value="<?php echo  $ciudad;?>">
<input type="hidden" id="neigh" name="neigh" value="<?php echo  $id_barrio;?>">
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <h3 class="panel-title">Actualizar datos colaborador</h3>
        </div>
        <div class="panel-body">
        <form role="form" method="post" enctype="multipart/form-data" id="form_edit_colab" >
            <div class="col-md-6">
                <input type="hidden" name="clbcodigo" value="<?php echo $clbcodigo; ?>">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Tipo de Documento</label>
                        <select style="width: 99px" class="form-control" name="tipo_documento" data-error="Escoja una opcion" required="NIT, CC, TI, CE" disabled="">
                            <?php
                                
                                $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento where not tdicodigo=".$tdi_codigo);
                                if ($result->num_rows > 0) {
                                    echo '<option value="'.$tdi_codigo.'">'.$alias.'</option>';
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                    }
                                }
                                
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div> <!-- TIPO DE DOCUMENTO -->
                    <div class="form-group col-md-8">
                        <label>Numero de documento</label>
                        <div class="form-inline">
                            <input   type="number" class="form-control" value=<?php echo "'".$id."'"; ?> name="no_documento" id="no_documento" placeholder="Numero de documento" data-error="Este campo es obligatorio y solo debe contener numeros" required  readonly>
                            <label> - </label> 
                            <input  style="width: 70px"  type="text" value="<?php echo $dv; ?>" class="form-control" pattern="[0-9]" maxlength="1" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" required readonly>
                            <div id="Info" class="help-block with-errors"></div>             
                        </div>
                    </div><!--No_documento-->
                </div>
                <div class="row">
                    <div class="form-group col-md-6" id="divnombre" required>
                        <label>Nombres</label>
                        <input  class="form-control text-uppercase" value="<?php echo $name ?>"  name="nombres" id="nombres" placeholder="Digite sus nombres" onchange="this.value=this.value.toUpperCase();" data-error="Campo obligatorio" required>
                        <div class="help-block with-errors"></div>
                    </div><!--Nombres-->

                    <div class="form-group col-md-6" id="divapellido" required>
                        <label>Apellidos</label>
                        <input  class="form-control text-uppercase" onchange="this.value=this.value.toUpperCase();" name="apellidos" value="<?php echo $apellidos ?>"  id="apellidos" data-error="Campo obligatorio" placeholder="digite sus apellidos" required>
                        <div class="help-block with-errors"></div>
                    </div><!--APELLIDOS--> 
                </div>
                <div class="row">
                    <div class="form-group col-md-4" id="divsexo">
                        <label>Sexo</label>
                            <select name="sexo" id="sexo" class="form-control">
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select>
                        <div class="help-block with-errors"></div>
                    </div> <!-- SEXO -->
                    <div class="form-group col-md-8">
                        <label>Fecha de nacimiento</label>
                        <div class="input-group">
                            <input  type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha ?>" placeholder="AAAA-MM-DD" max="<?php echo $today;?>" format="YYYY-MM-DD" data-error="campo obligatorio" required><div class="input-group-btn"><input style="width: 100px" type="text" class="form-control" id="edad" name="edad" readonly></div>
                        </div>
                        <div class="help-block with-errors text-danger" id="infoEdad"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Departamento</label>
                        <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                            <?php
                                
                                $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where not depcodigo = 0 ORDER BY depombre");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {                
                                        echo '<option value="'.$row['depcodigo'].'">'.$row['depombre'].'</option>';
                                    }
                                }
                                
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div><!--departamento-->

                    <div class="form-group col-md-4">
                        <label> Ciudad </label>
                        <select  zize="30" class="form-control" name="ciudad" id="ciudad" onchange="" data-error="Escoja una opcion" required>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div><!--ciudad-->

                    <div class="form-group col-md-4">
                        <label> Barrio </label>
                        <select zize="30" class="form-control" name="barrio" id="barrio" data-error="Escoja una opcion" required></select>
                        <div class="help-block with-errors"></div>
                    </div><!--Barrio-->
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Direccion</label>
                        <input  class="form-control text-uppercase" name="direccion" onchange="this.value=this.value.toUpperCase();" placeholder="Ejemplo: CLL 01 kr 02 - 03" data-error="Campo obligatorio" <?php echo "value='".$direccion."'"; ?> required>
                        <div class="help-block with-errors"></div>
                    </div> <!--direccion--> 

                    <div class="form-group col-md-4">
                        <label>Telefono movil</label>
                        <input  class="form-control" type="number" name="telefono_movil" placeholder="Ingrese numero de telefono" data-error="camp obligatorio" <?php echo "value='".$telefono_movil."'"; ?> >
                        <div class="help-block with-errors"></div>
                    </div><!--Telefono movil-->

                    <div class="form-group col-md-4">
                        <label>Telefono fijo</label>
                        <input  class="form-control" type="number" name="telefono_fijo" placeholder="Ingrese numero de telefono" <?php echo "value='".$telefono_fijo."'"; ?>>
                    </div><!--TElefono fijo-->
                </div>


                <div class="form-group">
                    <label for="inputEmail" class="control-label">Email</label>
                    <input  type="email" class="form-control text-uppercase" name="email" onchange="this.value=this.value.toUpperCase();"  id="email" placeholder="Email" data-error="Ingrese un direccion de correo valida" <?php echo "value='".$email."'"; ?>>
                    <div class="help-block with-errors"></div>
                </div><!--Email-->
                    
                </div>
            <div class="col-md-6">
                
                <div class="form-group">
                    <label>Cargo</label>
                    <select  zize="30" class="form-control" name="cargo" id="cargo" data-error="Escoja una opcion" required>
                        <option value="">--Escoja una opcion--</option>
                        <?php
                            
                            $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo where not crgcodigo =".$id_cargo);
                            if ($result->num_rows > 0) {
                                echo '<option selected value="'.$id_cargo.'">'.$cargo.'</option>'; 
                                while ($row = $result->fetch_assoc()) {                
                                    echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                }
                            }
                            
                        ?>
                    </select>
                    <div class="help-block with-errors"></div>
                </div><!-- Cargo-->
                <div class="form-group swcargo">
                    <label>Categoria</label>
                    <select class="form-control" id="Categoria" name="categoria">
                        <?php
                        
                            $sql = "SELECT ctccodigo, ctcnombre, ctccolor, ctcalias FROM btycategoria_colaborador WHERE ctcestado = 1";
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
                    <label>Fecha de ingreso</label>                        
                    <input  type="date" class="form-control" name="fecha_in" value="<?php echo $fecha_in ?>" id="datetimepicker_in" placeholder="AAAA-MM-DD" format="YYYY-MM-DD" data-error="campo obligatorio" required>
                    <div class="help-block with-errors"></div>
                    <p class="help-block"></p>
                </div>  
                

                 <div class="form-group hidden">
                    <label for="inputEmail" class="control-label">RUT</label>
                        <input type="file" class="form-control" name="rut">
                    <div class="help-block with-errors"></div>
                </div><!--Email-->

                <div class="form-group">
                    <label for="inputEmail" class="control-label">Foto</label>
                        <input type="file" class="form-control" name="file">
                    <div class="help-block with-errors"></div>
                </div><!--Email-->
            </div>
            

            <div class="row hidden">
                <div class="col-lg-6">
                    <div class="input-group">
                        <div class="help-block"> 
                            <input type="checkbox" checked name="notif[]" id="tipo_nombre2" value="movil" aria-label="..." <?php echo $m1; ?> >
                                <label>
                                    Recibir notificaciones a mi movil
                                </label> 
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <div class="input-group">
                        <div class="help-block"> 
                            <input type="checkbox" checked name="notif[]"  id="tipo_nombre1" value="email" aria-label="..." <?php echo $m1; ?> > 
                                <label>
                                    Recibir notificaciones a mi email
                                </label> 
                        </div>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
           </div><!-- /.row -->
                    <button type="submit" value="Guardar cambios" class="btn btn-success pull-right">Guardar Cambios </button>
           </form>
        </div><!--panel body-->
    </div><!--hpanel-->
</div><!--panel-->

        <br/>
<script type="text/javascript">
    $(document).ready(function() {   
        
        var a = $('#fecha').val();
        calcularEdad(a); 
        var depa = $("#dep").val();
        var depart = 'ciudad='+depa;
        $.ajax({
            type: "POST",
            url: "buscar_ciudad.php",
            data: depart,
            success: function(data) {
                $('#ciudad').html(data);
                $("#ciudad").val('<?php echo $ciudad;?>');
                brr ();
            }
        });
        $('#fecha').change(function() {
            var e = $('#fecha').val();
            calcularEdad(e);
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
                    $('#Info').fadeIn(1000).html(data);
                }
            });
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
       
        $("#sexo").val('<?php echo $sexo;?>');
        
        $("#Categoria").val('<?php echo $categoria;?>');
         
        if($("#swcargo").val()==0){
            $(".swcargo").addClass('hidden');
        }else{
            $(".swcargo").removeClass('hidden');
        }

    });

    /*window.addEventListener("load", function() { 
        $("#ciudad").val('<?php echo $ciudad;?>');
        $("#barrio").val('<?php echo $id_barrio;?>');
    });*/

    function calcularEdad(fecha) {
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }
        $('#edad').val(edad+' Años');
        if (edad < 18) {
            $('#infoEdad').html('Edad minima es de 18 a&ntilde;os<input type="hidden" name="" value="" required>');
        } else {
            $('#infoEdad').html('');
        }
    }
    function brr () {
        var cod_brr = $('#ciudad').val();
        var brr = 'barrio='+cod_brr;
        $.ajax({
            type: "POST",
            url: "buscar_barrio.php",
            data: brr,
            success: function(data) {
                $('#barrio').html(data);
                $("#barrio").val('<?php echo $id_barrio;?>');
                //ubicacion();
            }
        });
    }
   /* window.onload=function(){
        var city=$("#city").val();
        var neigh=$("#neigh").val();
        $("#ciudad").val(city);
        $("#barrio").val(neigh);
    };*/
</script>

